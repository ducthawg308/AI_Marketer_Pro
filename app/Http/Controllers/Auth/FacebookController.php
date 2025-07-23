<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\AiCreator\AiSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class FacebookController extends Controller
{
    // Chuyển hướng người dùng đến Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Xử lý callback từ Facebook
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            $user = User::where('facebook_id', $facebookUser->id)->first();

            if ($user) {
                Auth::login($user);
                return redirect()->intended('/');
            } else {
                $newUser = User::updateOrCreate(
                    ['email' => $facebookUser->email],
                    [
                        'name' => $facebookUser->name,
                        'facebook_id' => $facebookUser->id,
                        'password' => encrypt('dummy_password'),
                    ]
                );

                AiSetting::create([
                    'user_id' => $newUser->id,
                    'tone' => 'friendly',
                    'length' => 'medium',
                    'platform' => 'Facebook',
                    'language' => 'Vietnamese',
                ]);
                
                Auth::login($newUser);
                return redirect()->intended('/');
            }
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Đăng nhập bằng Facebook thất bại: ' . $e->getMessage());
        }
    }
}