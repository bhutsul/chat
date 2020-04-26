<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function invites()
    {
        return $this->hasMany('App\Invitations', 'to_user_id', 'id');
    }

    public function userToGroup()
    {
        return $this->hasMany('App\UserToGroup','user_id','id');
    }

    public function groups()
    {
        return $this->hasManyThrough('App\Group', 'App\UserToGroup', 'user_id', 'id', 'id', 'group_id')->where('confirmed', 1);
    }
}
