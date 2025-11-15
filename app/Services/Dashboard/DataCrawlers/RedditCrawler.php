<?php

namespace App\Services\Dashboard\DataCrawlers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Traits\DataCleaner;

class RedditCrawler
{
    use DataCleaner;

    protected $baseUrl = 'https://www.reddit.com';

    public function searchPosts($keyword, $limit = 15, $timeRange = 'month')
    {
        try {
            $url = "{$this->baseUrl}/search.json";
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (compatible; MarketResearch/1.0)'
            ])->get($url, [
                'q' => $keyword,
                'limit' => $limit,
                'sort' => 'relevance',
                't' => $timeRange,
                'type' => 'link'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $posts = $data['data']['children'] ?? [];

                $result = [
                    'success' => true,
                    'source' => 'reddit',
                    'keyword' => $keyword,
                    'posts' => array_map(function($post) {
                        $p = $post['data'];
                        return [
                            'title' => $p['title'] ?? '',
                            'text' => $p['selftext'] ?? '',
                            'score' => $p['score'] ?? 0,
                            'num_comments' => $p['num_comments'] ?? 0,
                            'upvote_ratio' => $p['upvote_ratio'] ?? 0,
                            'subreddit' => $p['subreddit'] ?? '',
                            'url' => 'https://reddit.com' . ($p['permalink'] ?? ''),
                            'created' => date('Y-m-d H:i:s', $p['created_utc'] ?? 0),
                        ];
                    }, $posts),
                    'summary' => [
                        'total_posts' => count($posts),
                        'avg_score' => $this->calculateAvgScore($posts),
                        'total_comments' => $this->calculateTotalComments($posts),
                        'top_subreddits' => $this->getTopSubreddits($posts)
                    ]
                ];

                $result['posts'] = $this->cleanArrayItems($result['posts'], ['title', 'text']);
                $result['posts'] = $this->normalizeDatesInArray($result['posts'], ['created']);
                $result['posts'] = $this->removeEmptyAndDuplicates($result['posts'], 'title', 1, 'score');

                return $result;
            }

            return ['success' => false, 'error' => 'Reddit API failed'];
            
        } catch (\Exception $e) {
            Log::error('Reddit API error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function calculateAvgScore($posts) {}
    private function calculateTotalComments($posts) {}
    private function getTopSubreddits($posts) {}
}