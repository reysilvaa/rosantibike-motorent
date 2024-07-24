<?php
//     public function getData(Request $request)
//     {
//         if ($request->ajax()) {
//             $data = Transaksi::with('jenisMotor')->get();
//             return DataTables::of($data)
//                 ->addColumn('jenis_motor', function ($row) {
//                     return $row->jenisMotor ? $row->jenisMotor->merk : 'N/A';
//                 })
//                 ->addColumn('tgl_sewa', function ($row) {
//                     return $row->tgl_sewa->format('Y-m-d');
//                 })
//                 ->addColumn('tgl_kembali', function ($row) {
//                     return $row->tgl_kembali->format('Y-m-d');
//                 })
//                 ->addColumn('total', function ($row) {
//                     return "Rp. " . number_format($row->total, 0, ',', '.');
//                 })
//                 ->rawColumns(['total'])
//                 ->make(true);
//         }
//     }
//   public function index(Request $request)
//   {
//     $jenis_motors = JenisMotor::all();
//     $transaksi = Transaksi::with('jenis_motor')->select(['id', 'id_jenis', 'nama_penyewa', 'wa1', 'wa2', 'wa3', 'tgl_sewa', 'tgl_kembali', 'status', 'total']);
//     return view('admin.index', compact('transaksi', 'jenis_motors'));
//   }

//   public function transaksi(Request $request)
//   {
//     $jenis_motors = JenisMotor::all();
//     $transaksi = Transaksi::with('jenis_motor')->select(['id', 'id_jenis', 'nama_penyewa', 'wa1', 'wa2', 'wa3', 'tgl_sewa', 'tgl_kembali', 'status', 'total']);
//     return view('admin.transaksi.index', compact('transaksi', 'jenis_motors'));
//   }
//     public function show(Transaksi $transaksi)
//     {
//         return view('admin.transaksi.show', compact('transaksi'));
//     }

//     public function edit(Transaksi $transaksi)
//     {
//         $jenis_motors = JenisMotor::all();
//         return view('admin.transaksi.edit', compact('transaksi', 'jenis_motors'));
//     }

//     public function destroy(Transaksi $transaksi)
//     {
//         $transaksi->delete();
//         return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
//     }


namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminTransaksiController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function transaksi()
    {
        return view('admin.transaksi.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaksi::with('jenisMotor')->select('transaksi.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('admin.transaksi.edit', $row->id) . '" class="edit btn btn-success btn-sm">Edit</a> ';
                    $actionBtn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="transaksi_checkbox[]" class="transaksi_checkbox" value="{{$id}}" />')
                ->rawColumns(['action', 'checkbox'])
                ->make(true);
        }
    }

    public function show(Transaksi $transaksi)
    {
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        return view('admin.transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $transaksi->update($request->all());
        return redirect()->route('admin.transaksi.transaksi')->with('success', 'Transaksi updated successfully');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return response()->json(['success'=>'Transaksi deleted successfully.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        Transaksi::whereIn('id', $ids)->delete();
        return response()->json(['success'=>"Transaksi Deleted successfully."]);
    }
}
