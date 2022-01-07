<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationComment extends Model
{
    protected $table = 'notifications_comment';
    public $timestamps = false;

    /**
     * Notification this refers to
     */
    public function notification()
    {
        return $this->belongsTo(Notification::class,'id','id','notification');
    }

    /**
     * Comment this notification refers to
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class,'comment_id','id');
    }
    
}
