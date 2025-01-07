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
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        Log::info('Login attempt received', ['username' => $request->uname]);

        try {
            $credentials = $request->validate([
                'uname' => 'required|string',
                'pass' => 'required|string',
            ]);

            // Cek apakah user ada
            $user = User::where('uname', $credentials['uname'])->first();

            if (!$user) {
                Log::warning('Login failed: User not found', ['username' => $credentials['uname']]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Username atau password salah!'
                ], 401);
            }

            // Cek apakah password cocok
            if (!Hash::check($credentials['pass'], $user->pass)) {
                Log::warning('Login failed: Invalid password', ['username' => $credentials['uname']]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Username atau password salah!'
                ], 401);
            }

            // Membuat token JWT
            $token = JWTAuth::fromUser($user);

            Log::info('Login successful', ['username' => $user->uname]);

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => $user
            ]);

        } catch (JWTException $e) {
            Log::error('JWT Error', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak dapat membuat token'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Login Error', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            Log::info('Logout successful');

            return response()->json([
                'status' => 'success',
                'message' => 'Logout berhasil'
            ]);
        } catch (JWTException $e) {
            Log::error('Logout Error', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal logout'
            ], 500);
        }
    }

    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'user' => $user
            ]);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token sudah kadaluarsa'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak ditemukan'
            ], 401);
        }
    }

    public function refresh()
    {
        try {
            $token = JWTAuth::parseToken()->refresh();

            return response()->json([
                'status' => 'success',
                'token' => $token
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak dapat refresh token'
            ], 401);
        }
    }
}
