<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;

    public function poster()
    {
        return $this->belongsTo(User::class,'idposter','id','poster');
    }

    public function group() //TODO: check if null is fine.
    {
        return $this->belongsTo(Group::class,'idgroup','id','group');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class,'post_likes','idpost','iduser');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'idpost','id');
    }

    /*
    public function notification()
    {
        return $this->hasMany(NotificationPost::class,'idpost');
    }
    */
}
