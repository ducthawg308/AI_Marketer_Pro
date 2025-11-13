<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dashboard\ContentCreator\AiSetting;
use App\Models\Facebook\UserPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;
use Exception;
use App\Traits\RedirectsBasedOnRole;

class FacebookController extends Controller
{
    use RedirectsBasedOnRole;

    private const GRAPH_VERSION = 'v23.0';

    private array $scopes = [
        'email',
        'public_profile',
        'pages_show_list',
        'pages_read_engagement',
        'pages_manage_metadata',
        'pages_manage_posts',
        'business_management', // Thêm quyền để lấy pages từ Business Manager
    ];

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')
            ->scopes($this->scopes)
            ->with(['auth_type' => 'rerequest'])
            ->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $fbUser = Socialite::driver('facebook')->user();

            if (empty($fbUser->token)) {
                Log::error('Facebook login failed: No access token returned');
                return redirect()->route('login')
                    ->with('error', 'Đăng nhập bằng Facebook thất bại: Không nhận được access token.');
            }

            $shortToken = $fbUser->token;

            $exchange = $this->exchangeForLongLivedToken($shortToken);
            if (isset($exchange['error'])) {
                Log::error('FB token exchange error', $exchange);
            }

            $longToken = $exchange['access_token'] ?? $shortToken;
            $expiresAt = $this->resolveExpiresAt($exchange, $longToken);

            $user = User::where('facebook_id', $fbUser->getId())
                ->orWhere('email', $fbUser->getEmail())
                ->first();

            if (!$user) {
                $user = User::create([
                    'name'                      => $fbUser->getName() ?? 'Facebook User',
                    'email'                     => $fbUser->getEmail(),
                    'facebook_id'               => $fbUser->getId(),
                    'password'                  => bcrypt(Str::random(32)),
                    'facebook_access_token'     => $longToken,
                    'facebook_token_expires_at' => $expiresAt,
                ]);
            } else {
                $user->update([
                    'facebook_id'               => $fbUser->getId(),
                    'facebook_access_token'     => $longToken,
                    'facebook_token_expires_at' => $expiresAt,
                ]);
            }

            Auth::login($user);

            $granted = $this->getGrantedPermissions($longToken);
            $missing = array_values(array_diff($this->scopes, $granted));
            if (!empty($missing)) {
                Log::warning('Missing FB permissions: ' . implode(',', $missing));
                session()->flash('warning', 'Thiếu quyền: ' . implode(', ', $missing));
            }

            // Lấy tất cả pages từ cả 2 nguồn: pages cá nhân và pages từ Business Manager
            $allPages = $this->fetchAllPagesFromAllSources($longToken);

            // Lấy danh sách page_id hiện tại từ Facebook
            $currentPageIds = collect($allPages)->pluck('id')->toArray();

            // Xóa các pages không còn quyền truy cập (feature #2)
            UserPage::where('user_id', $user->id)
                ->whereNotIn('page_id', $currentPageIds)
                ->delete();

            Log::info('Synced pages for user ' . $user->id . ': ' . count($allPages) . ' pages found');

            // Cập nhật hoặc tạo mới pages (bao gồm avatar - feature #1)
            foreach ($allPages as $page) {
                UserPage::updateOrCreate(
                    ['user_id' => $user->id, 'page_id' => $page['id']],
                    [
                        'page_name'         => $page['name'] ?? null,
                        'page_access_token' => $page['access_token'] ?? null,
                        'category'          => $page['category'] ?? null,
                        'about'             => $page['about'] ?? null,
                        'link'              => $page['link'] ?? null,
                        'fan_count'         => $page['fan_count'] ?? 0,
                        'is_published'      => $page['is_published'] ?? true,
                        'picture_url'       => $page['picture']['data']['url'] ?? null, // Avatar page (feature #1)
                        'source_type'       => $page['source_type'] ?? 'owned', // Phân biệt nguồn: owned, business_manager
                    ]
                );
            }

            return redirect($this->redirectPath());
        } catch (Exception $e) {
            Log::error('Facebook login error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Đăng nhập bằng Facebook thất bại: ' . $e->getMessage());
        }
    }

    public function listPages()
    {
        $user = Auth::user();
        if (!$user || !$user->facebook_access_token) {
            return redirect()->route('auth.facebook')->with('error', 'Vui lòng đăng nhập Facebook trước!');
        }

        $pages = UserPage::where('user_id', $user->id)->get();

        return view('facebook.pages', [
            'pages' => $pages,
            'user'  => $user,
        ]);
    }

    public function getPageDetails($pageId)
    {
        $user = Auth::user();
        if (!$user || !$user->facebook_access_token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $token = $user->facebook_access_token;

            $pageDetails = Http::withToken($token)->get(
                "https://graph.facebook.com/" . self::GRAPH_VERSION . "/{$pageId}",
                [
                    'fields'          => 'id,name,category,about,link,picture{url},cover,fan_count,followers_count,is_published,website,phone,location,hours',
                    'appsecret_proof' => $this->appSecretProof($token),
                ]
            )->json();

            return response()->json($pageDetails);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPageAccessToken($pageId)
    {
        $user = Auth::user();
        if (!$user || !$user->facebook_access_token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $page = UserPage::where('user_id', $user->id)
                ->where('page_id', $pageId)
                ->first();

            if ($page && $page->page_access_token) {
                return response()->json(['access_token' => $page->page_access_token]);
            }

            return response()->json(['error' => 'Page not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /* ===== Helpers ===== */

    private function appSecretProof(string $token): string
    {
        $secret = config('services.facebook.client_secret');
        return hash_hmac('sha256', $token, $secret);
    }

    private function exchangeForLongLivedToken(string $shortToken): array
    {
        try {
            $resp = Http::get(
                'https://graph.facebook.com/' . self::GRAPH_VERSION . '/oauth/access_token',
                [
                    'grant_type'        => 'fb_exchange_token',
                    'client_id'         => config('services.facebook.client_id'),
                    'client_secret'     => config('services.facebook.client_secret'),
                    'fb_exchange_token' => $shortToken,
                ]
            )->json();

            return is_array($resp) ? $resp : [];
        } catch (\Throwable $e) {
            Log::error('exchangeForLongLivedToken error: ' . $e->getMessage());
            return [];
        }
    }

    private function resolveExpiresAt(array $exchange, string $token): ?Carbon
    {
        $expiresIn = $exchange['expires_in'] ?? null;
        if ($expiresIn) {
            return now()->addSeconds((int) $expiresIn);
        }

        try {
            $appAccessToken = config('services.facebook.client_id') . '|' . config('services.facebook.client_secret');

            $debug = Http::get(
                'https://graph.facebook.com/' . self::GRAPH_VERSION . '/debug_token',
                [
                    'input_token'  => $token,
                    'access_token' => $appAccessToken,
                ]
            )->json();

            $ts = $debug['data']['expires_at'] ?? null;
            return $ts ? Carbon::createFromTimestamp((int) $ts) : null;
        } catch (\Throwable $e) {
            Log::warning('resolveExpiresAt debug_token error: ' . $e->getMessage());
            return null;
        }
    }

    private function getGrantedPermissions(string $userToken): array
    {
        try {
            $res = Http::withToken($userToken)->get(
                'https://graph.facebook.com/' . self::GRAPH_VERSION . '/me/permissions',
                ['appsecret_proof' => $this->appSecretProof($userToken)]
            )->json();

            if (!isset($res['data']) || !is_array($res['data'])) {
                return [];
            }

            return collect($res['data'])
                ->filter(fn($p) => ($p['status'] ?? null) === 'granted')
                ->pluck('permission')
                ->values()
                ->all();
        } catch (\Throwable $e) {
            Log::warning('getGrantedPermissions error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Feature #3: Lấy tất cả pages từ cả 2 nguồn
     * - Pages do user sở hữu trực tiếp (VIA cầm page)
     * - Pages được share từ Business Manager
     */
    private function fetchAllPagesFromAllSources(string $userToken): array
    {
        $allPages = [];

        // 1. Lấy pages cá nhân (owned pages)
        $ownedPages = $this->fetchOwnedPages($userToken);
        foreach ($ownedPages as $page) {
            $page['source_type'] = 'owned';
            $allPages[] = $page;
        }

        // 2. Lấy pages từ Business Manager
        $businessPages = $this->fetchBusinessManagerPages($userToken);

        // Loại bỏ duplicate (nếu page vừa owned vừa từ BM)
        $ownedPageIds = collect($ownedPages)->pluck('id')->toArray();
        foreach ($businessPages as $page) {
            if (!in_array($page['id'], $ownedPageIds)) {
                $page['source_type'] = 'business_manager';
                $allPages[] = $page;
            }
        }

        Log::info('Total pages fetched: ' . count($allPages) . ' (Owned: ' . count($ownedPages) . ', BM: ' . count($businessPages) . ')');

        return $allPages;
    }

    /**
     * Lấy pages mà user sở hữu trực tiếp
     */
    private function fetchOwnedPages(string $userToken): array
    {
        $all = [];
        $url = 'https://graph.facebook.com/' . self::GRAPH_VERSION . '/me/accounts';
        $params = [
            'fields'          => 'id,name,access_token,category,about,link,picture{url},fan_count,is_published',
            'limit'           => 100,
            'appsecret_proof' => $this->appSecretProof($userToken),
        ];

        try {
            do {
                $resp = Http::withToken($userToken)->get($url, $params)->json();

                if (!empty($resp['data'])) {
                    $all = array_merge($all, $resp['data']);
                }

                $next = $resp['paging']['next'] ?? null;
                if ($next) {
                    $url = $next;
                    $params = [];
                } else {
                    $url = null;
                }
            } while ($url);
        } catch (\Throwable $e) {
            Log::error('fetchOwnedPages error: ' . $e->getMessage());
        }

        return $all;
    }

    /**
     * Lấy pages từ Business Manager mà user có quyền truy cập
     */
    private function fetchBusinessManagerPages(string $userToken): array
    {
        $allPages = [];

        try {
            // Bước 1: Lấy danh sách Business Managers mà user có quyền truy cập
            $businessesResp = Http::withToken($userToken)->get(
                'https://graph.facebook.com/' . self::GRAPH_VERSION . '/me/businesses',
                [
                    'fields'          => 'id,name',
                    'appsecret_proof' => $this->appSecretProof($userToken),
                ]
            )->json();

            $businesses = $businessesResp['data'] ?? [];

            // Bước 2: Với mỗi Business Manager, lấy pages có quyền tasks=['MANAGE', 'CREATE_CONTENT', 'MODERATE', 'ADVERTISE']
            foreach ($businesses as $business) {
                $businessId = $business['id'];

                $pagesResp = Http::withToken($userToken)->get(
                    "https://graph.facebook.com/" . self::GRAPH_VERSION . "/{$businessId}/client_pages",
                    [
                        'fields'          => 'id,name,access_token,category,about,link,picture{url},fan_count,is_published',
                        'appsecret_proof' => $this->appSecretProof($userToken),
                    ]
                )->json();

                if (!empty($pagesResp['data'])) {
                    foreach ($pagesResp['data'] as $page) {
                        // Lấy access token cho page từ BM nếu chưa có
                        if (empty($page['access_token'])) {
                            $page['access_token'] = $this->getPageAccessTokenFromBM($userToken, $page['id']);
                        }
                        $allPages[] = $page;
                    }
                }
            }

            // Bước 3: Lấy thêm pages từ owned_pages của business (pages mà BM sở hữu)
            foreach ($businesses as $business) {
                $businessId = $business['id'];

                $ownedPagesResp = Http::withToken($userToken)->get(
                    "https://graph.facebook.com/" . self::GRAPH_VERSION . "/{$businessId}/owned_pages",
                    [
                        'fields'          => 'id,name,access_token,category,about,link,picture{url},fan_count,is_published',
                        'appsecret_proof' => $this->appSecretProof($userToken),
                    ]
                )->json();

                if (!empty($ownedPagesResp['data'])) {
                    foreach ($ownedPagesResp['data'] as $page) {
                        // Kiểm tra duplicate
                        $exists = collect($allPages)->contains('id', $page['id']);
                        if (!$exists) {
                            if (empty($page['access_token'])) {
                                $page['access_token'] = $this->getPageAccessTokenFromBM($userToken, $page['id']);
                            }
                            $allPages[] = $page;
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('fetchBusinessManagerPages error: ' . $e->getMessage());
        }

        return $allPages;
    }

    /**
     * Lấy page access token thông qua user token
     * Dùng khi page được share từ BM nhưng không có sẵn access_token
     */
    private function getPageAccessTokenFromBM(string $userToken, string $pageId): ?string
    {
        try {
            $resp = Http::withToken($userToken)->get(
                "https://graph.facebook.com/" . self::GRAPH_VERSION . "/{$pageId}",
                [
                    'fields'          => 'access_token',
                    'appsecret_proof' => $this->appSecretProof($userToken),
                ]
            )->json();

            return $resp['access_token'] ?? null;
        } catch (\Throwable $e) {
            Log::warning("Cannot get access token for page {$pageId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Legacy method - giữ lại để backward compatible
     */
    private function fetchAllPages(string $userToken): array
    {
        return $this->fetchAllPagesFromAllSources($userToken);
    }
}
