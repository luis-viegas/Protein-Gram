<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;
    
    public function members(){
        return $this->belongsToMany(User::class,'group_members','idgroup','iduser','id','id');
    }
    
    public function owners(){
        return $this->belongsToMany(User::class,'group_owners','idgroup','iduser','id','id');
    }

    public function posts(){
        return $this->hasMany(Post::class,'idgroup','id');
    }
}
