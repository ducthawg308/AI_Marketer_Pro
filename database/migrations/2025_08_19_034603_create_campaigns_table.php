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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('objective', ['brand_awareness', 'reach', 'engagement', 'traffic', 'lead_generation', 'app_promotion', 'conversions', 'sales', 'retention_loyalty', 'video_views'])->default('brand_awareness');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->enum('frequency', ['daily', 'weekly', 'custom'])->default('daily');
            $table->json('pages');
            $table->time('default_time_start')->default('08:00');
            $table->time('default_time_end')->default('20:00');
            $table->json('frequency_config')->nullable();
            $table->enum('status', ['draft', 'running', 'stopped', 'completed'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};