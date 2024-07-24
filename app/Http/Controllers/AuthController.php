<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login.index'); // Display the login form
    }

    public function login(Request $request)
    {
        $request->validate([
            'uname' => 'required|string',
            'pass' => 'required|string',
        ]);

        // Retrieve user by username
        $user = User::where('uname', $request->input('uname'))->first();

        // Check if user exists and password is correct
        if ($user) {
            Log::debug('User found: ' . $user->uname);
            if (Hash::check($request->input('pass'), $user->pass)) {
                Log::debug('Password correct');
                Auth::login($user);
                return redirect()->intended('admin/transaksi'); // Redirect after successful login
            } else {
                Log::debug('Password incorrect');
            }
        } else {
            Log::debug('User not found');
        }

        // Authentication failed
        return redirect()->back()->withErrors(['msg' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::logout();
        return redirect('/login');
    }
}
