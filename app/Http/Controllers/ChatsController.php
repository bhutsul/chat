<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chats');
    }

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        auth()->user()->messages()->create([
            'message' => $request->message,
        ]);

        return ['status' => 'success'];
    }
}
