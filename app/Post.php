<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function channel(){
        return $this->belongsTo('App\Channel');
    }

    public function replies(){
        return $this->hasMany('App\Reply');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }
}
