<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChessGameControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_queens_attack_with_five_obstacles()
    {
        $response = $this->postJson('/api/problem-1', [
            'board_size' => 5,
            'total_obstacles' => 3,
            'queen_rows' => 4,
            'queen_columns' => 3,
            'obstacles' => [
                [5, 5], // Obstacle to the right
                [4, 2], // Obstacle to the left
                [2, 3], // Obstacle above
            ],
        ]);

        // Verify that the response is successful
        $response->assertStatus(200);

        // Verify that the game is saved
        //$this->assertDatabaseHas('chess_games', [
        //    'board_size' => 5,
        //    'total_obstacles' => 3,
        //    'queen_rows' => 4,
        //    'queen_columns' => 3,
        //    'obstacles' => json_encode([
        //        [5, 5], // Obstacle to the right
        //        [4, 2], // Obstacle to the left
        //        [2, 3], // Obstacle above
        //    ]),
        //]);

        // Verify result
        $this->assertEquals(10, $response->json('data.attacks'));
    }
}
