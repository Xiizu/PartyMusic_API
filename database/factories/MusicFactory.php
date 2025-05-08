<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Room;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Music>
 */
class MusicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'artist' => $this->faker->name(),
            'duration' => $this->faker->numberBetween(180, 300),
            'link' => $this->faker->url(),
            'likes' => $this->faker->numberBetween(0, 1000),
            'playable' => $this->faker->boolean(),
            'room_id' => Room::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
