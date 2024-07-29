<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisMotor;
use App\Models\Stok;
use Illuminate\Support\Facades\Storage;

class StokController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $stok = Stok::all();
        return view('admin.stok.index', compact('stok'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('admin.stok.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'merk' => 'required|string|max:255',
            'harga_perHari' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional, for file uploads
            'foto_url' => 'nullable|url', // Optional, for URL
        ]);

        // Prepare the data for creation
        $data = $request->only(['merk', 'harga_perHari', 'stok']);

        if ($request->filled('foto_url')) {
            // If a URL is provided, store the URL in the foto column
            $data['foto'] = $request->input('foto_url');
        } elseif ($request->hasFile('foto')) {
            // If a file is uploaded, handle it
            $fotoPath = $request->file('foto')->store('photos', 'public');
            $data['foto'] = $fotoPath;
        }

        // Create a new Stok record
        Stok::create($data);

        return redirect()->route('admin.stok.index')
                         ->with('success', 'Stok created successfully.');
    }

    // Display the specified resource.
    public function show($id)
    {
        $stok = Stok::findOrFail($id);
        return view('admin.stok.show', compact('stok'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $stok = Stok::findOrFail($id);
        return view('admin.stok.edit', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request inputs
        $request->validate([
            'merk' => 'required|string|max:255',
            'harga_perHari' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_url' => 'nullable|url',
        ]);

        // Find the existing record
        $stok = Stok::findOrFail($id);

        // Prepare the data to update
        $data = $request->only(['merk', 'harga_perHari', 'stok']);

        if ($request->filled('foto_url')) {
            // If a URL is provided, store the URL in the foto column
            $data['foto'] = $request->input('foto_url');
            // Optionally delete the old photo file
            if ($stok->foto && Storage::exists('public/' . $stok->foto)) {
                Storage::delete('public/' . $stok->foto);
            }
        } elseif ($request->hasFile('foto')) {
            // If a file is uploaded, handle it
            if ($stok->foto && Storage::exists('public/' . $stok->foto)) {
                Storage::delete('public/' . $stok->foto);
            }
            $fotoPath = $request->file('foto')->store('photos', 'public');
            $data['foto'] = $fotoPath;
        } else {
            // If no new photo is provided, keep the existing one
            $data['foto'] = $stok->foto;
        }

        // Update the record
        $stok->update($data);

        return redirect()->route('admin.stok.index')
                         ->with('success', 'Stok updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $stok = Stok::findOrFail($id);

        // Optionally delete the photo file
        if ($stok->foto && Storage::exists('public/' . $stok->foto)) {
            Storage::delete('public/' . $stok->foto);
        }

        // Delete the record
        $stok->delete();

        // Redirect to the index page with a success message
        return redirect()->route('admin.stok.index')
                         ->with('success', 'Stok deleted successfully.');
    }
}
