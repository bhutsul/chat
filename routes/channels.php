<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('group.{id}', function ($user, $group_id) {
    $user_to_group = \App\UserToGroup::where('group_id', $group_id)->where('user_id', $user->id)->first();

    if ($user_to_group) {
        return $user;
    }
});
