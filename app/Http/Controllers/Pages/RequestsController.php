<?php

namespace App\Http\Controllers\Pages;

use App\Group;
use App\Requests;
use App\UserToGroup;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->request = app('request');
    }

    public function index()
    {
        return view('pages.group-requests', [
            'requests' => Requests::with('group', 'from_user')->where('to_user_id', Auth::id())->get()
        ]);
    }

    public function requestGroup()
    {
        $group = Group::with('admin')->whereId($this->request->group_id)->first();
        UserToGroup::create([
            'user_id' => $this->request->user_id,
            'group_id' => $this->request->group_id,
            'confirmed' => 0,
        ]);
        Requests::create([
            'from_user_id' => $this->request->user_id,
            'to_user_id' => $group->admin->id,
            'group_id' => $this->request->group_id,
        ]);

        return response()->json(['status' => 'success']);
    }

    public function delete()
    {
        $request_user = Requests::whereId($this->request->request_id)->where('to_user_id', Auth::id())->first();
        UserToGroup::where('user_id', $request_user->from_user_id)->where('group_id', $this->request->group_id)->delete();
        Requests::whereId($this->request->request_id)->where('to_user_id', Auth::id())->delete();
        return response()->json(['status' => 'success']);
    }

    public function confirm()
    {
        $request_user = Requests::whereId($this->request->request_id)->where('to_user_id', Auth::id())->first();
        UserToGroup::where('user_id', $request_user->from_user_id)->where('group_id', $this->request->group_id)->update(['confirmed' => 1]);
        Requests::whereId($this->request->request_id)->where('to_user_id', Auth::id())->delete();
        return response()->json(['status' => 'success']);
    }
}
