<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaksi;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Carbon\Carbon;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaksi;
    public $merk;
    public $nopol;
    public $formattedDate;

    public function __construct(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;

        // Set locale ke bahasa Indonesia dan format tanggal dengan jam
        Carbon::setLocale('id');
        $this->formattedDate = $transaksi->tgl_kembali->locale('id')->translatedFormat('l, j F Y H:i');

        // Ambil merk dan nopol kendaraan
        $this->merk = $transaksi->jenisMotor->stok->merk ?? 'N/A';
        $this->nopol = $transaksi->jenisMotor->nopol ?? 'N/A';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Pengingat: {$this->merk} {$this->nopol} akan kembali"
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin.emails.reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
