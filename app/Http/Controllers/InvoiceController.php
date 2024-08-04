<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function previewInvoice($id)
    {
        $transaksi = Transaksi::with('jenisMotor')->findOrFail($id);

        // Ensure dates are not null and correctly parsed
        $tgl_sewa = Carbon::parse($transaksi->tgl_sewa ?? now());
        $tgl_kembali = Carbon::parse($transaksi->tgl_kembali ?? now());

        // Calculate the difference in days
        $lama_sewa = $tgl_sewa->diffInDays($tgl_kembali);

        // Generate PDF
        $pdf = Pdf::loadView('rental.invoice', compact('transaksi', 'lama_sewa'));

        return view('rental.preview', [
            'pdf' => $pdf->output(),
            'transaksi' => $transaksi,
            'lama_sewa' => $lama_sewa
        ]);
    }


    public function downloadInvoice($id)
    {
        $transaksi = Transaksi::with('jenisMotor')->findOrFail($id);

        $pdf = Pdf::loadView('rental.invoice', compact('transaksi'));

        return $pdf->download('invoice_'.$transaksi->id.'.pdf');
    }

    public function previewInvoiceBooking($id)
    {
        $transaksi = Booking::with('jenisMotor')->findOrFail($id);

        // Ensure dates are not null and correctly parsed
        $tgl_sewa = Carbon::parse($transaksi->tgl_sewa ?? now());
        $tgl_kembali = Carbon::parse($transaksi->tgl_kembali ?? now());

        // Calculate the difference in days
        $lama_sewa = $tgl_sewa->diffInDays($tgl_kembali);

        // Generate PDF
        $pdf = Pdf::loadView('rental.invoice', compact('transaksi', 'lama_sewa'));

        return view('rental.preview', [
            'pdf' => $pdf->output(),
            'transaksi' => $transaksi,
            'lama_sewa' => $lama_sewa
        ]);
    }


    public function downloadInvoiceBooking($id)
    {
        $transaksi = Booking::with('jenisMotor')->findOrFail($id);

        $pdf = Pdf::loadView('rental.invoice', compact('transaksi'));

        return $pdf->download('invoice_'.$transaksi->id.'.pdf');
    }
    public function previewInvoiceEnglish($id)
    {
        $transaksi = Transaksi::with('jenisMotor')->findOrFail($id);

        // Ensure dates are not null and correctly parsed
        $tgl_sewa = Carbon::parse($transaksi->tgl_sewa ?? now());
        $tgl_kembali = Carbon::parse($transaksi->tgl_kembali ?? now());

        // Calculate the difference in days
        $lama_sewa = $tgl_sewa->diffInDays($tgl_kembali);

        // Generate PDF
        $pdf = Pdf::loadView('rental.invoiceEng', compact('transaksi', 'lama_sewa'));

        return view('rental.preview', [
            'pdf' => $pdf->output(),
            'transaksi' => $transaksi,
            'lama_sewa' => $lama_sewa
        ]);
    }


    public function downloadInvoiceEnglish($id)
    {
        $transaksi = Transaksi::with('jenisMotor')->findOrFail($id);

        $pdf = Pdf::loadView('rental.invoiceEng', compact('transaksi'));

        return $pdf->download('invoice_'.$transaksi->id.'.pdf');
    }
}
