<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show($id){
        $user = User::find($id);
        $auth = Auth::user();
        if (!$user) return redirect("");
        $posts = $user->posts()
                      ->orderBy('id','desc')
                      ->get();
        if($user->is_private==false){
            return view('pages.user', ['user'=> $user, 'posts' => $posts]);
        }
        else{
            if($auth && ($auth->is_admin || $id == $auth->id || $auth->isFriend($id))){
                return view('pages.user', ['user'=> $user, 'posts' => $posts]);
            }
            return view('pages.private_user',['user'=>$user]);
        }
    }

    public function listAdministration(){
        $users = DB::table('users')->get();

        return view('pages.administration', ['users' => $users]);
    }

    public function create(Request $request){
        $user = new User();
        $this->authorize('create');
        $user-> name = $request->input('name');
        $user-> email = $request->input('email');
        $user-> password = bcrypt($request->input('password'));
        $user-> is_admin = $request->input('is_admin');
        $user-> is_private = $request->input('is_private');
        $user->save();
        return $user;
    }

    public function update(Request $request, $id){
        
        $user = User::find($id);
        $this->authorize('update',$user);
        $user-> name = $request->input('name');
        $user-> is_admin = $request->boolean('is_admin');
        $user-> is_private = $request->boolean('is_private');
        $new_image = $request->input('image');
        if($new_image!=''){
            $user-> image = $new_image;
        }
        $user-> bio = $request->input('bio');
        $user->save();
        return redirect('/users/'.$user->id);
    }

    public function updateForm($id){
        $user = User::find($id);
        $this->authorize('update',$user);

        return view('pages.updateUser',['user'=> $user]);
    }

    public function delete($id){

        $user = User::find($id);
        $this->authorize('delete',$user);
        $user->delete();

        return redirect('/');

    }

    public function deleteConfirmation($id){
        $user = User::find($id);
        $this->authorize('delete',$user);

        return view('pages.deleteUser', ['user'=>$user]);

        
    }

    public function friends($id){
        $auth = Auth::user();
        if(!$auth) return redirect("/");
        $user = $auth->is_admin && $id?User::find($id) : $auth;
        if(!$user) return redirect("/");
        return view('pages.friends',[
            'user'=> $user, 
            'friends'=> $user->friends(),
            'friendRequests'=> $user->friendRequestsReceived()->get()
        ]);
    }

    public function createFriendRequest(Request $request){
        $user = Auth::user();
        if($user){
            $user->makeFriendRequest($request->input("friend_request_id"));
        }
        return redirect()->back();
    }

    public function removeFriendRequest(Request $request){
        $user = Auth::user();
        if($user){
            $user->removeFriendRequest($request->input("friend_request_id"));
        }
        return redirect()->back();
    }

    public function removeFriend(Request $request){
        $user = Auth::user();
        if($user){
            $user->removeFriend($request->input("friend_id"));
        }
        return redirect()->back();
    }



}
