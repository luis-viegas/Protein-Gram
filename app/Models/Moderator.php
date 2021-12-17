<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moderator extends Model
{
    public $timestamps = false;
    
    public function account()
    {
        return $this->belongsTo(Account::class,'id');
    }
}
