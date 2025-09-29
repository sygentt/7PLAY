@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan sistem pemesanan tiket 7PLAY')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-cinema-600 to-cinema-700 rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center text-white">
                    <div class="flex-shrink-0">
                        <x-heroicon-s-hand-raised class="h-8 w-8"/>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold">
                            Selamat datang kembali, {{ Auth::user()->name }}!
                        </h2>
                        <p class="text-cinema-100 mt-1">
                            Dashboard admin 7PLAY - Kelola sistem pemesanan tiket dengan mudah
                        </p>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <div class="text-white text-right">
                        <p class="text-sm font-medium">{{ now()->format('l, d F Y') }}</p>
                        <p class="text-xs text-cinema-100">{{ now()->format('H:i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($total_users) }}</p>
                        <p class="text-xs text-green-600 font-medium mt-1">
                            <x-heroicon-m-arrow-trending-up class="h-3 w-3 inline mr-1"/>
                            Active registrations
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <x-heroicon-s-users class="h-6 w-6 text-blue-600"/>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Movies -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Movies</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($total_movies) }}</p>
                        <p class="text-xs text-purple-600 font-medium mt-1">
                            <x-heroicon-m-film class="h-3 w-3 inline mr-1"/>
                            In catalog
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <x-heroicon-s-film class="h-6 w-6 text-purple-600"/>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($total_orders) }}</p>
                        <p class="text-xs text-green-600 font-medium mt-1">
                            <x-heroicon-m-banknotes class="h-3 w-3 inline mr-1"/>
                            All time bookings
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <x-heroicon-s-shopping-bag class="h-6 w-6 text-green-600"/>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Cities -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Cities</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($total_cities) }}</p>
                        <p class="text-xs text-blue-600 font-medium mt-1">
                            <x-heroicon-m-building-office-2 class="h-3 w-3 inline mr-1"/>
                            Registered cities
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <x-heroicon-s-building-office-2 class="h-6 w-6 text-blue-600"/>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Cinemas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Cinemas</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($total_cinemas) }}</p>
                        <p class="text-xs text-orange-600 font-medium mt-1">
                            <x-heroicon-m-check-circle class="h-3 w-3 inline mr-1"/>
                            {{ $active_cinemas }} active
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <x-heroicon-s-building-storefront class="h-6 w-6 text-orange-600"/>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Users This Month -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">New Users This Month</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($new_users_this_month ?? 0) }}</p>
                        <p class="text-xs text-emerald-600 font-medium mt-1">
                            <x-heroicon-m-user-plus class="h-3 w-3 inline mr-1"/>
                            Joined in {{ now()->translatedFormat('F Y') }}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                            <x-heroicon-s-user-plus class="h-6 w-6 text-emerald-600"/>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Showtimes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Active Showtimes</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($active_showtimes ?? 0) }}</p>
                        <p class="text-xs text-indigo-600 font-medium mt-1">
                            <x-heroicon-m-clock class="h-3 w-3 inline mr-1"/>
                            Currently running
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <x-heroicon-s-clock class="h-6 w-6 text-indigo-600"/>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Bookings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Today's Bookings</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($today_bookings ?? 0) }}</p>
                        <p class="text-xs text-rose-600 font-medium mt-1">
                            <x-heroicon-m-calendar-days class="h-3 w-3 inline mr-1"/>
                            Bookings today
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-rose-100 rounded-full flex items-center justify-center">
                            <x-heroicon-s-calendar-days class="h-6 w-6 text-rose-600"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>



@endsection
