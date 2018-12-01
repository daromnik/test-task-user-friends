<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $table = "users_recommendations";

    protected $fillable = ['user_id', 'recommend_id', 'rate'];

    public $timestamps = false;
}
