<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Dashboard\MarketResearch\SerpApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestMarketFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:market-flow {product=son môi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test full flow: SerpApi -> Python Microservice -> Growth Forecast';

    /**
     * Execute the console command.
     */
    public function handle(SerpApiService $serpApi)
    {
        $productName = $this->argument('product');
        $this->info("=== Bắt đầu quy trình test cho sản phẩm: {$productName} ===");

        // STEP 1: Gọi SerpApi
        $this->info("1. Đang gọi SerpApi (Google Trends, Search, Shopping)...");
        
        $startTime = microtime(true);
        
        $trendsResults = $serpApi->searchTrends($productName);
        $searchResults = $serpApi->searchOrganic($productName);
        $shoppingResults = $serpApi->searchShopping($productName);
        
        $duration = round(microtime(true) - $startTime, 2);
        $this->info("   > Hoàn tất gọi API trong {$duration} giây.");

        // LOGGING STEP 1 OUTPUT
        $this->info("--- [DEBUG] SerpApi Output (Trích đoạn) ---");
        $this->line("Google Trends (interest_over_time): " . (isset($trendsResults['interest_over_time']) ? "Có dữ liệu" : "Không có dữ liệu"));
        $this->line("Google Search results count: " . count($searchResults['organic_results'] ?? []));
        $this->line("Google Shopping results count: " . count($shoppingResults['shopping_results'] ?? []));
        $this->line("Sample Search (đầu tiên): " . ($searchResults['organic_results'][0]['title'] ?? 'N/A'));

        if (!$trendsResults || isset($trendsResults['error'])) {
            $this->error("   > Lỗi SerpApi: " . ($trendsResults['error'] ?? 'Không có phản hồi'));
            return 1;
        }

        // STEP 2: Trích xuất dữ liệu (Format cho Python)
        $this->info("2. Đang chuẩn bị dữ liệu cho Python Microservice...");
        
        $trendsTimeline = $this->extractTrendsTimeline($trendsResults);
        $this->info("   > Trích xuất được " . count($trendsTimeline) . " điểm dữ liệu xu hướng.");

        $rawData = [
            'search_results' => $searchResults['organic_results'] ?? [],
            'shopping_data'  => $shoppingResults['shopping_results'] ?? [],
            'trends_data'    => $trendsTimeline,
            'news_results'   => [],
        ];

        $pythonPayload = [
            'raw_data' => $rawData,
            'product' => [
                'name' => $productName,
                'industry' => 'N/A',
                'competitors' => []
            ],
        ];

        // LOGGING STEP 2 OUTPUT (Input for Python)
        $this->info("--- [DEBUG] Python Request Body (Gửi sang Python) ---");
        // Chỉ log sample của trends_data để tránh log quá dài
        $payloadSample = $pythonPayload;
        $payloadSample['raw_data']['trends_data'] = array_slice($trendsTimeline, 0, 3);
        $payloadSample['raw_data']['search_results'] = array_slice($rawData['search_results'], 0, 1);
        $payloadSample['raw_data']['shopping_data'] = array_slice($rawData['shopping_data'], 0, 1);
        $this->line(json_encode($payloadSample, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n... (dữ liệu đã được lược bớt để log) ...");

        // STEP 3: Gọi Python Microservice
        $pythonUrl = config('services.ml_microservice.url', 'http://localhost:8001') . '/api/v1/market-research/analyze';
        $this->info("3. Đang gọi Python Microservice tại: {$pythonUrl}");

        try {
            $pythonResponse = Http::timeout(60)->post($pythonUrl, $pythonPayload);

            if (!$pythonResponse->successful()) {
                $this->error("   > Lỗi Python Service: " . $pythonResponse->body());
                return 1;
            }

            $analysis = $pythonResponse->json();

            // LOGGING STEP 3 OUTPUT (Python Response)
            $this->info("--- [DEBUG] Python Response Body (Kết quả từ Python) ---");
            $this->line(json_encode($analysis, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            // STEP 4: Log kết quả
            $this->info("\n=== KẾT QUẢ PHÂN TÍCH CUỐI CÙNG ===");

            $growthRate = $analysis['trend_analysis']['growth_rate_pct'] ?? 0;
            $trendDir = $analysis['trend_analysis']['trend_direction'] ?? 'N/A';
            
            $this->warn("Tốc độ tăng trưởng dự báo: {$growthRate}%");
            $this->warn("Hướng xu hướng: " . strtoupper($trendDir));
            
            $this->info("Chi tiết giá thị trường:");
            $this->line("- Giá thấp nhất: " . number_format($analysis['price_analysis']['market_price_min'] ?? 0) . " VNĐ");
            $this->line("- Giá cao nhất: " . number_format($analysis['price_analysis']['market_price_max'] ?? 0) . " VNĐ");
            $this->line("- Giá trung bình: " . number_format($analysis['price_analysis']['market_price_avg'] ?? 0) . " VNĐ");
            
            $this->info("Sentiment thị trường: " . ($analysis['sentiment_analysis']['overall_sentiment'] ?? 'N/A'));

        } catch (\Exception $e) {
            $this->error("   > Lỗi kết nối Python Service: " . $e->getMessage());
            return 1;
        }

        $this->info("=== Test hoàn tất ===");
        return 0;
    }

    /**
     * Helper trích xuất timeline từ SerpApi Trends
     */
    private function extractTrendsTimeline($trendsResults)
    {
        // SerpApi Google Trends result usually puts timeline in 'interest_over_time' 'timeline_data'
        $timelineData = $trendsResults['interest_over_time']['timeline_data'] ?? $trendsResults['timeline_data'] ?? null;

        if (empty($timelineData) || !is_array($timelineData)) {
            return [];
        }

        $result = [];
        foreach ($timelineData as $item) {
            $timestamp = $item['timestamp'] ?? null;
            if ($timestamp) {
                $dateStr = date('Y-m', (int) $timestamp);
            } else {
                $rawDate = $item['date'] ?? '';
                $parsed  = strtotime($rawDate);
                $dateStr = $parsed ? date('Y-m', $parsed) : date('Y-m');
            }

            $val = 0;
            if (!empty($item['values']) && is_array($item['values'])) {
                $val = $item['values'][0]['extracted_value'] ?? $item['values'][0]['value'] ?? 0;
            } elseif (isset($item['value'])) {
                $val = $item['value'];
            }

            $result[] = ['date' => $dateStr, 'value' => (int) $val];
        }

        return $result;
    }

}
