<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = false;
    
    /**
     * User who sent the message
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    /**
     * User who received the message
     */
    public function chat(){
        return $this->belongsTo(Chat::class);
    }
}
