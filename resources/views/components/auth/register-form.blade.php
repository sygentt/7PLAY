<!-- Register Form Content -->
<div id="register-form-content" class="hidden">
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            Bergabung dengan 7PLAY
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            Daftar sekarang dan nikmati pengalaman menonton terbaik
        </p>
    </div>

    <!-- Register Form -->
    <form id="modal-register-form" method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="space-y-2">
            <label for="modal-name" class="block text-sm font-semibold text-gray-900 dark:text-white">
                Nama Lengkap
            </label>
            <div class="relative">
                <input 
                    id="modal-name" 
                    type="text" 
                    name="name" 
                    required 
                    autofocus 
                    autocomplete="name"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                    placeholder="Masukkan nama lengkap Anda"
                />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-heroicon-o-user class="w-5 h-5 text-gray-400" />
                </div>
            </div>
            <div id="modal-name-error" class="text-red-500 text-sm hidden"></div>
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="modal-register-email" class="block text-sm font-semibold text-gray-900 dark:text-white">
                Alamat Email
            </label>
            <div class="relative">
                <input 
                    id="modal-register-email" 
                    type="email" 
                    name="email" 
                    required 
                    autocomplete="username"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                    placeholder="nama@email.com"
                />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-400" />
                </div>
            </div>
            <div id="modal-register-email-error" class="text-red-500 text-sm hidden"></div>
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="modal-register-password" class="block text-sm font-semibold text-gray-900 dark:text-white">
                Kata Sandi
            </label>
            <div class="relative">
                <input 
                    id="modal-register-password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="new-password"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                    placeholder="Minimal 8 karakter"
                />
                <button 
                    type="button" 
                    onclick="toggleModalPassword('modal-register-password')"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                >
                    <x-heroicon-o-eye id="modal-register-eye-open" class="w-5 h-5" />
                    <x-heroicon-o-eye-slash id="modal-register-eye-closed" class="w-5 h-5 hidden" />
                </button>
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Password harus minimal 8 karakter dengan kombinasi huruf dan angka
            </div>
            <div id="modal-register-password-error" class="text-red-500 text-sm hidden"></div>
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <label for="modal-password-confirmation" class="block text-sm font-semibold text-gray-900 dark:text-white">
                Konfirmasi Kata Sandi
            </label>
            <div class="relative">
                <input 
                    id="modal-password-confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                    placeholder="Ulangi kata sandi"
                />
                <button 
                    type="button" 
                    onclick="toggleModalPassword('modal-password-confirmation')"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                >
                    <x-heroicon-o-eye id="modal-confirmation-eye-open" class="w-5 h-5" />
                    <x-heroicon-o-eye-slash id="modal-confirmation-eye-closed" class="w-5 h-5 hidden" />
                </button>
            </div>
            <div id="modal-password-confirmation-error" class="text-red-500 text-sm hidden"></div>
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            id="modal-register-submit"
            class="w-full bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
        >
            <span id="modal-register-text">Daftar Akun Sekarang</span>
            <span id="modal-register-loading" class="hidden">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mendaftar...
            </span>
        </button>

        <!-- Error Message -->
        <div id="modal-register-error" class="hidden bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-xl text-sm">
        </div>

        <!-- Divider -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                    Sudah punya akun?
                </span>
            </div>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <button 
                type="button"
                onclick="switchToLogin()"
                class="w-full bg-white/50 dark:bg-gray-800/50 text-teal-700 dark:text-teal-300 font-semibold py-3 px-6 rounded-xl border border-teal-200 dark:border-teal-700 hover:bg-teal-50 dark:hover:bg-teal-900/30 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
            >
                Masuk ke Akun Saya
            </button>
        </div>
    </form>
</div>

