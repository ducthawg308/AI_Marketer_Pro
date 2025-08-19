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
        Schema::create('ad_schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_id');
            $table->unsignedBigInteger('user_page_id');
            $table->dateTime('scheduled_time');
            $table->enum('status', ['pending', 'posted', 'failed'])->default('pending');
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_interval', 50)->nullable();
            $table->timestamps();

            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');
            $table->foreign('user_page_id')->references('id')->on('user_pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_schedule');
    }
};
