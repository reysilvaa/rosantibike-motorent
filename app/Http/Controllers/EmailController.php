<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Mail\ReminderEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendReminder($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        Carbon::setLocale('id');
        $formattedDate = $transaksi->tgl_kembali->locale('id')->translatedFormat('l, j F Y H:i');

        Mail::to('reynaldsilva123@gmail.com')->send(new ReminderEmail($transaksi, $formattedDate));

        return redirect()->back()->with('success', 'Reminder email sent successfully.');
    }
}
