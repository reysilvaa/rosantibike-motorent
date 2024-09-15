<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use App\Models\JenisMotor;

class UpdateMotorStatus extends Command
{
    protected $signature = 'motor:update-status';
    protected $description = 'Check if any transactions have a motor with status ready and update them to disewa';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Ambil semua transaksi yang memiliki motor dengan status 'ready'
        $transaksiList = Transaksi::with('jenisMotor')->whereHas('jenisMotor', function ($query) {
            $query->where('status', 'ready');
        })->get();

        // Jika ada, ubah status menjadi 'disewa'
        foreach ($transaksiList as $transaksi) {
            $jenisMotor = $transaksi->jenisMotor;
            $jenisMotor->status = 'disewa';
            $jenisMotor->save();

            $this->info("Motor dengan id_jenis {$jenisMotor->id} sekarang disewa.");
        }

        $this->info('Pengecekan dan pembaruan status motor selesai.');
    }
}
