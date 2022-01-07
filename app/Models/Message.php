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
    public function sender(){
        return $this->belongsTo(Account::class,'idsender','id');
    }
    
    /**
     * User who received the message
     */
    public function receiver(){
        return $this->belongsTo(Account::class,'idreceiver','id');
    }
}
