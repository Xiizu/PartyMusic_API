<?php

namespace App\Http\Controllers;

use App\Models\Music;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Join;

class MusicController extends Controller
{
    /**
     * Get a music by user ID.
     */
    public function getMusic(Request $request)
    {
        $id = $request->input('room_id');
        if (!$id) {
            return response()->json(['statut' => 'error', 'message' => 'Room ID is required'], 400);
        }

        $musics = Music::where('room_id', $id)->get();
        if ($musics->isEmpty()) {
            return response()->json(['statut' => 'error', 'message' => 'No musics found for this room'], 404);
        } else {
            // Add user_name attribute to each music
            foreach ($musics as $music) {
                $music->user_name = User::where('id', $music->user_id)->value('name');
            }
            return response()->json(['statut' => 'success', 'message' => 'Musics retrieved successfully', 'data' => $musics], 200);
        }
    }

    /**
     * Get all musics for a user by user ID.
     */
    public function getAllMusicForUser(Request $request)
    {
        $userId = $request->input('user_id');
        if (!$userId) {
            return response()->json(['statut' => 'error', 'message' => 'User ID is required'], 400);
        }
        $createdRooms = Room::where('host_id', $userId)->get();
        $joinedRooms = Join::where('user_id', $userId)->with('room')->get()->pluck('room')->filter();
        $rooms = $createdRooms->merge($joinedRooms)->unique('id');
        if ($rooms->isEmpty()) {
            return response()->json(['statut' => 'error', 'message' => 'No rooms found for this user'], 404);
        }
        $roomIds = $rooms->pluck('id');
        $musics = Music::whereIn('room_id', $roomIds)->get();
        if ($musics->isEmpty()) {
            return response()->json(['statut' => 'error', 'message' => 'No musics found for this user'], 404);
        }
        $userNames = User::whereIn('id', $musics->pluck('user_id')->unique())->pluck('name', 'id');
        foreach ($musics as $music) {
            $music->user_name = $userNames[$music->user_id] ?? 'Unknown';
        }
        return response()->json(['statut' => 'success', 'message' => 'Musics retrieved successfully', 'data' => $musics], 200);
    }
}

