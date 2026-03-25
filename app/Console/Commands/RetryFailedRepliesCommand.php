<?php

namespace App\Console\Commands;

use App\Models\Dashboard\CampaignTracking\CommentAutoReply;
use App\Models\Dashboard\CampaignTracking\CommentAiAnalysis;
use App\Models\Facebook\UserPage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RetryFailedRepliesCommand extends Command
{
    protected $signature = 'auto-reply:retry-failed {--limit=10 : Number of failed replies to retry}';
    protected $description = 'Retry failed auto-reply comments';

    public function handle()
    {
        $limit = $this->option('limit');
        
        $this->info("Starting retry process for failed replies (limit: {$limit})...");

        // Get failed replies
        $failedReplies = CommentAutoReply::where('status', 'failed')
            ->where('retry_count', '<', 3) // Max 3 retries
            ->limit($limit)
            ->get();

        if ($failedReplies->isEmpty()) {
            $this->info('No failed replies to retry.');
            return;
        }

        $this->info("Found {$failedReplies->count()} failed replies to retry.");

        $successCount = 0;
        $failCount = 0;

        foreach ($failedReplies as $reply) {
            try {
                $result = $this->retryReply($reply);
                
                if ($result['success']) {
                    $successCount++;
                    $this->info("Successfully retried reply for comment: {$reply->comment_id}");
                } else {
                    $failCount++;
                    $this->error("Failed to retry reply for comment: {$reply->comment_id}");
                }
                
            } catch (\Exception $e) {
                $failCount++;
                $this->error("Error retrying reply for comment {$reply->comment_id}: " . $e->getMessage());
                Log::error('Error retrying failed reply', [
                    'comment_id' => $reply->comment_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info("Retry process completed. Success: {$successCount}, Failed: {$failCount}");
    }

    protected function retryReply(CommentAutoReply $reply)
    {
        $commentId = $reply->comment_id;
        Log::info("RetryFailedRepliesCommand: Starting retry for comment: {$commentId}");
        
        try {
            // Get the analysis to find the page
            $this->info("Getting analysis for comment: {$commentId}");
            $analysis = CommentAiAnalysis::where('comment_id', $commentId)->first();
            if (!$analysis) {
                $this->warn("Analysis not found for comment: {$commentId}");
                Log::warning("RetryFailedRepliesCommand: Analysis not found for comment: {$commentId}");
                return ['success' => false, 'error' => 'Analysis not found'];
            }

            // Get campaign analytics to find the page
            $this->info("Getting campaign analytics for comment: {$commentId}");
            $campaignAnalytics = $analysis->campaignAnalytics;
            if (!$campaignAnalytics || !$campaignAnalytics->adSchedule) {
                $this->warn("Campaign analytics or ad schedule not found for comment: {$commentId}");
                Log::warning("RetryFailedRepliesCommand: Campaign analytics or ad schedule not found for comment: {$commentId}");
                return ['success' => false, 'error' => 'Campaign analytics not found'];
            }

            $userPage = $campaignAnalytics->adSchedule->userPage;
            if (!$userPage || !$userPage->page_access_token) {
                $this->warn("User page or page access token not found for comment: {$commentId}");
                Log::warning("RetryFailedRepliesCommand: User page or page access token not found for comment: {$commentId}");
                return ['success' => false, 'error' => 'Page access token not found'];
            }

            $this->info("Sending retry reply to Facebook for comment: {$commentId}");
            Log::info("RetryFailedRepliesCommand: Sending retry reply to Facebook for comment: {$commentId}");

            // Send reply to Facebook
            $replyResult = $this->sendReplyToFacebook($commentId, $reply->reply_text, $userPage);

            // Update retry count
            $reply->increment('retry_count');
            $this->info("Retry count incremented for comment: {$commentId}");

            // Update status
            $reply->update([
                'status' => $replyResult['success'] ? 'success' : 'failed',
                'response_fb' => $replyResult['response'] ?? null,
            ]);

            $this->info("Retry completed for comment: {$commentId}, status: " . ($replyResult['success'] ? 'SUCCESS' : 'FAILED'));
            Log::info("RetryFailedRepliesCommand: Retry completed for comment: {$commentId}", [
                'status' => $replyResult['success'] ? 'success' : 'failed',
                'response' => $replyResult['response']
            ]);

            return $replyResult;

        } catch (\Exception $e) {
            $this->error("Error retrying reply for comment {$commentId}: " . $e->getMessage());
            Log::error('RetryFailedRepliesCommand: Error in retryReply', [
                'comment_id' => $commentId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    protected function sendReplyToFacebook($commentId, $message, UserPage $userPage)
    {
        $this->info("Sending Facebook API request for comment: {$commentId}");
        $this->info("Reply message: {$message}");
        $this->info("Page ID: {$userPage->page_id}");
        
        try {
            // Add random delay (5-30 seconds) to avoid spam detection
            $delay = rand(5, 30);
            $this->info("Adding delay of {$delay} seconds to avoid spam detection...");
            sleep($delay);

            $this->info("Making Facebook API request...");
            $response = Http::post("https://graph.facebook.com/v25.0/{$commentId}/comments", [
                'message' => $message,
                'access_token' => $userPage->page_access_token,
            ]);

            $this->info("Facebook API response status: {$response->status()}");
            $this->info("Facebook API response body: " . $response->body());

            return [
                'success' => $response->successful(),
                'response' => $response->json()
            ];

        } catch (\Exception $e) {
            $this->error("Facebook API request failed with exception: {$e->getMessage()}");
            return [
                'success' => false,
                'response' => ['error' => $e->getMessage()]
            ];
        }
    }
}