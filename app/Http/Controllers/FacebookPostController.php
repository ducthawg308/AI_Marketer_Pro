<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class FacebookPostController extends Controller
{
    public function postToPageWithImage()
    {
        $page_id = "755455100983167";
        $access_token = "EAAeZCFXahJtMBPeNG4TVSIOtZBaf5Soj3FJo2SjGLdALRrsI7JMoAZAmSHV1byvY9heEvZCOnu3z8i3Rcgqf0BWDkHDWs9uhRi0WuuadsRKnhgOzknl5tAIxFPpMrZCwx0j6DdN91ZAX03pFYa80tQpF2mtFKfHzyBwlR7VK7PEgj3YY5CTiKhnEoGF6ADcQIgE1xW";

        $message = "Hello Nguyễn Đức Thắng! Đây là bài đăng kèm ảnh.";
        $imageUrl = "https://i.pinimg.com/236x/a0/56/ba/a056ba5b5e5b9518ef6d2031cbf9cb3b.jpg";

        $url = "https://graph.facebook.com/v23.0/{$page_id}/photos";

        $response = Http::asForm()->post($url, [
            'url' => $imageUrl,
            'message' => $message,
            'access_token' => $access_token
        ]);

        return $response->json();
    }
}
