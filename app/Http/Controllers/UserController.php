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
            'pass' => 'required|min:6',
        ], $messages);

        $validated['pass'] = Hash::make($validated['pass']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
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

        $request->validate($rules, $messages);

        $user->uname = $request->uname;

        if ($request->filled('pass')) {
            $user->pass = Hash::make($request->pass);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
