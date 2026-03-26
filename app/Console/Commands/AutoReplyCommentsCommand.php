<?php

namespace App\Console\Commands;

use App\Jobs\ProcessCommentForAutoReply;
use App\Models\Dashboard\CampaignTracking\PostComment;
use Illuminate\Console\Command;

class AutoReplyCommentsCommand extends Command
{
    protected $signature = 'auto-reply:comments';
    protected $description = 'Process comments for auto-reply using Python microservice';

    public function handle()
    {
        try {
            // Get comments that haven't been analyzed yet, in batches
            $comments = PostComment::doesntHave('aiAnalysis')
                ->with('campaignAnalytics') // eager load for post_message context
                ->limit(50)
                ->get();

            if ($comments->isEmpty()) {
                return;
            }

            $dispatchedJobs = 0;

            foreach ($comments as $postComment) {
                // Pass the PostComment model and its analytics ID to the job
                ProcessCommentForAutoReply::dispatch(
                    $postComment,
                    $postComment->campaign_analytics_id
                );
                $dispatchedJobs++;
            }

        } catch (\Exception $e) {
            return 1;
        }
    }
}
