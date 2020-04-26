<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Group extends Model
{
    protected $fillable = ['admin_id','status','name'];
    public function messages()
    {
        return $this->hasMany(Message::class)->with('user');
    }

    public function admin()
    {
        return $this->hasOne('App\User','id','admin_id');
    }

    public function userToGroup()
    {
        return $this->hasMany('App\UserToGroup','group_id','id')->where('user_id', Auth::id());
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_to_group', 'group_id','user_id')->withPivot('confirmed');
    }
}
