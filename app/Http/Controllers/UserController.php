<?php

namespace App\Http\Controllers;

use App\Invitations;
use App\User;
use App\UserToGroup;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->request = app('request');
    }

    public function search()
    {
        $searchText = $this->request->text;
        $users = User::with('invites','userToGroup')->where('name', 'like', '%' . $searchText . '%')->get();
        foreach ($users as $user) {
            if ($user->invites->count()) {
                foreach ($user->invites as $invite) {
                    if ($invite->from_user_id == $this->request->user_id && $invite->group_id == $this->request->group_id) {
                        $user->setAttribute('invited', true);
                        break;
                    } else {
                        $user->setAttribute('invited', false);
                    }
                }
            } else {
                $user->setAttribute('invited', false);
            }
            $user->userToGroup->where('group_id', $this->request->group_id)->where('confirmed', 1)->count()
                ? $user->setAttribute('inGroup', true)
                : $user->setAttribute('inGroup', false);
        }
        return response()->json(['users' => $users]);
    }
}
