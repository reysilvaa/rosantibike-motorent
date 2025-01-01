<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RentalUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $rental;
    public $type;

    public function __construct($rental, $type = 'update')
    {
        $this->rental = $rental;
        $this->type = $type;
    }

    public function broadcastOn()
    {
        return new Channel('rentals');
    }

    public function broadcastAs()
    {
        return 'rental.updated';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->rental->id,
            'type' => $this->type,
            'timestamp' => now()->timestamp
        ];
    }
}