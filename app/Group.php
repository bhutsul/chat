<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function messages()
    {
        return $this->hasMany(Message::class)->with('user');
    }
}
