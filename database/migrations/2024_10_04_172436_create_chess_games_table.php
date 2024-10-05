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
        Schema::create('chess_games', function (Blueprint $table) {
            $table->id();
            $table->integer('board_size'); // Board size
            $table->integer('total_obstacles'); // Total obstacles
            $table->integer('queen_rows'); // Queen row
            $table->integer('queen_columns'); // Queen column
            $table->json('obstacles'); // Obstacles in JSON format
            $table->integer('attacks'); // Attack result
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chess_games');
    }
};
