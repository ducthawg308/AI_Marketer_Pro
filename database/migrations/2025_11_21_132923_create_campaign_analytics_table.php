<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaign_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('ad_schedule_id')->constrained('ad_schedule')->onDelete('cascade');
            $table->string('facebook_post_id');

            // Basic engagement metrics
            $table->unsignedInteger('impressions')->default(0); // post_impressions
            $table->unsignedInteger('reach')->default(0); // post_reach
            $table->unsignedInteger('clicks')->default(0); // post_clicks

            // Reaction metrics (separated by type)
            $table->unsignedInteger('reactions_total')->default(0);
            $table->unsignedInteger('reactions_like')->default(0);
            $table->unsignedInteger('reactions_love')->default(0);
            $table->unsignedInteger('reactions_wow')->default(0);
            $table->unsignedInteger('reactions_haha')->default(0);
            $table->unsignedInteger('reactions_sorry')->default(0);
            $table->unsignedInteger('reactions_anger')->default(0);

            // Comments and shares
            $table->unsignedInteger('comments')->default(0);
            $table->unsignedInteger('shares')->default(0);

            // Video metrics (if applicable)
            $table->unsignedInteger('video_views')->default(0);
            $table->unsignedInteger('video_views_3s')->default(0);
            $table->unsignedInteger('video_completions')->default(0);

            // Calculated metrics
            $table->decimal('engagement_rate', 5, 2)->default(0); // (reactions + comments + shares) / impressions * 100
            $table->decimal('click_through_rate', 5, 2)->default(0); // clicks / impressions * 100

            // Insights metadata
            $table->json('raw_insights')->nullable(); // Store full response from Facebook API
            $table->timestamp('fetched_at');
            $table->timestamp('insights_date'); // Date this insight data represents

            $table->timestamps();

            // Indexes for performance
            $table->index(['campaign_id', 'insights_date']);
            $table->index(['ad_schedule_id']);
            $table->index(['facebook_post_id']);
            $table->unique(['ad_schedule_id', 'insights_date'], 'unique_schedule_date_insight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_analytics');
    }
};
