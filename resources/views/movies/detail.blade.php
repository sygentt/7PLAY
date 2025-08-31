@extends('layouts.public')

@section('title', $movie['title'] . ' - ' . config('app.name', '7PLAY'))

@section('description', 'Tonton ' . $movie['title'] . ' di bioskop terdekat. Pesan tiket dengan mudah dan aman di 7PLAY.')

@section('content')
    <!-- Movie Hero Section -->
    <section class="relative min-h-screen flex items-center">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img 
                src="{{ $movie['backdrop'] ?? $movie['poster'] }}" 
                alt="{{ $movie['title'] }}"
                class="w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-center">
                
                <!-- Movie Poster -->
                <div class="lg:col-span-1 flex justify-center lg:justify-start">
                    <div class="relative group">
                        <img 
                            src="{{ $movie['poster'] }}" 
                            alt="{{ $movie['title'] }}"
                            class="w-80 h-auto rounded-2xl shadow-2xl group-hover:scale-105 transition-transform duration-300"
                        >
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                </div>

                <!-- Movie Info -->
                <div class="lg:col-span-2 text-white">
                    <!-- Title -->
                    <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                        {{ $movie['title'] }}
                    </h1>

                    <!-- Movie Details -->
                    <div class="flex flex-wrap items-center gap-6 mb-8">
                        <div class="flex items-center space-x-2">
                            <x-heroicon-o-star class="w-5 h-5 text-yellow-400" />
                            <span class="text-lg font-semibold">{{ $movie['rating'] }}/10</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <x-heroicon-o-clock class="w-5 h-5 text-gray-300" />
                            <span>{{ $movie['duration'] }} menit</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <x-heroicon-o-calendar-days class="w-5 h-5 text-gray-300" />
                            <span>{{ $movie['release_date'] }}</span>
                        </div>
                        <div class="px-3 py-1 bg-cinema-600 rounded-full text-sm font-medium">
                            {{ $movie['genre'] }}
                        </div>
                    </div>

                    <!-- Synopsis -->
                    <p class="text-lg leading-relaxed mb-8 text-gray-200 max-w-2xl">
                        {{ $movie['synopsis'] }}
                    </p>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button class="px-8 py-4 bg-gradient-to-r from-cinema-600 to-cinema-700 hover:from-cinema-700 hover:to-cinema-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center space-x-3">
                            <x-heroicon-o-ticket class="w-6 h-6" />
                            <span>Beli Tiket Sekarang</span>
                        </button>
                        <button class="px-8 py-4 bg-white/10 backdrop-blur-lg border border-white/20 text-white font-bold rounded-xl hover:bg-white/20 transition-all duration-300 flex items-center justify-center space-x-3">
                            <x-heroicon-o-play-circle class="w-6 h-6" />
                            <span>Tonton Trailer</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Movie Details Section -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- Cast & Crew -->
                <div class="lg:col-span-2">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
                        Pemeran & Kru
                    </h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($movie['cast'] ?? [] as $cast)
                            <div class="text-center group">
                                <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-gray-200 dark:bg-gray-700 group-hover:scale-110 transition-transform duration-200"></div>
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $cast['name'] }}</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-xs">{{ $cast['character'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Movie Info Sidebar -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
                        Informasi Film
                    </h2>
                    
                    <div class="space-y-6">
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Sutradara</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $movie['director'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Produser</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $movie['producer'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Studio</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $movie['studio'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Bahasa</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $movie['language'] ?? 'Bahasa Indonesia' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Showtimes Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">
                Jadwal Tayang
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($showtimes ?? [] as $cinema)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            {{ $cinema['name'] }}
                        </h3>
                        
                        <div class="space-y-3">
                            @foreach($cinema['times'] as $time)
                                <button class="w-full px-4 py-2 bg-cinema-50 dark:bg-cinema-900/20 text-cinema-600 dark:text-cinema-400 rounded-lg hover:bg-cinema-100 dark:hover:bg-cinema-900/40 transition-colors duration-200 font-medium">
                                    {{ $time }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Add any page-specific JavaScript here
    console.log('Movie detail page loaded');
</script>
@endpush


