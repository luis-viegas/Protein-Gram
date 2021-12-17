<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;
    public function members(){
        return $this->belongsToMany(User::class,'groupmember','idgroup','iduser');
    }
    public function owners(){
        return $this->belongsToMany(User::class,'groupowner','idgroup','iduser');
    }
}
