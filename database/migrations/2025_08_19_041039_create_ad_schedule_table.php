<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ad_id')->constrained()->onDelete('cascade');
            $table->foreignId('campaign_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_page_id')->constrained()->onDelete('cascade');
            $table->dateTime('scheduled_time');
            $table->enum('status', ['pending', 'posted', 'failed'])->default('pending');
            $table->string('facebook_post_id')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status', 'scheduled_time'], 'idx_schedule_user_status_time');
            $table->index(['campaign_id', 'status']);
            $table->index(['facebook_post_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_schedule');
    }
};
