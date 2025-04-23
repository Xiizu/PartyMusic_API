<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Mr. Tester',
            'email' => 'test@test.com',
            'password' => hash('sha256', 'Test123!'),
            'token' => 'test_token',
        ]);
        User::factory()->count(5)->create();
    }
}
