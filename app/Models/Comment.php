<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = true;
    
    /**
     * Post comment was made in
     */
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }

    /**
     * User who made the comment
     */
    public function commentor()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * Comment this comment was replying to, if any
     */
    public function replyTo()
    {
        return $this->belongsTo(Comment::class,'reply_to','id');
    }

    /**
     * Comments replying to this comment
     */
    public function replies()
    {
        return $this->hasMany(Comment::class,'reply_to','id');
    }

    /**
     * Likes this comment received
     */
    public function likes()
    {
        return $this->belongsToMany(User::class,'comment_likes','comment_id','user_id','id','id');
    }

    /**
     * Users this comment tagged
     */
    public function taggingUsers()
    {
        return $this->belongsToMany(User::class, 'comment_tags','comment_id','user_id','id','id');
    }

}
