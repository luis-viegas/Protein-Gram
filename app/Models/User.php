<?php

namespace App\Models;

use DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $fillable = [
        'name', 'email', 'password','is_private','bio',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Posts made by the user
     */
    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->whereRaw('tsvectors @@ plainto_tsquery(\'simple\', ?)', [$search])
            ->orderByRaw('ts_rank( tsvectors, plainto_tsquery(\'simple\', ?)) DESC', [$search]);
    }

    /**
     * Groups the user is in
     */
    public function memberOfGroups()
    {
        return $this->belongsToMany(Group::class,'group_members','user_id','group_id','id','id');
    }
    
    /**
     * Groups the user owns
     */
    public function ownerOfGroups()
    {
        return $this->belongsToMany(Group::class,'group_owners','user_id','group_id','id','id');
    }
    
    /**
     * Relationships the user has
     */
    public function relationships()
    {
        //return $this->belongsToMany(User::class,'relationships','id1','id2','id','id')->get();
        return DB::select('SELECT * FROM ((SELECT id2 as id, friends, blocked1, blocked2 FROM relationships WHERE ? = relationships.id1) UNION (SELECT id1 as id, friends, blocked1 as blocked2, blocked2 as blocked1 FROM relationships WHERE ? = relationships.id2)) as related INNER JOIN users ON related.id = users.id', [$this->id,$this->id]);
        
        /* array of records.
            can be cast to User Collection with User::hydrate(relationships())
            or individually with $var = new User(relationships()[index]);
            attributes:
            [ 
                all user attributes AND
                'friends': boolean      if they are friends with $this.
                'blocked1': boolean     if they are blocked by $this.
                'blocked2': boolean     if they blocked $this.
            ]
        */
    }
    /**
     * Returns the user's friends
     */
    public function friends()
    {
        return User::hydrate(DB::select('SELECT * FROM ((SELECT id2 as id, friends, blocked1, blocked2 FROM relationships WHERE ? = relationships.id1 And friends = TRUE) UNION (SELECT id1 as id, friends, blocked1 as blocked2, blocked2 as blocked1 FROM relationships WHERE ? = relationships.id2 And friends = TRUE)) as related INNER JOIN users ON related.id = users.id', [$this->id,$this->id]));
    }

    /**
     * Messages written by the user
     */
    public function messages(){
        return $this->hasMany(Message::class);
    }

    /**
     * Chats user is in
     */
    public function chats(){

        return $this->belongsToMany(Chat::class, 'chat_user', 'user_id', 'chat_id','id', 'id');
    }


    /**
     * Pending friend requests the user has
     */
    public function friendRequestsMade()
    {
        return $this->belongsToMany(User::class,'friend_requests','id1','id2','id','id');
    }

    /**
     * Pending friend requests the user has received
     */
    public function friendRequestsReceived()
    {
        return $this->belongsToMany(User::class,'friend_requests','id2','id1','id','id');
    }

    /**
     * Comments made by the user
     */
    public function comments()
    {
        return $this->hasMany(Comment::class,'user_id','id');
    }

    /**
     * Comments tagging the user
     */
    public function commentsTaggedIn()
    {
        return $this->belongsToMany(Comment::class,'comment_tags','user_id','comment_id','id','id');
    }

    /**
     * Notifications the user received
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class,'user_id','id');
    }

    /**
     * Comments the user liked
     */
    public function likedComments()
    {
        return $this->belongsToMany(Comment::class,'comment_likes','user_id','comment_id','id','id');
    }

    /**
     * Posts the user liked
     */
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class,'post_likes','user_id','post_id','id','id');
    }

    public function sharedChats($user2_id){
        return DB::select(DB::raw("SELECT DISTINCT user1_chats as id FROM (SELECT id as user1_chats FROM chats inner join chat_user on id = chat_id where user_id = $user2_id) as user1 INNER JOIN (SELECT id as user2_chats FROM chats inner join chat_user on id = chat_id where user_id = $this->id) as user2 ON user1.user1_chats = user2.user2_chats"));
    }

    public function isFriend($friend_id){
        if(isset($friend_id)){
            if($friend_id < $this->id){
                $result = DB::select('SELECT id1 FROM relationships WHERE id1 = ? AND id2 = ? AND friends = TRUE',[$friend_id,$this->id]);
                return !(empty($result));
            }
            if($friend_id > $this->id){
                $result = DB::select('SELECT id2 FROM relationships WHERE id1 = ? AND id2 = ? AND friends = TRUE',[$this->id,$friend_id]);
                return !(empty($result));
            }
        }
        return false;
    }
    public function removeFriend($friend_id)
    {   
        return DB::table('relationships')
            ->where('id1', $friend_id < $this->id ? $friend_id : $this->id)
            ->where('id2', $friend_id > $this->id ? $friend_id : $this->id)
            ->update(['friends'=>'false']);
    }
    public function makeFriendRequest($friend_id)
    {
        if(DB::table('friend_requests')
            ->where('id1',$friend_id)
            ->where('id2',$this->id)
            ->get()
            ->isEmpty())
        {
            DB::table('friend_requests')
                ->insertOrIgnore([
                    'id1' => $this->id,
                    'id2' => $friend_id
                ]);
        }else{
            $this->removeFriendRequest($friend_id);
            DB::table('relationships')
                ->updateOrInsert([
                    'id1' => $friend_id < $this->id ? $friend_id : $this->id,
                    'id2' => $friend_id > $this->id ? $friend_id : $this->id
                ],['friends'=>'true']);
        }
    }
    public function removeFriendRequest($friend_id)
    {
        DB::table('friend_requests')
            ->whereRaw('(id1 IN (?,?))',[$this->id,$friend_id])
            ->whereRaw('(id2 IN (?,?))',[$this->id,$friend_id])
            ->delete();
    }
    public function sentFriendRequest($user2_id)
    {
        return isset($user2_id) && !DB::table('friend_requests')
            ->where('id2',$user2_id)
            ->where('id1',$this->id)
            ->get()
            ->isEmpty();
    }
}