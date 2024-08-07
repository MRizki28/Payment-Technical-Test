<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_create_transaction()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->accessToken;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/transaction/create', [
            'amount' => 1000.00,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('transaction', [
            'user_id' => $user->id,
            'amount' => 1000.00,
        ]);
    }
}
