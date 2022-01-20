<?php

namespace App\Http\Controllers;

use App\Events\NotificationUpdate;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\NotificationComment;
use App\Models\NotificationReplyComment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function show($post_id,$comment_id){
        $comment = Comment::find($comment_id);
        //verificar if comment exists
        //authorize('show', $comment);

        return view('partials.comment', ['comment'=> $comment]);
    }

    public function list($post_id){
        $post = Post::find($post_id);
        
        //authorize('list', $post_id, $comment_id);

        $comments = $post->comments()->get();

        return view('pages.comments', ['comments'=> $comments]);
    }   

    public function create(Request $request){
        $user = Auth::user();
        if(!$user) return redirect()->back();
        $comment = new Comment();
        //authorize('create',$post_id);
        if($request->input('message') == null || $request->input('post_id') == null){
            return redirect()->back();
        }
        $post = Post::find($request->input('post_id'));
        if(!$post) return redirect()->back();
        $comment->message = $request->input('message');
        $comment->user_id = $user->id;
        $comment->post_id = $post->id;
        $commentReplying = null;
        if($request->input('comment_id') == null)
            $comment->reply_to = null;
        else{
            $commentReplying = Comment::find($request->input('comment_id'));
            if(!$commentReplying ||  $commentReplying->post_id != $post->id)
                return redirect()->back();
            $comment->reply_to = $commentReplying->id;
        }
        $comment->save();
        if($post->user_id != $user->id){
            $notification = new Notification();
            $notification->user_id = $post->user_id;
            $notification->type = 'comment';
            $notification->save();
            $notification_comment = new NotificationComment();
            $notification_comment->notification_id=$notification->id;
            $notification_comment->comment_id=$comment->id;
            $notification_comment->save();
            $notification->broadcast();
        }
        if($commentReplying != null && $commentReplying->user_id != $user->id){
            $notification = new Notification();
            $notification->user_id = $commentReplying->user_id;
            $notification->type = 'comment_reply';
            $notification->save();
            $notification_reply_comment = new NotificationReplyComment();
            $notification_reply_comment->notification_id=$notification->id;
            $notification_reply_comment->comment_id=$comment->id;
            $notification_reply_comment->save();
            $notification->broadcast();
        }
        return redirect()->back();
    }

    /*public function createResponse($post_id, $comment_id, Request $request){
        $comment = new Comment();
        if($request->input('message') == null){
            return redirect()->back();
        }
        $comment->message = $request->input('message');
        $comment->user_id = Auth::id();
        $comment->post_id = $post_id;
        $comment->reply_to = $comment_id;
        $comment->save();
        return redirect()->back();
    }*/

    

}
