<!-- Login Form Content -->
<div id="login-form-content">
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            Selamat Datang Kembali
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            Masuk ke akun Anda untuk melanjutkan
        </p>
    </div>

    <!-- Login Form -->
    <form id="modal-login-form" method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="modal-email" class="block text-sm font-semibold text-gray-900 dark:text-white">
                Alamat Email
            </label>
            <div class="relative">
                <input 
                    id="modal-email" 
                    type="email" 
                    name="email" 
                    required 
                    autofocus 
                    autocomplete="username"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                    placeholder="nama@email.com"
                />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-400" />
                </div>
            </div>
            <div id="modal-email-error" class="text-red-500 text-sm hidden"></div>
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="modal-password" class="block text-sm font-semibold text-gray-900 dark:text-white">
                Kata Sandi
            </label>
            <div class="relative">
                <input 
                    id="modal-password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                    class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                    placeholder="••••••••"
                />
                <button 
                    type="button" 
                    onclick="toggleModalPassword('modal-password')"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                >
                    <x-heroicon-o-eye id="modal-eye-open" class="w-5 h-5" />
                    <x-heroicon-o-eye-slash id="modal-eye-closed" class="w-5 h-5 hidden" />
                </button>
            </div>
            <div id="modal-password-error" class="text-red-500 text-sm hidden"></div>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="modal-remember-me" class="flex items-center">
                <input 
                    id="modal-remember-me" 
                    type="checkbox" 
                    name="remember"
                    class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                >
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
            </label>

            <button type="button" onclick="showForgotPassword()" class="text-sm text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 font-medium transition-colors duration-200">
                Lupa kata sandi?
            </button>
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            id="modal-login-submit"
            class="w-full bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
        >
            <span id="modal-login-text">Masuk ke Akun</span>
            <span id="modal-login-loading" class="hidden">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Masuk...
            </span>
        </button>

        <!-- Error Message -->
        <div id="modal-login-error" class="hidden bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-xl text-sm">
        </div>

        <!-- Divider -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                    Belum punya akun?
                </span>
            </div>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <button 
                type="button"
                onclick="switchToRegister()"
                class="w-full bg-white/50 dark:bg-gray-800/50 text-teal-700 dark:text-teal-300 font-semibold py-3 px-6 rounded-xl border border-teal-200 dark:border-teal-700 hover:bg-teal-50 dark:hover:bg-teal-900/30 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
            >
                Daftar Akun Baru
            </button>
        </div>
    </form>
</div>

