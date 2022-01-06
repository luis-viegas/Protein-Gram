<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function show($id){

        $post = Post::find($id);
        $user = $post->user();
        return view('partials.post', ['post'=>$post, 'user'=>$user]);
    }

    public function publicTimeline(){

        $posts = DB::table('posts')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->select('posts.*','users.name','users.image')
                    ->orderBy('id','desc')
                    ->get();
        return view('pages.mainPage', ['posts'=>$posts]);
    }

    public function creationForm(){
        $this->authorize('create', Post::class);
        return view('pages.createPost');
    }

    public function create(Request $request){

        $post = new Post();
        $this->authorize('create',Post::class);
        $post->text = $request->input('text');
        $post->user_id = Auth::id();

        $post->save();
        return redirect('users/'.$post->user_id);
    }

    public function update(Request $request, $id){

        $post = Post::find($id);
        $this->authorize('update',$post);
        $post->text = $request->input('text');

        $post->save();
        return redirect('users/'.Auth::id());

    }

    public function delete(Request $request){
        $id = $request->input('id');
        $post = Post::find($id);
        $this->authorize('delete',$post);

        $post->delete();
        return redirect('users/'.Auth::id());
    }
}