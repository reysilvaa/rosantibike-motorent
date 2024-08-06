<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'uname.required' => 'Masukkan Username.',
            'uname.unique' => 'Username sudah digunakan.',
            'pass.required' => 'Masukkan Password.',
            'pass.confirmed' => 'Password Konfirmasi tidak sesuai.',
            'pass.min' => 'Password harus minimal 6 karakter.',
        ];

        $validated = $request->validate([
            'uname' => 'required|unique:users',
            'pass' => 'required|min:6|confirmed',
        ], $messages);

        User::create([
            'uname' => $validated['uname'],
            'pass' => Hash::make($validated['pass']),
        ]);

        // Using success preset
        notify()->preset('success', ['title' => 'Sukses', 'message' => 'Pengguna berhasil dibuat']);

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $messages = [
            'uname.required' => 'Masukkan Username.',
            'uname.unique' => 'Username sudah digunakan.',
            'pass.confirmed' => 'Password Konfirmasi tidak sesuai.',
            'pass.min' => 'Password harus minimal 6 karakter.',
        ];

        $rules = [
            'uname' => 'required|unique:users,uname,' . $user->id,
            'pass' => 'nullable|confirmed|min:6',
        ];

        $validated = $request->validate($rules, $messages);

        $user->uname = $validated['uname'];

        if ($request->filled('pass')) {
            $user->pass = Hash::make($validated['pass']);
        }

        $user->save();

        // Using success preset
        notify()->preset('success', ['title' => 'Sukses', 'message' => 'Pengguna berhasil diperbarui']);

        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        // Using error preset
        notify()->preset('error', ['title' => 'Hapus Pengguna', 'message' => 'Pengguna berhasil dihapus']);

        return redirect()->route('admin.users.index');
    }
}
