<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('industry');
            $table->text('description')->nullable();
            $table->string('target_customer_age_range')->nullable();
            $table->string('target_customer_income_level')->nullable();
            $table->text('target_customer_interests')->nullable();
            $table->string('competitor_name')->nullable();
            $table->text('competitor_url')->nullable();
            $table->text('competitor_description')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'name'], 'products_user_name_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};