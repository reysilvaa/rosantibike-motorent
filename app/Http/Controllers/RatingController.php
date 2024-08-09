<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

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
            'avatar.image' => 'Avatar harus berupa gambar.',
            'avatar.mimes' => 'Avatar harus berupa file gambar dengan format: jpeg, png, jpg, gif.',
            'avatar.max' => 'Avatar maksimal 2MB.',
            'avatar_url.url' => 'URL Avatar harus berupa URL yang valid.',
        ];

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'tanggal' => 'required|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'avatar_url' => 'nullable|url',
        ], $messages);

        $avatarPath = null;

        if ($request->hasFile('avatar')) {
            // Store the avatar file in the storage/app/public/avatars directory
            $avatarPath = $request->file('avatar')->store('public/avatars');
        } elseif ($request->input('avatar_url')) {
            // Handle avatar URL
            $avatarUrl = $request->input('avatar_url');
            $imageContent = Http::get($avatarUrl)->body();

            $imageName = basename(parse_url($avatarUrl, PHP_URL_PATH));
            $avatarPath = 'public/avatars/' . $imageName;

            Storage::put($avatarPath, $imageContent);
        }

        // Create rating with avatar path
        Rating::create(array_merge($validated, ['avatar' => $avatarPath]));

        notify()->preset('success', ['title' => 'Sukses', 'message' => 'Rating berhasil dibuat']);

        return redirect()->route('admin.rating.index');
    }

    public function edit($id)
    {
        $rating = Rating::findOrFail($id);
        return view('admin.rating.edit', compact('rating'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',
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
            'avatar.image' => 'Avatar harus berupa gambar.',
            'avatar.mimes' => 'Avatar harus berupa file gambar dengan format: jpeg, png, jpg, gif.',
            'avatar.max' => 'Avatar maksimal 2MB.',
            'avatar_url.url' => 'URL Avatar harus berupa URL yang valid.',
        ];

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'tanggal' => 'required|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'avatar_url' => 'nullable|url',
        ], $messages);

        $rating = Rating::find($id);

        if (!$rating) {
            notify()->preset('error', ['title' => 'Error', 'message' => 'Rating tidak ditemukan.']);
            return redirect()->back();
        }

        $updateData = [
            'nama' => $validated['nama'],
            'role' => $validated['role'],
            'deskripsi' => $validated['deskripsi'],
            'rating' => $validated['rating'],
            'tanggal' => $validated['tanggal'],
        ];

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($rating->avatar && Storage::exists($rating->avatar)) {
                Storage::delete($rating->avatar);
            }
            // Store the new avatar
            $updateData['avatar'] = $request->file('avatar')->store('public/avatars');
        } elseif ($request->input('avatar_url')) {
            // Handle new avatar URL
            $avatarUrl = $request->input('avatar_url');
            $imageContent = Http::get($avatarUrl)->body();

            $imageName = basename(parse_url($avatarUrl, PHP_URL_PATH));
            $avatarPath = 'public/avatars/' . $imageName;

            Storage::put($avatarPath, $imageContent);

            // Delete old avatar if exists
            if ($rating->avatar && Storage::exists($rating->avatar)) {
                Storage::delete($rating->avatar);
            }

            $updateData['avatar'] = $avatarPath;
        } else {
            // Retain the old avatar if no new avatar is provided
            if ($rating->avatar) {
                $updateData['avatar'] = $rating->avatar;
            }
        }

        $rating->update($updateData);

        notify()->preset('success', ['title' => 'Sukses', 'message' => 'Rating berhasil diperbarui']);

        return redirect()->route('admin.rating.index');
    }

    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);

        if ($rating->avatar && Storage::exists($rating->avatar)) {
            Storage::delete($rating->avatar);
        }

        $rating->delete();

        notify()->preset('error', ['title' => 'Sukses', 'message' => 'Rating berhasil dihapus']);

        return redirect()->route('admin.rating.index');
    }
}
