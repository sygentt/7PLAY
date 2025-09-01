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
    <!-- Debug Modal Fallback -->
    <script src="{{ asset('js/modal-debug.js') }}"></script>
    
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
        
        // Debug function to check modal availability
        function debugModal() {
            console.log('=== MODAL DEBUG ===');
            console.log('DOM ready state:', document.readyState);
            console.log('seat-count-modal element:', document.getElementById('seat-count-modal'));
            console.log('window.seatCountModal:', window.seatCountModal);
            console.log('================');
        }
        
        // Global openSeatCountModal function with fallback
        function openSeatCountModal(showtimeId) {
            console.log('openSeatCountModal called with ID:', showtimeId);
            
            // Try main modal first
            if (window.seatCountModal && window.seatCountModal.modal) {
                console.log('Using main modal');
                window.seatCountModal.open(showtimeId);
            } else if (typeof SeatCountModal !== 'undefined') {
                console.log('Creating new modal instance');
                window.seatCountModal = new SeatCountModal();
                if (window.seatCountModal.modal) {
                    window.seatCountModal.open(showtimeId);
                } else {
                    console.log('Main modal failed, using fallback');
                    openSimpleModal(showtimeId);
                }
            } else {
                console.log('SeatCountModal class not found, using fallback');
                openSimpleModal(showtimeId);
            }
        }
        
        // Initialize modal when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded');
            debugModal();
            
            // Ensure seat count modal is initialized
            if (typeof SeatCountModal !== 'undefined') {
                if (!window.seatCountModal) {
                    console.log('Initializing seat count modal...');
                    window.seatCountModal = new SeatCountModal();
                }
            }
        });
    </script>
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>


