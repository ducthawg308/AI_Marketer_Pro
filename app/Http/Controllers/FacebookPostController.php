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

        $message = "Các game thủ ơi, có món ngon mới về làng đây! 😍

Chào mừng em màn hình ASUS TUF VG259Q5A 25 inch đến với đội hình chiến game của bạn. Với tấm nền Fast IPS, độ phân giải Full HD sắc nét, màu sắc trung thực sống động, bạn sẽ đắm chìm vào thế giới game một cách trọn vẹn nhất. 

Đặc biệt, tốc độ phản hồi siêu nhanh 0.3ms GTG và tần số quét 200Hz sẽ giúp bạn loại bỏ hiện tượng bóng mờ, giật lag, cho trải nghiệm mượt mà trên mọi tựa game, đặc biệt là FPS, đua xe hay MOBA tốc độ cao. 😎

Nâng tầm gaming, chiến thắng dễ dàng hơn với ASUS TUF VG259Q5A! 🚀

👉 Xem chi tiết và rinh ngay em nó về nhà tại [Link sản phẩm của bạn] nhé!

#ASUS #TUF #GamingMonitor #VG259Q5A #200Hz #FastIPS";

        // B1: Đặt giờ hẹn ở Việt Nam
        $timeVN = '2025-08-08 10:00:00';

        // B2: Chuyển sang UTC timestamp
        $publishTimeUtc = Carbon::parse($timeVN, 'Asia/Ho_Chi_Minh')
            ->timezone('UTC')
            ->timestamp;

        // B3: Gọi API Facebook
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
