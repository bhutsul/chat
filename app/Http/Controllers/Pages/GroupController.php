<?php

namespace App\Http\Controllers\Pages;

use App\Events\MessageSent;
use App\Group;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->request = app('request');
    }

    public function index()
    {
        return view('group');
    }

    public function show()
    {
        return view('pages.show-groups');
    }

    public function fetchMessages($group_id)
    {
        $group_id = (int)$group_id;
        $group = Group::with('messages')->where('id', $group_id)->first();
        return $group->messages;
    }

    public function sendMessage()
    {
        $message = auth()->user()->messages()->create([
            'message' => $this->request->message,
            'group_id' => (int)$this->request->group_id,
        ]);

        broadcast(new MessageSent($message->load('user','group')))->toOthers();

        return ['status' => 'success'];
    }
}
