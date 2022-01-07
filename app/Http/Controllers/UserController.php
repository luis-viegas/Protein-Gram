<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show($id){

        $user = User::find($id);
        //if (user==null) return view( Invalid user)
        //TODO: check if user exists.
        $posts = $user->posts()
                      ->join('users', 'posts.user_id', '=', 'users.id')
                      ->select('posts.*','users.name','users.image')
                      ->orderBy('id','desc')
                      ->get();

        return view('pages.user', ['user'=> $user, 'posts' => $posts]);
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



}
