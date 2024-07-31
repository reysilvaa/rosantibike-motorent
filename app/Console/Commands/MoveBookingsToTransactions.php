<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Transaksi;
use App\Models\JenisMotor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MoveBookingsToTransactions extends Command
{
    protected $signature = 'bookings:move';
    protected $description = 'Move bookings to transactions when the booking date is today';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        DB::beginTransaction();

        try {
            // Get bookings where tgl_sewa is today
            $bookings = Booking::whereDate('tgl_sewa', $today)->get();

            foreach ($bookings as $booking) {
                // Create a transaction record
                Transaksi::create([
                    'nama_penyewa' => $booking->nama_penyewa,
                    'wa1' => $booking->wa1,
                    'wa2' => $booking->wa2,
                    'wa3' => $booking->wa3,
                    'tgl_sewa' => $booking->tgl_sewa,
                    'tgl_kembali' => $booking->tgl_kembali,
                    'id_jenis' => $booking->id_jenis,
                    'total' => $booking->total,
                    'helm' => $booking->helm,
                    'jashujan' => $booking->jashujan,
                ]);

                // Update JenisMotor status to 'disewa'
                $jenis_motor = JenisMotor::find($booking->id_jenis);
                if ($jenis_motor) {
                    $jenis_motor->update(['status' => 'disewa']);
                }

                // Delete the booking record
                $booking->delete();
            }

            DB::commit();
            $this->info('Bookings moved to transactions successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('An error occurred while moving the bookings: ' . $e->getMessage());
        }
    }
}
