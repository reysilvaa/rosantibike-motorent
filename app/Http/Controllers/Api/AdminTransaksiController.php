<?php

namespace App\Http\Controllers\Api;

use App\Models\JenisMotor;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class AdminTransaksiController extends Controller
{
    // Endpoint untuk mengambil semua data transaksi
    public function index(Request $request)
    {
        // Get search and lastUpdated query parameters
        $search = $request->query('search', null);
        $lastUpdated = $request->query('last_updated', null);
        
        // Start building the query
        $query = Transaksi::with(['jenisMotor.stok'])
                          ->leftJoin('jenis_motor', 'transaksi.id_jenis', '=', 'jenis_motor.id')
                          ->select('transaksi.*', 'jenis_motor.nopol', 'jenis_motor.status');
        
        // Apply lastUpdated condition if available
        if ($lastUpdated) {
            $query->where('transaksi.updated_at', '>', $lastUpdated);
        }
    
        // Apply search condition if there is a search query
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('transaksi.id', 'like', "%$search%")
                  ->orWhere('jenis_motor.nopol', 'like', "%$search%")
                  ->orWhere('transaksi.nama_penyewa', 'like', "%$search%"); // Add more fields as needed
                //   ->orWhere('transaksi.*', 'like', "%$search%"); // Replace with other relevant columns
            });
        }
    
        // Execute the query and get the data
        $data = $query->get();
        
        // Get total counts
        $totalCount1 = Transaksi::count(); // Total transaksi
        $totalCount2 = JenisMotor::where('status', 'ready')->count(); // Total motor ready
    
        // Return the response
        return response()->json([
            'data' => $data,
            'motor_tersewa' => $totalCount1,
            'sisa_motor' => $totalCount2,
            'timestamp' => now(), // Timestamp for the next request
        ], 200);
    }
    
    // Endpoint untuk mengambil detail transaksi berdasarkan ID
    public function show($id)
    {
        $transaksi = Transaksi::with(['jenisMotor.stok'])->findOrFail($id);

        return response()->json($transaksi, 200);
    }

    // Endpoint untuk memperbarui transaksi
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tgl_kembali' => 'required|date|after_or_equal:today',
            'id_jenis' => 'required|exists:jenis_motor,id',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $originalTglKembali = $transaksi->tgl_kembali;

        $jenisMotorBaru = JenisMotor::findOrFail($validated['id_jenis']);

        if ($validated['tgl_kembali'] != $originalTglKembali) {
            $tglKembali = $validated['tgl_kembali'];
            $jumlahHariPerpanjangan = $originalTglKembali->diffInDays($tglKembali);
            $totalHargaPerpanjangan = $jumlahHariPerpanjangan * $jenisMotorBaru->harga_perHari;

            $transaksi->total += $totalHargaPerpanjangan;
            $transaksi->tgl_kembali = $tglKembali;
        }

        if ($transaksi->id_jenis != $validated['id_jenis']) {
            $jenisMotorLama = JenisMotor::findOrFail($transaksi->id_jenis);
            $jenisMotorLama->status = 'ready';
            $jenisMotorLama->save();

            $jenisMotorBaru->status = 'disewa';
            $jenisMotorBaru->save();

            $transaksi->id_jenis = $validated['id_jenis'];
        } else {
            $jenisMotorBaru->status = 'disewa';
            $jenisMotorBaru->save();
        }

        $transaksi->save();

        return response()->json(['message' => 'Transaksi berhasil diperbarui.', 'data' => $transaksi], 200);
    }

    // Endpoint untuk menghapus transaksi
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $jenisMotor = JenisMotor::find($transaksi->id_jenis);

        if ($jenisMotor) {
            $jenisMotor->update(['status' => 'ready']);
        }

        $transaksi->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus.'], 200);
    }

    // Endpoint untuk menghapus beberapa transaksi sekaligus
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        Transaksi::whereIn('id', $ids)->each(function ($transaksi) {
            $jenisMotor = JenisMotor::find($transaksi->id_jenis);
            if ($jenisMotor) {
                $jenisMotor->update(['status' => 'ready']);
            }
        });

        Transaksi::whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus secara massal.'], 200);
    }

    // Endpoint untuk mengambil data transaksi dengan format DataTables
    public function getData(Request $request)
    {
        $data = Transaksi::with(['jenisMotor.stok'])
            ->leftJoin('jenis_motor', 'transaksi.id_jenis', '=', 'jenis_motor.id')
            ->select('transaksi.*', 'jenis_motor.nopol', 'jenis_motor.status');

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return [
                    'edit_url' => route('api.transaksi.edit', $row->id),
                    'invoice_url' => route('api.transaksi.invoice.preview', ['type' => 'transaksi', 'id' => $row->id]),
                ];
            })
            ->editColumn('tgl_sewa', function ($row) {
                return $row->tgl_sewa->format('d-m-Y H:i');
            })
            ->editColumn('tgl_kembali', function ($row) {
                return $row->tgl_kembali->format('d-m-Y H:i');
            })
            ->editColumn('total', function ($row) {
                return "Rp. " . number_format($row->total, 0, ',', '.');
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
