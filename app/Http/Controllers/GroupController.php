<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    public function create(Request $request){

        $group = new Group();
        //$this->authorize('create',Group::class);
        $group->name = $request->input('name');
        $group->save();
        $group->members()->attach(Auth::user()->id);
        $group->owners()->attach(Auth::user()->id);
        return redirect()->back();
    }

    public function show($id) {
        $group = Group::find($id);
        if(!$group) return redirect("/");
        return view('pages.group', ['group'=> $group]); 
    }

    public function getAllGroups() {
        $groups = Group::orderBy('id','desc')
                      ->get();
        return $groups;
    }

    public function groups(){
        $user = Auth::user();
        $groups = $this->getAllGroups();

        return view('pages.groups' , ['user'=>$user , 'groups'=>$groups]);
    }

    public function delete(Request $request){
        $id = $request->input('id');
        $group = Group::find($id);
        //$this->authorize('delete',$post);

        $group->delete();
        return redirect()->route('groups_page', ['id' => Auth::user()->id]);
    }

    public function rename(Request $request) {
        $id = $request->input('id');
        $group = Group::find($id);
        $name = $request->input('name');

        $group->name = $name;
        $group->save();
        return redirect('groups/'.$group->id);
    }

    public function join(Request $request , $group_id) {
        $id = $request->input('id');
        $group = Group::find($id);
        $group->members()->attach(Auth::user()->id);
        return redirect('groups/{{$group_id}}');
        
    }

    public function leave(Request $request , $group_id) {
        $id = $request->input('id');
        $group = Group::find($id);
        $group->members()->detach(Auth::user()->id);
        $group->members()->delete(Auth::user()->id);
        return redirect()->route('groups_page', ['id' => Auth::user()->id]);
        
    }
}