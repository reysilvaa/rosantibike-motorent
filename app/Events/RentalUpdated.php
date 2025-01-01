<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractorShouldBroadcast;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RentalUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

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
}