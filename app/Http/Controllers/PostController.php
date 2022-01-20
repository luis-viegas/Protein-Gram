<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function show($id){
        $post = Post::find($id);
        if($post->poster()->first()->is_private)
            return redirect('/');
        return view('pages.mainPage', ['posts'=>['0'=>$post],'showNewPost'=>False]);
    }

    public function publicTimeline(){

        $posts = Post::orderBy('id','desc')
                      ->get();
        return view('pages.mainPage', ['posts'=>$posts]);
    }

    public function creationForm(){
        $this->authorize('create', Post::class);
        return view('pages.createPost');
    }

    public function create(Request $request){
        $user = Auth::user();
        if(!$user) return redirect()->back();
        $post = new Post();
        $this->authorize('create',Post::class);
        $post->text = $request->input('text');
        $post->user_id = Auth::id();
        $post->save();
        return redirect()->back();
    }

    public function groupCreate(Request $request){
        $user = Auth::user();
        if(!$user) return redirect()->back();
        $post = new Post();
        $this->authorize('create',Post::class);
        $post->text = $request->input('text');
        $post->user_id = Auth::id();
        $group = Group::find($request->input('id'));
        $post->group_id = $request->input('id');
        $post->save();
        return redirect()->back();
    }

    public function edit($id){
        $user = Auth::user();
        if($user->is_admin || $user->id == Post::find($id)->user_id)
            return view('pages.editPost', ['post' => Post::find($id)]);
        return redirect()->back();
    }
    public function update(Request $request, $id = null){
        $auth = Auth::user();
        if(!$auth) return redirect()->back();
        $user = $auth->is_admin && isset($id) ? User::find($id) : $auth;
        if(!$user) return redirect()->back();
        $post = $user->posts->find($request->input('id'));
        if(!$post) return redirect()->back();

        $this->authorize('update',$post);
        $post->text = $request->input('text');
        $post->save();
        return redirect('/posts/'.$post->id);
    }

    public function delete(Request $request, $user_id = null){
        $auth = Auth::user();
        if(!$auth) return redirect()->back();
        $user = $auth->is_admin && isset($user_id) ? User::find($user_id) : $auth;
        if(!$user) return redirect()->back();
        $post = $user->posts->find($request->input('id'));
        if(!$post) return redirect()->back();
        $this->authorize('delete',$post);
        $post->delete();
        return redirect()->back(); //TODO: check if appropriate.
    }

    public function like(Request $request, $post_id = null){
        $user = Auth::user();
        if(!$user) return redirect()->back();
        $post = $user->posts->find($post_id?:$request->input('id'));
        if(!$post)return redirect()->back();
        $post->likes()->attach($user->id, ['type' => 'LIKE']);
        return 0;

    }
}
