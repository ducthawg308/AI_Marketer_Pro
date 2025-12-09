<?php

namespace App\Services\Dashboard\CampaignTracking;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MLService
{
    private const ML_BASE_URL = 'http://localhost:8001';

    /**
     * Call ML service to predict engagement for a post
     */
    public function predictEngagement(array $data): ?array
    {
        try {
            $response = Http::timeout(10)->post(self::ML_BASE_URL . '/predict-engagement', [
                'content' => $data['content'] ?? '',
                'reacts' => $data['reacts'] ?? 0,
                'shares' => $data['shares'] ?? 0,
                'comments' => $data['comments'] ?? 0,
                'time_posted' => $data['time_posted'] ?? now()->toISOString()
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("ML Service engagement prediction failed: " . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error("ML Service connection error (engagement): " . $e->getMessage());
            return null;
        }
    }

    /**
     * Call ML service to analyze sentiment and intent from comments
     */
    public function predictSentiment(array $comments): ?array
    {
        if (empty($comments)) {
            return null;
        }

        try {
            $response = Http::timeout(10)->post(self::ML_BASE_URL . '/predict-sentiment', [
                'comments' => $comments
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("ML Service sentiment analysis failed: " . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error("ML Service connection error (sentiment): " . $e->getMessage());
            return null;
        }
    }

    /**
     * Call ML service to optimize content
     */
    public function optimizeContent(string $content): ?array
    {
        try {
            $response = Http::timeout(15)->post(self::ML_BASE_URL . '/optimize-content', [
                'content' => $content
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("ML Service content optimization failed: " . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error("ML Service connection error (optimize): " . $e->getMessage());
            return null;
        }
    }

    /**
     * Call ML service to detect anomalies in engagement data
     */
    public function detectAnomaly(array $engagementData, array $timestamps): ?array
    {
        if (empty($engagementData) || count($engagementData) < 3) {
            return null;
        }

        try {
            $response = Http::timeout(10)->post(self::ML_BASE_URL . '/detect-anomaly', [
                'engagement_data' => $engagementData,
                'timestamps' => $timestamps
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("ML Service anomaly detection failed: " . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error("ML Service connection error (anomaly): " . $e->getMessage());
            return null;
        }
    }

    /**
     * Analyze single post with all ML services
     */
    public function analyzePost($analytics): array
    {
        $result = [
            'engagement_prediction' => null,
            'sentiment_analysis' => null,
            'content_optimization' => null
        ];

        // Engagement prediction
        $engagementData = [
            'content' => $analytics->post_message ?? '',
            'reacts' => $analytics->reactions_total ?? 0,
            'shares' => $analytics->shares ?? 0,
            'comments' => $analytics->comments ?? 0,
            'time_posted' => $analytics->post_created_time?->toISOString() ?? now()->toISOString()
        ];
        $result['engagement_prediction'] = $this->predictEngagement($engagementData);

        // Sentiment analysis for comments
        if ($analytics->comments_data && is_array($analytics->comments_data)) {
            $comments = array_column($analytics->comments_data, 'message');
            $comments = array_filter($comments); // Remove empty comments
            if (!empty($comments)) {
                $result['sentiment_analysis'] = $this->predictSentiment(array_slice($comments, 0, 50)); // Limit to 50 comments
            }
        }

        // Content optimization (optional - only if post has content)
        if ($analytics->post_message) {
            $result['content_optimization'] = $this->optimizeContent($analytics->post_message);
        }

        return $result;
    }

    /**
     * Check if ML service is available
     */
    public function isServiceAvailable(): bool
    {
        try {
            $response = Http::timeout(5)->get(self::ML_BASE_URL . '/docs');
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
