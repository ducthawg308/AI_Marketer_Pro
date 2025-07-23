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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('industry');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('target_customer_age_range')->nullable();
            $table->string('target_customer_income_level')->nullable();
            $table->text('target_customer_interests')->nullable();
            $table->string('competitor_name')->nullable();
            $table->string('competitor_url')->nullable();
            $table->text('competitor_description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};