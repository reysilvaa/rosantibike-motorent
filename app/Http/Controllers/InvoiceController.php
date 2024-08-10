<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    protected function getModel($type)
    {
        return $type === 'booking' ? Booking::class : Transaksi::class;
    }

    protected function getView($language)
    {
        return $language === 'en' ? 'rental.invoiceEng' : 'rental.invoice';
    }

    public function previewInvoice($type, $id)
    {
        $language = request()->query('language', 'id'); // Default to 'id' if not set
        $model = $this->getModel($type);
        $transaksi = $model::with('jenisMotor')->findOrFail($id);

        $tgl_sewa = Carbon::parse($transaksi->tgl_sewa ?? now());
        $tgl_kembali = Carbon::parse($transaksi->tgl_kembali ?? now());

        $lama_sewa = $tgl_sewa->diffInDays($tgl_kembali);

        // Set locale based on parameter
        app()->setLocale($language);

        $pdf = Pdf::loadView($this->getView($language), compact('transaksi', 'lama_sewa'));

        return view('rental.preview', [
            'pdf' => $pdf->output(),
            'transaksi' => $transaksi,
            'lama_sewa' => $lama_sewa
        ]);
    }

    public function downloadInvoice($type, $id)
    {
        $language = request()->query('language', 'id'); // Default to 'id' if not set
        $model = $this->getModel($type);
        $transaksi = $model::with('jenisMotor')->findOrFail($id);

        // Set locale based on parameter
        app()->setLocale($language);

        $pdf = Pdf::loadView($this->getView($language), compact('transaksi'));

        $tglSewaFormatted = $transaksi->tgl_sewa->format('d-m-Y_His');
        $tglKembaliFormatted = $transaksi->tgl_kembali->format('d-m-Y_His');
        $date = "{$tglSewaFormatted}_{$tglKembaliFormatted}";
        $fileName = "{$type}_{$transaksi->nama_penyewa}_{$date}.pdf";

        return $pdf->download($fileName);
    }
}
