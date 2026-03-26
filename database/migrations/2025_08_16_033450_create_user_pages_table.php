<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('page_id')->unique();
            $table->string('page_name');
            $table->text('page_access_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->string('category')->nullable();
            $table->text('about')->nullable();
            $table->string('link')->nullable();
            $table->unsignedInteger('fan_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->text('avatar_url')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_published']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_pages');
    }
};
