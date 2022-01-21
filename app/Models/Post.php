<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps  = true;

    /**
     * The user who made this post
     */
    public function poster() {
        return $this->belongsTo(User::class,'user_id','id','poster');
    }

    /**
     * The group this post was posted in, if it was posted in one
     */
    public function group() //TODO: check if null is fine.
    {
        //if this->group_id == null return null;
        return $this->belongsTo(Group::class,'group_id','id','group');
    }

    /**
     * The likes the post has received
     */
    public function likes()
    {
        return $this->belongsToMany(User::class,'post_likes','post_id','user_id','id','id','likes');
    }

    /**
     * The comments made on this post
     */
    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id','id');
    }

    
    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->whereRaw('tsvectors @@ plainto_tsquery(\'simple\', ?)', [$search])
            ->orderByRaw('ts_rank( tsvectors, plainto_tsquery(\'simple\', ?)) DESC', [$search]);
    }
}
