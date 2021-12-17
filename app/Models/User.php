<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Resources\MergeValue;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class,'id','id','account');
    }

    public function memberOfGroups()
    {
        return $this->belongsToMany(Group::class,'group_members','iduser','idgroup','id','id');
    }
    
    public function ownerOfGroups()
    {
        return $this->belongsToMany(Group::class,'group_owners','iduser','idgroup','id','id');
    }
    
    public function relationship()
    {
        return $this->belongsToMany(User::class,'relationships','id1','id2','id','id');
    }

    public function friendRequest()
    {
        return $this->belongsToMany(User::class,'friend_requests','id1','id2','id','id'); //TODO: check for opposite direction.
    }

    public function posts()
    {
        return $this->hasMany(Post::class,'idposter','id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'iduser','id');
    }

    public function commentsTaggedIn()
    {
        return $this->belongsToMany(Comment::class,'comment_tags','iduser','idcomment','id','id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class,'iduser','id');
    }

    public function likedComments()
    {
        return $this->belongsToMany(Comment::class,'comment_likes','iduser','idcomment','id','id');
    }
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class,'post_likes','iduser','idpost','id','id');
    }
    public function profilePicture()
    {
        return $this->belongsToOne(Image::class,'profile_picture','id');
    }
}
