<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comment_auto_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_ai_analysis_id')
                  ->constrained('comment_ai_analysis')
                  ->onDelete('cascade');
            $table->text('reply_text');
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->unsignedTinyInteger('retry_count')->default(0);
            $table->json('response_fb')->nullable(); // store full FB API response
            $table->timestamps();

            $table->index(['status', 'retry_count']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comment_auto_replies');
    }
};