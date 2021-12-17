<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = false;
    
    public function profiles()
    {
        return $this->hasMany(User::class,'profile_picture','id');
    }
}
