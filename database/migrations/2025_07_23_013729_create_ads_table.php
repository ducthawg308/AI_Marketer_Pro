<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['manual', 'product', 'link'])->default('manual');
            $table->string('link', 500)->nullable();
            $table->string('ad_title', 255);
            $table->text('ad_content');
            $table->json('hashtags')->nullable();
            $table->json('emojis')->nullable();
            $table->enum('status', ['draft', 'approved'])->default('draft');
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
