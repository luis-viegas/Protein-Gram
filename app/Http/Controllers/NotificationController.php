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
    public function checkNew($last_id){
        $user = Auth::user();
        if(!$user) return redirect()->back();
        $newNotifications = Notification::where('id','>',$last_id)->get();
        foreach($newNotifications as $notification){
            event(new NotificationUpdate($notification));
        }
    }

    public function get(){
        $user=Auth::user();
        if(!$user) return;
        $notifications = $user->notifications()->select('id')->get();//or use ->get()->pluck('id');
        $count = $notifications->count();
        $specificsArray = array();
        foreach($notifications as $notif){
            $specificsArray[$notif->id] = Notification::find($notif->id)->specific();
        }
        return view('partials.notifications', ['notifications' => $specificsArray] );
    }
}
