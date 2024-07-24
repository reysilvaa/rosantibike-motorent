<?php
namespace App\Http\Controllers;

use App\Models\JenisMotor;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class AdminTransaksiController extends Controller
{
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaksi::with('jenisMotor')->get();
            return DataTables::of($data)
                ->addColumn('jenis_motor', function ($row) {
                    return $row->jenisMotor ? $row->jenisMotor->merk : 'N/A';
                })
                ->addColumn('tgl_sewa', function ($row) {
                    return $row->tgl_sewa->format('Y-m-d');
                })
                ->addColumn('tgl_kembali', function ($row) {
                    return $row->tgl_kembali->format('Y-m-d');
                })
                ->addColumn('total', function ($row) {
                    return "Rp. " . number_format($row->total, 0, ',', '.');
                })
                ->rawColumns(['total'])
                ->make(true);
        }
    }
  public function index(Request $request)
  {
    $jenis_motors = JenisMotor::all();
    $transaksi = Transaksi::with('jenis_motor')->select(['id', 'id_jenis', 'nama_penyewa', 'wa1', 'wa2', 'wa3', 'tgl_sewa', 'tgl_kembali', 'status', 'total']);
    return view('admin.index', compact('transaksi', 'jenis_motors'));
  }

  public function transaksi(Request $request)
  {
    $jenis_motors = JenisMotor::all();
    $transaksi = Transaksi::with('jenis_motor')->select(['id', 'id_jenis', 'nama_penyewa', 'wa1', 'wa2', 'wa3', 'tgl_sewa', 'tgl_kembali', 'status', 'total']);
    return view('admin.transaksi.index', compact('transaksi', 'jenis_motors'));
  }
    public function show(Transaksi $transaksi)
    {
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $jenis_motors = JenisMotor::all();
        return view('admin.transaksi.edit', compact('transaksi', 'jenis_motors'));
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
