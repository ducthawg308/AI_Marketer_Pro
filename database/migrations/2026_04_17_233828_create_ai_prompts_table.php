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
    Schema::create('ai_prompts', function (Blueprint $table) {
      $table->id();
      $table->string('slug')->unique();
      $table->string('name');
      $table->string('group');
      $table->text('content');
      $table->string('role')->nullable();
      $table->text('notes')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ai_prompts');
  }
};
