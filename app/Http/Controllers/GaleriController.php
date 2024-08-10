<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'deskripsi.max' => 'Deskripsi maksimal 50 karakter.',
            'full_description.required' => 'Deskripsi lengkap wajib diisi.',
            'foto.string' => 'Foto harus berupa URL atau string.',
            'local_foto.image' => 'Foto yang diunggah harus berupa gambar.',
            'local_foto.mimes' => 'Foto harus memiliki format jpeg, png, jpg, atau gif.',
            'local_foto.max' => 'Ukuran foto maksimal adalah 2MB.',
            'kategori.required' => 'Kategori wajib diisi.',
            'kategori.in' => 'Kategori harus salah satu dari: alam, sejarah, kuliner, budaya.',
            'link_maps.required' => 'Link Maps wajib diisi.',
            'link_maps.string' => 'Link Maps harus berupa teks.',
        ];

        $validated = $request->validate([
            'judul' => 'required|string|max:20',
            'deskripsi' => 'required|string|max:50',
            'full_description' => 'required',
            'foto' => 'nullable|string',
            'local_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar lokal
            'kategori' => 'required|in:alam,sejarah,kuliner,budaya',
            'link_maps' => 'required|string',
        ], $messages);

        // Handle the local file upload
        if ($request->hasFile('local_foto')) {
            $file = $request->file('local_foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('public/galeri', $filename); // Simpan file di direktori 'public/galeri'
            $validated['foto'] = Storage::url($path); // Simpan URL dari file yang diunggah ke kolom 'foto'
        }

        Galeri::create([
            'id_user' => Auth::user()->id,
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'full_description' => $validated['full_description'],
            'foto' => $validated['foto'],
            'kategori' => $validated['kategori'],
            'link_maps' => $validated['link_maps'],
        ]);

        // Menggunakan preset success
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
            'foto.string' => 'Foto harus berupa URL atau string.',
            'local_foto.image' => 'Foto yang diunggah harus berupa gambar.',
            'local_foto.mimes' => 'Foto harus memiliki format jpeg, png, jpg, atau gif.',
            'local_foto.max' => 'Ukuran foto maksimal adalah 2MB.',
            'kategori.required' => 'Kategori wajib diisi.',
            'kategori.in' => 'Kategori harus salah satu dari: alam, sejarah, kuliner, budaya.',
            'link_maps.required' => 'Link Maps wajib diisi.',
            'link_maps.string' => 'Link Maps harus berupa teks.',
        ];

        $rules = [
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'full_description' => 'required',
            'foto' => 'nullable|string',
            'local_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori' => 'required|in:alam,sejarah,kuliner,budaya',
            'link_maps' => 'required|string',
        ];

        $validated = $request->validate($rules, $messages);

        // Handle the local file upload
        if ($request->hasFile('local_foto')) {
            // Delete the old image if a new one is uploaded
            if ($galeri->foto && Storage::exists('public/galeri/'.basename($galeri->foto))) {
                Storage::delete('public/galeri/'.basename($galeri->foto));
            }

            $file = $request->file('local_foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('public/galeri', $filename);
            $validated['foto'] = Storage::url($path);
        }

        $galeri->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'full_description' => $validated['full_description'],
            'foto' => $validated['foto'],
            'kategori' => $validated['kategori'],
            'link_maps' => $validated['link_maps'],
        ]);

        // Menggunakan preset success
        notify()->preset('success', ['title' => 'Sukses', 'message' => 'Galeri berhasil diperbarui']);

        return redirect()->route('admin.galeri.index');
    }

    public function destroy(Galeri $galeri)
    {
        // Delete the image file from storage
        if ($galeri->foto && Storage::exists('public/galeri/'.basename($galeri->foto))) {
            Storage::delete('public/galeri/'.basename($galeri->foto));
        }

        $galeri->delete();

        // Menggunakan preset error
        notify()->preset('error', ['title' => 'Hapus Galeri', 'message' => 'Galeri berhasil dihapus']);

        return redirect()->route('admin.galeri.index');
    }
}
