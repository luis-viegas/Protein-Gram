<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\View\View;
use App\Models\Notification;

class NotificationUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    public function broadcastWith(){
        $spec = $this->notification->specific();
        $arr = (array)$spec;
        $arr['html'] = view('partials.notificationsSingle', ['notification' => $spec])->render();
        $arr['html'] = substr($arr['html'],0,strrpos($arr['html'],">",-1)+1);
        return $arr;
    }

    public function broadcastOn()
    {
        return new Channel('notification'.$this->notification->user_id);
    }

    public function broadcastAs()
    {
        return 'notification_update';
    }
}