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
    $jenis_motors = JenisMotor::select('jenis_motor.id_stok', DB::raw('MIN(jenis_motor.id) as id'))
        ->join('stok', 'jenis_motor.id_stok', '=', 'stok.id')
        ->groupBy('jenis_motor.id_stok')
        ->orderBy('stok.harga_perHari', 'asc')
        ->get()
        ->map(function ($item) {
            $jenis_motor = JenisMotor::find($item->id);

            $available_stock = JenisMotor::where('id_stok', $jenis_motor->id_stok)
                ->where('status', 'ready')
                ->count();

            $jenis_motor->available_stock = $available_stock;
            $jenis_motor->total_stock = JenisMotor::where('id_stok', $jenis_motor->id_stok)->count();

            $jenis_motor->all_ids = JenisMotor::where('id_stok', $jenis_motor->id_stok)
                ->pluck('id')
                ->toJson();

            return $jenis_motor;
        });

    return view('rental.index', compact('jenis_motors'));
}
    // public function find(Request $request)
    // {
    //     // Select the first 'ready' motor for each 'id_stok' group
    //     $jenis_motors = JenisMotor::where('status', 'ready')
    //         ->select('id_stok', DB::raw('MIN(id) as id'))
    //         ->groupBy('id_stok')
    //         ->get()
    //         ->map(function ($item) {
    //             // Attempt to get an available jenis_motor
    //             $jenis_motor = $this->getAvailableJenisMotor($item->id);

    //             if (!$jenis_motor) {
    //                 // If no available jenis_motor found, set properties to indicate this
    //                 $jenis_motor = new JenisMotor();
    //                 $jenis_motor->id = $item->id;
    //                 $jenis_motor->available_stock = 0;
    //                 $jenis_motor->total_stock = 0;
    //                 $jenis_motor->all_ids = json_encode([]);
    //                 return $jenis_motor;
    //             }

    //             // Calculate the available stock
    //             $available_stock = JenisMotor::where('id_stok', $jenis_motor->id_stok)
    //                 ->where('status', 'ready')
    //                 ->count();

    //             $total_stock = JenisMotor::where('id_stok', $jenis_motor->id_stok)->count();

    //             $all_ids = JenisMotor::where('id_stok', $jenis_motor->id_stok)
    //                 ->pluck('id')
    //                 ->toJson();

    //             $jenis_motor->available_stock = $available_stock;
    //             $jenis_motor->total_stock = $total_stock;
    //             $jenis_motor->all_ids = $all_ids;

    //             return $jenis_motor->get();
    //         });

    //     return view('rental.index', compact('jenis_motors'));
    // }

    // private function getAvailableJenisMotor($id_jenis)
    // {
    //     $jenis_motor = JenisMotor::find($id_jenis);

    //     if (!$jenis_motor) {
    //         return null;
    //     }

    //     // Get the id_stok for the given id_jenis
    //     $id_stok = $jenis_motor->id_stok;

    //     // Check if the current jenis_motor is booked or rented
    //     if ($this->checkMotorAvailability($id_jenis, Carbon::today(), Carbon::today()->addDays(7))) {
    //         return $jenis_motor;
    //     }

    //     // Find another available jenis_motor with the same id_stok
    //     return JenisMotor::where('id_stok', $id_stok)
    //         ->where('status', 'ready')
    //         ->where('id', '!=', $id_jenis)
    //         ->first();
    // }



    public function create()
    {
        $jenis_motor = JenisMotor::all();
        return view('rental.index', compact('jenis_motor'));
    }

    public function store(Request $request)
    {
        $messages = [
            'nama_penyewa.required' => 'Nama penyewa harus diisi.',
            'wa1.required' => 'Nomor WA 1 harus diisi.',
            'rentals.required' => 'Data rental harus diisi.',
            'rentals.*.tgl_sewa.required' => 'Tanggal sewa harus diisi.',
            'rentals.*.tgl_kembali.required' => 'Tanggal kembali harus diisi.',
            'rentals.*.tgl_kembali.after_or_equal' => 'Tanggal kembali harus sama atau setelah tanggal sewa.',
            'rentals.*.id_jenis.required' => 'Jenis motor harus dipilih.',
            'rentals.*.id_jenis.exists' => 'Jenis motor yang dipilih tidak valid.',
            'rentals.*.total.required' => 'Total harus diisi.',
            'rentals.*.jashujan.required' => 'Jumlah jas hujan harus diisi.',
            'rentals.*.helm.required' => 'Jumlah helm harus diisi.',
            'agreement.accepted' => 'Persetujuan harus diterima.',
        ];

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
            'agreement' => 'accepted',
        ], $messages);

        DB::beginTransaction();

        try {
            $today = Carbon::today();

            foreach ($validated['rentals'] as $rental) {
                $tgl_sewa = Carbon::parse($rental['tgl_sewa']);
                $tgl_kembali = Carbon::parse($rental['tgl_kembali']);
                $id_jenis = $rental['id_jenis'];

                // Cek ketersediaan motor
                // if (!$this->checkMotorAvailability($id_jenis, $tgl_sewa, $tgl_kembali)) {
                //     return back()->with('error', 'Motor dengan ID ' . $id_jenis . ' tidak tersedia untuk periode sewa yang dipilih.');
                // }

                $isBooking = $tgl_sewa->gt($today->copy()->addDays(1));

                $rentalData = [
                    'nama_penyewa' => $validated['nama_penyewa'],
                    'wa1' => $validated['wa1'],
                    'wa2' => $validated['wa2'],
                    'wa3' => $validated['wa3'],
                    'tgl_sewa' => $tgl_sewa,
                    'tgl_kembali' => $tgl_kembali,
                    'id_jenis' => $id_jenis,
                    'total' => $rental['total'],
                    'helm' => $rental['helm'],
                    'jashujan' => $rental['jashujan'],
                ];

                if ($isBooking) {
                    Booking::create($rentalData);
                } else {
                    Transaksi::create($rentalData);
                    $jenis_motor = JenisMotor::find($id_jenis);
                    if ($jenis_motor) {
                        $jenis_motor->update(['status' => 'disewa']);
                    }
                }
            }

            DB::commit();
            return redirect()->route('rental.preview')->with('success', 'Transaksi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membuat transaksi: ' . $e->getMessage());
        }
    }

    private function checkMotorAvailability($id_jenis, $tgl_sewa, $tgl_kembali)
    {
        $jenis_motor = JenisMotor::find($id_jenis);
        if (!$jenis_motor) {
            return false;
        }

        $tgl_sewa_start = Carbon::parse($tgl_sewa)->startOfDay();
        $tgl_kembali_end = Carbon::parse($tgl_kembali)->endOfDay();

        $isBooked = Booking::where('id_jenis', $id_jenis)
            ->where(function ($query) use ($tgl_sewa_start, $tgl_kembali_end) {
                $query->where(function ($q) use ($tgl_sewa_start, $tgl_kembali_end) {
                    $q->where('tgl_sewa', '<=', $tgl_kembali_end)
                    ->where('tgl_kembali', '>=', $tgl_sewa_start);
                });
            })
            ->exists();

        $isRented = Transaksi::where('id_jenis', $id_jenis)
            ->where(function ($query) use ($tgl_sewa_start, $tgl_kembali_end) {
                $query->where(function ($q) use ($tgl_sewa_start, $tgl_kembali_end) {
                    $q->where('tgl_sewa', '<=', $tgl_kembali_end)
                    ->where('tgl_kembali', '>=', $tgl_sewa_start);
                });
            })
            ->exists();

        return !$isBooked && !$isRented && $jenis_motor->status === 'ready';
    }


    public function getAvailableStock(Request $request)
    {
        $jenisMotorId = $request->input('id_jenis');
        $tgl_sewa = $request->input('tgl_sewa');
        $tgl_kembali = $request->input('tgl_kembali');

        $jenis_motor = JenisMotor::find($jenisMotorId);
        if (!$jenis_motor) {
            return response()->json(['available_stock' => 0]);
        }

        $relatedJenisMotorIds = JenisMotor::where('id_stok', $jenis_motor->id_stok)->pluck('id');

        $availableStock = $relatedJenisMotorIds->filter(function ($id) use ($tgl_sewa, $tgl_kembali) {
            return $this->checkMotorAvailability($id, $tgl_sewa, $tgl_kembali);
        })->count();

        return response()->json(['available_stock' => $availableStock]);
    }


    public function checkBookingDates(Request $request)
    {
        $tgl_kembali = $request->input('tgl_kembali');
        $tgl_sewa = $request->input('tgl_sewa');
        $id_jenis = $request->input('id_jenis');

        $jenis_motor = JenisMotor::find($id_jenis);
        if (!$jenis_motor) {
            return response()->json(['isBooked' => true]);
        }

        $relatedJenisMotorIds = JenisMotor::where('id_stok', $jenis_motor->id_stok)->pluck('id');

        $availableMotor = $relatedJenisMotorIds->first(function ($id) use ($tgl_sewa, $tgl_kembali) {
            return $this->checkMotorAvailability($id, $tgl_sewa, $tgl_kembali);
        });

        return response()->json(['isBooked' => is_null($availableMotor)]);
    }
    public function show(Transaksi $transaksi)
    {
        $transaksi->load('jenisMotor.stok');
        return view('transaksi.show', compact('transaksi'));
    }

    public function preview()
    {
        $transaksi = Transaksi::with('jenisMotor.stok')->get();
        $booking = Booking::with('jenisMotor.stok')->get();
        return view('rental.preview', compact('transaksi', 'booking'));
    }
}
