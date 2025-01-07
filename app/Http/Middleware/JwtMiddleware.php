<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\Request;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Coba autentikasi token
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            // Token sudah kedaluwarsa
            return response()->json(['error' => 'Token is expired'], 401);
        } catch (TokenInvalidException $e) {
            // Token tidak valid
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (Exception $e) {
            // Token tidak ada
            return response()->json(['error' => 'Token not found'], 401);
        }

        return $next($request);
    }
}