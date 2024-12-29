<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Login dan menghasilkan token
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'uname' => 'required|string',
            'pass' => 'required|string',
        ]);

        // Cari user berdasarkan username
        $user = User::where('uname', $credentials['uname'])->first();

        // Cek apakah user ada dan password valid
        if (!$user || !Hash::check($credentials['pass'], $user->pass)) {
            Log::warning('Percobaan login gagal untuk username: ' . $credentials['uname']);
            return response()->json(['message' => 'Username atau password salah!'], 401);
        }

        // Generate token JWT
        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            Log::error('Gagal membuat token: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal membuat token.'], 500);
        }

        // Log login berhasil
        Log::info('User ' . $user->uname . ' berhasil login.');

        return response()->json([
            'message' => 'Login berhasil.',
            'token' => $token,
            'user' => $user
        ]);
    }

    // Logout user
    public function logout(Request $request)
    {
        // Ambil token dari header Authorization
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['message' => 'Token tidak ditemukan.'], 400);
        }

        // Invalidate token
        try {
            JWTAuth::invalidate($token);
            return response()->json(['message' => 'Logout berhasil.']);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Gagal logout.'], 500);
        }
    }

    public function me(Request $request)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['message' => 'Token tidak ditemukan.'], 400);
        }

        try {
            // Validasi dan autentikasi token
            $user = JWTAuth::setToken(str_replace('Bearer ', '', $token))->authenticate();

            if (!$user) {
                return response()->json(['message' => 'User tidak ditemukan.'], 404);
            }

            return response()->json(['user' => $user]);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['message' => 'Token sudah kedaluwarsa.', 'error' => $e->getMessage()], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['message' => 'Token tidak valid.', 'error' => $e->getMessage()], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['message' => 'Token tidak ditemukan.', 'error' => $e->getMessage()], 400);
        }
    }

}
