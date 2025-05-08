<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::class::factory(1)->create([
            'label' => 'Room 1',
            'description' => 'This is the first room',
            'host_id' => 1,
            'code' => 'ROOM0001',
        ]);
        Room::class::factory(50)->create();
    }
}
