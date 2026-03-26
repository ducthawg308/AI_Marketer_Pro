<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comment_ai_analysis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_comment_id')
                  ->unique()
                  ->constrained('post_comments')
                  ->onDelete('cascade');
            $table->string('facebook_comment_id')->index();
            $table->text('message');
            $table->enum('sentiment', ['positive', 'negative', 'neutral'])->nullable();
            $table->enum('type', [
                'hoi_gia',
                'hoi_thong_tin',
                'khieu_nai',
                'spam',
                'khen_ngoi',
                'khac',
            ])->nullable();
            $table->boolean('should_reply')->default(false);
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->decimal('confidence', 3, 2)->nullable();
            $table->timestamps();

            $table->index(['sentiment', 'should_reply']);
            $table->index(['type', 'priority']);
            $table->index(['should_reply', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comment_ai_analysis');
    }
};