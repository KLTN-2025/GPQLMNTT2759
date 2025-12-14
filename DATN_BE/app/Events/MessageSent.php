<?php

namespace App\Events;

use App\Models\TinNhan;
use App\Models\CuocTroChuyen;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $conversation;

    /**
     * Create a new event instance.
     */
    public function __construct(TinNhan $message, CuocTroChuyen $conversation)
    {
        $this->message = $message;
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('conversation.' . $this->conversation->id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'MessageSent';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'cuoc_tro_chuyen_id' => $this->message->cuoc_tro_chuyen_id,
                'loai_nguoi_gui' => $this->message->loai_nguoi_gui,
                'nguoi_gui_id' => $this->message->nguoi_gui_id,
                'noi_dung' => $this->message->noi_dung,
                'da_doc' => $this->message->da_doc,
                'file_dinh_kem' => $this->message->file_dinh_kem,
                'thoi_gian_gui' => $this->message->thoi_gian_gui,
                'created_at' => $this->message->created_at->toISOString(),
            ],
            'conversation_id' => $this->conversation->id,
        ];
    }
}
