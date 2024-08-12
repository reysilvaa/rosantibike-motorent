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
            $data = Booking::with(['jenisMotor.stok'])
                ->leftJoin('jenis_motor', 'booking.id_jenis', '=', 'jenis_motor.id')
                ->select('booking.*', 'jenis_motor.nopol', 'jenis_motor.status');

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
                ->editColumn('tgl_sewa', function($row) {
                    return $row->tgl_sewa->format('d-m-Y H:i');
                })
                ->editColumn('tgl_kembali', function($row) {
                    return $row->tgl_kembali->format('d-m-Y H:i');
                })
                ->editColumn('merk_motor', function($row) {
                    return $row->jenisMotor->stok->merk ?? '';
                })
                ->editColumn('status', function($row) {
                    return $row->status ?? '';
                })
                ->editColumn('total', function($row) {
                    return "Rp. " . number_format($row->total, 0, ',', '.');
                })
                ->filterColumn('nopol', function($query, $keyword) {
                    $query->where('jenis_motor.nopol', 'like', "%{$keyword}%");
                })
                ->filterColumn('merk_motor', function($query, $keyword) {
                    $query->whereHas('jenisMotor.stok', function($q) use ($keyword) {
                        $q->where('merk', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('status', function($query, $keyword) {
                    $query->where('jenis_motor.status', 'like', "%{$keyword}%");
                })
                ->filterColumn('tgl_sewa', function($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(booking.tgl_sewa, '%d-%m-%Y %H:%i') like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('tgl_kembali', function($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(booking.tgl_kembali, '%d-%m-%Y %H:%i') like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('total', function($query, $keyword) {
                    $query->whereRaw("CAST(total AS CHAR) like ?", ["%{$keyword}%"]);
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
        $jenisMotorBaru = JenisMotor::findOrFail($validated['id_jenis']);

        if ($validated['tgl_kembali'] != $originalTglKembali) {
            $jumlahHariPerpanjangan = $originalTglKembali->diffInDays($validated['tgl_kembali']);
            $totalHargaPerpanjangan = $jumlahHariPerpanjangan * $jenisMotorBaru->harga_perHari;
            $booking->total = $originalTotal + $totalHargaPerpanjangan;
            $booking->tgl_kembali = $validated['tgl_kembali'];
        }

        if ($booking->id_jenis != $validated['id_jenis']) {
            $jenisMotorLama = JenisMotor::findOrFail($booking->id_jenis);
            $jenisMotorLama->status = 'ready';
            $jenisMotorLama->save();

            // $jenisMotorBaru->status = 'ready';
            // $jenisMotorBaru->save();

            $booking->id_jenis = $validated['id_jenis'];
        }

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
