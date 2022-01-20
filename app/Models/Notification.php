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
    
    public function broadcast(){
        event (New NotificationUpdate($this));
    }
    /**
     * User who got the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * returns the Notification object of a specific type that created this
     */
    public function specific()
    {
        switch($this->type){
            case 'comment':
                $arr = DB::select('SELECT v.id, type, v.created_at, comment_id, comments.user_id as user_id, post_id, name, image FROM (SELECT * FROM (VALUES (?::int, \'comment\', ?::timestamptz)) as v (id, type, created_at)) as v INNER JOIN notifications_comment ON id = notification_id INNER JOIN comments ON notifications_comment.comment_id = comments.id INNER JOIN users ON comments.user_id = users.id',[$this->id, $this->created_at]);
                return empty($arr)? null : $arr[0];
                // notification:(id, type, created_at) comment:(comment_id, post_id) commenter:(user_id, name, image)
            case 'post_like':
                $arr = DB::select('SELECT v.id, type, v.created_at, user_id, post_id, name, image FROM (SELECT * FROM (VALUES (?::int, \'post_like\', ?::timestamptz)) as v (id, type, created_at)) as v INNER JOIN notifications_post_like ON id = notification_id INNER JOIN post_likes ON notifications_post_like.post_id = post_likes.post_id AND notifications_post_like.user_id = post_likes.user_id INNER JOIN users ON notifications_post_like.user_id = users.id', [$this->id,$this->created_at])[0];
                return empty($arr)? null : $arr[0];
                // notification:(id, type, created_at) post:(post_id) liker:(user_id, name, image)
            case 'comment_like':
                $arr = DB::select('SELECT v.id, type, v.created_at, user_id, comment_id, post_id, name, image FROM (SELECT * FROM (VALUES (?::int, \'comment_like\', ?::timestamptz)) as v (id, type, created_at)) as v INNER JOIN notifications_comment_like ON id = notification_id INNER JOIN comment_likes ON notifications_comment_like.comment_id = comment_likes.comment_id AND notifications_comment_like.user_id = comment_likes.user_id INNER JOIN users ON notifications_comment_like.user_id = users.id', [$this->id,$this->created_at])[0];
                return empty($arr)? null : $arr[0];
                // notification:(id, type, created_at) comment:(comment_id, post_id) liker:(user_id, name, image)
            case 'comment_tag': 
                $arr = DB::select('SELECT v.id, type, v.created_at, user_id, comment_id, post_id, name, image FROM (SELECT * FROM (VALUES (?::int, \'comment_tag\', ?::timestamptz)) as v (id, type, created_at)) as v INNER JOIN notifications_comment_tag ON id = notification_id INNER JOIN comment_tags ON notifications_comment_tag.comment_id = comment_tags.comment_id INNER JOIN comments ON comment_tags.comment_id = comments.id INNER JOIN users ON comments.user_id = users.id', [$this->id,$this->created_at])[0];
                return empty($arr)? null : $arr[0];
                // notification:(id, type, created_at) comment:(comment_id, post_id) tagger:(user_id, name, image)
            case 'message': 
                $arr = DB::select('SELECT v.id, type, v.created_at, message_id, messages.user_id as user_id, chat_id, name, image FROM (SELECT * FROM (VALUES (?::int, \'message\', ?::timestamptz)) as v (id, type, created_at)) as v INNER JOIN notifications_message ON id = notification_id INNER JOIN messages ON notifications_message.message_id = messages.id INNER JOIN users ON messages.user_id = users.id', [$this->id,$this->created_at])[0];
                return empty($arr)? null : $arr[0];
                // notification:(id, type, created_at) message:(message_id, text, chat_id) sender:(user_id, name, image)
            case 'comment_reply':
                $arr = DB::select('SELECT v.id, type, v.created_at, user_id, comment_id, post_id, name, image FROM (SELECT * FROM (VALUES (?::int, \'comment_reply\', ?::timestamptz)) as v (id, type, created_at)) as v INNER JOIN notifications_comment_reply ON id = notification_id INNER JOIN comments ON notifications_comment_reply.comment_id = comments.id INNER JOIN users ON comments.user_id = users.id', [$this->id,$this->created_at])[0];
                return empty($arr)? null : $arr[0];
                // notification:(id, type, created_at) comment:(comment_id, post_id) commenter:(user_id, name, image)
        }
    }
}
