<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlaylistMusic>
 */
class PlaylistMusicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'playlist_id' => \App\Models\Playlist::inRandomOrder()->first()->id,
            'music_id' => \App\Models\Music::where('room_id', 1)->inRandomOrder()->first()->id,
        ];
    }
}
