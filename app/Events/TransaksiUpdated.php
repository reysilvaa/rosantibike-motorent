<?php
namespace App\Events;

use App\Models\Transaksi;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransaksiUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transaksi;

    /**
     * Create a new event instance.
     *
     * @param Transaksi $transaksi
     */
    public function __construct(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('transaksi-channel');
    }

    /**
     * Get the name of the event to broadcast.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'transaksi-updated';
    }

    /**
     * Get the data to broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->transaksi->id,
            'tgl_sewa' => $this->transaksi->tgl_sewa->format('d-m-Y H:i'),
            'tgl_kembali' => $this->transaksi->tgl_kembali->format('d-m-Y H:i'),
            'total' => number_format($this->transaksi->total, 0, ',', '.'),
            'nopol' => $this->transaksi->jenisMotor->nopol,
            'status_motor' => $this->transaksi->jenisMotor->status,
            'message' => 'Transaksi telah diperbarui'
        ];
    }
}
