<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::all();
        return view('admin.landing.galeri.index', compact('galeris'));
    }

    public function create()
    {
        return view('admin.landing.galeri.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'judul.required' => 'Judul wajib diisi.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.max' => 'Judul maksimal 20 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 30 karakter.',
            'full_description.required' => 'Deskripsi lengkap wajib diisi.',
            'foto.required' => 'Foto wajib diisi.',
            'foto.string' => 'Foto harus berupa teks.',
            'kategori.required' => 'Kategori wajib diisi.',
            'kategori.in' => 'Kategori harus salah satu dari: alam, sejarah, kuliner, budaya.',
            'link_maps.required' => 'Link Maps wajib diisi.',
            'link_maps.string' => 'Link Maps harus berupa teks.',
        ];

        $request->validate([
            'judul' => 'required|string|max:20',
            'deskripsi' => 'required|string|max:30',
            'full_description' => 'required',
            'foto' => 'required|string',
            'kategori' => 'required|in:alam,sejarah,kuliner,budaya',
            'link_maps' => 'required|string',
        ], $messages);

        Galeri::create([
            'id_user' => Auth::user()->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'full_description' => $request->full_description,
            'foto' => $request->foto,
            'kategori' => $request->kategori,
            'link_maps' => $request->link_maps,
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil dibuat.');
    }

    public function show(Galeri $galeri)
    {
        return view('admin.landing.galeri.show', compact('galeri'));
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.landing.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $messages = [
            'judul.required' => 'Judul wajib diisi.',
            'judul.string' => 'Judul harus berupa teks.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'full_description.required' => 'Deskripsi lengkap wajib diisi.',
            'foto.required' => 'Foto wajib diisi.',
            'foto.string' => 'Foto harus berupa teks.',
            'kategori.required' => 'Kategori wajib diisi.',
            'kategori.in' => 'Kategori harus salah satu dari: alam, sejarah, kuliner, budaya.',
            'link_maps.required' => 'Link Maps wajib diisi.',
            'link_maps.string' => 'Link Maps harus berupa teks.',
        ];

        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'full_description' => 'required',
            'foto' => 'required|string',
            'kategori' => 'required|in:alam,sejarah,kuliner,budaya',
            'link_maps' => 'required|string',
        ], $messages);

        $galeri->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'full_description' => $request->full_description,
            'foto' => $request->foto,
            'kategori' => $request->kategori,
            'link_maps' => $request->link_maps,
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Galeri deleted successfully.');
    }
}
