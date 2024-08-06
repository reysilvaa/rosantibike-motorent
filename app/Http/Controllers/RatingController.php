<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::all();
        return view('admin.rating.index', compact('ratings'));
    }

    public function create()
    {
        return view('admin.rating.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 255 karakter.',
            'role.required' => 'Role wajib diisi.',
            'role.string' => 'Role harus berupa teks.',
            'role.max' => 'Role maksimal 255 karakter.',
            'rating.required' => 'Rating wajib diisi.',
            'rating.integer' => 'Rating harus berupa angka.',
            'rating.min' => 'Rating minimal 1.',
            'rating.max' => 'Rating maksimal 5.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus berupa format tanggal yang valid.',
        ];

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'tanggal' => 'required|date',
        ], $messages);

        Rating::create($request->all());

        return redirect()->route('admin.rating.index')
                        ->with('success', 'Rating berhasil dibuat.');
    }


    public function edit($id)
    {
        $rating = Rating::findOrFail($id);
        return view('admin.rating.edit', compact('rating'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'role.required' => 'Role wajib diisi.',
            'role.string' => 'Role harus berupa teks.',
            'role.max' => 'Role maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'rating.required' => 'Rating wajib diisi.',
            'rating.integer' => 'Rating harus berupa angka.',
            'rating.min' => 'Rating minimal 1.',
            'rating.max' => 'Rating maksimal 5.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus berupa format tanggal yang valid.',
        ];

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'tanggal' => 'required|date',
        ], $messages);

        $rating = Rating::find($id);

        if (!$rating) {
            return redirect()->back()->with('error', 'Rating tidak ditemukan.');
        }

        $rating->nama = $request->input('name');
        $rating->role = $request->input('role');
        $rating->deskripsi = $request->input('deskripsi');
        $rating->rating = $request->input('rating');
        $rating->tanggal = $request->input('tanggal');
        $rating->save();

        return redirect()->route('admin.rating.index')->with('success', 'Rating berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();

        return redirect()->route('admin.rating.index')
                         ->with('success', 'Rating deleted successfully.');
    }
}
