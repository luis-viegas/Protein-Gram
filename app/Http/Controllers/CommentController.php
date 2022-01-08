<?php

namespace App\Http\Controllers;

use App\Models\Comment;
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

    public function create($post_id, Request $request){
        $comment = new Comment();

        //authorize('create',$post_id);

        if($request->input('message') == null){
            return redirect()->back();
        }

        $comment->message = $request->input('message');
        $comment->user_id = Auth::id();
        $comment->post_id = $post_id;
        $comment->reply_to = null;

        $comment->save();

        return redirect()->back();
    }
}
