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
            $table->enum('objective', ['awareness', 'engagement', 'leads', 'sales', 'other'])->default('other');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('frequency', ['daily', 'weekly', 'custom'])->default('daily');
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
