<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\JenisMotor;
use App\Models\Stok;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Uploader;
use App\Http\Controllers\Controller;
\
class JenisMotorController extends Controller
{
    // Display a listing of the resource.
    public function index(Request $request)
    {
        $lastUpdated = $request->query('last_updated', null);

        $jenisMotors = JenisMotor::with('stok')->get();

        $count = $jenisMotors->count();
        return response()->json([
            'data' => $jenisMotors,
            'count' => $count,
            'timestamps' => $lastUpdated,
        ]);
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $jenisMotors = JenisMotor::with('stok')->distinct('id_stok')->get();
        $stoks = Stok::all();
        return response()->json([
            'jenisMotors' => $jenisMotors,
            'stoks' => $stoks
        ]);
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $messages = [
            'nopol.required' => 'Nomor Polisi wajib diisi.',
            'nopol.string' => 'Nomor Polisi harus berupa teks.',
            'nopol.max' => 'Nomor polisi maksimal 9 karakter.',
            'id_stok.required' => 'Pilihan Merk Motor wajib diisi.',
            'id_stok.exists' => 'Pilihan Merk Motor tidak valid.',
        ];

        $validated = $request->validate([
            'nopol' => 'required|string|max:10',
            'id_stok' => 'required|exists:stok,id',
        ], $messages);

        $data = $validated;
        $data['status'] = 'ready'; // Set the status to 'ready'

        // Jika ada foto yang diupload
        if ($request->hasFile('foto')) {
            // Upload ke Cloudinary di folder rosantibike/motors/
            $file = $request->file('foto');
            $uploadedFile = Uploader::upload($file->getRealPath(), [
                'folder' => 'rosantibike/motors/',
            ]);

            // Simpan URL foto yang diupload ke Cloudinary
            $data['foto'] = $uploadedFile['secure_url'];
        }

        $jenisMotor = JenisMotor::create($data);

        return response()->json([
            'message' => 'Jenis Motor berhasil dibuat',
            'data' => $jenisMotor
        ], 201);
    }

    // Display the specified resource.
    public function show($id)
    {
        $jenisMotor = JenisMotor::findOrFail($id);
        return response()->json([
            'data' => $jenisMotor
        ]);
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $stoks = Stok::all();
        $jenisMotor = JenisMotor::with('stok')->findOrFail($id);
        return response()->json([
            'jenisMotor' => $jenisMotor,
            'stoks' => $stoks
        ]);
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $messages = [
            'nopol.required' => 'Nomor Polisi wajib diisi.',
            'nopol.string' => 'Nomor Polisi harus berupa teks.',
            'nopol.max' => 'Nomor polisi maksimal 9 karakter.',
            'id_stok.required' => 'Pilihan Merk Motor wajib diisi.',
            'id_stok.exists' => 'Pilihan Merk Motor tidak valid.',
        ];

        $validated = $request->validate([
            'nopol' => 'required|string|max:255',
            'id_stok' => 'required|exists:stok,id',
        ], $messages);

        $data = $validated;

        // Jika ada foto baru yang diupload
        if ($request->hasFile('foto')) {
            // Upload foto ke Cloudinary
            $file = $request->file('foto');
            $uploadedFile = Uploader::upload($file->getRealPath(), [
                'folder' => 'rosantibike/motors/',
            ]);

            // Simpan URL foto baru
            $data['foto'] = $uploadedFile['secure_url'];
        }

        $jenisMotor = JenisMotor::findOrFail($id);
        $jenisMotor->update($data);

        return response()->json([
            'message' => 'Jenis Motor berhasil diperbarui',
            'data' => $jenisMotor
        ]);
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $jenisMotor = JenisMotor::findOrFail($id);
        $jenisMotor->delete();

        return response()->json([
            'message' => 'Jenis Motor berhasil dihapus'
        ]);
    }
}
