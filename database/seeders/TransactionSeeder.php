<?php

namespace Database\Seeders;

use App\Models\TransactionModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransactionModel::factory()->count(10000)->create();
    }
}
