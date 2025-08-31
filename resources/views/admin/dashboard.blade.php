@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview of 7PLAY cinema booking system')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center text-white">
                    <div class="flex-shrink-0">
                        <x-heroicon-s-hand-raised class="h-8 w-8"/>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold">
                            Selamat datang kembali, {{ Auth::user()->name }}!
                        </h2>
                        <p class="text-blue-100 mt-1">
                            Dashboard admin 7PLAY - Kelola sistem cinema booking dengan mudah
                        </p>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <div class="text-white text-right">
                        <p class="text-sm font-medium">{{ now()->format('l, d F Y') }}</p>
                        <p class="text-xs text-blue-100">{{ now()->format('H:i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
        </div>

        <!-- Quick Actions & Status -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Quick Actions -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                        <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                            Ready to Use
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <!-- Add Movie -->
                        <a href="{{ route('admin.movies.create') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all group">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                <x-heroicon-o-plus class="h-5 w-5 text-purple-600"/>
                            </div>
                            <span class="text-sm font-medium text-gray-700 mt-2 group-hover:text-purple-600">Add Movie</span>
                        </a>
                        
                        <!-- Manage Showtimes -->
                        <a href="{{ route('admin.showtimes.index') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all group">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                <x-heroicon-o-calendar-days class="h-5 w-5 text-blue-600"/>
                            </div>
                            <span class="text-sm font-medium text-gray-700 mt-2 group-hover:text-blue-600">Showtimes</span>
                        </a>
                        
                        <!-- View Orders -->
                        <a href="{{ route('admin.orders.index') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-all group">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                <x-heroicon-o-document-text class="h-5 w-5 text-green-600"/>
                            </div>
                            <span class="text-sm font-medium text-gray-700 mt-2 group-hover:text-green-600">Orders</span>
                        </a>
                        
                        <!-- Add Cinema -->
                        <a href="{{ route('admin.cinemas.create') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-orange-300 hover:bg-orange-50 transition-all group">
                            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                                <x-heroicon-o-building-storefront class="h-5 w-5 text-orange-600"/>
                            </div>
                            <span class="text-sm font-medium text-gray-700 mt-2 group-hover:text-orange-600">Add Cinema</span>
                        </a>
                        
                        <!-- User Management -->
                        <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition-all group">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                                <x-heroicon-o-users class="h-5 w-5 text-indigo-600"/>
                            </div>
                            <span class="text-sm font-medium text-gray-700 mt-2 group-hover:text-indigo-600">Users</span>
                        </a>
                        
                        <!-- Reports -->
                        <a href="{{ route('admin.reports.index') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-pink-300 hover:bg-pink-50 transition-all group">
                            <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center group-hover:bg-pink-200 transition-colors">
                                <x-heroicon-o-chart-bar class="h-5 w-5 text-pink-600"/>
                            </div>
                            <span class="text-sm font-medium text-gray-700 mt-2 group-hover:text-pink-600">Reports</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">System Status</h3>
                
                <div class="space-y-4">
                    <!-- Database -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Database</span>
                        </div>
                        <span class="text-xs text-green-600 font-medium">Online</span>
                    </div>
                    
                    <!-- Authentication -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Authentication</span>
                        </div>
                        <span class="text-xs text-green-600 font-medium">Active</span>
                    </div>
                    
                    <!-- File Storage -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">File Storage</span>
                        </div>
                        <span class="text-xs text-yellow-600 font-medium">Pending</span>
                    </div>
                    
                    <!-- Email Service -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Email Service</span>
                        </div>
                        <span class="text-xs text-yellow-600 font-medium">Pending</span>
                    </div>
                    
                    <!-- Payment Gateway -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-gray-400 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Payment Gateway</span>
                        </div>
                        <span class="text-xs text-gray-500 font-medium">Not configured</span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-xs text-gray-500">Last updated</p>
                        <p class="text-sm font-medium text-gray-900">{{ now()->format('H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Modules Overview -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Admin Modules</h3>
                <div class="flex items-center text-sm text-green-600">
                    <x-heroicon-m-check-circle class="h-4 w-4 mr-2"/>
                    Production Ready
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach([
                    ['name' => 'Cities Management', 'desc' => 'Kelola kota & provinsi', 'icon' => 'building-office-2', 'color' => 'blue', 'progress' => 100, 'status' => 'Completed'],
                    ['name' => 'Cinemas Management', 'desc' => 'Kelola bioskop & studio', 'icon' => 'building-storefront', 'color' => 'purple', 'progress' => 100, 'status' => 'Completed'],
                    ['name' => 'Movies Management', 'desc' => 'Kelola film & catalog', 'icon' => 'film', 'color' => 'pink', 'progress' => 100, 'status' => 'Completed'],
                    ['name' => 'Showtimes Management', 'desc' => 'Atur jadwal tayang', 'icon' => 'calendar-days', 'color' => 'indigo', 'progress' => 100, 'status' => 'Completed'],
                    ['name' => 'Orders Management', 'desc' => 'Kelola pemesanan tiket', 'icon' => 'shopping-bag', 'color' => 'green', 'progress' => 100, 'status' => 'Completed'],
                    ['name' => 'Users Management', 'desc' => 'Kelola pengguna sistem', 'icon' => 'users', 'color' => 'orange', 'progress' => 100, 'status' => 'Completed'],
                ] as $module)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-{{ $module['color'] }}-200 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-{{ $module['color'] }}-100 rounded-lg flex items-center justify-center mr-3">
                                <x-dynamic-component :component="'heroicon-o-'.$module['icon']" class="h-5 w-5 text-{{ $module['color'] }}-600"/>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $module['name'] }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $module['desc'] }}</p>
                            </div>
                        </div>
                        <span class="inline-block py-1 px-2 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                            {{ $module['status'] ?? $module['progress'].'%' }}
                        </span>
                    </div>
                    <div class="mt-3">
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-{{ $module['color'] }}-500 h-1.5 rounded-full" style="width: {{ $module['progress'] }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Authentication Test Info -->
        <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-heroicon-s-check-circle class="h-5 w-5 text-green-400"/>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Authentication Working!</h3>
                    <div class="mt-2 text-sm text-green-700">
                        <p>✅ Admin authentication berhasil diimplementasi</p>
                        <p>✅ Middleware admin protection aktif</p>
                        <p>✅ Admin user berhasil login: <strong>{{ Auth::user()->email }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
@endsection
