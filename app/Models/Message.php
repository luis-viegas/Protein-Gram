<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\MessageUpdate;

class Message extends Model
{
    public $timestamps = false;
    
    protected static function booted(){
        static::created(function($message){
            event (New MessageUpdate($message));
        });
    }

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
