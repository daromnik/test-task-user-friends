<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = "users_friends";

    protected $fillable = ['user_id', 'friend_id'];

    public $timestamps = false;
}
