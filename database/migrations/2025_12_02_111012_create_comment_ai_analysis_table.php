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
        Schema::create('comment_ai_analysis', function (Blueprint $table) {
            $table->id();
            $table->string('comment_id')->unique();
            $table->string('message');
            $table->enum('sentiment', ['positive', 'negative', 'neutral'])->nullable();
            $table->enum('type', [
                'hoi_gia',
                'hoi_thong_tin',
                'khieu_nai',
                'spam',
                'khen_ngoi',
                'khac'
            ])->nullable();
            $table->boolean('should_reply')->default(false);
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->decimal('confidence', 3, 2)->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['sentiment', 'should_reply']);
            $table->index(['type', 'priority']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_ai_analysis');
    }
};