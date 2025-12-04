<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        'read_insights',
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

            // ✅ SYNC pages - Xóa pages không còn quyền truy cập
            $this->syncUserPages($user->id, $longToken);

            return redirect($this->redirectPath());
        } catch (Exception $e) {
            Log::error('Facebook login error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Đăng nhập bằng Facebook thất bại: ' . $e->getMessage());
        }
    }

    /**
     * ✅ SYNC User Pages - Update/Create/DELETE
     */
    private function syncUserPages(int $userId, string $userToken): void
    {
        try {
            // Lấy danh sách pages hiện tại từ Facebook
            $facebookPages = $this->fetchAllPages($userToken);
            $facebookPageIds = collect($facebookPages)->pluck('id')->toArray();

            Log::info('Syncing pages for user', [
                'user_id' => $userId,
                'facebook_pages_count' => count($facebookPageIds),
                'facebook_page_ids' => $facebookPageIds,
            ]);

            // Update hoặc Create pages từ Facebook
            foreach ($facebookPages as $page) {
                // ✅ Lấy avatar URL từ picture data
                $avatarUrl = $page['picture']['data']['url'] ?? null;

                // ✅ Log debug avatar URL
                Log::debug('Page avatar URL', [
                    'page_id' => $page['id'],
                    'page_name' => $page['name'] ?? 'N/A',
                    'avatar_url' => $avatarUrl,
                    'picture_data' => $page['picture'] ?? null,
                ]);

                UserPage::updateOrCreate(
                    ['user_id' => $userId, 'page_id' => $page['id']],
                    [
                        'page_name'         => $page['name'] ?? null,
                        'page_access_token' => $page['access_token'] ?? null,
                        'category'          => $page['category'] ?? null,
                        'about'             => $page['about'] ?? null,
                        'link'              => $page['link'] ?? null,
                        'avatar_url'        => $avatarUrl, // ✅ Lưu avatar URL
                        'fan_count'         => $page['fan_count'] ?? 0,
                        'is_published'      => $page['is_published'] ?? true,
                        'updated_at'        => now(),
                    ]
                );
            }

            // ✅ XÓA pages không còn trong danh sách Facebook
            $deletedCount = UserPage::where('user_id', $userId)
                ->whereNotIn('page_id', $facebookPageIds)
                ->delete();

            if ($deletedCount > 0) {
                Log::info("Deleted {$deletedCount} pages that user no longer has access to", [
                    'user_id' => $userId,
                ]);

                session()->flash('info', "Đã xóa {$deletedCount} trang không còn quyền truy cập.");
            }

            Log::info('Pages synced successfully', [
                'user_id' => $userId,
                'total_pages' => count($facebookPageIds),
                'deleted_pages' => $deletedCount,
            ]);
        } catch (\Throwable $e) {
            Log::error('syncUserPages error: ' . $e->getMessage(), [
                'user_id' => $userId,
                'trace' => $e->getTraceAsString(),
            ]);
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

    /**
     * ✅ Refresh Pages - Sync lại khi user muốn
     */
    public function refreshPages()
    {
        $user = Auth::user();

        if (!$user || !$user->facebook_access_token) {
            return redirect()->route('auth.facebook')
                ->with('error', 'Vui lòng đăng nhập Facebook trước!');
        }

        // Kiểm tra token còn hiệu lực
        if ($user->facebook_token_expires_at && $user->facebook_token_expires_at->isPast()) {
            return redirect()->route('auth.facebook')
                ->with('error', 'Token Facebook đã hết hạn. Vui lòng đăng nhập lại!');
        }

        try {
            $this->syncUserPages($user->id, $user->facebook_access_token);

            return redirect()->route('facebook.pages')
                ->with('success', 'Đã cập nhật danh sách Pages thành công!');
        } catch (\Exception $e) {
            Log::error('Refresh pages error: ' . $e->getMessage());

            return redirect()->route('facebook.pages')
                ->with('error', 'Không thể cập nhật Pages. Vui lòng thử lại!');
        }
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
                    'fields'          => 'id,name,category,about,link,picture,cover,fan_count,followers_count,is_published,website,phone,location,hours',
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
        if (!empty($exchange['expires_in'])) {
            $expiresIn = (int) $exchange['expires_in'];
            $expiresAt = now()->addSeconds($expiresIn);

            Log::info('Token expires_at from exchange', [
                'expires_in_seconds' => $expiresIn,
                'expires_at' => $expiresAt->toDateTimeString()
            ]);

            return $expiresAt;
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

            Log::info('Debug token response', ['debug' => $debug]);

            if (isset($debug['data']['expires_at']) && $debug['data']['expires_at'] > 0) {
                $expiresAt = Carbon::createFromTimestamp((int) $debug['data']['expires_at']);

                Log::info('Token expires_at from debug_token', [
                    'timestamp' => $debug['data']['expires_at'],
                    'expires_at' => $expiresAt->toDateTimeString()
                ]);

                return $expiresAt;
            }

            if (isset($debug['data']['data_access_expires_at']) && $debug['data']['data_access_expires_at'] > 0) {
                $expiresAt = Carbon::createFromTimestamp((int) $debug['data']['data_access_expires_at']);

                Log::info('Token expires_at from data_access_expires_at', [
                    'timestamp' => $debug['data']['data_access_expires_at'],
                    'expires_at' => $expiresAt->toDateTimeString()
                ]);

                return $expiresAt;
            }

            if (isset($debug['data']['expires_at']) && $debug['data']['expires_at'] === 0) {
                Log::info('Token never expires (long-lived token)');
                return now()->addDays(60);
            }
        } catch (\Throwable $e) {
            Log::error('resolveExpiresAt debug_token error: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString()
            ]);
        }

        Log::warning('Could not determine exact expiry, using 60-day default');
        return now()->addDays(60);
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

    private function fetchAllPages(string $userToken): array
    {
        $all = [];
        $url = 'https://graph.facebook.com/' . self::GRAPH_VERSION . '/me/accounts';
        $params = [
            'fields'          => 'id,name,access_token,category,about,link,picture{url},fan_count,is_published', // ✅ Thêm picture{url}
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
            Log::error('fetchAllPages error: ' . $e->getMessage());
        }

        return $all;
    }
}
