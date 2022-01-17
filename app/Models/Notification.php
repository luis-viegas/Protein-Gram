<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    public $timestamps = false;

    /**
     * User who got the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * returns the Notification of a specific type that created this
     */
    public function specific()
    {
        switch($this->type){
            case 'comment': 
                return $this->join(NotificationComment::class,'notifications_comment.notification_id','=','notifications.id');
            case 'post_like': 
                return $this->join(NotificationLikePost::class,'notifications_post_like.notification_id','=','notifications.id');
            case 'comment_like': 
                return $this->join(NotificationLikeComment::class,'notifications_comment_like.notification_id','=','notifications.id');
            case 'comment_tag': 
                return $this->join(NotificationTagComment::class,'notifications_comment_tag.notification_id','=','notifications.id');
            case 'message': 
                return $this->join(NotificationMessage::class,'notifications_message.notification_id','=','notifications.id');
            case 'comment_reply':
                return $this->join(NotificationReplyComment::class,'notifications_comment_reply.notification_id','=','notifications.id');
        }
        //return $this->morphTo('notifiable','type','id','id');

        /*$this->join('notifications_comment','notifications_comment.notification_id','=','notifications.id')
            ->join('notifications_post_like','notifications_post_like.notification_id','=','notifications.id')
            ->join('notifications_comment_like','notifications_comment_like.notification_id','=','notifications.id')
            ->join('notifications_comment_tag','notifications_comment_tag.notification_id','=','notifications.id')
            ->join('notifications_message','notifications_message.notification_id','=','notifications.id')
            ->join('notifications_comment_reply','notifications_comment_reply.notification_id','=','notifications.id');*/
        
    }
}
