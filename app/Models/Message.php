<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = false;
    public function sender(){
        return $this->hasOne(Account::class,'idsender');
    }
    public function receiver(){
        return $this->hasOne(Account::class,'idreceiver');
    }
}
