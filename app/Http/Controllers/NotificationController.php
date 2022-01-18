<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Notification;
use App\Events\NotificationUpdate;

class NotificationController extends Controller
{
    /*public function checkNew($last_id){
        $user = Auth::user();
        if(!$user) return redirect()->back();
        $newNotifications = Notification::where('id','>',$last_id)->get();
        foreach($newNotifications as $notification){
            event(new NotificationUpdate($notification));
        }
    }*/

    public function get(){
        $user=Auth::user();
        if(!$user) return redirect()->back();
        $specificsArray = array();
        $ns = $user->notifications()->orderBy('id','desc')->limit(10)->get();
        foreach($ns as $n){
            info($n);
            $specificsArray[$n->id] = $n->specific();
        }
        return view('partials.notifications', ['notifications' => $specificsArray] );
    }
    public function consume($last_id){
        $user=Auth::user();
        if(!$user) return redirect()->back();
        $user->notifications()->where('id','<=',end($specificsArray)->id)->where('consumed',False)->update(['consumed'=>True]);
    }
}
