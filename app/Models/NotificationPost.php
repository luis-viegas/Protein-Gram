<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPost extends Model
{
    public $timestamps = false;

    public function notification()
    {
        return $this->belongsTo(Notification::class,'id','id','notification');
    }

    public function post()
    {
        return $this->belongsTo(Post::class,'idpost','id');
    }
}
