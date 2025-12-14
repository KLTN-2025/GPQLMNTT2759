<?php

namespace App\Events;

use App\Models\TinNhanNhom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(TinNhanNhom $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('group-chat.' . $this->message->nhom_chat_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'GroupMessageSent';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'nhom_chat_id' => $this->message->nhom_chat_id,
                'loai_nguoi_gui' => $this->message->loai_nguoi_gui,
                'nguoi_gui_id' => $this->message->nguoi_gui_id,
                'noi_dung' => $this->message->noi_dung,
                'created_at' => $this->message->created_at->toISOString(),
                'nguoi_gui_info' => $this->message->nguoi_gui
            ]
        ];
    }
}
