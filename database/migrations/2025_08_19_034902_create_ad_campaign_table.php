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
        Schema::create('ad_campaign', function (Blueprint $table) {
            $table->unsignedBigInteger('ad_id');
            $table->unsignedBigInteger('campaign_id');
            
            $table->primary(['ad_id', 'campaign_id']);
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_campaign');
    }
};
