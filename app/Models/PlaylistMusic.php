<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistMusic extends Model
{
    /** @use HasFactory<\Database\Factories\PlaylistMusicFactory> */
    use HasFactory;

    protected $fillable = [
        'playlist_id',
        'music_id',
    ];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
    public function music()
    {
        return $this->belongsTo(Music::class);
    }
}
