<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use App\Events\NotificationUpdate;

class Notification extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'type',
    ];
    protected static function booted(){
        static::created(function($notification){
            event (New NotificationUpdate($notification));
        });
    }
    
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
                return DB::select('SELECT notifications.id as id, notifications.type as type, dates as created_at, comment_id, comments.user_id as user_id, post_id, name, image FROM notifications INNER JOIN notifications_comment ON id = notification_id INNER JOIN comments ON notifications_comment.comment_id = comments.id INNER JOIN users ON comments.user_id = users.id WHERE notifications.id = ?', [$this->id])[0];
                //(id:notification, created_at:notification, comment_id, user_id:comment, post_id: comment, name:commenter, image:commenter)
            case 'post_like':
                return DB::select('SELECT notifications.id as id, notifications.type as type, dates as created_at, user_id, post_id, name, image FROM notifications INNER JOIN notifications_post_like ON id = notification_id INNER JOIN post_likes ON notifications_post_like.post_id = post_likes.post_id AND notifications_post_like.user_id = post_likes.user_id INNER JOIN users ON notifications_post_like.user_id = users.id WHERE notifications.id = $1', [$this->id])[0];
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
