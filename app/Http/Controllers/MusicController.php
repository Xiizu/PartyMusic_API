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

    /**
     * Create a new music.
     */
    public function createMusic(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'link' => 'required|string',
        ]);

        $music = new Music();
        $music->room_id = $request->input('room_id');
        $music->user_id = $request->input('user_id');
        $music->title = $request->input('title');
        $music->artist = $request->input('artist');
        $music->link = $request->input('link');
        $music->duration = $request->input('duration', 0);
        $music->likes = $request->input('likes', 0);
        $music->playable = $request->input('playable', 1);
        $music->save();

        return response()->json(['statut' => 'success', 'message' => 'Music created successfully', 'data' => $music], 201);
    }

    /**
     * Update a music.
     */
   /*  public function extractAudioUrl(Request $request)
    {
        $videoUrl = $request->input('url');
        if (!$videoUrl) {
            return response()->json(['statut' => 'error', 'message' => 'Video URL is required'], 400);
        }
        $command = escapeshellcmd("yt-dlp -f bestaudio -g https://youtu.be/" . escapeshellarg($videoUrl));
        $audioUrl = shell_exec($command);
        if ($audioUrl === null) {
            return response()->json(['statut' => 'error', 'message' => 'Failed to extract audio URL'], 500);
        }
        return response()->json(['statut' => 'success', 'message' => 'Audio URL extracted successfully for https://youtu.be/' . $videoUrl, 'data' => $audioUrl], 200);
    } */
}

