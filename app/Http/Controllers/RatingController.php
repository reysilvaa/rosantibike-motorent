<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    // Display a listing of the rating.
    public function index()
    {
        $ratings = Rating::all();
        return view('admin.rating.index', compact('ratings'));
    }

    // Show the form for creating a new rating.
    public function create()
    {
        return view('admin.rating.create');
    }

    // Store a newly created rating in storage.
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'tanggal' => 'required|date',
        ]);

        Rating::create($request->all());

        return redirect()->route('admin.rating.index')
                         ->with('success', 'Rating created successfully.');
    }

    // // Display the specified rating.
    // public function show($id)
    // {
    //     $rating = Rating::findOrFail($id);
    //     return view('rating.show', compact('rating'));
    // }

    // Show the form for editing the specified rating.
    public function edit($id)
    {
        $rating = Rating::findOrFail($id);
        return view('admin.rating.edit', compact('rating'));
    }

    // Update the specified rating in storage.
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'tanggal' => 'required|date',
        ]);

        $rating = Rating::findOrFail($id);
        $rating->update($request->all());

        return redirect()->route('admin.rating.index')
                         ->with('success', 'Rating updated successfully.');
    }

    // Remove the specified rating from storage.
    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();

        return redirect()->route('admin.rating.index')
                         ->with('success', 'Rating deleted successfully.');
    }
}
