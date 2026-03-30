<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('market_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Status tracking
            $table->enum('status', ['pending', 'collecting', 'analyzing', 'generating', 'completed', 'failed'])
                  ->default('pending');
            $table->string('current_step', 255)->nullable();
            $table->unsignedTinyInteger('progress_percent')->default(0);
            $table->text('error_message')->nullable();

            // Stage 1: Raw Data từ SerpApi
            $table->json('raw_data')->nullable();

            // Stage 2: Kết quả xử lý từ Python Microservice
            $table->json('quantitative_analysis')->nullable();

            // Stage 3: Kết quả phân tích định tính từ Gemini
            $table->json('qualitative_analysis')->nullable();

            // Chart-ready data (pre-processed cho Chart.js)
            $table->json('chart_data')->nullable();

            // Timestamps for each stage
            $table->timestamp('data_collected_at')->nullable();
            $table->timestamp('analysis_completed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'status']);
            $table->index(['user_id', 'created_at']);
            $table->unique('product_id'); // 1 report per product
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_reports');
    }
};
