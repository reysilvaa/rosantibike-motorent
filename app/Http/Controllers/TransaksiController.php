<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\JenisMotor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        // Get IDs of jenis_motor that are currently rented
        $rentedMotorIds = Transaksi::where('status', 'disewa')
                                   ->pluck('id_jenis'); // Adjust the field name as needed

        // Fetch all jenis_motor that are not rented
        $jenis_motors = JenisMotor::whereNotIn('id', $rentedMotorIds)->get();

        // Fetch all transactions and eager load jenis_motor
        $transaksis = Transaksi::with('jenisMotor')->get();

        // Pass both the filtered jenis_motor and transactions to the view
        return view('rental.index', compact('transaksis', 'jenis_motors'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'wa1' => 'required|string|max:15',
            'wa2' => 'nullable|string|max:15',
            'wa3' => 'nullable|string|max:15',
            'rentals' => 'required|array|min:1',
            'rentals.*.tgl_sewa' => 'required|date',
            'rentals.*.tgl_kembali' => 'required|date|after_or_equal:rentals.*.tgl_sewa',
            'rentals.*.id_jenis' => 'required|exists:jenis_motor,id',
            'rentals.*.total' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            foreach ($validatedData['rentals'] as $rental) {
                Transaksi::create([
                    'id_user' => 1,
                    'nama_penyewa' => $validatedData['nama_penyewa'],
                    'wa1' => $validatedData['wa1'],
                    'wa2' => $validatedData['wa2'],
                    'wa3' => $validatedData['wa3'],
                    'tgl_sewa' => $rental['tgl_sewa'],
                    'tgl_kembali' => $rental['tgl_kembali'],
                    'id_jenis' => $rental['id_jenis'],
                    'total' => $rental['total'],
                    'status' => 'disewa',
                ]);
            }

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
