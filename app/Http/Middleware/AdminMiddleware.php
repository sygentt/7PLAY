<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Silakan login admin terlebih dahulu.');
        }

        $user = Auth::user();

        // Check if user is admin
        if (!$user->is_admin) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Akses ditolak. Anda tidak memiliki hak akses admin.');
        }

        // Check if user is active
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Akun Anda tidak aktif. Hubungi administrator.');
        }

        return $next($request);
    }
}
