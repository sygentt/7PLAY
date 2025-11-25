<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', '7PLAY') }} - @yield('title', 'Admin Dashboard')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/logo.svg') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
    <style>
        /* Fix admin content overflow */
        .container {
            max-width: 100% !important;
            overflow-x: hidden;
        }
        @media (min-width: 1024px) {
            .container {
                max-width: calc(100vw - 16rem - 3rem) !important;
            }
        }
    </style>
</head>
<body class="h-full bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="flex h-full">
        <!-- Sidebar -->
        <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
            <div class="flex flex-col flex-grow bg-white border-r border-gray-200 pt-5 pb-4 overflow-y-auto">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-4">
                    @include('admin.components.brand-logo')
                </div>
                
                <!-- Navigation -->
                <nav class="mt-8 flex-1 px-2 space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        @if(request()->routeIs('admin.dashboard'))
                            <x-heroicon-s-squares-2x2 class="mr-3 flex-shrink-0 h-5 w-5 text-blue-500"/>
                        @else
                            <x-heroicon-o-squares-2x2 class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"/>
                        @endif
                        Dashboard
                    </a>

                    <!-- Cities Management -->
                    <a href="{{ route('admin.cities.index') }}" 
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.cities.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        @if(request()->routeIs('admin.cities.*'))
                            <x-heroicon-s-building-office-2 class="mr-3 flex-shrink-0 h-5 w-5 text-blue-500"/>
                        @else
                            <x-heroicon-o-building-office-2 class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"/>
                        @endif
                        Cities
                    </a>

                    <!-- Cinemas Management -->
                    <a href="{{ route('admin.cinemas.index') }}" 
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.cinemas.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        @if(request()->routeIs('admin.cinemas.*'))
                            <x-heroicon-s-building-storefront class="mr-3 flex-shrink-0 h-5 w-5 text-purple-500"/>
                        @else
                            <x-heroicon-o-building-storefront class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"/>
                        @endif
                        Cinemas
                    </a>

                    <!-- Movies Management -->
                    <a href="{{ route('admin.movies.index') }}" 
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.movies.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        @if(request()->routeIs('admin.movies.*'))
                            <x-heroicon-s-film class="mr-3 flex-shrink-0 h-5 w-5 text-indigo-500"/>
                        @else
                            <x-heroicon-o-film class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"/>
                        @endif
                        Movies
                    </a>

                    <!-- Showtimes Management -->
                    <a href="{{ route('admin.showtimes.index') }}" 
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.showtimes.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        @if(request()->routeIs('admin.showtimes.*'))
                            <x-heroicon-s-calendar-days class="mr-3 flex-shrink-0 h-5 w-5 text-purple-500"/>
                        @else
                            <x-heroicon-o-calendar-days class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"/>
                        @endif
                        Showtimes
                    </a>

                    <!-- Orders Management -->
                    <a href="{{ route('admin.orders.index') }}" 
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.orders.*') ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        @if(request()->routeIs('admin.orders.*'))
                            <x-heroicon-s-shopping-bag class="mr-3 flex-shrink-0 h-5 w-5 text-green-500"/>
                        @else
                            <x-heroicon-o-shopping-bag class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"/>
                        @endif
                        Orders
                    </a>

                    <!-- Users Management -->
                    <a href="{{ route('admin.users.index') }}" 
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        @if(request()->routeIs('admin.users.*'))
                            <x-heroicon-s-users class="mr-3 flex-shrink-0 h-5 w-5 text-blue-500"/>
                        @else
                            <x-heroicon-o-users class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"/>
                        @endif
                        Users
                    </a>

                    <!-- Vouchers Management -->
                    <a href="{{ route('admin.vouchers.index') }}" 
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.vouchers.*') ? 'bg-teal-100 text-teal-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        @if(request()->routeIs('admin.vouchers.*'))
                            <x-heroicon-s-ticket class="mr-3 flex-shrink-0 h-5 w-5 text-teal-500"/>
                        @else
                            <x-heroicon-o-ticket class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"/>
                        @endif
                        Vouchers
                    </a>

                    <!-- Notifications Management -->
                    <a href="{{ route('admin.notifications.index') }}" 
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.notifications.*') ? 'bg-red-100 text-red-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        @if(request()->routeIs('admin.notifications.*'))
                            <x-heroicon-s-bell class="mr-3 flex-shrink-0 h-5 w-5 text-red-500"/>
                        @else
                            <x-heroicon-o-bell class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"/>
                        @endif
                        Notifications
                    </a>

                    <!-- Reports & Analytics -->
                    <a href="{{ route('admin.reports.index') }}" 
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md 
                       {{ request()->routeIs('admin.reports.*') 
                          ? 'bg-orange-100 text-orange-700' 
                          : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        @if(request()->routeIs('admin.reports.*'))
                            <x-heroicon-s-chart-bar class="mr-3 flex-shrink-0 h-5 w-5"/>
                        @else
                            <x-heroicon-o-chart-bar class="mr-3 flex-shrink-0 h-5 w-5"/>
                        @endif
                        Reports
                    </a>
                </nav>
            </div>
        </div>

        <!-- Mobile Sidebar -->
        <div class="lg:hidden" x-show="sidebarOpen" style="display: none;">
            <div class="fixed inset-0 flex z-40">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75" x-on:click="sidebarOpen = false"></div>
                
                <!-- Sidebar Panel -->
                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button type="button" 
                                class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                x-on:click="sidebarOpen = false">
                            <x-heroicon-o-x-mark class="h-6 w-6 text-white"/>
                        </button>
                    </div>
                    
                    <!-- Mobile Navigation Content (Same as desktop but responsive) -->
                    <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center px-4">
                            @include('admin.components.brand-logo')
                        </div>
                        
                        <!-- Mobile Navigation -->
                        <nav class="mt-8 flex-1 px-2 space-y-1">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                @if(request()->routeIs('admin.dashboard'))
                                    <x-heroicon-s-squares-2x2 class="mr-4 flex-shrink-0 h-6 w-6 text-blue-500"/>
                                @else
                                    <x-heroicon-o-squares-2x2 class="mr-4 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"/>
                                @endif
                                Dashboard
                            </a>
                            
                            <!-- Cities Management -->
                            <a href="{{ route('admin.cities.index') }}" 
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.cities.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                @if(request()->routeIs('admin.cities.*'))
                                    <x-heroicon-s-building-office-2 class="mr-4 flex-shrink-0 h-6 w-6 text-blue-500"/>
                                @else
                                    <x-heroicon-o-building-office-2 class="mr-4 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"/>
                                @endif
                                Cities
                            </a>

                            <!-- Cinemas Management -->
                            <a href="{{ route('admin.cinemas.index') }}" 
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.cinemas.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                @if(request()->routeIs('admin.cinemas.*'))
                                    <x-heroicon-s-building-storefront class="mr-4 flex-shrink-0 h-6 w-6 text-purple-500"/>
                                @else
                                    <x-heroicon-o-building-storefront class="mr-4 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"/>
                                @endif
                                Cinemas
                            </a>

                            <!-- Movies Management -->
                            <a href="{{ route('admin.movies.index') }}" 
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.movies.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                @if(request()->routeIs('admin.movies.*'))
                                    <x-heroicon-s-film class="mr-4 flex-shrink-0 h-6 w-6 text-indigo-500"/>
                                @else
                                    <x-heroicon-o-film class="mr-4 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"/>
                                @endif
                                Movies
                            </a>

                            <!-- Showtimes Management -->
                            <a href="{{ route('admin.showtimes.index') }}" 
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.showtimes.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                @if(request()->routeIs('admin.showtimes.*'))
                                    <x-heroicon-s-calendar-days class="mr-4 flex-shrink-0 h-6 w-6 text-purple-500"/>
                                @else
                                    <x-heroicon-o-calendar-days class="mr-4 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"/>
                                @endif
                                Showtimes
                            </a>

                            <!-- Orders Management -->
                            <a href="{{ route('admin.orders.index') }}" 
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.orders.*') ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                @if(request()->routeIs('admin.orders.*'))
                                    <x-heroicon-s-shopping-bag class="mr-4 flex-shrink-0 h-6 w-6 text-green-500"/>
                                @else
                                    <x-heroicon-o-shopping-bag class="mr-4 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"/>
                                @endif
                                Orders
                            </a>

                            <!-- Users Management -->
                            <a href="{{ route('admin.users.index') }}" 
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                @if(request()->routeIs('admin.users.*'))
                                    <x-heroicon-s-users class="mr-4 flex-shrink-0 h-6 w-6 text-blue-500"/>
                                @else
                                    <x-heroicon-o-users class="mr-4 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"/>
                                @endif
                                Users
                            </a>

                            <!-- Vouchers Management -->
                            <a href="{{ route('admin.vouchers.index') }}" 
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.vouchers.*') ? 'bg-teal-100 text-teal-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                @if(request()->routeIs('admin.vouchers.*'))
                                    <x-heroicon-s-ticket class="mr-4 flex-shrink-0 h-6 w-6 text-teal-500"/>
                                @else
                                    <x-heroicon-o-ticket class="mr-4 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"/>
                                @endif
                                Vouchers
                            </a>

                            <!-- Notifications Management -->
                            <a href="{{ route('admin.notifications.index') }}" 
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.notifications.*') ? 'bg-red-100 text-red-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                @if(request()->routeIs('admin.notifications.*'))
                                    <x-heroicon-s-bell class="mr-4 flex-shrink-0 h-6 w-6 text-red-500"/>
                                @else
                                    <x-heroicon-o-bell class="mr-4 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"/>
                                @endif
                                Notifications
                            </a>

                            <!-- Reports & Analytics -->
                            <a href="{{ route('admin.reports.index') }}" 
                               class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.reports.*') ? 'bg-orange-100 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                @if(request()->routeIs('admin.reports.*'))
                                    <x-heroicon-s-chart-bar class="mr-4 flex-shrink-0 h-6 w-6 text-orange-500"/>
                                @else
                                    <x-heroicon-o-chart-bar class="mr-4 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"/>
                                @endif
                                Reports
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:pl-64 flex flex-col flex-1">
            <!-- Top Header -->
            <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow-sm border-b border-gray-200">
                <!-- Mobile Menu Button -->
                <button type="button"
                        class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 lg:hidden"
                        x-on:click="sidebarOpen = true">
                    <x-heroicon-o-bars-3 class="h-6 w-6"/>
                </button>
                
                <div class="flex-1 px-4 flex justify-between items-center">
                    <!-- Page Title -->
                    <div class="flex-1">
                        <h1 class="text-xl font-semibold text-gray-900">
                            @yield('page-title', 'Dashboard')
                        </h1>
                        <p class="text-sm text-gray-600">
                            @yield('page-description', 'Kelola sistem 7PLAY cinema booking')
                        </p>
                    </div>
                    
                    <!-- Header Actions (no dropdown) -->
                    <div class="ml-4 flex items-center space-x-3">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <span class="text-sm text-gray-700 hidden sm:inline">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <x-heroicon-o-arrow-right-on-rectangle class="h-4 w-4 mr-1"/>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden">
                <div class="py-6 w-full max-w-full">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <x-heroicon-s-check-circle class="h-5 w-5 mr-2"/>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <x-heroicon-s-x-circle class="h-5 w-5 mr-2"/>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
