<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    protected $fillable = ['from_user_id','to_user_id','group_id'];

    public function group()
    {
        return $this->hasOne('App\Group', 'id', 'group_id');
    }

    public function from_user()
    {
        return $this->hasOne('App\User', 'id', 'from_user_id');
    }
}
