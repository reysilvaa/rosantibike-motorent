<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisMotor;
use App\Models\Stok;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Storage;

class JenisMotorController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $jenisMotors = JenisMotor::with('stok')->get();
        $stoks = Stok::all(); // Retrieve all stok records
        return view('admin.unit.index', compact('jenisMotors', 'stoks'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $jenisMotors = JenisMotor::with('stok')->distinct('id_stok')->get();
        $stoks = Stok::all(); // Retrieve all stok records
        return view('admin.unit.create', compact('jenisMotors', 'stoks'));
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

        // Validate the request inputs with custom messages
        $validated = $request->validate([
            'nopol' => 'required|string|max:10',
            'id_stok' => 'required|exists:stok,id',
        ], $messages);

        // Prepare the data for creation
        $data = $validated;
        $data['status'] = 'ready'; // Set the status to 'ready'

        // Create a new JenisMotor record
        JenisMotor::create($data);

        // Using success preset
        notify()->preset('success', ['title' => 'Sukses', 'message' => 'Jenis Motor berhasil dibuat']);

        return redirect()->route('admin.jenisMotor.index');
    }

    // Display the specified resource.
    public function show($id)
    {
        $jenisMotor = JenisMotor::findOrFail($id);
        return view('admin.unit.show', compact('jenisMotor'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $stoks = Stok::all();
        $jenisMotor = JenisMotor::with('stok')->findOrFail($id);
        return view('admin.unit.edit', compact('jenisMotor', 'stoks'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'nopol.required' => 'Nomor Polisi wajib diisi.',
            'nopol.string' => 'Nomor Polisi harus berupa teks.',
            'nopol.max' => 'Nomor polisi maksimal 9 karakter.',
            'id_stok.required' => 'Pilihan Merk Motor wajib diisi.',
            'id_stok.exists' => 'Pilihan Merk Motor tidak valid.',
        ];

        // Validate the request inputs with custom messages
        $validated = $request->validate([
            'nopol' => 'required|string|max:255',
            'id_stok' => 'required|exists:stok,id',
        ], $messages);

        // Find the JenisMotor record
        $jenisMotor = JenisMotor::findOrFail($id);

        // Update the JenisMotor record
        $jenisMotor->update($validated);

        // Using success preset
        notify()->preset('success', ['title' => 'Sukses', 'message' => 'Jenis Motor berhasil diperbarui']);

        return redirect()->route('admin.jenisMotor.index');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $jenisMotor = JenisMotor::findOrFail($id);

        // Delete the JenisMotor record
        $jenisMotor->delete();

        // Using success preset
        notify()->preset('error', ['title' => 'Sukses', 'message' => 'Jenis Motor berhasil dihapus']);

        return redirect()->route('admin.jenisMotor.index');
    }
}
