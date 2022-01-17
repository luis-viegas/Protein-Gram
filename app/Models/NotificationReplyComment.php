<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationReplyComment extends Model
{
    protected $table = 'notifications_comment_reply';
    public $timestamps = false;

    public function notification()
    {
        return $this->belongsTo(Notification::class,'id','id','notification');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class,'comment_id','id');
    }
}
