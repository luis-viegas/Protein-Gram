<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationMessage extends Model
{
    protected $table = 'notifications_message';
    public $timestamps = false;

    /**
     * Notification this refers to
     */
    public function notification()
    {
        return $this->belongsTo(Notification::class,'id','id','notification');
    }

    /**
     * Message this notification refers to
     */
    public function message()
    {
        return $this->belongsTo(Message::class,'message_id','id');
    }
}
