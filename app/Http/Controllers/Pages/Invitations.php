<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\UserToGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Invitations extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->request = app('request');
    }

    public function index()
    {
        return view('pages.group-invitations', [
            'invitations' => \App\Invitations::with('group', 'from_user')->where('to_user_id', Auth::id())->get()
        ]);
    }

    public function invite()
    {
        \App\Invitations::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $this->request->user_id,
            'group_id' => $this->request->group_id,
        ]);

        UserToGroup::create([
            'user_id' => $this->request->user_id,
            'group_id' => $this->request->group_id,
            'confirmed' => 0,
        ]);
        return response()->json(['status' => 'success']);
    }

    public function delete()
    {
        $invite_user = \App\Invitations::whereId($this->request->invitation_id)->where('to_user_id', Auth::id())->first();
        UserToGroup::where('user_id', $invite_user->to_user_id)->where('group_id', $this->request->group_id)->delete();
        \App\Invitations::whereId($this->request->invitation_id)->where('to_user_id', Auth::id())->delete();
        return response()->json(['status' => 'success']);
    }

    public function confirm()
    {
        $invite_user = \App\Invitations::whereId($this->request->invitation_id)->where('to_user_id', Auth::id())->first();
        UserToGroup::where('user_id', $invite_user->to_user_id)->where('group_id', $this->request->group_id)->update(['confirmed' => 1]);
        \App\Invitations::whereId($this->request->invitation_id)->where('to_user_id', Auth::id())->delete();
        return response()->json(['status' => 'success']);
    }
}
