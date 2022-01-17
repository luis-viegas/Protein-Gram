<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public $timestamps  = true;

    /**
     * Users that are on the chat
     */
    public function users(){
        return $this->belongsToMany(User::class, 'chat_user', 'chat_id', 'user_id', 'id', 'id');
    }

    /**
     * Messages in the chat
     */
    public function messages(){
        return $this->hasMany(Message::class);
    }
}