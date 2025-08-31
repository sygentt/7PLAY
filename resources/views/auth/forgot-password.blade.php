<x-guest-layout>
    <x-slot name="title">Lupa Kata Sandi</x-slot>

    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            Lupa Kata Sandi?
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            Jangan khawatir, kami akan bantu Anda
        </p>
    </div>

    <!-- Description -->
    <div class="mb-6 p-4 bg-cinema-50/50 dark:bg-cinema-900/20 rounded-lg border border-cinema-200/50 dark:border-cinema-700/50">
        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
            Masukkan alamat email yang terdaftar di akun 7PLAY Anda. Kami akan mengirimkan link untuk mengatur ulang kata sandi ke email tersebut.
        </p>
    </div>

    <!-- Session Status -->
    <x-ui.auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-gray-900 dark:text-white">
                Alamat Email
            </label>
            <div class="relative">
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                    placeholder="Masukkan email akun Anda"
                />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-400" />
                </div>
            </div>
            <x-form.input-error :messages="$errors->get('email')" class="text-red-500 text-sm" />
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            class="w-full bg-button-gradient hover:bg-button-gradient-hover text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-lg hover:shadow-xl"
        >
            Kirim Link Reset Password
        </button>

        <!-- Info Box -->
        <div class="info-box bg-blue-50/50 dark:bg-blue-900/20 border border-blue-200/50 dark:border-blue-700/50 rounded-lg p-4">
            <div class="flex items-start space-x-3">
                <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" />
                <div class="text-sm text-blue-800 dark:text-blue-200">
                    <p class="font-medium mb-1">Tips:</p>
                    <ul class="space-y-1 text-xs">
                        <li>• Periksa folder spam/junk jika email tidak masuk ke inbox</li>
                        <li>• Link reset berlaku selama 60 menit</li>
                        <li>• Pastikan email yang dimasukkan sudah terdaftar</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-card-gradient-light dark:bg-card-gradient-dark text-gray-500 dark:text-gray-400">
                    Ingat kata sandi Anda?
                </span>
            </div>
        </div>

        <!-- Back to Login -->
        <div class="text-center">
            <a href="{{ route('login') }}" class="w-full inline-block bg-white/50 dark:bg-gray-800/50 text-cinema-700 dark:text-cinema-300 font-semibold py-3 px-6 rounded-xl border border-cinema-200 dark:border-cinema-700 hover:bg-cinema-50 dark:hover:bg-cinema-900/30 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <x-heroicon-o-arrow-left class="w-4 h-4 inline-block mr-2" />
                Kembali ke Halaman Login
            </a>
        </div>
    </form>
</x-guest-layout>
