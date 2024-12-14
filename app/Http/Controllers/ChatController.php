<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request){
        $message = $request->message;
        $sender = $request->userId;
        // MessageSent::dispatch($message);
        // event(new MessageSent($message));

        broadCast(new MessageSent($message, $sender))->toOthers();

        return response()->json(['message' => $message, 'sender' => $sender],201);

    }
}
