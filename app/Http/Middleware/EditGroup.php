<?php

namespace App\Http\Middleware;

use App\Group;
use App\UserToGroup;
use Closure;
use Illuminate\Support\Facades\Auth;

class EditGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $g_id = $request->route('id');
        $group = Group::where('admin_id', Auth::id())->whereId($g_id)->first();

        if ($group ) {
            return $next($request);
        } else {
            return redirect('myGroups');
        }
    }
}
