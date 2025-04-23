<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Create a new room.
     */
    public function createRoom()
    {
        $user = request('id');
        $label = request('label');
        $description = request('description');
        if (!$user || !$label) {
            return response()->json(['statut' => 'error', 'message' => 'User ID and room label are required'], 400);
        } 
        if (Room::where('host_id', $user)->count() >= 3) {
            return response()->json(['statut' => 'error', 'message' => 'User already has 3 rooms'], 433);
        }

        $room = new Room();
        $room->label = $label;
        $room->description = $description? $description : '';
        $room->host_id = $user;
        $room->code = strtoupper(Str::random(8));
        $room->save();

        return response()->json(['statut' => 'success','message' => 'Room created successfully', 'data' => $room], 201);
    }

    /**
     * Get a room by user ID.
     */
    public function getRoom(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return response()->json(['statut' => 'error', 'message' => 'User ID is required'], 400);
        }
        $rooms = Room::where('host_id', $id)->get();
        if ($rooms->isEmpty()) {
            return response()->json(['statut' => 'error', 'message' => 'No rooms found for this user'], 404);
        } else {
            return response()->json(['statut' => 'success', 'message' => 'Rooms retrieved successfully', 'data' => $rooms], 200);
        }
    }
}
