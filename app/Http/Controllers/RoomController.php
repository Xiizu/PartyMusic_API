<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Controllers\Controller;
use App\Models\Join;
use Illuminate\Http\Request;
use \Illuminate\Support\Str;
use App\Models\User;

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
        // Add host_name attribute to the room
        $room->host_name = User::where('id', $user)->value('name');

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
        $joinedRooms = Join::where('user_id', $id)->with('room')->get()->pluck('room')->filter();

        if ($rooms->isEmpty() && $joinedRooms->isEmpty()) {
            return response()->json(['statut' => 'error', 'message' => 'No rooms found for this user'], 404);
        } else {
            if ($rooms->isEmpty()) {
                $roomsToReturn = $joinedRooms;
            } else if ($joinedRooms->isEmpty()) {
                $roomsToReturn = $rooms;
            } else {
                $roomsToReturn = $rooms->merge($joinedRooms);
            }

            // Add host_name attribute to each room
            $roomsToReturn->each(function ($room) {
                $room->host_name = User::where('id', $room->host_id)->value('name');
            });

            return response()->json([
                'statut' => 'success',
                'message' => 'Rooms retrieved successfully',
                'data' => $roomsToReturn
            ], 200);
        }
    }

    /**
     * Join a room by code.
     */
    public function joinRoom(Request $request)
    {
        $code = $request->input('code');
        $user = $request->input('user_id');
        if (!$code || !$user) {
            return response()->json(['statut' => 'error', 'message' => 'Room code is required'], 400);
        }
        $room = Room::where('code', $code)->first();
        if (!$room) {
            return response()->json(['statut' => 'error', 'message' => 'Room not found'], 404);
        } else {
            $join = new Join();
            $join->user_id = $user;
            $join->room_id = $room->id;
            $join->save();

            // Add host_name attribute to the room
            $room->host_name = User::where('id', $room->host_id)->value('name');
            return response()->json(['statut' => 'success', 'message' => 'Room joined successfully', 'data' => $room], 200);
        }
    }
}
