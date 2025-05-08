<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Join;

class JoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 random join records
        Join::factory()->count(10)->create([
            'user_id' => 1,
        ]);
        Join::factory()->count(400)->create();
        
    }
}
