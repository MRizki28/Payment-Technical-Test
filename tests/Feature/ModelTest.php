<?php

namespace Tests\Feature;

use App\Models\TransactionModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_user_has_many_transactions()
    {
        $user = User::factory()->create();
        $transactions = TransactionModel::factory()->count(3)->create(['user_id' => $user->id]);

        foreach ($transactions as $transaction) {
            $this->assertDatabaseHas('transaction', [
                'id' => $transaction->id,
                'user_id' => $user->id,
                'amount' => $transaction->amount,
                'status' => $transaction->status,
            ]);
        }
        
        $this->assertTrue($user->transactions->count() === 3);
    }

    public function test_transaction_belongs_to_user()
    {
        $user = User::factory()->create();
        $transaction = TransactionModel::factory()->create(['user_id' => $user->id]);

        $this->assertNotNull($transaction->user);
        $this->assertInstanceOf(User::class, $transaction->user);
        $this->assertEquals($user->id, $transaction->user->id);
    }
}
