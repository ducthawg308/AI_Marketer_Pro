<?php

namespace App\Services\Dashboard\DataCrawlers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Traits\DataCleaner;

class YouTubeCrawler
{
    use DataCleaner;

    protected $apiKey;
    protected $baseUrl = 'https://www.googleapis.com/youtube/v3';

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
    }

    public function searchVideos($keyword, $maxResults = 15, $regionCode = 'VN')
    {
        if (!$this->apiKey) {
            return ['success' => false, 'error' => 'Missing YouTube API key'];
        }

        try {
            $url = "{$this->baseUrl}/search";
            $response = Http::get($url, [
                'part' => 'snippet',
                'q' => $keyword,
                'maxResults' => $maxResults,
                'type' => 'video',
                'regionCode' => $regionCode,
                'relevanceLanguage' => 'vi',
                'order' => 'relevance',
                'key' => $this->apiKey
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $items = $data['items'] ?? [];
                $videoIds = implode(',', array_column(array_column($items, 'id'), 'videoId'));
                $statistics = $this->getVideoStatistics($videoIds);

                $result = [
                    'success' => true,
                    'source' => 'youtube',
                    'keyword' => $keyword,
                    'videos' => array_map(function($item) use ($statistics) {
                        $videoId = $item['id']['videoId'] ?? '';
                        $stats = $statistics[$videoId] ?? [];
                        return [
                            'video_id' => $videoId,
                            'title' => $item['snippet']['title'] ?? '',
                            'description' => $item['snippet']['description'] ?? '',
                            'channel' => $item['snippet']['channelTitle'] ?? '',
                            'published_at' => $item['snippet']['publishedAt'] ?? '',
                            'thumbnail' => $item['snippet']['thumbnails']['high']['url'] ?? '',
                            'url' => "https://www.youtube.com/watch?v={$videoId}",
                            'view_count' => $stats['viewCount'] ?? 0,
                            'like_count' => $stats['likeCount'] ?? 0,
                            'comment_count' => $stats['commentCount'] ?? 0,
                        ];
                    }, $items),
                    'summary' => [
                        'total_videos' => count($items),
                        'total_views' => array_sum(array_column($statistics, 'viewCount')),
                        'avg_views' => count($statistics) > 0 ? 
                            round(array_sum(array_column($statistics, 'viewCount')) / count($statistics)) : 0
                    ]
                ];

                $result['videos'] = $this->cleanArrayItems($result['videos'], ['title', 'description', 'channel']);
                $result['videos'] = $this->normalizeDatesInArray($result['videos'], ['published_at']);
                $result['videos'] = $this->removeEmptyAndDuplicates($result['videos'], 'video_id', 100, 'view_count');

                return $result;
            }

            return ['success' => false, 'error' => 'YouTube API failed'];
            
        } catch (\Exception $e) {
            Log::error('YouTube API error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function getVideoStatistics($videoIds)
    {
        if (empty($videoIds)) return [];
        try {
            $response = Http::get("{$this->baseUrl}/videos", [
                'part' => 'statistics',
                'id' => $videoIds,
                'key' => $this->apiKey
            ]);
            if (!$response->successful()) return [];

            $result = [];
            foreach ($response->json()['items'] as $item) {
                $videoId = $item['id'] ?? '';
                $stats = $item['statistics'] ?? [];
                $result[$videoId] = [
                    'viewCount' => (int)($stats['viewCount'] ?? 0),
                    'likeCount' => (int)($stats['likeCount'] ?? 0),
                    'commentCount' => (int)($stats['commentCount'] ?? 0),
                ];
            }
            return $result;
        } catch (\Exception $e) {
            Log::error('YouTube statistics error: ' . $e->getMessage());
            return [];
        }
    }
}