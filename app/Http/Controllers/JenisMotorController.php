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
        $jenisMotors = JenisMotor::with('stok')->get();
        $stoks = Stok::all(); // Retrieve all stok records


        return view('admin.unit.create', compact('jenisMotors', 'stoks'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'nopol' => 'required|string|max:255',
            'id_stok' => 'required|exists:stok,id', // Ensure id_stok exists in stok table
        ]);

        // Prepare the data for creation
        $data = $request->only(['nopol', 'id_stok']);
        $data['status'] = 'ready'; // Set the status to 'ready'

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
        $stoks = Stok::all(); // Retrieve all stok records

        return view('admin.unit.edit', compact('jenisMotor', 'stoks'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request inputs
        $request->validate([
            'nopol' => 'required|string|max:255',
            'id_stok' => 'required|exists:stok,id', // Ensure id_stok exists in stok table
        ]);

        // Find the JenisMotor record
        $jenisMotor = JenisMotor::findOrFail($id);

        // Update the JenisMotor record
        $jenisMotor->update($request->only(['nopol', 'id_stok']));

        return redirect()->route('admin.jenisMotor.index')
                        ->with('success', 'Jenis Motor updated successfully.');
    }


    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $jenisMotor = JenisMotor::findOrFail($id);

        // Increment the stok value
        $stok = $jenisMotor->stok;
        $stok->stok += 1;
        $stok->save();

        // Delete the JenisMotor record
        $jenisMotor->delete();

        // Redirect to the index page with a success message
        return redirect()->route('admin.jenisMotor.index')
                         ->with('success', 'Jenis Motor deleted successfully, and stok incremented by 1.');
    }

}
