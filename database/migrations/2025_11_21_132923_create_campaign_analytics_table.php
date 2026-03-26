<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaign_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('ad_schedule_id')->constrained('ad_schedule')->onDelete('cascade');

            // Reaction metrics
            $table->unsignedInteger('reactions_total')->default(0);
            $table->unsignedInteger('reactions_like')->default(0);
            $table->unsignedInteger('reactions_love')->default(0);
            $table->unsignedInteger('reactions_wow')->default(0);
            $table->unsignedInteger('reactions_haha')->default(0);
            $table->unsignedInteger('reactions_sorry')->default(0);
            $table->unsignedInteger('reactions_anger')->default(0);

            // Engagement counters
            $table->unsignedInteger('comments')->default(0);
            $table->unsignedInteger('shares')->default(0);

            // Post info (synced from Facebook at fetch time)
            $table->string('status_type')->nullable();
            $table->text('post_message')->nullable();
            $table->timestamp('post_created_time')->nullable();
            $table->timestamp('post_updated_time')->nullable();
            $table->string('post_permalink_url')->nullable();

            // Tracking
            $table->timestamp('fetched_at');
            $table->date('insights_date');
            $table->timestamps();

            $table->index(['campaign_id', 'insights_date']);
            $table->index(['ad_schedule_id', 'insights_date']);
            $table->unique(['ad_schedule_id', 'insights_date'], 'unique_schedule_date_analytics');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_analytics');
    }
};
