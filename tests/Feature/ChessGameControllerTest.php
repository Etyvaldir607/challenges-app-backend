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
            'board_size' => 8,
            'total_obstacles' => 5,
            'queen_rows' => 4,
            'queen_columns' => 4,
            'obstacles' => [
                [3, 5], // Obstacle to the right
                [5, 4], // Obstacle below
                [4, 2], // Obstacle to the left
                [2, 4], // Obstacle above
                [5, 5], // Obstacle bottom-right diagonal
            ],
        ]);

        // Verificamos que la respuesta es un éxito
        $response->assertStatus(200);

        // Verificamos que se guarda la partida
        //$this->assertDatabaseHas('chess_games', [
        //    'board_size' => 8,
        //    'total_obstacles' => 5,
        //    'queen_rows' => 4,
        //    'queen_columns' => 4,
        //    'obstacles' => json_encode([
        //        [3, 5],
        //        [5, 4],
        //        [4, 2],
        //        [2, 4],
        //        [5, 5],
        //    ]),
        //]);

        // Puedes verificar el número de ataques esperados
        $expectedAttacks = 13; // Ajusta este número al resultado esperado para tus obstáculos
        $this->assertEquals($expectedAttacks, $response->json('data.attacks'));
    }
}
