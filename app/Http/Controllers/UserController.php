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
        if (!$user) return redirect("");
        $posts = $user->posts()
                      ->orderBy('id','desc')
                      ->get();
        if($user->is_private==false){
            return view('pages.user', ['user'=> $user, 'posts' => $posts]);
        }
        else if(Auth::check()){
            if(Auth::user()->is_admin){
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
        $user = User::find($id);

        $friends = $user->relationships()->get();
        $friendRequests = $user->friendRequestsReceived()->get();

        return view('pages.friends',['user'=>$user, 'friends'=>$friends, 'friendRequests'=>$friendRequests]);
    }


    public function createFriendRequest($id){
        $user = User::find($id);

        $user->friendRequestsReceived()->attach(Auth::user()->id);
        return redirect()->back();
    }

    public function removeFriendRequest(Request $request){
        $user = User::find(Auth::user()->id);

        $user->friendRequestsReceived()->detach($request->input('friend_request_id'));
        return redirect()->back();
    }

    public function removeFriend(Request $request){
        $user = User::find(Auth::user()->id);
        $friend = User::find($request->input('friend_request_id'));

        $user->relationship()->detach($friend);
        $friend->relationship()->detach($user);

        return redirect()->back();
    }



}
