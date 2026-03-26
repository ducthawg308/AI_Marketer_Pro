<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('market_researches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('summary')->nullable();
            $table->enum('research_type', ['consumer', 'competitor', 'trend']);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('report_file')->nullable();
            $table->json('analysis_data')->nullable();
            $table->json('analysis_prompt')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'status']);
            $table->index(['product_id', 'research_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_researches');
    }
};
