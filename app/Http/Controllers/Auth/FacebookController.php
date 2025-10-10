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

class FacebookController extends Controller
{
    private const GRAPH_VERSION = 'v23.0';

    private array $scopes = [
        'email',
        'public_profile',
        'pages_show_list',
        'pages_read_engagement',
        'pages_manage_metadata',
        'pages_manage_posts',
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

                if (!$user->hasAnyRole()) {
                    $user->assignRole('user');
                }

                AiSetting::create([
                    'user_id'  => $user->id,
                    'tone'     => 'friendly',
                    'length'   => 'medium',
                    'platform' => 'Facebook',
                    'language' => 'Vietnamese',
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

            $pages = $this->fetchAllPages($longToken);
            foreach ($pages as $page) {
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
                    ]
                );
            }

            return redirect()->route('home')->with('success', 'Đăng nhập Facebook thành công!');
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
                ->filter(fn ($p) => ($p['status'] ?? null) === 'granted')
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
            'fields'          => 'id,name,access_token,category,about,link,picture,fan_count,is_published',
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