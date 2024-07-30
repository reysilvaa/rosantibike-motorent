<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\JenisMotor;
use App\Models\Stok;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $jenis_motors = JenisMotor::select('id_stok', DB::raw('MIN(id) as id'))
            ->groupBy('id_stok')
            ->get()
            ->map(function ($item) {
                $jenis_motor = JenisMotor::find($item->id);

                $available_stock = JenisMotor::where('id_stok', $jenis_motor->id_stok)
                    ->where('status', 'ready')
                    ->count();

                $jenis_motor->available_stock = $available_stock;
                $jenis_motor->total_stock = JenisMotor::where('id_stok', $jenis_motor->id_stok)->count();

                // Get all id_jenis for this id_stok
                $jenis_motor->all_ids = JenisMotor::where('id_stok', $jenis_motor->id_stok)
                    ->pluck('id')
                    ->toJson();

                return $jenis_motor;
            });

        return view('rental.index', compact('jenis_motors'));
    }

    public function create()
    {
        $jenis_motor = JenisMotor::all();
        return view('rental.index', compact('jenis_motor'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'wa1' => 'required|string|max:20',
            'wa2' => 'nullable|string|max:20',
            'wa3' => 'nullable|string|max:20',
            'rentals' => 'required|array',
            'rentals.*.tgl_sewa' => 'required|date',
            'rentals.*.tgl_kembali' => 'required|date|after_or_equal:rentals.*.tgl_sewa',
            'rentals.*.id_jenis' => 'required|exists:jenis_motor,id',
            'rentals.*.total' => 'required|numeric',
            'rentals.*.jashujan' => 'required|integer',
            'rentals.*.helm' => 'required|integer',
        ]);

        DB::beginTransaction();

        try {
            foreach ($validated['rentals'] as $rental) {
                $transaksi = Transaksi::create([
                    'nama_penyewa' => $validated['nama_penyewa'],
                    'wa1' => $validated['wa1'],
                    'wa2' => $validated['wa2'],
                    'wa3' => $validated['wa3'],
                    'tgl_sewa' => $rental['tgl_sewa'],
                    'tgl_kembali' => $rental['tgl_kembali'],
                    'id_jenis' => $rental['id_jenis'],
                    'total' => $rental['total'],
                    'helm' => $rental['helm'],
                    'jashujan' => $rental['jashujan'],
                ]);

                $jenis_motor = JenisMotor::find($rental['id_jenis']);
                if ($jenis_motor) {
                    $jenis_motor->update(['status' => 'disewa']);
                }
            }

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transactions created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while creating the transactions: ' . $e->getMessage());
        }
    }
    public function show(Transaksi $transaksi)
    {
        $transaksi->load('jenisMotor.stok');
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $jenisMotor = JenisMotor::all(); // Get all jenis_motor for the dropdown
        return view('transaksi.edit', compact('transaksi', 'jenisMotor'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'id_jenis' => 'required|exists:jenis_motor,id',
            'nama_penyewa' => 'required|string|max:255',
            'wa1' => 'required|string|max:15',
            'wa2' => 'nullable|string|max:15',
            'wa3' => 'nullable|string|max:15',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_sewa',
            'total' => 'required|numeric',
            'helm' => 'required|integer',
            'jashujan' => 'required|integer',
        ]);

        $transaksi->update($request->all());
        return redirect()->route('transaksi.index')->with('success', 'Transaction updated successfully.');
    }

    public function getAvailableStock(Request $request)
    {
        $jenisMotorId = $request->input('id_jenis');
        $availableStock = JenisMotor::where('id', $jenisMotorId)
            ->whereHas('stok', function($query) {
                $query->where('status', 'ready');
            })
            ->count();

        return response()->json(['available_stock' => $availableStock]);
    }

}
