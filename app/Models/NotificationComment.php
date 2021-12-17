<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationComment extends Model
{
    public $timestamps = false;

    public function notification()
    {
        return $this->belongsTo(Notification::class,'id','id','notification');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class,'idcomment','id');
    }
    
}
