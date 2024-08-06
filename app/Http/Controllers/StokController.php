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
            'merk.required' => 'Merk wajib diisi.',
            'merk.string' => 'Merk harus berupa teks.',
            'merk.max' => 'Merk maksimal 255 karakter.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.max' => 'Judul maksimal 100 karakter.',
            'deskripsi1.string' => 'Deskripsi 1 harus berupa teks.',
            'deskripsi1.max' => 'Deskripsi 1 maksimal 100 karakter.',
            'deskripsi2.string' => 'Deskripsi 2 harus berupa teks.',
            'deskripsi2.max' => 'Deskripsi 2 maksimal 100 karakter.',
            'deskripsi3.string' => 'Deskripsi 3 harus berupa teks.',
            'deskripsi3.max' => 'Deskripsi 3 maksimal 100 karakter.',
            'kategori.required' => 'Kategori wajib diisi.',
            'kategori.in' => 'Kategori harus salah satu dari: manual, matic.',
            'harga_perHari.required' => 'Harga per hari wajib diisi.',
            'harga_perHari.numeric' => 'Harga per hari harus berupa angka.',
            'foto.image' => 'Foto harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat jpeg, png, jpg, gif, atau svg.',
            'foto.max' => 'Foto maksimal 2MB.',
            'foto_url.url' => 'URL foto harus valid.',
        ];

        $request->validate([
            'merk' => 'required|string|max:255',
            'judul' => 'nullable|string|max:100',
            'deskripsi1' => 'nullable|string|max:100',
            'deskripsi2' => 'nullable|string|max:100',
            'deskripsi3' => 'nullable|string|max:100',
            'kategori' => 'required|in:manual,matic',
            'harga_perHari' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_url' => 'nullable|url',
        ], $messages);

        $data = $request->only(['merk', 'harga_perHari', 'deskripsi1', 'deskripsi2', 'deskripsi3', 'kategori', 'judul']);

        if ($request->filled('foto_url')) {
            $data['foto'] = $request->input('foto_url');
        } elseif ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('photos', 'public');
            $data['foto'] = $fotoPath;
        }

        Stok::create($data);

        return redirect()->route('admin.jenisMotor.index')
                        ->with('success', 'Stok berhasil dibuat.');
    }


    public function show($id)
    {
        $stok = Stok::findOrFail($id);
        $qty = JenisMotor::findOrFail($id)->where('id_stok', $id)->count();
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
            'merk.required' => 'Merk wajib diisi.',
            'merk.string' => 'Merk harus berupa teks.',
            'merk.max' => 'Merk maksimal 255 karakter.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.max' => 'Judul maksimal 100 karakter.',
            'deskripsi1.string' => 'Deskripsi 1 harus berupa teks.',
            'deskripsi1.max' => 'Deskripsi 1 maksimal 100 karakter.',
            'deskripsi2.string' => 'Deskripsi 2 harus berupa teks.',
            'deskripsi2.max' => 'Deskripsi 2 maksimal 100 karakter.',
            'deskripsi3.string' => 'Deskripsi 3 harus berupa teks.',
            'deskripsi3.max' => 'Deskripsi 3 maksimal 100 karakter.',
            'kategori.required' => 'Kategori wajib diisi.',
            'kategori.in' => 'Kategori harus salah satu dari: manual, matic.',
            'harga_perHari.required' => 'Harga per hari wajib diisi.',
            'harga_perHari.numeric' => 'Harga per hari harus berupa angka.',
            'foto.image' => 'Foto harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat jpeg, png, jpg, gif, atau svg.',
            'foto.max' => 'Foto maksimal 2MB.',
            'foto_url.url' => 'URL foto harus valid.',
        ];

        $request->validate([
            'merk' => 'required|string|max:255',
            'judul' => 'nullable|string|max:100',
            'deskripsi1' => 'nullable|string|max:100',
            'deskripsi2' => 'nullable|string|max:100',
            'deskripsi3' => 'nullable|string|max:100',
            'kategori' => 'required|in:manual,matic',
            'harga_perHari' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_url' => 'nullable|url',
        ], $messages);

        $stok = Stok::findOrFail($id);

        $data = $request->only(['merk', 'harga_perHari', 'deskripsi1', 'deskripsi2', 'deskripsi3', 'kategori', 'judul']);

        if ($request->filled('foto_url')) {
            $data['foto'] = $request->input('foto_url');
            if ($stok->foto && Storage::exists('public/' . $stok->foto)) {
                Storage::delete('public/' . $stok->foto);
            }
        } elseif ($request->hasFile('foto')) {
            if ($stok->foto && Storage::exists('public/' . $stok->foto)) {
                Storage::delete('public/' . $stok->foto);
            }
            $fotoPath = $request->file('foto')->store('photos', 'public');
            $data['foto'] = $fotoPath;
        } else {
            $data['foto'] = $stok->foto;
        }

        $stok->update($data);

        return redirect()->route('admin.jenisMotor.index')
                        ->with('success', 'Stok berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $stok = Stok::findOrFail($id);

        if ($stok->foto && Storage::exists('public/' . $stok->foto)) {
            Storage::delete('public/' . $stok->foto);
        }

        $stok->delete();

        return redirect()->route('admin.stok.index')
                         ->with('success', 'Stok deleted successfully.');
    }
}
