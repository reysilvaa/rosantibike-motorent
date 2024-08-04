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
        $request->validate([
            'judul' => 'required|string|max:20',
            'deskripsi' => 'required|string|max:30',
            'full_description' => 'required',
            'foto' => 'required|string',
            'kategori' => 'required|in:alam,sejarah,kuliner,budaya',
            'link_maps' => 'required|string',
        ]);

        Galeri::create([
            'id_user' => Auth::user()->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'full_description' => $request->full_description,
            'foto' => $request->foto,
            'kategori' => $request->kategori,
            'link_maps' => $request->link_maps,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Galeri created successfully.');
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
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'full_description' => 'required',
            'foto' => 'required|string',
            'kategori' => 'required|in:alam,sejarah,kuliner,budaya',
            'link_maps' => 'required|string',
        ]);

        $galeri->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'full_description' => $request->full_description,
            'foto' => $request->foto,
            'kategori' => $request->kategori,
            'link_maps' => $request->link_maps,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Galeri updated successfully.');
    }

    public function destroy(Galeri $galeri)
    {
        $galeri->delete();
        return redirect()->route('galeri.index')->with('success', 'Galeri deleted successfully.');
    }
}
