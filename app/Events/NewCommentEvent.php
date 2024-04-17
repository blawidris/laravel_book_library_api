<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewCommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Comment $comment)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {

        return [
            new Channel('post.' . $this->comment->id),
            // new PrivateChannel("private.post." . $this->comment->id)
        ];
    }

    public function broadCastWith()
    {
        return [
            'body' => $this->comment->body,
            'created_at' => $this->comment->created_at,
            'user' => [
                'id' => $this->comment->user->id,
                'name' => $this->comment->user->name,
                'avatar' => $this->comment->user->avatar,
            ]
        ];
    }
}
