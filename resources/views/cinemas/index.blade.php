@extends('layouts.public')

@section('title', 'Daftar Bioskop - ' . config('app.name', '7PLAY'))

@section('description', 'Temukan bioskop terdekat dengan mudah. Lihat lokasi, fasilitas, dan jadwal film di berbagai bioskop di seluruh Indonesia.')

@section('content')
    <!-- Hero Section -->
    <section class="relative py-20 bg-gradient-to-br from-cinema-600 via-cinema-700 to-cinema-800">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-white mb-6">
                Daftar Bioskop
            </h1>
            <p class="text-xl text-cinema-100 max-w-2xl mx-auto">
                Temukan bioskop terdekat dan nikmati pengalaman menonton yang tak terlupakan
            </p>
        </div>
    </section>

    <!-- Search & Filter Section -->
    <section class="py-8 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6 items-center">
                
                <!-- Search Bar -->
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input 
                            type="text" 
                            placeholder="Cari bioskop atau lokasi..." 
                            class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:border-cinema-500 transition-all duration-200"
                        >
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 i-solar-magnifer-bold w-5 h-5 text-gray-400"></span>
                    </div>
                </div>

                <!-- City Filter -->
                <div class="relative">
                    <select class="appearance-none bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-6 py-3 pr-10 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:border-cinema-500 transition-all duration-200">
                        <option value="">Semua Kota</option>
                        <option value="jakarta">Jakarta</option>
                        <option value="bandung">Bandung</option>
                        <option value="surabaya">Surabaya</option>
                        <option value="medan">Medan</option>
                    </select>
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 i-solar-alt-arrow-down-line-duotone w-4 h-4 text-gray-400"></span>
                </div>

                <!-- View Toggle -->
                <div class="flex bg-gray-100 dark:bg-gray-800 rounded-xl p-1">
                    <button class="px-4 py-2 rounded-lg bg-cinema-600 text-white font-medium transition-all duration-200">
                        <span class="i-solar-widget-bold w-4 h-4"></span>
                    </button>
                    <button class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:text-cinema-600 dark:hover:text-cinema-400 transition-all duration-200">
                        <span class="i-solar-list-bold w-4 h-4"></span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Cinemas Grid -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @foreach($cinemas ?? [] as $cinema)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 group">
                        
                        <!-- Cinema Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img 
                                src="{{ $cinema['image'] ?? 'https://via.placeholder.com/400x200' }}" 
                                alt="{{ $cinema['name'] }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            
                            <!-- Cinema Chain Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-cinema-600 text-white text-sm font-semibold rounded-full">
                                    {{ $cinema['chain'] ?? 'Cinema' }}
                                </span>
                            </div>
                        </div>

                        <!-- Cinema Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ $cinema['name'] }}
                            </h3>
                            
                            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 mb-4">
                                <span class="i-solar-map-point-bold w-4 h-4"></span>
                                <span class="text-sm">{{ $cinema['location'] }}</span>
                            </div>

                            <!-- Facilities -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach($cinema['facilities'] ?? [] as $facility)
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-lg">
                                        {{ $facility }}
                                    </span>
                                @endforeach
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-3">
                                <button class="flex-1 px-4 py-2 bg-cinema-600 hover:bg-cinema-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                    Lihat Jadwal
                                </button>
                                <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
                                    <span class="i-solar-map-point-bold w-4 h-4"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Sample Cinema Cards (if no data) -->
                @if(empty($cinemas))
                    @for($i = 1; $i <= 6; $i++)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 group">
                            
                            <!-- Cinema Image -->
                            <div class="relative h-48 overflow-hidden">
                                <img 
                                    src="https://via.placeholder.com/400x200/6366f1/ffffff?text=Cinema+{{ $i }}" 
                                    alt="Cinema {{ $i }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                
                                <!-- Cinema Chain Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-cinema-600 text-white text-sm font-semibold rounded-full">
                                        CGV
                                    </span>
                                </div>
                            </div>

                            <!-- Cinema Info -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                    CGV Grand Indonesia
                                </h3>
                                
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 mb-4">
                                    <span class="i-solar-map-point-bold w-4 h-4"></span>
                                    <span class="text-sm">Jakarta Pusat</span>
                                </div>

                                <!-- Facilities -->
                                <div class="flex flex-wrap gap-2 mb-6">
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-lg">
                                        IMAX
                                    </span>
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-lg">
                                        4DX
                                    </span>
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-lg">
                                        Dolby Atmos
                                    </span>
                                </div>

                                <!-- Actions -->
                                <div class="flex space-x-3">
                                    <button class="flex-1 px-4 py-2 bg-cinema-600 hover:bg-cinema-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                        Lihat Jadwal
                                    </button>
                                    <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
                                        <span class="i-solar-map-point-bold w-4 h-4"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-12">
                <button class="px-8 py-3 bg-cinema-600 hover:bg-cinema-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    Muat Lebih Banyak
                </button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[placeholder="Cari bioskop atau lokasi..."]');
        const citySelect = document.querySelector('select');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                // Implement search logic here
                console.log('Searching for:', this.value);
            });
        }
        
        if (citySelect) {
            citySelect.addEventListener('change', function() {
                // Implement filter logic here
                console.log('Filter by city:', this.value);
            });
        }
    });
</script>
@endpush


