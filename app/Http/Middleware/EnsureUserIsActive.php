<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * Ensure that the authenticated user is active before proceeding.
     * Inactive users will be logged out and redirected to login.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // If user is not authenticated, let auth middleware handle it
        if (!$user) {
            return $next($request);
        }

        // Check if user is active
        if (!$user->is_active) {
            Auth::logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()
                ->route('login')
                ->withErrors([
                    'account' => 'Akun Anda telah dinonaktifkan. Silakan hubungi customer service untuk informasi lebih lanjut.'
                ]);
        }

        return $next($request);
    }
}
