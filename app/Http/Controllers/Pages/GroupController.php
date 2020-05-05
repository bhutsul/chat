<?php

namespace App\Http\Controllers\Pages;

use App\Events\MessageSent;
use App\Group;
use App\Http\Controllers\Controller;
use App\Message;
use App\User;
use App\UserToGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function edit()
    {
        return view('pages.edit-group', ['group' => Group::with('users')->whereId($this->request->id)->first()]);
    }

    public function update()
    {
        Group::whereId($this->request->group_id)->update(['name' => $this->request->name, 'status' => $this->request->status]);
        return response()->json(['status' => 'success']);
    }

    public function delete()
    {
        Group::whereId($this->request->group_id)->delete();
        return response()->json(['status' => 'success']);
    }

    public function kickUser()
    {
        UserToGroup::whereUserId($this->request->user_id)->whereGroupId($this->request->group_id)->delete();
        return response()->json(['status' => 'success']);
    }

    public function create()
    {
        $group =(new Group());
        $group->name = $this->request->name;
        $group->status = $this->request->status;
        $group->admin_id = Auth::id();
        $group->save();
        $group_id = $group->id;

        UserToGroup::create([
            'user_id' => Auth::id(),
            'group_id' => $group_id,
            'confirmed' => 1,
        ]);

        return redirect('myGroups');
    }

    public function showMyGroups()
    {
        $vars = [];

        $groups = Group::where('admin_id', Auth::id())->get();
        if ($groups->count()) {
            $vars['groups'] = $groups;
        }

        return view('pages.show-my-groups', $vars);
    }

    public function showAllGroups()
    {
        $vars = [];
        $user = Auth::user()->load('groups');

        $groups = $user->groups;
        if ($groups->count()) {
            $vars['groups'] = $groups;
        }

        return view('pages.show-all-groups', $vars);
    }

    public function search()
    {
        $searchText = $this->request->text;
        $groups = Group::with('users')->where('name', 'like', '%' . $searchText . '%')->get();
        foreach ($groups as $group) {
            if ($group->users->count()) {
                foreach ($group->users as $user) {
                    if ($group->status == 0) {
                        $user->pivot->confirmed === 0 ? $group->setAttribute('requested', true) : $group->setAttribute('requested', false);
                    }
                    if (Auth::id() == $user->id) {
                        $group->setAttribute('has_user', true);
                        break;
                    } else {
                        $group->setAttribute('has_user', false);
                    }
                }
            } else {
                $group->setAttribute('has_user', false);
            }

        }
        return response()->json(['groups' => $groups]);
    }

    public function joinGroup()
    {
        UserToGroup::create([
            'user_id' => $this->request->user_id,
            'group_id' => $this->request->group_id,
            'confirmed' => 1,
        ]);

        return response()->json(['status' => 'success']);
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
