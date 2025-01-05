<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\JenisMotor;
use App\Models\Stok;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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
                    ->toArray();

                return $jenis_motor;
            });

        return response()->json(['jenis_motors' => $jenis_motors]);
    }

    public function create()
    {
        $jenis_motor = JenisMotor::all();
        return response()->json(['jenis_motor' => $jenis_motor]);
    }
        
    public function store(Request $request)
    {
        $messages = [
            'nama_penyewa.required' => 'Nama penyewa harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'wa1.required' => 'Nomor WA 1 harus diisi.',
            'wa2.required' => 'Nomor WA 2 harus diisi.',
            'wa3.required' => 'Nomor WA 3 harus diisi.',
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
            'device_token.required' => 'Device token harus ada',
        ];

        try {
            $validated = $request->validate([
                'nama_penyewa' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
                'wa1' => 'required|string|max:20',
                'wa2' => 'required|string|max:20',
                'wa3' => 'required|string|max:20',
                'device_token' => 'required|string',
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

            $today = Carbon::today();
            $createdTransactions = [];

            foreach ($validated['rentals'] as $rental) {
                $tgl_sewa = Carbon::parse($rental['tgl_sewa']);
                $tgl_kembali = Carbon::parse($rental['tgl_kembali']);
                $id_jenis = $rental['id_jenis'];
                $jenis_motor = JenisMotor::find($id_jenis);

                $isBooking = $tgl_sewa->gt($today->copy()->addDays(2));

                $rentalData = [
                    'nama_penyewa' => $validated['nama_penyewa'],
                    'alamat' => $validated['alamat'],
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
                    $transaction = Booking::create($rentalData);
                } else {
                    $transaction = Transaksi::create($rentalData);
                    if ($jenis_motor) {
                        $jenis_motor->update(['status' => 'disewa']);
                    }
                }

                // Prepare notification data
                $notificationData = [
                    'token' => $validated['device_token'],
                    'title' => $isBooking ? 'Booking Baru' : 'Transaksi Sewa Baru',
                    'body' => "Penyewaan {$jenis_motor->nama} oleh {$validated['nama_penyewa']} untuk tanggal " . 
                            $tgl_sewa->format('d/m/Y') . " sampai " . $tgl_kembali->format('d/m/Y'),
                    'transaction_id' => (string)$transaction->id,
                    'motor_type' => $jenis_motor->nama
                ];

                // Send notification
                Http::post(route('api.send-notification'), $notificationData);

                $createdTransactions[] = [
                    'id' => $transaction->id,
                    'type' => $isBooking ? 'booking' : 'rental'
                ];
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil dibuat',
                'data' => $createdTransactions
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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
}
