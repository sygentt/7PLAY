<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm(): View
    {
        // Redirect if already authenticated admin
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle admin login attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Check if user is admin
            if (!$user->is_admin) {
                Auth::logout();
                
                return back()
                    ->withInput($request->except('password'))
                    ->withErrors([
                        'email' => 'Akun Anda tidak memiliki akses admin.',
                    ]);
            }
            
            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                
                return back()
                    ->withInput($request->except('password'))
                    ->withErrors([
                        'email' => 'Akun Anda tidak aktif. Hubungi administrator.',
                    ]);
            }

            $request->session()->regenerate();

            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('success', "Selamat datang, {$user->name}!");
        }

        return back()
            ->withInput($request->except('password'))
            ->withErrors([
                'email' => 'Email atau password salah.',
            ]);
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Anda telah berhasil logout.');
    }
}
