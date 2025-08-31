<x-guest-layout>
    <x-slot name="title">Reset Password</x-slot>

    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            Reset Password
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            Buat password baru untuk akun Anda
        </p>
    </div>

    <!-- Email Display -->
    <div class="mb-6 p-4 bg-cinema-50/50 dark:bg-cinema-900/20 rounded-lg border border-cinema-200/50 dark:border-cinema-700/50">
        <div class="text-center">
            <div class="flex items-center justify-center space-x-2 mb-2">
                <x-heroicon-o-envelope class="w-5 h-5 text-cinema-600 dark:text-cinema-400" />
                <span class="text-sm font-medium text-cinema-700 dark:text-cinema-300">Email yang direset:</span>
            </div>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ $request->email }}
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="hidden" name="email" value="{{ $request->email }}">

        <!-- Password -->
        <div class="space-y-2">
            <x-form.input-label for="password" :value="__('Password Baru')" />
            <x-form.text-input 
                id="password" 
                class="block mt-1 w-full" 
                type="password" 
                name="password" 
                required 
                autofocus 
                autocomplete="new-password"
                placeholder="Masukkan password baru"
            />
            <x-form.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <x-form.input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-form.text-input 
                id="password_confirmation" 
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="Konfirmasi password baru"
            />
            <x-form.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <x-form.primary-button class="w-full">
                <x-heroicon-o-key class="w-5 h-5 mr-2" />
                {{ __('Reset Password') }}
            </x-form.primary-button>
        </div>
    </form>

    <!-- Info Box -->
    <div class="mt-8 info-box bg-blue-50/50 dark:bg-blue-900/20 border border-blue-200/50 dark:border-blue-700/50 rounded-lg p-4">
        <div class="flex items-start space-x-3">
            <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" />
            <div class="text-sm text-blue-800 dark:text-blue-200">
                <p class="font-medium mb-1">Tips Password yang Aman:</p>
                <ul class="space-y-1 text-xs">
                    <li>• Gunakan minimal 8 karakter</li>
                    <li>• Kombinasikan huruf besar, kecil, angka, dan simbol</li>
                    <li>• Hindari informasi pribadi seperti nama atau tanggal lahir</li>
                    <li>• Jangan gunakan password yang sama dengan akun lain</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Back to Login -->
    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center text-sm text-cinema-600 dark:text-cinema-400 hover:text-cinema-700 dark:hover:text-cinema-300 transition-colors duration-200">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-1" />
            Kembali ke Login
        </a>
    </div>
</x-guest-layout>
