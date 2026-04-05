<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('ads', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->enum('type', ['manual', 'product', 'link'])->default('manual');
      $table->string('media_type')->default('text'); // text, image, video
      $table->string('link', 500)->nullable();
      $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
      $table->foreignId('video_id')->nullable()->constrained('videos')->onDelete('set null');
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

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ads');
  }
};
