<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'phone' => ['nullable', 'string', 'regex:/^(\+62|62|0)[0-9]{9,13}$/', 'unique:'.User::class],
                'birth_date' => ['nullable', 'date', 'before:today', 'after:1920-01-01'],
                'gender' => ['nullable', 'in:male,female,other'],
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['phone'] ?? null,
                'birth_date' => $validatedData['birth_date'] ?? null,
                'gender' => $validatedData['gender'] ?? null,
                'is_active' => true, // New users are active by default
            ]);

            event(new Registered($user));
            // Explicitly send verification email to ensure delivery
            $user->sendEmailVerificationNotification();
            Auth::login($user);

            // Check if this is an AJAX request
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'verification_sent' => true,
                    'email' => $user->email,
                    'message' => 'Registrasi berhasil! Tautan verifikasi telah dikirim ke email Anda.'
                ]);
            }

            return redirect()->route('home')
                ->with('verification_sent_email', $user->email);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data registrasi tidak valid. Silakan periksa kembali.',
                    'errors' => $e->errors()
                ], 422);
            }
            
            throw $e;
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'
                ], 500);
            }
            
            throw $e;
        }
    }
}
