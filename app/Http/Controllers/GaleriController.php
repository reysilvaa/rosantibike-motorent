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

        $validated = $request->validate([
            'judul' => 'required|string|max:20',
            'deskripsi' => 'required|string|max:30',
            'full_description' => 'required',
            'foto' => 'required|string',
            'kategori' => 'required|in:alam,sejarah,kuliner,budaya',
            'link_maps' => 'required|string',
        ], $messages);

        Galeri::create([
            'id_user' => Auth::user()->id,
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'full_description' => $validated['full_description'],
            'foto' => $validated['foto'],
            'kategori' => $validated['kategori'],
            'link_maps' => $validated['link_maps'],
        ]);

        // Using success preset
        notify()->preset('success', ['title' => 'Sukses', 'message' => 'Galeri berhasil dibuat']);

        return redirect()->route('admin.galeri.index');
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

        $rules = [
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'full_description' => 'required',
            'foto' => 'required|string',
            'kategori' => 'required|in:alam,sejarah,kuliner,budaya',
            'link_maps' => 'required|string',
        ];

        $validated = $request->validate($rules, $messages);

        $galeri->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'full_description' => $validated['full_description'],
            'foto' => $validated['foto'],
            'kategori' => $validated['kategori'],
            'link_maps' => $validated['link_maps'],
        ]);

        // Using success preset
        notify()->preset('success', ['title' => 'Sukses', 'message' => 'Galeri berhasil diperbarui']);

        return redirect()->route('admin.galeri.index');
    }

    public function destroy(Galeri $galeri)
    {
        $galeri->delete();

        // Using error preset
        notify()->preset('error', ['title' => 'Hapus Galeri', 'message' => 'Galeri berhasil dihapus']);

        return redirect()->route('admin.galeri.index');
    }
}
