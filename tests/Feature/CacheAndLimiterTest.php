<?php

namespace Tests\Feature;

use App\Models\TransactionModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class CacheAndLimiterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_redis_cache()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->accessToken;
        
        TransactionModel::factory()->count(20)->create();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/v1/transaction?page=1');
        
        $response->assertStatus(200);
        
        $redisKey = 'transactions_page_1';
        $cachedData = Redis::get($redisKey);
        $this->assertNotNull($cachedData, 'Redis cache should have data');
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/v1/transaction?page=1');
        
        $response->assertStatus(200);
    }

    public function test_rate_limiter()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->accessToken;
        
        $request = 1000;
        $rateLimitExceeded = false;

        for ($i=0; $i < $request ; $i++) { 
            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('/api/v1/transaction');

            Log::info('Request ' . ($i + 1) . ': Response status code: ' . $response->status());

            if($response->status() == 429){
                $rateLimitExceeded = true;
                break;
            }

            usleep(50000);
        }

        $this->assertTrue($rateLimitExceeded, 'Rate limiter should be exceeded');
    }
}
