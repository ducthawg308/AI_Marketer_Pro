<?php

namespace App\Services\Dashboard\DataCrawlers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Traits\DataCleaner;

class GoogleShoppingCrawler
{
    use DataCleaner;

    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.serpapi.api_key');
        $this->baseUrl = config('services.serpapi.base_url');
    }

    public function searchShoppingResults($keyword, $location = 'Vietnam', $limit = 15)
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
                'engine' => 'google_shopping',
                'q' => $keyword,
                'location' => $location,
                'api_key' => $this->apiKey,
                'hl' => 'vi',
                'num' => $limit,
            ];

            Log::info('Đang gọi Google Shopping API', ['keyword' => $keyword, 'location' => $location]);

            $response = Http::timeout(30)->get($this->baseUrl, $params);

            if (!$response->successful()) {
                Log::error('Google Shopping API failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return [
                    'success' => false,
                    'error' => 'Google Shopping API request failed',
                    'status' => $response->status(),
                    'message' => $response->body()
                ];
            }

            $data = $response->json();
            $shoppingResults = $data['shopping_results'] ?? [];

            $result = [
                'success' => true,
                'source' => 'google_shopping_serpapi',
                'keyword' => $keyword,
                'location' => $location,
                'products' => array_map(function($item) {
                    return [
                        'title' => $item['title'] ?? '',
                        'link' => $item['link'] ?? '',
                        'source' => $item['source'] ?? '',
                        'price' => $item['price'] ?? '',
                        'extracted_price' => $item['extracted_price'] ?? 0,
                        'rating' => $item['rating'] ?? 0,
                        'reviews' => $item['reviews'] ?? 0,
                        'thumbnail' => $item['thumbnail'] ?? '',
                        'snippet' => $item['snippet'] ?? '',
                    ];
                }, $shoppingResults),
                'summary' => [
                    'total_products' => count($shoppingResults),
                    'avg_price' => $this->calculateAveragePrice($shoppingResults),
                    'total_reviews' => $this->calculateTotalReviews($shoppingResults),
                    'avg_rating' => $this->calculateAverageRating($shoppingResults),
                ]
            ];

            $result['products'] = $this->cleanArrayItems($result['products'], ['title', 'source']);
            $result['products'] = $this->removeEmptyAndDuplicates($result['products'], 'title', 0, 'extracted_price');

            return $result;

        } catch (\Exception $e) {
            Log::error('Google Shopping Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'Exception: ' . $e->getMessage()
            ];
        }
    }

    private function calculateAveragePrice($products)
    {
        $prices = array_filter(array_column($products, 'extracted_price'));
        if (empty($prices)) return 0;
        return round(array_sum($prices) / count($prices), 2);
    }

    private function calculateTotalReviews($products)
    {
        return array_sum(array_column($products, 'reviews'));
    }

    private function calculateAverageRating($products)
    {
        $ratings = array_filter(array_column($products, 'rating'));
        if (empty($ratings)) return 0;
        return round(array_sum($ratings) / count($ratings), 1);
    }
}
