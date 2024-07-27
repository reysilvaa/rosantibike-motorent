<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login.index'); // Display the login form
    }

    public function login(Request $request)
    {
        // Validate the input
        $credentials = $request->validate([
            'uname' => 'required|string',
            'pass' => 'required|string',
        ]);

        // Retrieve user by username
        $user = User::where('uname', $credentials['uname'])->first();

        // Check if user exists and password is correct
        if ($user && Hash::check($credentials['pass'], $user->pass)) {
            // Log the successful authentication event
            Log::info('User ' . $user->uname . ' successfully logged in.');

            // Log the user in
            Auth::login($user);

            // Redirect to intended route or default route
            return redirect()->intended('admin');
        }

        // Log the failed authentication attempt
        Log::warning('Failed login attempt for username: ' . $credentials['uname']);

        // Authentication failed
        throw ValidationException::withMessages([
            'msg' => 'Username atau password salah!',
        ]);
    }

    public function logout(Request $request)
    {
        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Log out the user
        Auth::logout();

        // Redirect to login page
        return redirect('/login');
    }
}
