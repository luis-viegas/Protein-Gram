<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;
    
    /**
     * Users in the group
     */
    public function members(){
        return $this->belongsToMany(User::class,'group_members','group_id','user_id','id','id');
    }
    
    /**
     * Owners of the group
     */
    public function owners(){
        return $this->belongsToMany(User::class,'group_owners','group_id','user_id','id','id');
    }

    /**
     * Posts made in the group
     */
    public function posts(){
        return $this->hasMany(Post::class,'group_id','id');
    }
}
