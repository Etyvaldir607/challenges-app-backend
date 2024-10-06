<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StringValueGameControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_string_values_with_nine_characters()
    {
        $response = $this->postJson('/api/problem-2', [
            'string_value' => 'abcabcddd'
        ]);

        // Verify that the response is successful
        $response->assertStatus(200);

        // Verify that the game is saved
        //$this->assertDatabaseHas('string_value_games', [
        //    'string_value' => 8,
        //    'result' => 5
        //]);

        // Verify result
        $this->assertEquals(9 , $response->json('data.result'));
    }
}
