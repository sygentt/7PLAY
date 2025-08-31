@extends('layouts.app')

@section('title', $movie->title . ' - Detail Film')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- Breadcrumb -->
        <x-movie.breadcrumb :items="[
            ['title' => 'Beranda', 'url' => route('home')],
            ['title' => 'Film', 'url' => route('movies.index')],
            ['title' => $movie->title]
        ]" />

        <!-- Movie Header -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="relative">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-gray-100"></div>
                
                <div class="relative p-8">
                    <!-- Advance Ticket Sales Badge -->
                    @if($movie->isComingSoon())
                        <div class="inline-block mb-4">
                            <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                Advance ticket sales
                            </span>
                        </div>
                    @endif

                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Movie Poster -->
                        <div class="flex-shrink-0">
                            <div class="w-48 h-72 bg-gray-200 rounded-lg overflow-hidden shadow-lg">
                                @if($movie->poster_url)
                                    <img src="{{ $movie->poster_url }}" 
                                         alt="{{ $movie->title }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <img src="https://dummyimage.com/300x450/374151/ffffff?text={{ urlencode($movie->title) }}" 
                                         alt="{{ $movie->title }}" 
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                        </div>

                        <!-- Movie Info -->
                        <div class="flex-1">
                            <!-- Movie Details -->
                            <div class="mb-4">
                                <div class="text-sm text-teal-600 mb-2">
                                    Tayang: {{ $movie->release_date->format('F d') }} | 
                                    Jual: {{ $movie->release_date->subDays(7)->format('F d') }}
                                </div>
                                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">
                                    {{ $movie->title }}
                                </h1>
                                <div class="text-gray-600 mb-4">{{ $movie->genre }}</div>
                            </div>

                            <!-- Trailer Button -->
                            <div class="mb-6">
                                <x-movie.trailer-button :movie="$movie" />
                            </div>

                            <!-- Movie Synopsis (if available) -->
                            @if($movie->synopsis)
                                <div class="prose prose-gray max-w-none">
                                    <p class="text-gray-700">{{ Str::limit($movie->synopsis, 300) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-8">
                    <button class="py-4 px-1 border-b-2 border-teal-600 text-teal-600 font-medium text-sm">
                        Jadwal
                    </button>
                    <button class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">
                        Detail
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-8">
                <!-- Date Selector -->
                <div class="mb-8">
                    <x-movie.date-selector 
                        :dates="$availableDates" 
                        :selectedDate="$selectedDate" 
                        :movieId="$movie->id" />
                </div>

                <!-- Search & Filter -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <!-- All Cinemas Filter -->
                        <button class="flex items-center bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Semua
                        </button>

                        <!-- Brand Filter (XXI example) -->
                        <button class="bg-black text-white rounded-lg px-4 py-2 text-sm font-medium">
                            Cinema XXI
                        </button>
                    </div>

                    <!-- Search -->
                    <div class="relative">
                        <input type="text" 
                               placeholder="Cari cinema..." 
                               class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Cinema Section -->
                <div class="space-y-4">
                    @forelse($cinemas as $cinema)
                        @php
                            $cinemaShowtimes = collect();
                            foreach($cinema->cinema_halls as $hall) {
                                $cinemaShowtimes = $cinemaShowtimes->merge($hall->showtimes);
                            }
                            $cinemaShowtimes = $cinemaShowtimes->sortBy('show_time');
                        @endphp
                        
                        <x-movie.cinema-card 
                            :cinema="$cinema" 
                            :showtimes="$cinemaShowtimes" />
                    @empty
                        <div class="text-center py-12">
                            <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Jadwal Tersedia</h3>
                            <p class="text-gray-500">
                                Tidak ada jadwal tayang untuk tanggal {{ $selectedDate->format('d F Y') }}. 
                                Silakan pilih tanggal lain.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('[role="tab"]');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active classes from all tabs
                tabButtons.forEach(tab => {
                    tab.classList.remove('border-teal-600', 'text-teal-600');
                    tab.classList.add('border-transparent', 'text-gray-500');
                });
                
                // Add active classes to clicked tab
                this.classList.remove('border-transparent', 'text-gray-500');
                this.classList.add('border-teal-600', 'text-teal-600');
            });
        });
    });
</script>
@endpush
