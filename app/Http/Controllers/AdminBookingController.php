<?php

namespace App\Http\Controllers;

use App\Models\JenisMotor;
use App\Models\Booking;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminBookingController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function booking()
    {
        return view('admin.booking.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Booking::with('jenisMotor.stok')->select('booking.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $editBtn = '<a href="' . route('admin.booking.edit', $row->id) . '" class="bg-green-600 text-white hover:bg-green-700 rounded px-3 py-2 text-xs flex items-center justify-center"><i class="fa-solid fa-pen"></i></a>';
                    $cetakBtn = '<a href="' . route('transaksi.invoice.booking.preview', $row->id) . '" target="_blank" class="bg-blue-600 text-white hover:bg-blue-700 rounded px-3 py-2 text-xs flex items-center justify-center" title="Preview Invoice"><i class="fa-solid fa-eye"></i></a>';
                    return '<div class="flex space-x-2 justify-center">' . $editBtn . $cetakBtn . '</div>';
                })
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" name="booking_checkbox[]" class="booking_checkbox custom-checkbox" value="' . $row->id . '" />';
                })
                ->addColumn('tgl_sewa', function($row) {
                    return $row->tgl_sewa->format('d-m-Y H:i');
                })
                ->addColumn('tgl_kembali', function($row) {
                    return $row->tgl_kembali->format('d-m-Y H:i');
                })
                ->addColumn('merk_motor', function($row) {
                    return $row->jenisMotor->stok->merk ?? '';
                })
                ->addColumn('status', function($row) {
                    return $row->jenisMotor->status ?? '';
                })
                ->addColumn('total', function($row) {
                    return "Rp. " . number_format($row->total, 0, ',', '.');
                })
                ->rawColumns(['action', 'checkbox'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        // Temukan booking yang akan diedit
        $booking = Booking::findOrFail($id);

        // Ambil daftar jenis motor yang sedang tidak disewa, tetapi pastikan jenis motor yang sedang diedit tetap ada
        $jenisMotorList = JenisMotor::where(function($query) use ($booking) {
            $query->whereDoesntHave('booking', function($query) {
                $query->whereIn('status', ['disewa', 'perpanjang']);
            });
        })->orWhere('id', $booking->id_jenis)->get();

        // Tampilkan view edit dengan data booking dan daftar jenis motor
        return view('admin.booking.edit', compact('booking', 'jenisMotorList'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'tgl_kembali' => 'required|date|after_or_equal:today',
            'id_jenis' => 'required|exists:jenis_motor,id',
        ]);

        // Temukan booking yang akan diperbarui
        $booking = Booking::findOrFail($id);

        // Simpan total awal sebelum update
        $originalTotal = $booking->total;

        // Simpan tanggal kembali yang asli
        $originalTglKembali = $booking->tgl_kembali;

        // Ambil data jenis motor terbaru
        $jenisMotor = JenisMotor::findOrFail($validated['id_jenis']);

        // Hitung jumlah hari perpanjangan dari tanggal kembali yang asli
        $tglSewa = $booking->tgl_sewa;
        $tglKembali = $validated['tgl_kembali'];

        // Jika tanggal kembali baru lebih awal dari tanggal kembali asli, tidak perlu perpanjangan
        if ($tglKembali <= $originalTglKembali) {
            return redirect()->back()->with('error', 'Tanggal kembali baru tidak boleh lebih awal dari tanggal kembali asli.');
        }

        // Hitung jumlah hari perpanjangan
        $jumlahHariPerpanjangan = $originalTglKembali->diffInDays($tglKembali);

        // Hitung total harga perpanjangan
        $totalHargaPerpanjangan = $jumlahHariPerpanjangan * $jenisMotor->harga_perHari;

        // Tambahkan total perpanjangan ke total yang sudah ada
        $totalHargaBaru = $originalTotal + $totalHargaPerpanjangan;

        // Perbarui data booking
        $booking->tgl_kembali = $validated['tgl_kembali'];
        $booking->id_jenis = $validated['id_jenis'];
        $booking->total = $totalHargaBaru;
        $booking->jenisMotor->status = 'perpanjang'; // Atau status sesuai kebutuhan
        $booking->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.booking.edit', ['booking' => $id])->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        $jenisMotor = JenisMotor::find($booking->id_jenis);

        // Check if JenisMotor exists
        if ($jenisMotor) {
            // Update the status to 'ready'
            $jenisMotor->update(['status' => 'ready']);
        }

        // Delete the booking record
        $booking->delete();
        return response()->json(['success'=>'Booking deleted successfully.']);
    }

    public function bulkDelete(Request $request)
    {
        // Get the IDs from the request
        $ids = $request->ids;

        // Delete the bookings with the specified IDs
        Booking::whereIn('id', $ids)->each(function ($booking) {
            // Find the JenisMotor associated with the current booking
            $jenisMotor = JenisMotor::find($booking->id_jenis);

            // Check if JenisMotor exists and update its status
            if ($jenisMotor) {
                $jenisMotor->update(['status' => 'ready']);
            }
        });

        // Delete the bookings after updating JenisMotor statuses
        Booking::whereIn('id', $ids)->delete();

        // Return a success response
        return response()->json(['success' => "Bookings deleted successfully."]);
    }
}
