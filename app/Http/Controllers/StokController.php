<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisMotor;
use App\Models\Stok;
use Illuminate\Support\Facades\Storage;

class StokController extends Controller
{
    public function index()
    {
        $stok = Stok::all();
        return view('admin.stok.index', compact('stok'));
    }

    public function create()
    {
        $stoks = Stok::all();
        return view('admin.stok.create', compact('stoks'));
    }
    public function store(Request $request)
    {
        $messages = [
            'merk.required' => 'Merk motor wajib diisi.',
            'merk.string' => 'Merk motor harus berupa teks.',
            'merk.max' => 'Merk motor maksimal 255 karakter.',
            'kategori.required' => 'Kategori motor wajib dipilih.',
            'kategori.in' => 'Kategori motor tidak valid.',
            'harga_perHari.required' => 'Harga per hari wajib diisi.',
            'harga_perHari.numeric' => 'Harga per hari harus berupa angka.',
            'harga_perHari.min' => 'Harga per hari minimal 0.',
            'judul.required' => 'Judul wajib diisi.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'deskripsi1.required' => 'Deskripsi 1 wajib diisi.',
            'deskripsi1.string' => 'Deskripsi 1 harus berupa teks.',
            'deskripsi2.required' => 'Deskripsi 2 wajib diisi.',
            'deskripsi2.string' => 'Deskripsi 2 harus berupa teks.',
            'image_source.required' => 'Sumber gambar wajib dipilih.',
            'image_source.in' => 'Sumber gambar tidak valid.',
            'foto.required_if' => 'Foto wajib diunggah jika memilih upload gambar.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
            'foto_url.required_if' => 'URL foto wajib diisi jika memilih gunakan URL.',
            'foto_url.url' => 'URL foto tidak valid.',
        ];

        $validated = $request->validate([
            'merk' => 'required|string|max:255',
            'kategori' => 'required|in:matic,manual',
            'harga_perHari' => 'required|numeric|min:0',
            'judul' => 'required|string|max:255',
            'deskripsi1' => 'required|string',
            'deskripsi2' => 'required|string',
            'image_source' => 'required|in:upload,url',
            'foto' => 'required_if:image_source,upload|image|max:2048',
            'foto_url' => 'nullable|url',
        ], $messages);

        $data = $validated;

        if ($request->image_source === 'upload') {
            $path = $request->file('foto')->store('motors', 'public');
            $data['foto'] = $path;
        } else {
            $data['foto'] = $request->foto_url;
        }

        Stok::create($data);

        notify()->preset('success', ['title' => 'Sukses', 'message' => 'Stok Motor berhasil ditambahkan']);

        return redirect()->route('admin.jenisMotor.index');
    }


    public function show($id)
    {
        $stok = Stok::findOrFail($id);
        $qty = JenisMotor::where('id_stok', $id)->count();
        return view('admin.stok.show', compact('stok', 'qty'));
    }

    public function edit($id)
    {
        $stok = Stok::findOrFail($id);
        return view('admin.stok.edit', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'merk.required' => 'Merk motor wajib diisi.',
            'merk.string' => 'Merk motor harus berupa teks.',
            'merk.max' => 'Merk motor maksimal 255 karakter.',
            'kategori.required' => 'Kategori motor wajib dipilih.',
            'kategori.in' => 'Kategori motor tidak valid.',
            'harga_perHari.required' => 'Harga per hari wajib diisi.',
            'harga_perHari.numeric' => 'Harga per hari harus berupa angka.',
            'harga_perHari.min' => 'Harga per hari minimal 0.',
            'judul.required' => 'Judul wajib diisi.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'deskripsi1.required' => 'Deskripsi 1 wajib diisi.',
            'deskripsi1.string' => 'Deskripsi 1 harus berupa teks.',
            'deskripsi2.required' => 'Deskripsi 2 wajib diisi.',
            'deskripsi2.string' => 'Deskripsi 2 harus berupa teks.',
            'image_source.required' => 'Sumber gambar wajib dipilih.',
            'image_source.in' => 'Sumber gambar tidak valid.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
            'foto_url.url' => 'URL foto tidak valid.',
        ];

        $validated = $request->validate([
            'merk' => 'required|string|max:255',
            'kategori' => 'required|in:matic,manual',
            'harga_perHari' => 'required|numeric|min:0',
            'judul' => 'required|string|max:255',
            'deskripsi1' => 'required|string',
            'deskripsi2' => 'required|string',
            'image_source' => 'required|in:upload,url,unchanged',
            'foto' => 'nullable|image|max:2048',
            'foto_url' => 'nullable|url',
        ], $messages);

        $stok = Stok::findOrFail($id);
        $data = $validated;

        if ($request->image_source === 'upload' && $request->hasFile('foto')) {
            // Delete old image if it exists
            if ($stok->foto && Storage::disk('public')->exists($stok->foto)) {
                Storage::disk('public')->delete($stok->foto);
            }
            $path = $request->file('foto')->store('motors', 'public');
            $data['foto'] = $path;
        } elseif ($request->image_source === 'url') {
            $data['foto'] = $request->foto_url;
        } else {
            // Keep the existing photo
            $data['foto'] = $stok->foto;
        }

        $stok->update($data);

        notify()->preset('success', ['title' => 'Sukses', 'message' => 'Stok Motor berhasil diperbarui']);

        return redirect()->route('admin.jenisMotor.index');
    }

    public function destroy($id)
    {
        $stok = Stok::findOrFail($id);

        if ($stok->foto && Storage::exists('public/' . $stok->foto)) {
            Storage::delete('public/' . $stok->foto);
        }

        $stok->delete();

        // Using success preset
        notify()->preset('success', ['title' => 'Sukses', 'message' => 'Stok berhasil dihapus']);

        return redirect()->route('admin.stok.index');
    }
}
