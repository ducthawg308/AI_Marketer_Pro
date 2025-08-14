<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class FacebookPostController extends Controller
{
    public function postToPage()
    {
        $page_id = "718467094685058";
        $access_token = "EAASVj4awe9ABPHqsAdZBKKmr2y5AjPAVtJrGagrIK4ZCEP41o3nFLzoZCUanuQXjCGgzBHTgKrvZA8qTfrydZAU5zlmqrqlPrl2OKWcyWEsE3hHoGduUmRtAi88Txwgy2vlJZAiuyfkuHhDiTWZCEyWhYNiZAQKxIhWpZCqyQlS0mYlZBiYHS2nAEovB3dNaXKZA0VPCeBYAakf";

        $message = "Hello Nguyễn Đức Thắng";

        $timeVN = '2025-08-08 10:00:00';

        $publishTimeUtc = Carbon::parse($timeVN, 'Asia/Ho_Chi_Minh')
            ->timezone('UTC')
            ->timestamp;

        $url = "https://graph.facebook.com/v23.0/{$page_id}/feed";

        $response = Http::asForm()->post($url, [
            'message' => $message,
            //'published' => 'false', // Bắt buộc để hẹn giờ
           // 'scheduled_publish_time' => $publishTimeUtc,
            'access_token' => $access_token
        ]);

        return $response->json();
    }
}
