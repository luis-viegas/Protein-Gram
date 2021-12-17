<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
    
    public function post()
    {
        return $this->belongsTo(Post::class,'idpost','id');
    }

    public function commentor()
    {
        return $this->belongsTo(User::class,'iduser','id');
    }

    public function replyTo()
    {
        return $this->belongsTo(Comment::class,'reply_to','id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class,'reply_to','id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class,'comment_likes','idcomment','iduser','id','id');
    }

    public function taggingUsers()
    {
        return $this->belongsToMany(User::class, 'comment_tags','idcomment','iduser','id','id');
    }

}
