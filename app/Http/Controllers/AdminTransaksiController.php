<?php
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
                ->addColumn('action', function($row) {
                    $editBtn = '<a href="' . route('admin.transaksi.edit', $row->id) . '" class="bg-green-600 text-white hover:bg-green-700 rounded px-3 py-2 text-xs flex items-center justify-center"><i class="fa-solid fa-pen"></i></a>';
                    // $deleteBtn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="bg-red-600 text-white hover:bg-red-700 rounded px-3 py-2 text-xs flex items-center justify-center delete"><i class="fa-solid fa-trash"></i></a>';
                    $cetakBtn = '<a href="' . route('transaksi.invoice.preview', $row->id) . '" target="_blank" class="bg-blue-600 text-white hover:bg-blue-700 rounded px-3 py-2 text-xs flex items-center justify-center" title="Preview Invoice"><i class="fa-solid fa-eye"></i></a>';

                    return '<div class="flex space-x-2 justify-center">' . $editBtn . $cetakBtn . '</div>';
                })
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" name="transaksi_checkbox[]" class="transaksi_checkbox custom-checkbox" value="' . $row->id . '" />';
                })
                ->addColumn('tgl_sewa', function($row) {
                    return $row->tgl_sewa->format('d-m-Y');
                })
                ->addColumn('tgl_kembali', function($row) {
                    return $row->tgl_kembali->format('d-m-Y');
                })
                ->addColumn('jenis_motor_merk', function($row) {
                    return $row->jenisMotor->merk ?? ''; // Adjust if your relationship or field names are different
                })
                ->addColumn('total', function($row) {
                    return "Rp. " . number_format($row->total, 0, ',', '.');
                })
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
