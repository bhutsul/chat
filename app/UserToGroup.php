<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserToGroup extends Model
{
    protected $table = 'user_to_group';
    protected $fillable = ['user_id', 'group_id', 'confirmed'];
    public $timestamps = false;
}
