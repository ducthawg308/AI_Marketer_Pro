<?php

namespace App\Services\Dashboard\DataCrawlers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Traits\DataCleaner;

class GoogleTrendsCrawler
{
    use DataCleaner;

    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.serpapi.api_key');
        $this->baseUrl = config('services.serpapi.base_url');
    }

    public function fetchTrends($keyword, $geo = 'VN', $timeRange = null)
    {
        if (!$this->apiKey) {
            Log::warning('SerpAPI API key chưa được cấu hình');
            return [
                'success' => false,
                'error' => 'Missing SerpAPI API key',
                'note' => 'Vui lòng cấu hình SERPAPI_API_KEY trong .env'
            ];
        }

        try {
            $params = [
                'engine' => 'google_trends',
                'q' => $keyword,
                'geo' => $geo,
                'data_type' => 'TIMESERIES',
                'api_key' => $this->apiKey,
                'hl' => 'vi',
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
            $timelineData = $data['interest_over_time']['timeline_data'] ?? [];
            $relatedQueries = $data['related_queries']['top'] ?? [];

            $result = [
                'success' => true,
                'source' => 'google_trends_serpapi',
                'keyword' => $keyword,
                'geo' => $geo,
                'timeline_data' => array_map(function($item) {
                    return [
                        'date' => $this->normalizeDateFromTimestamp($item['timestamp'] ?? null), // Use timestamp instead of text date
                        'timestamp' => $item['timestamp'] ?? null,
                        'original_date' => $item['date'] ?? null, // Keep original for reference
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

            // Don't use normalizeDatesInArray anymore since we already normalized in the mapping
            $result['timeline_data'] = $this->removeEmptyAndDuplicates($result['timeline_data'], 'date', 0, 'extracted_value');

            $result['related_queries'] = $this->cleanArrayItems($result['related_queries'], ['query']);
            $result['related_queries'] = $this->removeEmptyAndDuplicates($result['related_queries'], 'query', 5, 'value');

            return $result;

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

    private function normalizeDateFromTimestamp($timestamp)
    {
        if (empty($timestamp) || !is_numeric($timestamp)) {
            return null;
        }
        return date('Y-m-d H:i:s', $timestamp);
    }

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
                $raw = $response->json();
                $top = $raw['related_queries']['top'] ?? [];

                $cleaned = array_map(fn($item) => [
                    'query' => $item['query'] ?? '',
                    'value' => $item['value'] ?? 0,
                    'extracted_value' => $item['extracted_value'] ?? 0,
                ], $top);

                $cleaned = $this->cleanArrayItems($cleaned, ['query']);
                $cleaned = $this->removeEmptyAndDuplicates($cleaned, 'query', 10, 'value');

                return [
                    'success' => true,
                    'data' => $cleaned
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
