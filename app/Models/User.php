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
        return $this->belongsToMany(Group::class,'groupmember','iduser','idgroup');
    }
    
    public function ownerOfGroups()
    {
        return $this->belongsToMany(Group::class,'groupowner','iduser','idgroup');
    }
    
    public function relationship()
    {
        return $this->belongsToMany(User::class,'relationship','id1','id2');
    }

    public function friendRequest()
    {
        return $this->belongsToMany(User::class,'friend_request','id1','id2'); //TODO: check for opposite direction.
    }

    public function posts()
    {
        return $this->hasMany(Post::class,'idposter','id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class,'iduser','id');
    }

    public function likedComments()
    {
        return $this->belongsToMany(Comment::class,'like_comment','iduser','idcomment');
    }
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class,'like_post','iduser','idpost');
    }
}
