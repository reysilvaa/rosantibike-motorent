<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisMotor;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Storage;

class JenisMotorController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $jenisMotors = JenisMotor::all();
        return view('admin.unit.index', compact('jenisMotors'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('admin.unit.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'merk' => 'required|string|max:255',
            'nopol' => 'required|string|max:255',
            'harga_perHari' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional, for file uploads
            'foto_url' => 'nullable|url', // Optional, for URL
        ]);

        // Prepare the data for creation
        $data = $request->only(['merk', 'nopol', 'harga_perHari']);

        if ($request->filled('foto_url')) {
            // If a URL is provided, store the URL in the foto column
            $data['foto'] = $request->input('foto_url');
        } elseif ($request->hasFile('foto')) {
            // If a file is uploaded, handle it
            $fotoPath = $request->file('foto')->store('photos', 'public');
            $data['foto'] = $fotoPath;
        }

        // Create a new JenisMotor record
        JenisMotor::create($data);

        return redirect()->route('admin.jenisMotor.index')
                         ->with('success', 'Jenis Motor created successfully.');
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
        $jenisMotor = JenisMotor::findOrFail($id);
        return view('admin.unit.edit', compact('jenisMotor'));
    }

    public function update(Request $request, $id)

    {
        // Validate the request inputs
        $request->validate([
            'merk' => 'required|string|max:255',
            'nopol' => 'required|string|max:255',
            'harga_perHari' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_url' => 'nullable|url',
        ]);

        // Find the existing record
        $jenisMotor = JenisMotor::findOrFail($id);

        // Prepare the data to update
        $data = $request->only(['merk', 'nopol', 'harga_perHari']);

        if ($request->filled('foto_url')) {
            // If a URL is provided, store the URL in the foto column
            $data['foto'] = $request->input('foto_url');
            // Optionally delete the old photo file
            if ($jenisMotor->foto && Storage::exists('public/' . $jenisMotor->foto)) {
                Storage::delete('public/' . $jenisMotor->foto);
            }
        } elseif ($request->hasFile('foto')) {
            // If a file is uploaded, handle it
            if ($jenisMotor->foto && Storage::exists('public/' . $jenisMotor->foto)) {
                Storage::delete('public/' . $jenisMotor->foto);
            }
            $fotoPath = $request->file('foto')->store('photos', 'public');
            $data['foto'] = $fotoPath;
        } else {
            // If no new photo is provided, keep the existing one
            $data['foto'] = $jenisMotor->foto;
        }

        // Update the record
        $jenisMotor->update($data);

        return redirect()->route('admin.jenisMotor.index')
                        ->with('success', 'Jenis Motor updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $jenisMotor = JenisMotor::findOrFail($id);

        // Delete the record
        $jenisMotor->delete();

        // Redirect to the index page with a success message
        return redirect()->route('admin.jenisMotor.index')
                         ->with('success', 'Jenis Motor deleted successfully.');
    }
}
