<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageUpdate implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public Message $message;

  public function __construct(Message $message)
  {
      $this->message = $message;

  }

  public function broadcastOn()
  {
      return new Channel('chat'.$this->message->chat_id);
  }

  public function broadcastAs()
  {
      return 'update';
  }
}