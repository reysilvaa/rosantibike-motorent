<?php
namespace App\Events;

use App\Models\Booking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function broadcastOn()
    {
        return new Channel('booking-channel');
    }

    public function broadcastAs()
    {
        return 'booking-updated';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->booking->id,
            'updated_at' => $this->booking->updated_at->toDateTimeString(),
            'message' => 'Booking has been updated'
        ];
    }
}