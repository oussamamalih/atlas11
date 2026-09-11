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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scout_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('player_profile_id')->constrained('player_profiles')->cascadeOnDelete();
            $table->timestamps();

            // A scout cannot favorite the same player more than once
            $table->unique(['scout_id', 'player_profile_id']);

            // Secondary index for querying favorites of a player
            $table->index('player_profile_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
