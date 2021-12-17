<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class,'iduser','id');
    }

    public function notificationComent()
    {
        return $this->hasOne(NotificationComment::class,'id','id');
    }

    public function notificationLikeComent()
    {
        return $this->hasOne(NotificationLikeComment::class,'id','id');
    }
    public function notificationPost()
    {
        return $this->hasOne(NotificationPost::class,'id','id');
    }
    public function notificationLikePost()
    {
        return $this->hasOne(NotificationLikePost::class,'id','id');
    }

    //TODO: reverse notification queries?
}
