<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'host_id' => User::query()->where('id', '!=', 1)->inRandomOrder()->first()->id,
            'code' => strtoupper($this->faker->unique()->lexify('ROOM????')),
        ];
    }
}
