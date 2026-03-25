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
        Schema::create('comment_auto_replies', function (Blueprint $table) {
            $table->id();
            $table->string('comment_id');
            $table->string('reply_text');
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->integer('retry_count')->default(0);
            $table->text('response_fb')->nullable();
            $table->timestamps();
            
            // Foreign key constraint to comment_ai_analysis
            $table->foreign('comment_id')
                  ->references('comment_id')
                  ->on('comment_ai_analysis')
                  ->onDelete('cascade');
            
            // Indexes for performance
            $table->index(['status', 'retry_count']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_auto_replies');
    }
};