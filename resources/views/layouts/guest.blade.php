<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-cinema-gradient-light dark:bg-cinema-gradient-dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', '7PLAY') }} - {{ $title ?? 'Masuk' }}</title>
        <meta name="description" content="Platform pemesanan tiket bioskop online terpercaya di Indonesia. Booking tiket film favorit Anda dengan mudah dan aman.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('storage/logo.svg') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Dark Mode Script -->
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body class="min-h-screen font-sans antialiased bg-cinema-gradient-light dark:bg-cinema-gradient-dark bg-fixed">
        <!-- Dark Mode Toggle -->
        <div class="fixed top-4 right-4 z-50">
            <button 
                onclick="toggleDarkMode()" 
                class="p-3 rounded-full bg-white/20 dark:bg-black/20 backdrop-blur-sm border border-white/30 dark:border-white/10 text-cinema-700 dark:text-cinema-300 hover:bg-white/30 dark:hover:bg-black/30 transition-all duration-300 shadow-lg"
                aria-label="Toggle dark mode"
            >
                <x-heroicon-o-sun class="w-5 h-5 block dark:hidden" />
                <x-heroicon-o-moon class="w-5 h-5 hidden dark:block" />
            </button>
        </div>

        <!-- Full Screen Background Overlay -->
        <div class="fixed inset-0 bg-cinema-gradient-light dark:bg-cinema-gradient-dark -z-10"></div>
        
        <div class="min-h-screen flex relative">
            <!-- Left Side - Branding & Visual -->
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-gradient-to-br from-cinema-600 via-cinema-700 to-cinema-900"></div>
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
                
                <!-- Content -->
                <div class="relative z-10 flex flex-col justify-center items-center px-12 text-white text-center">
                    <!-- Logo & Tagline - Centered Layout -->
                    <div class="flex items-center justify-center gap-8 mb-8 animate-fade-in">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/logo.svg') }}" alt="7PLAY Logo" class="w-32 h-32 drop-shadow-2xl">
                        </div>
                        
                        <!-- Tagline -->
                        <div class="animate-slide-up text-left">
                            <h1 class="text-4xl font-bold mb-4 bg-gradient-to-r from-white to-cinema-100 bg-clip-text text-transparent">
                                Selamat Datang di 7PLAY
                            </h1>
                            <p class="text-xl text-cinema-100 leading-relaxed">
                                Platform pemesanan tiket bioskop terpercaya.<br>
                                Nikmati pengalaman menonton yang tak terlupakan.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Features -->
                    <div class="grid grid-cols-1 gap-6 max-w-sm animate-fade-in">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                                <x-heroicon-o-check-circle class="w-5 h-5" />
                            </div>
                            <span class="text-cinema-100">Booking mudah & cepat</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                                <x-heroicon-o-shield-check class="w-5 h-5" />
                            </div>
                            <span class="text-cinema-100">Pembayaran aman</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                                <x-heroicon-o-ticket class="w-5 h-5" />
                            </div>
                            <span class="text-cinema-100">E-ticket digital</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">
                <div class="w-full max-w-md">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden text-center mb-8 animate-fade-in">
                        <img src="{{ asset('storage/logo.svg') }}" alt="7PLAY Logo" class="w-16 h-16 mx-auto mb-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">7PLAY</h1>
                        <p class="text-gray-600 dark:text-gray-400">Pemesanan Tiket Bioskop</p>
                    </div>

                    <!-- Form Card -->
                    <div class="bg-card-gradient-light dark:bg-card-gradient-dark backdrop-blur-xl border border-white/20 dark:border-gray-700/30 rounded-2xl shadow-2xl p-8 animate-slide-up">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Dark Mode Toggle Script -->
        <script>
            function toggleDarkMode() {
                const html = document.documentElement;
                const isDark = html.classList.contains('dark');
                
                if (isDark) {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }
        </script>
    </body>
</html>
