<?php
namespace App\Services\Dashboard\DataCrawlers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleTrendsCrawler
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.google_trends.api_key');
        $this->baseUrl = config('services.google_trends.api_url', 'https://serpapi.com/search');
    }

    /**
     * Lấy dữ liệu trend từ SerpApi
     * @param string $keyword
     * @param string $geo - Mã quốc gia (VN cho Việt Nam)
     * @param string|null $timeRange - không dùng với SerpApi
     * @return array
     */
    public function fetchTrends($keyword, $geo = 'VN', $timeRange = null)
    {
        if (!$this->apiKey) {
            Log::warning('Google Trends API key chưa được cấu hình');
            return [
                'success' => false, 
                'error' => 'Missing Google Trends API key',
                'note' => 'Vui lòng cấu hình GOOGLE_TRENDS_API_KEY trong .env'
            ];
        }

        try {
            // SerpApi Google Trends Interest Over Time
            $params = [
                'engine' => 'google_trends',
                'q' => $keyword,
                'geo' => $geo,
                'data_type' => 'TIMESERIES',
                'api_key' => $this->apiKey,
                'hl' => 'vi', // Ngôn ngữ tiếng Việt
            ];

            Log::info('Đang gọi Google Trends API', ['keyword' => $keyword, 'geo' => $geo]);

            $response = Http::timeout(30)->get($this->baseUrl, $params);

            if (!$response->successful()) {
                Log::error('Google Trends API failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return [
                    'success' => false,
                    'error' => 'GoogleTrends API request failed',
                    'status' => $response->status(),
                    'message' => $response->body()
                ];
            }

            $data = $response->json();

            // Xử lý dữ liệu từ SerpApi
            $timelineData = $data['interest_over_time']['timeline_data'] ?? [];
            $relatedQueries = $data['related_queries']['top'] ?? [];

            return [
                'success' => true,
                'source' => 'google_trends_serpapi',
                'keyword' => $keyword,
                'geo' => $geo,
                'timeline_data' => array_map(function($item) {
                    return [
                        'date' => $item['date'] ?? null,
                        'timestamp' => $item['timestamp'] ?? null,
                        'value' => $item['values'][0]['value'] ?? 0,
                        'extracted_value' => $item['values'][0]['extracted_value'] ?? 0,
                    ];
                }, $timelineData),
                'related_queries' => array_map(function($item) {
                    return [
                        'query' => $item['query'] ?? '',
                        'value' => $item['value'] ?? 0,
                        'extracted_value' => $item['extracted_value'] ?? 0,
                    ];
                }, $relatedQueries),
                'summary' => [
                    'total_data_points' => count($timelineData),
                    'avg_interest' => $this->calculateAverage($timelineData),
                    'peak_interest' => $this->findPeak($timelineData),
                ]
            ];

        } catch (\Exception $e) {
            Log::error('Google Trends Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'Exception: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Tính trung bình interest
     */
    private function calculateAverage($timelineData)
    {
        if (empty($timelineData)) return 0;
        
        $sum = 0;
        $count = 0;
        foreach ($timelineData as $item) {
            $value = $item['values'][0]['extracted_value'] ?? 0;
            $sum += $value;
            $count++;
        }
        
        return $count > 0 ? round($sum / $count, 2) : 0;
    }

    /**
     * Tìm điểm peak (cao nhất)
     */
    private function findPeak($timelineData)
    {
        if (empty($timelineData)) return null;
        
        $peak = null;
        $maxValue = -1;
        
        foreach ($timelineData as $item) {
            $value = $item['values'][0]['extracted_value'] ?? 0;
            if ($value > $maxValue) {
                $maxValue = $value;
                $peak = [
                    'date' => $item['date'] ?? null,
                    'value' => $value
                ];
            }
        }
        
        return $peak;
    }

    /**
     * Lấy related queries
     */
    public function getRelatedQueries($keyword, $geo = 'VN')
    {
        if (!$this->apiKey) {
            return ['success' => false, 'error' => 'Missing API key'];
        }

        $params = [
            'engine' => 'google_trends',
            'q' => $keyword,
            'geo' => $geo,
            'data_type' => 'RELATED_QUERIES',
            'api_key' => $this->apiKey,
        ];

        try {
            $response = Http::timeout(30)->get($this->baseUrl, $params);
            
            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }
            
            return [
                'success' => false,
                'error' => 'Request failed',
                'status' => $response->status()
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}