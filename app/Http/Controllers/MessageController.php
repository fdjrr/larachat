<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use Throwable;
use App\Models\User;
use App\Models\Message;
use App\Events\SendMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $friends = User::whereNot('id', Auth::user()->id)->get();

        return view('messages.index', [
            'title'   => 'My Message',
            'friends' => $friends,
        ]);
    }

    public function saveMessage(Request $request): JsonResponse
    {
        $roomId  = $request->room_id;
        $userId  = Auth::user()->id;
        $message = $request->message;

        DB::beginTransaction();

        try {
            broadcast(new SendMessage($roomId, $userId, $message));

            $message = Message::create([
                'user_id' => $userId,
                'room_id' => $roomId,
                'message' => $message,
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ])->setStatusCode(500);
        }

        return (new MessageResource($message))->additional([
            'status'  => true,
            'message' => 'Message sent successfully',
        ])->response()->setStatusCode(201);
    }

    public function loadMessage($roomId)
    {
        $messages = Message::where('room_id', $roomId)
            ->orderBy('updated_at', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $messages,
        ])->setStatusCode(200);
    }
}
