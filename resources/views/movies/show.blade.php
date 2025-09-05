@extends('layouts.public')

@section('title', $movie->title . ' - Detail Film')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- Breadcrumb -->
        <x-movie.breadcrumb :items="[
            ['title' => 'Beranda', 'url' => route('home')],
            ['title' => 'Film', 'url' => route('movies.index')],
            ['title' => $movie->title]
        ]" />

        <!-- Movie Header -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="relative">
                @php
                    $backdrop_url = $movie->poster_url ?: ('https://dummyimage.com/1600x900/e5e7eb/374151.jpg&text=' . urlencode($movie->title));
                @endphp
                <!-- Background Image + Gradient Overlay -->
                <div class="absolute inset-0">
                    <img src="{{ $backdrop_url }}" alt="{{ $movie->title }} background" class="w-full h-full object-cover scale-110 blur-2xl opacity-60 dark:opacity-50">
                    <div class="absolute inset-0 bg-gradient-to-b from-white/95 via-white/40 to-white dark:from-gray-900/95 dark:via-gray-900/50 dark:to-gray-900"></div>
                </div>

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
                                <div class="text-sm text-teal-600 dark:text-teal-400 mb-2">
                                    Tayang: {{ $movie->release_date->format('F d') }} | 
                                    Jual: {{ $movie->release_date->subDays(7)->format('F d') }}
                                </div>
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                            {{ $movie->title }}
                                        </h1>
                                        <div class="text-gray-600 dark:text-gray-300 mb-4">{{ $movie->genre }}</div>
                                    </div>
                                    @auth
                                    <div class="flex-shrink-0">
                                        <x-movie.favorite-button :movie-id="$movie->id" :is-favorited="$isFavorited" />
                                    </div>
                                    @endauth
                                </div>
                            </div>

                            <!-- Trailer Button -->
                            <div class="mb-6">
                                <x-movie.trailer-button :movie="$movie" />
                            </div>

                            <!-- Movie Synopsis (if available) -->
                            @if($movie->synopsis)
                                <div class="prose prose-gray dark:prose-invert max-w-none">
                                    <p class="text-gray-700 dark:text-gray-200">{{ Str::limit($movie->synopsis, 300) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur rounded-xl shadow-sm overflow-hidden">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex space-x-8 px-8" role="tablist">
                    <button role="tab" data-tab="schedule" aria-selected="true" class="py-4 px-1 border-b-2 border-teal-600 text-teal-600 dark:text-teal-400 font-medium text-sm">
                        Jadwal
                    </button>
                    <button role="tab" data-tab="details" aria-selected="false" class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 font-medium text-sm">
                        Detail
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-8">
                <!-- Schedule Tab -->
                <div id="tab-schedule">
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
                            <button class="flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
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
                                   class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Tidak Ada Jadwal Tersedia</h3>
                                <p class="text-gray-500 dark:text-gray-400">
                                    Tidak ada jadwal tayang untuk tanggal {{ $selectedDate->format('d F Y') }}. 
                                    Silakan pilih tanggal lain.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Details Tab -->
                <div id="tab-details" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Detail Film</h3>
                            <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                                <div class="py-3 flex justify-between">
                                    <dt class="text-gray-600 dark:text-gray-300">Judul</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $movie->title }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-gray-600 dark:text-gray-300">Genre</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $movie->genre }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-gray-600 dark:text-gray-300">Durasi</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $movie->getFormattedDuration() }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-gray-600 dark:text-gray-300">Klasifikasi Usia</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $movie->rating ?? '-' }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-gray-600 dark:text-gray-300">Bahasa</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $movie->language ?? '-' }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-gray-600 dark:text-gray-300">Tanggal Rilis</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100">{{ optional($movie->release_date)->format('d M Y') }}</dd>
                                </div>
                                <div class="py-3">
                                    <dt class="text-gray-600 dark:text-gray-300 mb-1">Sutradara</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $movie->director ?? '-' }}</dd>
                                </div>
                                <div class="py-3">
                                    <dt class="text-gray-600 dark:text-gray-300 mb-1">Pemeran</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100">{{ $movie->getCastString() ?: '-' }}</dd>
                                </div>
                            </dl>
                        </div>

                        @if($movie->synopsis)
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Sinopsis</h3>
                            <div class="prose prose-gray dark:prose-invert max-w-none">
                                <p class="text-gray-700 dark:text-gray-200">{{ $movie->synopsis }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tab switching functionality with content toggle
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('[role="tab"]');
        const scheduleTab = document.getElementById('tab-schedule');
        const detailsTab = document.getElementById('tab-details');

        function activateTab(target) {
            tabButtons.forEach(btn => {
                const isActive = btn.getAttribute('data-tab') === target;
                btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
                btn.classList.toggle('border-teal-600', isActive);
                btn.classList.toggle('text-teal-600', isActive);
                btn.classList.toggle('dark:text-teal-400', isActive);
                btn.classList.toggle('border-transparent', !isActive);
                btn.classList.toggle('text-gray-500', !isActive);
                btn.classList.toggle('dark:text-gray-400', !isActive);
            });

            if (target === 'schedule') {
                scheduleTab.classList.remove('hidden');
                detailsTab.classList.add('hidden');
            } else {
                detailsTab.classList.remove('hidden');
                scheduleTab.classList.add('hidden');
            }
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const target = this.getAttribute('data-tab');
                activateTab(target);
            });
        });
    });
</script>
@endpush
