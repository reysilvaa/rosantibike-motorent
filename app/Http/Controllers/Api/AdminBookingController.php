<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisMotor;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return response()->json(['message' => 'Welcome to Admin Booking API']);
    }

    public function bookings(Request $request)
    {
        $search = $request->query('search', null);
        $lastUpdated = $request->query('last_updated', null);

        $query = Booking::with(['jenisMotor.stok'])
                        ->leftJoin('jenis_motor', 'booking.id_jenis', '=', 'jenis_motor.id')
                        ->select('booking.*', 'jenis_motor.nopol', 'jenis_motor.status');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('booking.id', 'like', "%$search%")
                  ->orWhere('jenis_motor.nopol', 'like', "%$search%")
                  ->orWhere('booking.nama_penyewa', 'like', "%$search%");
            });
        }

        if ($lastUpdated) {
            $query->where('booking.updated_at', '>=', $lastUpdated);
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return response()->json([]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking list retrieved successfully',
            'data' => $data,
            'count' => $data->count(),
            'timestamps' => now(),
        ]);
    }

    public function show($id)
    {
        $booking = Booking::with(['jenisMotor'])->find($id);

        if ($booking) {
            return response()->json($booking);
        }

        return response()->json(['error' => 'Booking not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tgl_kembali' => 'required|date|after_or_equal:today',
            'id_jenis' => 'required|exists:jenis_motor,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $booking = Booking::findOrFail($id);
        $originalTotal = $booking->total;
        $originalTglKembali = $booking->tgl_kembali;
        $jenisMotorBaru = JenisMotor::findOrFail($request->id_jenis);

        if ($request->tgl_kembali != $originalTglKembali) {
            $jumlahHariPerpanjangan = $originalTglKembali->diffInDays($request->tgl_kembali);
            $totalHargaPerpanjangan = $jumlahHariPerpanjangan * $jenisMotorBaru->harga_perHari;
            $booking->total = $originalTotal + $totalHargaPerpanjangan;
            $booking->tgl_kembali = $request->tgl_kembali;
        }

        if ($booking->id_jenis != $request->id_jenis) {
            $jenisMotorLama = JenisMotor::findOrFail($booking->id_jenis);
            $jenisMotorLama->status = 'ready';
            $jenisMotorLama->save();

            $booking->id_jenis = $request->id_jenis;
        }

        $booking->save();

        return response()->json(['message' => 'Booking updated successfully', 'booking' => $booking]);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $jenisMotor = JenisMotor::find($booking->id_jenis);

        if ($jenisMotor) {
            $jenisMotor->update(['status' => 'ready']);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        Booking::whereIn('id', $ids)->each(function ($booking) {
            $jenisMotor = JenisMotor::find($booking->id_jenis);

            if ($jenisMotor) {
                $jenisMotor->update(['status' => 'ready']);
            }
        });

        Booking::whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Bookings deleted successfully']);
    }
}