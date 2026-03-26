<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // New normalized table replacing comments_data JSON blob in campaign_analytics
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_analytics_id')
                  ->constrained('campaign_analytics')
                  ->onDelete('cascade');
            $table->string('facebook_comment_id')->unique(); // Facebook comment ID
            $table->string('parent_comment_id')->nullable(); // For nested replies
            $table->text('message');
            $table->string('from_facebook_id')->nullable();
            $table->string('from_name')->nullable();
            $table->unsignedInteger('like_count')->default(0);
            $table->timestamp('comment_created_at')->nullable();
            $table->timestamps();

            $table->index(['campaign_analytics_id']);
            $table->index(['facebook_comment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
