<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\JenisMotor;
use App\Models\Stok;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            'rentals.*.tgl_sewa' => 'required|date_format:Y-m-d H:i:s',
            'rentals.*.tgl_kembali' => 'required|date_format:Y-m-d H:i:s|after_or_equal:rentals.*.tgl_sewa',
            'rentals.*.id_jenis' => 'required|exists:jenis_motor,id',
            'rentals.*.total' => 'required|numeric',
            'rentals.*.jashujan' => 'required|integer',
            'rentals.*.helm' => 'required|integer',
            'agreement' => 'accepted',
        ]);

        DB::beginTransaction();

        try {
            foreach ($validated['rentals'] as $rental) {
                $tgl_sewa = Carbon::parse($rental['tgl_sewa']);
                $tgl_kembali = Carbon::parse($rental['tgl_kembali']);

                $today = Carbon::today();
                if ($tgl_sewa->gt($today->addDays(2))) {
                    // Add to booking table
                    Booking::create([
                        'nama_penyewa' => $validated['nama_penyewa'],
                        'wa1' => $validated['wa1'],
                        'wa2' => $validated['wa2'],
                        'wa3' => $validated['wa3'],
                        'tgl_sewa' => $tgl_sewa,
                        'tgl_kembali' => $tgl_kembali,
                        'id_jenis' => $rental['id_jenis'],
                        'total' => $rental['total'],
                        'helm' => $rental['helm'],
                        'jashujan' => $rental['jashujan'],
                    ]);


                    $jenis_motor = JenisMotor::find($rental['id_jenis']);
                    if ($jenis_motor) {
                        $jenis_motor->update(['status' => 'ready']);
                    }
                } else {
                    // Add to transaksi table
                    Transaksi::create([
                        'nama_penyewa' => $validated['nama_penyewa'],
                        'wa1' => $validated['wa1'],
                        'wa2' => $validated['wa2'],
                        'wa3' => $validated['wa3'],
                        'tgl_sewa' => $tgl_sewa,
                        'tgl_kembali' => $tgl_kembali,
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
            }

            DB::commit();
            return redirect()->route('rental.preview')->with('success', 'Transactions created successfully.');
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

    public function checkBookingDates(Request $request)
    {
        $tgl_kembali = $request->input('tgl_kembali');
        $tgl_sewa = $request->input('tgl_sewa');
        $id_jenis = $request->input('id_jenis');

        $isBooked = Booking::where('id_jenis', $id_jenis)
            ->where(function ($query) use ($tgl_sewa, $tgl_kembali) {
                $query->whereBetween('tgl_sewa', [$tgl_sewa, $tgl_kembali])
                    ->orWhereBetween('tgl_kembali', [$tgl_sewa, $tgl_kembali])
                    ->orWhere(function ($q) use ($tgl_sewa, $tgl_kembali) {
                        $q->where('tgl_sewa', '<=', $tgl_sewa)
                        ->where('tgl_kembali', '>=', $tgl_kembali);
                    });
            })
            ->exists();
            $response = ['isBooked' => $isBooked];

        return response()->json($response);
    }


    public function preview()
    {
        $transaksi = Transaksi::with('jenisMotor.stok')->get();
        $booking = Booking::with('jenisMotor.stok')->get();
        return view('rental.preview', compact('transaksi', 'booking'));
    }
}
