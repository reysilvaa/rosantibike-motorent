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
        $data = Transaksi::with(['jenisMotor.stok'])
            ->leftJoin('jenis_motor', 'transaksi.id_jenis', '=', 'jenis_motor.id')
            ->select('transaksi.*', 'jenis_motor.nopol', 'jenis_motor.status')
            ->get();

        return response()->json($data, 200);
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
