<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        <!-- Auth Modal -->
        <x-auth.modal-container />
        
        <!-- Toast Component -->
        <x-ui.toast />
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                try {
                    const params = new URLSearchParams(window.location.search);
                    if (params.get('verified') === '1') {
                        @if (session('verified_email'))
                            window.Toast?.show('Akun {{ session('verified_email') }} berhasil terverifikasi.', 'success', 5000);
                        @else
                            window.Toast?.show('Email kamu berhasil diverifikasi. Selamat datang di 7PLAY!', 'success', 5000);
                        @endif
                        const url = new URL(window.location.href);
                        url.searchParams.delete('verified');
                        window.history.replaceState({}, document.title, url.pathname + url.search);
                    }
                    // From session (non-ajax register fallback)
                    @if (session('verification_sent_email'))
                        window.Toast?.show('Pemberitahuan verifikasi telah dikirim ke {{ session('verification_sent_email') }}. Silakan cek email Anda.', 'info', 5000);
                    @endif
                } catch (e) { /* noop */ }
            });
        </script>
    </body>
</html>
