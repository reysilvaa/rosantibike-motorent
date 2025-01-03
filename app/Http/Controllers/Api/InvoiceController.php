<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    /**
     * Generate invoice preview (return PDF as base64 for preview)
     */
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
    
        // Set paper size to A5
        $pdf = Pdf::loadView($this->getView($language), compact('transaksi', 'lama_sewa'))
                  ->setPaper('a4', 'potrait'); // A5 size in portrait orientation
    
        // Convert PDF to base64 for preview
        $pdfBase64 = base64_encode($pdf->output());
    
        return response()->json([
            'pdf_base64' => $pdfBase64,
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
    
        // Set paper size to A5
        $pdf = Pdf::loadView($this->getView(language: $language), compact('transaksi'))
                  ->setPaper('a4', 'potrait'); // A5 size in portrait orientation
    
        // Format the file name using the transaction date
        $tglSewaFormatted = $transaksi->tgl_sewa->format('d-m-Y_His');
        $tglKembaliFormatted = $transaksi->tgl_kembali->format('d-m-Y_His');
        $date = "{$tglSewaFormatted}_{$tglKembaliFormatted}";
        $fileName = "{$type}_{$transaksi->nama_penyewa}_{$date}.pdf";
    
        // Return PDF as a response with the correct content type and filename for download
        return response()->stream(
            fn() => print($pdf->output()),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"$fileName\""
            ]
        );
    }
}    