<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use App\Mail\ReminderEmail;
use Illuminate\Support\Facades\Mail;

class SendReminderEmails extends Command
{
    protected $signature = 'email:send-reminders';
    protected $description = 'Send reminder emails for upcoming rental returns';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $transaksis = Transaksi::join('jenis_motor', 'transaksi.id_jenis', '=', 'jenis_motor.id')
            ->where('tgl_kembali', '<=', now()->addDays(1))
            ->where('tgl_kembali', '>=', now())
            ->whereIn('jenis_motor.status', ['disewa', 'perpanjang'])
            ->select('transaksi.*')
            ->get();

        foreach ($transaksis as $transaksi) {
            Mail::to('reynaldsilva123@gmail.com')->send(new ReminderEmail($transaksi));
        }

        $this->info('Reminder emails sent successfully.');
    }
}
