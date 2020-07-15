<?php

namespace VCComponent\Laravel\Order\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddAttributesEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $attributes;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order, $attributes)
    {
        $this->order      = $order;
        $this->attributes = $attributes;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
