<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(private $message) {}

    public function broadcastAs(): string
    {
        return 'chat-message';
    }
    
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('private.chat.1'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'user' => ['username' => Auth::user()->name]
        ];
    }
}
