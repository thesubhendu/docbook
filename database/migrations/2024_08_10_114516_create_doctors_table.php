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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('specialization_id')->constrained();
            $table->text('bio')->nullable();
            $table->json('availability')->nullable(); // JSON format: { "Monday": ["09:00-12:00", "14:00-18:00"], "Wednesday": ["10:00-13:00"] }
            $table->json('exceptions')->nullable(); // {   "2024-11-05": null,// Unavailable the entire day   "2024-11-07": ["09:00-12:00"],     // Unavailable from 9 AM to 12 PM   "2024-11-10": ["14:00-16:00"]      // Unavailable from 2 PM to 4 PM }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
