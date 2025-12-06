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

            // Surface data only - Reaction metrics (separated by type)
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

            // Post info fields
            $table->string('status_type')->nullable(); // Loại post: status, photo, video, etc.
            $table->text('post_message')->nullable(); // Nội dung bài post
            $table->timestamp('post_created_time')->nullable(); // Thời gian đăng post
            $table->timestamp('post_updated_time')->nullable(); // Thời gian cập nhật post cuối
            $table->string('post_permalink_url')->nullable(); // Link đến post

            // Detailed comments data
            $table->json('comments_data')->nullable(); // JSON array of comments with details



            // Surface data metadata
            $table->timestamp('fetched_at');
            $table->date('insights_date'); // Date this data represents

            $table->timestamps();

            // Indexes for performance
            $table->index(['campaign_id', 'insights_date']);
            $table->index(['ad_schedule_id']);
            $table->index(['facebook_post_id']);
            $table->unique(['ad_schedule_id', 'insights_date'], 'unique_schedule_date_analytics');
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
