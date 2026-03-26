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
        try {
            // Step 1: Get comments that haven't been analyzed yet
            $comments = CampaignAnalytics::whereDoesntHave('commentAiAnalysis')
                ->whereNotNull('comments_data')
                ->where('comments_data', '!=', '[]')
                ->limit(50) // Process in batches
                ->get();

            if ($comments->isEmpty()) {
                return;
            }

            // Step 2: Process each comment
            $processedCount = 0;
            $dispatchedJobs = 0;

            foreach ($comments as $comment) {
                // Extract comments from comments_data
                $commentsData = $comment->comments_data;
                
                if (is_array($commentsData)) {
                    foreach ($commentsData as $commentData) {
                        if (isset($commentData['id']) && isset($commentData['message'])) {
                            // Dispatch job for each comment
                            ProcessCommentForAutoReply::dispatch($commentData, $comment->id);
                            $dispatchedJobs++;
                        }
                    }
                }
                
                $processedCount++;
            }

        } catch (\Exception $e) {
            return 1; // Return error code
        }
    }
}
