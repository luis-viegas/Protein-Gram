<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLikeComment extends Model
{
    protected $table = 'notifications_comment_like';
    public $timestamps = false;

    public function notification()
    {
        return $this->belongsTo(Notification::class,'id','id','notification');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class,'idcomment','id');
    }

    public function liker()
    {
        return $this->belongsTo(user::class,'iduser','id');
    }
}
