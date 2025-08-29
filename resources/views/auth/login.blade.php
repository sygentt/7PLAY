<x-guest-layout>
    <x-slot name="title">Masuk ke Akun</x-slot>

    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            Selamat Datang Kembali
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            Masuk ke akun Anda untuk melanjutkan
        </p>
    </div>

    <!-- Session Status -->
    <x-ui.auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
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
                    placeholder="nama@email.com"
                />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <span class="i-solar-letter-bold w-5 h-5 text-gray-400"></span>
                </div>
            </div>
            <x-form.input-error :messages="$errors->get('email')" class="text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-semibold text-gray-900 dark:text-white">
                Kata Sandi
            </label>
            <div class="relative">
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                    placeholder="••••••••"
                />
                <button 
                    type="button" 
                    onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                >
                    <span id="eye-open" class="i-solar-eye-bold w-5 h-5"></span>
                    <span id="eye-closed" class="i-solar-eye-closed-bold w-5 h-5 hidden"></span>
                </button>
            </div>
            <x-form.input-error :messages="$errors->get('password')" class="text-red-500 text-sm" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember"
                    class="w-4 h-4 text-cinema-600 bg-gray-100 border-gray-300 rounded focus:ring-cinema-500 dark:focus:ring-cinema-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                >
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-cinema-600 hover:text-cinema-700 dark:text-cinema-400 dark:hover:text-cinema-300 font-medium transition-colors duration-200">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            class="w-full bg-button-gradient hover:bg-button-gradient-hover text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-lg hover:shadow-xl"
        >
            Masuk ke Akun
        </button>

        <!-- Divider -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-card-gradient-light dark:bg-card-gradient-dark text-gray-500 dark:text-gray-400">
                    Belum punya akun?
                </span>
            </div>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <a href="{{ route('register') }}" class="w-full inline-block bg-white/50 dark:bg-gray-800/50 text-cinema-700 dark:text-cinema-300 font-semibold py-3 px-6 rounded-xl border border-cinema-200 dark:border-cinema-700 hover:bg-cinema-50 dark:hover:bg-cinema-900/30 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                Daftar Akun Baru
            </a>
        </div>
    </form>

    <!-- Password Toggle Script -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>
