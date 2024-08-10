<?php

namespace App\Http\Controllers;

use App\Models\JenisMotor;
use App\Models\Booking;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

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
                    $cetakBtn = '<a href="' . route('transaksi.invoice.preview', ['type' => 'booking', 'id' => $row->id]) . '" target="_blank" class="bg-blue-600 text-white hover:bg-blue-700 rounded px-3 py-2 text-xs flex items-center justify-center" title="Preview Invoice"><i class="fa-solid fa-eye"></i></a>';
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
        $booking = Booking::findOrFail($id);
        $jenisMotorList = JenisMotor::where(function($query) use ($booking) {
            $query->whereDoesntHave('booking', function($query) {
                $query->whereIn('status', ['disewa', 'perpanjang']);
            });
        })->orWhere('id', $booking->id_jenis)->get();

        return view('admin.booking.edit', compact('booking', 'jenisMotorList'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tgl_kembali' => 'required|date|after_or_equal:today',
            'id_jenis' => 'required|exists:jenis_motor,id',
        ]);

        $booking = Booking::findOrFail($id);
        $originalTotal = $booking->total;
        $originalTglKembali = $booking->tgl_kembali;
        $jenisMotor = JenisMotor::findOrFail($validated['id_jenis']);

        $tglSewa = $booking->tgl_sewa;
        $tglKembali = $validated['tgl_kembali'];

        if ($tglKembali <= $originalTglKembali) {
            notify()->preset('error', [
                'title' => 'Gagal Memperbarui Booking',
                'message' => 'Tanggal kembali baru tidak boleh lebih awal dari tanggal kembali asli.'
            ]);
            return redirect()->back()->with('error', 'Tanggal kembali baru tidak boleh lebih awal dari tanggal kembali asli.');
        }

        $jumlahHariPerpanjangan = $originalTglKembali->diffInDays($tglKembali);
        $totalHargaPerpanjangan = $jumlahHariPerpanjangan * $jenisMotor->harga_perHari;
        $totalHargaBaru = $originalTotal + $totalHargaPerpanjangan;

        $booking->tgl_kembali = $validated['tgl_kembali'];
        $booking->id_jenis = $validated['id_jenis'];
        $booking->total = $totalHargaBaru;
        $booking->jenisMotor->status = 'perpanjang';
        $booking->save();

        notify()->preset('success', [
            'title' => 'Booking Berhasil Diperbarui',
            'message' => 'Booking berhasil diperbarui dengan total baru.'
        ]);

        return redirect()->route('admin.booking.edit', ['booking' => $id]);
    }

    public function destroy(Booking $booking)
    {
        $jenisMotor = JenisMotor::find($booking->id_jenis);

        if ($jenisMotor) {
            $jenisMotor->update(['status' => 'ready']);
        }

        $booking->delete();

        notify()->preset('success', [
            'title' => 'Booking Berhasil Dihapus',
            'message' => 'Booking berhasil dihapus.'
        ]);

        return response()->json(['success' => 'Booking deleted successfully.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        Booking::whereIn('id', $ids)->each(function ($booking) {
            $jenisMotor = JenisMotor::find($booking->id_jenis);

            if ($jenisMotor) {
                $jenisMotor->update(['status' => 'ready']);
            }
        });

        Booking::whereIn('id', $ids)->delete();

        notify()->preset('success', [
            'title' => 'Bulk Delete Berhasil',
            'message' => 'Bookings berhasil dihapus.'
        ]);

        return response()->json(['success' => 'Bookings deleted successfully.']);
    }
}
