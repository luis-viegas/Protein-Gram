<?php

namespace App\Events;

use App\Models\Notification;
use App\Models\NotificationComment;
use App\Models\NotificationLikePost;
use App\Models\NotificationLikeComment;
use App\Models\NotificationMessage;
use App\Models\NotificationReplyComment;
use App\Models\NotificationTagComment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification->specific();
    }

    public function broadcastOn()
    {
        return new Channel('notification'.$this->notification->user_id);
    }

    public function broadcastAs()
    {
        return 'update';
    }
}