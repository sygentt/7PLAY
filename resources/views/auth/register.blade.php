<x-guest-layout>
    <x-slot name="title">Daftar Akun Baru</x-slot>

    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            Bergabung dengan 7PLAY
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            Daftar sekarang dan nikmati pengalaman menonton terbaik
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="space-y-2">
            <label for="name" class="block text-sm font-semibold text-gray-900 dark:text-white">
                Nama Lengkap
            </label>
            <div class="relative">
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus 
                    autocomplete="name"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                    placeholder="Masukkan nama lengkap Anda"
                />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-heroicon-o-user class="w-5 h-5 text-gray-400" />
                </div>
            </div>
            <x-form.input-error :messages="$errors->get('name')" class="text-red-500 text-sm" />
        </div>

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
                    autocomplete="username"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                    placeholder="nama@email.com"
                />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-400" />
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
                    autocomplete="new-password"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                    placeholder="Minimal 8 karakter"
                />
                <button 
                    type="button" 
                    onclick="togglePasswordRegister('password')"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                >
                    <x-heroicon-o-eye id="eye-open-password" class="w-5 h-5" />
                    <x-heroicon-o-eye-slash id="eye-closed-password" class="w-5 h-5 hidden" />
                </button>
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Password harus minimal 8 karakter dengan kombinasi huruf dan angka
            </div>
            <x-form.input-error :messages="$errors->get('password')" class="text-red-500 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-900 dark:text-white">
                Konfirmasi Kata Sandi
            </label>
            <div class="relative">
                <input 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                    placeholder="Ulangi kata sandi"
                />
                <button 
                    type="button" 
                    onclick="togglePasswordRegister('password_confirmation')"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                >
                    <x-heroicon-o-eye id="eye-open-confirmation" class="w-5 h-5" />
                    <x-heroicon-o-eye-slash id="eye-closed-confirmation" class="w-5 h-5 hidden" />
                </button>
            </div>
            <x-form.input-error :messages="$errors->get('password_confirmation')" class="text-red-500 text-sm" />
        </div>



        <!-- Submit Button -->
        <button 
            type="submit"
            class="w-full bg-button-gradient hover:bg-button-gradient-hover text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-lg hover:shadow-xl"
        >
            Daftar Akun Sekarang
        </button>

        <!-- Divider -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-card-gradient-light dark:bg-card-gradient-dark text-gray-500 dark:text-gray-400">
                    Sudah punya akun?
                </span>
            </div>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <a href="{{ route('login') }}" class="w-full inline-block bg-white/50 dark:bg-gray-800/50 text-cinema-700 dark:text-cinema-300 font-semibold py-3 px-6 rounded-xl border border-cinema-200 dark:border-cinema-700 hover:bg-cinema-50 dark:hover:bg-cinema-900/30 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                Masuk ke Akun Saya
            </a>
        </div>
    </form>

    <!-- Password Toggle Script -->
    <script>
        function togglePasswordRegister(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const suffix = fieldId === 'password' ? 'password' : 'confirmation';
            const eyeOpen = document.getElementById(`eye-open-${suffix}`);
            const eyeClosed = document.getElementById(`eye-closed-${suffix}`);
            
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

        // Real-time password confirmation validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            const submitButton = document.querySelector('button[type="submit"]');
            
            if (confirmation && password !== confirmation) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '';
            }
        });
    </script>
</x-guest-layout>
