<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationFriendRequest extends Model
{
    protected $table = 'notifications_friend_request';
    public $timestamps = false;
    protected $primaryKey = 'notification_id';
    protected $fillable = ['notification_id', 'user_id',];

    /**
     * Notification this refers to
     */
    public function notification()
    {
        return $this->belongsTo(Notification::class,'id','id','notification');
    }

    /**
     * User who sent the request this notification refers to
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    
}
