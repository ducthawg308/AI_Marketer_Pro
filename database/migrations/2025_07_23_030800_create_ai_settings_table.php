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
        Schema::create('ai_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('tone', ['friendly', 'professional', 'funny', 'emotional'])->default('friendly');
            $table->enum('length', ['short', 'medium', 'long'])->default('medium');
            $table->enum('platform', ['Facebook', 'Zalo', 'TikTok', 'Shopee'])->default('Facebook');
            $table->enum('language', ['Vietnamese', 'English'])->default('Vietnamese');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_settings');
    }
};
