<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $id_gui;

    public function __construct($message, $id_gui)
    {
        $this->message = $message;
        $this->id_gui = $id_gui;
    }


    public function broadcastOn(): array
    {
        return [
            new Channel('chat_real_time'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'chatRealTime';
    }
}
