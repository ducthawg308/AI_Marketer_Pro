<?php

namespace App\Console\Commands;

use App\Jobs\ProcessCommentForAutoReply;
use App\Models\Dashboard\CampaignTracking\CampaignAnalytics;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoReplyCommentsCommand extends Command
{
    protected $signature = 'auto-reply:comments';
    protected $description = 'Process comments for auto-reply using Python microservice';

    public function handle()
    {
        $this->info('=== STARTING AUTO-REPLY COMMENT PROCESSING ===');
        Log::info('AutoReplyCommentsCommand: Starting comment processing');

        try {
            // Step 1: Get comments that haven't been analyzed yet
            $this->info('Step 1: Fetching unanalyzed comments...');
            Log::info('AutoReplyCommentsCommand: Fetching unanalyzed comments');
            
            $comments = CampaignAnalytics::whereDoesntHave('commentAiAnalysis')
                ->whereNotNull('comments_data')
                ->where('comments_data', '!=', '[]')
                ->limit(50) // Process in batches
                ->get();

            $this->info("Found {$comments->count()} comments with unanalyzed data");
            Log::info("AutoReplyCommentsCommand: Found {$comments->count()} comments to process");

            if ($comments->isEmpty()) {
                $this->info('No new comments to process. Exiting.');
                Log::info('AutoReplyCommentsCommand: No comments to process');
                return;
            }

            // Step 2: Process each comment
            $processedCount = 0;
            $dispatchedJobs = 0;

            foreach ($comments as $comment) {
                $this->info("Processing comment batch from campaign analytics ID: {$comment->id}");
                Log::info("AutoReplyCommentsCommand: Processing campaign analytics ID: {$comment->id}");
                
                // Extract comments from comments_data
                $commentsData = $comment->comments_data;
                
                if (is_array($commentsData)) {
                    $this->info("Found " . count($commentsData) . " individual comments in this batch");
                    Log::info("AutoReplyCommentsCommand: Found " . count($commentsData) . " comments in batch");
                    
                    foreach ($commentsData as $commentData) {
                        if (isset($commentData['id']) && isset($commentData['message'])) {
                            $this->info("  - Dispatching job for comment ID: {$commentData['id']}");
                            Log::info("AutoReplyCommentsCommand: Dispatching job for comment ID: {$commentData['id']}");
                            
                            // Dispatch job for each comment
                            ProcessCommentForAutoReply::dispatch($commentData, $comment->id);
                            $dispatchedJobs++;
                        } else {
                            $this->warn("  - Skipping invalid comment data (missing ID or message)");
                            Log::warning("AutoReplyCommentsCommand: Skipping invalid comment data", ['comment_data' => $commentData]);
                        }
                    }
                } else {
                    $this->warn("Comments data is not an array for campaign analytics ID: {$comment->id}");
                    Log::warning("AutoReplyCommentsCommand: Comments data is not an array", ['campaign_analytics_id' => $comment->id]);
                }
                
                $processedCount++;
            }

            // Step 3: Summary
            $this->info('=== PROCESSING SUMMARY ===');
            $this->info("Total campaign analytics processed: {$processedCount}");
            $this->info("Total jobs dispatched: {$dispatchedJobs}");
            $this->info('Auto-reply comment processing completed successfully.');
            
            Log::info('AutoReplyCommentsCommand: Processing completed', [
                'campaigns_processed' => $processedCount,
                'jobs_dispatched' => $dispatchedJobs
            ]);

        } catch (\Exception $e) {
            $this->error('Error occurred during comment processing: ' . $e->getMessage());
            Log::error('AutoReplyCommentsCommand: Error during processing', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1; // Return error code
        }
    }
}
