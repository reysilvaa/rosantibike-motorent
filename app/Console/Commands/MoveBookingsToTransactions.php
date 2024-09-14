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
        $today = Carbon::today();
        DB::beginTransaction();

        try {
            // Get bookings where tgl_sewa is today
            $bookings = Booking::whereDate('tgl_sewa', $today)->get();

            // Prepare transactions data for batch insert
            $transactionsData = [];
            $motorIdsToUpdate = [];

            foreach ($bookings as $booking) {
                $transactionsData[] = [
                    'nama_penyewa' => $booking->nama_penyewa,
                    'alamat' => $booking->alamat,
                    'wa1' => $booking->wa1,
                    'wa2' => $booking->wa2,
                    'wa3' => $booking->wa3,
                    'tgl_sewa' => $booking->tgl_sewa,
                    'tgl_kembali' => $booking->tgl_kembali,
                    'id_jenis' => $booking->id_jenis,
                    'total' => $booking->total,
                    'helm' => $booking->helm,
                    'jashujan' => $booking->jashujan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Add motor ID to the update list
                $motorIdsToUpdate[] = $booking->id_jenis;
            }

            // Insert all transactions at once
            if (!empty($transactionsData)) {
                Transaksi::insert($transactionsData);
            }

            // Update status of all involved motors
            if (!empty($motorIdsToUpdate)) {
                JenisMotor::whereIn('id', $motorIdsToUpdate)
                    ->update(['status' => 'disewa']);
            }

            // Delete all bookings that have been moved
            Booking::whereDate('tgl_sewa', $today)->delete();

            DB::commit();
            $this->info('Bookings moved to transactions successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('An error occurred while moving the bookings: ' . $e->getMessage());
        }
    }
}
