<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $userId   = Auth::user()->id;
        $friendId = $request->friend_id;

        $room = Room::where('users', "{$userId}:{$friendId}")
            ->orWhere('users', "{$friendId}:{$userId}")
            ->first();

        if (!$room) {
            $room        = new Room();
            $room->users = "{$userId}:{$friendId}";
            $room->save();
        }

        return response()->json([
            'status'  => true,
            'message' => 'Room created successfully!',
            'data'    => $room,
        ])->setStatusCode(201);
    }
}
