<?php
namespace App\Services\Dashboard\DataCrawlers;

use Illuminate\Support\Facades\Http;

class NewsAPICrawler
{
    protected $apiKey;
    protected $baseUrl = 'https://newsapi.org/v2';

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.api_key');
    }

    public function searchNews($keyword, $language = 'vi', $sortBy = 'relevancy')
    {
        if (!$this->apiKey) {
            return ['success' => false, 'error' => 'Missing NewsAPI key'];
        }

        try {
            $url = "{$this->baseUrl}/everything";
            
            $response = Http::get($url, [
                'q' => $keyword,
                'language' => $language,
                'sortBy' => $sortBy,
                'pageSize' => 50,
                'apiKey' => $this->apiKey
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'source' => 'newsapi',
                    'keyword' => $keyword,
                    'articles' => array_map(function($article) {
                        return [
                            'title' => $article['title'] ?? '',
                            'description' => $article['description'] ?? '',
                            'content' => $article['content'] ?? '',
                            'url' => $article['url'] ?? '',
                            'source' => $article['source']['name'] ?? '',
                            'published_at' => $article['publishedAt'] ?? '',
                        ];
                    }, $data['articles'] ?? []),
                    'total_results' => $data['totalResults'] ?? 0
                ];
            }

            return ['success' => false, 'error' => 'NewsAPI failed'];
            
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}