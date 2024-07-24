<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\JenisMotor;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('jenisMotor')->get();
        $jenis_motors = JenisMotor::all();
        return view('rental.index', compact('transaksis', 'jenis_motors'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'wa1' => 'required|string|max:15',
            'wa2' => 'nullable|string|max:15',
            'wa3' => 'nullable|string|max:15',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_sewa',
            'id_jenis' => 'required|exists:jenis_motor,id',
            'total' => 'required|numeric',
        ]);
        // $jenis_motor = JenisMotor::find($request->id_jenis);
        // $validatedData['total'] = $jenis_motor->calculateHarga($request->tgl_sewa, $request->tgl_kembali);

        Transaksi::createTransaction($validatedData);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
    }


}
