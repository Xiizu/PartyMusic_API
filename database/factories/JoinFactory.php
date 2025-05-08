<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Room;
use App\Models\User;
use App\Models\Join;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Join>
 */
class JoinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $room = Room::inRandomOrder()->first();
            $user = User::inRandomOrder()->first();
        } while (Join::where('room_id', $room->id)->where('user_id', $user->id)->exists());
        return [
            'room_id' => $room->id,
            'user_id' => $user->id,
            'admin' => $this->faker->boolean(20),
            'banned' => $this->faker->boolean(20),
        ];

    }
}
