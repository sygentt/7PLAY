<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full bg-cinema-gradient-light dark:bg-cinema-gradient-dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '7PLAY') }} - @yield('title', isset($title) ? $title : 'Autentikasi')</title>
    <meta name="description"
        content="Platform pemesanan tiket bioskop online terpercaya di Indonesia. Booking tiket film favorit Anda dengan mudah dan aman.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/logo.svg') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Dark Mode Script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="min-h-screen bg-cinema-gradient-light bg-fixed font-sans antialiased dark:bg-cinema-gradient-dark">
    <!-- Dark Mode Toggle -->
    <div class="fixed right-4 top-4 z-50">
        <button onclick="toggleDarkMode()"
            class="rounded-full border border-white/30 bg-white/20 p-3 text-cinema-700 shadow-lg backdrop-blur-sm transition-all duration-300 hover:bg-white/30 dark:border-white/10 dark:bg-black/20 dark:text-cinema-300 dark:hover:bg-black/30"
            aria-label="Toggle dark mode">
            <x-heroicon-o-sun class="block h-5 w-5 dark:hidden" />
            <x-heroicon-o-moon class="hidden h-5 w-5 dark:block" />
        </button>
    </div>

    <!-- Full Screen Background Overlay -->
    <div class="fixed inset-0 -z-10 bg-cinema-gradient-light dark:bg-cinema-gradient-dark"></div>

    <div class="relative flex min-h-screen">
        <!-- Left Side - Branding & Visual -->
        <div class="relative hidden overflow-hidden lg:flex lg:w-1/2">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-gradient-to-br from-cinema-600 via-cinema-700 to-cinema-900"></div>
            <div class="bg-[url('data:image/svg+xml,%3Csvg width= absolute inset-0"60" height="60"
                viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg
                fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"
                /%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col items-center justify-center px-12 text-center text-white">
                <!-- Logo & Tagline - Centered Layout -->
                <div class="mb-8 flex animate-fade-in items-center justify-center gap-8">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/logo.svg') }}" alt="7PLAY Logo" class="h-32 w-32 drop-shadow-2xl">
                    </div>

                    <!-- Tagline -->
                    <div class="animate-slide-up text-left">
                        <h1
                            class="mb-4 bg-gradient-to-r from-white to-cinema-100 bg-clip-text text-4xl font-bold text-transparent">
                            Selamat Datang di 7PLAY
                        </h1>
                        <p class="text-xl leading-relaxed text-cinema-100">
                            Platform pemesanan tiket bioskop terpercaya.<br>
                            Nikmati pengalaman menonton yang tak terlupakan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="flex w-full items-center justify-center p-6 lg:w-1/2 lg:p-12">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="mb-8 animate-fade-in text-center lg:hidden">
                    <img src="{{ asset('storage/logo.svg') }}" alt="7PLAY Logo" class="mx-auto mb-4 h-16 w-16">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">7PLAY</h1>
                    <p class="text-gray-600 dark:text-gray-400">Pemesanan Tiket Bioskop</p>
                </div>

                <!-- Form Card -->
                <div
                    class="animate-slide-up rounded-2xl border border-white/20 bg-card-gradient-light p-8 shadow-2xl backdrop-blur-xl dark:border-gray-700/30 dark:bg-card-gradient-dark">
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
