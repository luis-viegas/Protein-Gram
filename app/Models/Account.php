<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = false;

    public function user(){
        return $this->hasOne(User::class,'id','id');
    }

    public function administrator(){
        return $this->hasOne(Administrator::class,'id','id');
    }

    public function moderator(){
        return $this->hasOne(Moderator::class,'id','id');
    }

    public function messagesReceived(){
        return $this->hasMany(Message::class,'idreceiver','id');
    }

    public function messagesSent(){
        return $this->hasMany(Message::class,'idsender','id');
    }
}
