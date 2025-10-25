<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-authenticated" content="{{ auth()->check() ? 'true' : 'false' }}">

    <title>@yield('title', config('app.name', '7PLAY') . ' - Platform Pemesanan Tiket Bioskop')</title>
    <meta name="description" content="@yield('description', 'Platform pemesanan tiket bioskop online terpercaya di Indonesia. Booking tiket film favorit Anda dengan mudah dan aman.')">
    
    <!-- SEO Meta Tags -->
    @yield('meta')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/logo.svg') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- Additional CSS -->
    @stack('styles')
    
    <!-- Dark Mode Script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="min-h-screen font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    
    <!-- Header Navigation -->
    @include('components.layout.header', [
        'cities' => $cities ?? [],
        'current_page' => $current_page ?? 'home'
    ])
    
    <!-- Main Content -->
    <main class="relative">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.layout.footer')
    
    <!-- Auth Modal -->
    <x-auth.modal-container />
    
    <!-- YouTube Modal -->
    <x-ui.youtube-modal />
    
    <!-- Toast Component -->
    <x-ui.toast />

    <!-- Seat Count Modal -->
    <x-booking.seat-count-modal />
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- Auth Modal Scripts -->
    <script src="{{ asset('js/auth-modal.js') }}"></script>
    
    <!-- Booking Modal Scripts -->
    <script src="{{ asset('js/seat-count-modal.js') }}"></script>
    
    <!-- Global Scripts -->
    <script>
        // Dark Mode Toggle Function
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
        
        // Global openSeatCountModal function with fallback
        function openSeatCountModal(showtimeId) {
            // Try main modal first
            if (window.seatCountModal && window.seatCountModal.modal) {
                window.seatCountModal.open(showtimeId);
            } else if (typeof SeatCountModal !== 'undefined') {
                window.seatCountModal = new SeatCountModal();
                if (window.seatCountModal.modal) {
                    window.seatCountModal.open(showtimeId);
                } else {
                    // Fallback: arahkan langsung ke halaman pilih kursi
                    window.location.href = `/booking/select-seats/${showtimeId}`;
                }
            } else {
                window.location.href = `/booking/select-seats/${showtimeId}`;
            }
        }
        
        // Initialize modal when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure seat count modal is initialized
            if (typeof SeatCountModal !== 'undefined') {
                if (!window.seatCountModal) {
                    window.seatCountModal = new SeatCountModal();
                }
            }
        });
    </script>
    
    <!-- Additional Scripts -->
    @stack('scripts')
    <script>
        (function(){
            const params = new URLSearchParams(window.location.search);
            if (params.get('verified') === '1' && window.Toast) {
                window.Toast.show('Email Anda berhasil diverifikasi. Selamat datang!', 'success', 5000);
                // bersihkan query agar tidak muncul lagi saat back/refresh
                const url = new URL(window.location.href);
                url.searchParams.delete('verified');
                window.history.replaceState({}, document.title, url.toString());
            }
            if (params.get('verify_sent') === '1' && window.Toast) {
                window.Toast.show('Registrasi berhasil! Link verifikasi telah dikirim ke email Anda.', 'info', 6000);
                const url = new URL(window.location.href);
                url.searchParams.delete('verify_sent');
                window.history.replaceState({}, document.title, url.toString());
            }
        })();
        
        // Auto-open auth modal if redirected from login or register page
        @if(session('auth_modal'))
            document.addEventListener('DOMContentLoaded', function() {
                const modalType = '{{ session('auth_modal') }}';
                setTimeout(function() {
                    openAuthModal(modalType);
                }, 300);
            });
        @endif
        
        // Show toast notification from session flash
        @if(session('toast'))
            document.addEventListener('DOMContentLoaded', function() {
                @php
                    $toast = session('toast');
                    $message = is_array($toast) ? ($toast['message'] ?? '') : $toast;
                    $type = is_array($toast) ? ($toast['type'] ?? 'info') : 'info';
                @endphp
                setTimeout(function() {
                    if (window.Toast) {
                        window.Toast.show('{{ addslashes($message) }}', '{{ $type }}', 5000);
                    }
                }, 300);
            });
        @endif
    </script>
</body>
</html>


