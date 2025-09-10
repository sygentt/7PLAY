@extends('layouts.public')

@section('title', 'Daftar Film')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-cinema-600 dark:hover:text-cinema-400 transition-colors duration-200">
                Beranda
            </a>
            <x-heroicon-o-chevron-right class="w-4 h-4" />
            <span class="text-gray-900 dark:text-gray-100 font-medium">Daftar Film</span>
        </nav>

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-xl flex items-center justify-center">
                    <x-heroicon-o-play class="w-6 h-6 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">
                        Daftar Film
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        Jelajahi koleksi film terbaik kami
                    </p>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-xl">
                    <button 
                        onclick="setMovieFilter('now_playing')"
                        class="movie-tab px-6 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request('status') == 'now_playing' || !request('status') ? 'bg-white dark:bg-gray-700 text-cinema-600 dark:text-cinema-400 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}"
                        data-status="now_playing"
                    >
                        Lagi Tayang
                    </button>
                    <button 
                        onclick="setMovieFilter('coming_soon')"
                        class="movie-tab px-6 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request('status') == 'coming_soon' ? 'bg-white dark:bg-gray-700 text-cinema-600 dark:text-cinema-400 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}"
                        data-status="coming_soon"
                    >
                        Akan Tayang
                    </button>
                </div>

                <!-- View Toggle -->
                <div class="flex items-center space-x-2">
                    <div class="flex items-center space-x-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg">
                        <button 
                            onclick="setViewMode('grid')" 
                            id="grid-view-btn"
                            class="view-toggle p-2 text-gray-600 dark:text-gray-400 hover:text-cinema-600 dark:hover:text-cinema-400 rounded-md transition-all duration-200 bg-white dark:bg-gray-700 shadow-sm"
                        >
                            <x-heroicon-o-squares-2x2 class="w-5 h-5" />
                        </button>
                        <button 
                            onclick="setViewMode('list')" 
                            id="list-view-btn"
                            class="view-toggle p-2 text-gray-600 dark:text-gray-400 hover:text-cinema-600 dark:hover:text-cinema-400 rounded-md transition-all duration-200"
                        >
                            <x-heroicon-o-bars-3 class="w-5 h-5" />
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Search and Filters -->
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1 relative">
                    <x-heroicon-o-magnifying-glass class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                    <input type="text" 
                           name="search" 
                           id="search-input"
                           placeholder="Cari film..."
                           value="{{ request('search') }}"
                           class="w-full pl-11 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-cinema-500/50 focus:border-cinema-500 transition-all duration-200 text-sm">
                </div>
                
                <select name="sort" 
                        id="sort-select"
                        class="px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-cinema-500/50 focus:border-cinema-500 transition-all duration-200 text-sm min-w-[200px]">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Tanggal tayang: terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Tanggal tayang: terlama</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul: A-Z</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating tertinggi</option>
                </select>
            </div>
        </div>

        <!-- Movies Grid/List Container -->
        <div id="movies-container">
            
            <!-- Grid View -->
            <div id="grid-view" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @forelse($movies as $movie)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 dark:border-gray-700 overflow-hidden group">
                        @auth
                            <a href="{{ route('movies.show', $movie) }}" class="block h-full">
                        @else
                            <div onclick="openAuthModal('login')" class="block h-full cursor-pointer">
                        @endauth
                            
                            <!-- Movie Poster -->
                            <div class="relative aspect-[2/3] overflow-hidden">
                                @if($movie->poster_url)
                                    <img src="{{ $movie->poster_url }}" 
                                         alt="{{ $movie->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <img src="https://dummyimage.com/300x450/374151/ffffff?text={{ urlencode($movie->title) }}" 
                                         alt="{{ $movie->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @endif
                                
                                <!-- Favorite Button (overlay) -->
                                <div class="absolute top-3 right-3 z-10">
                                    <x-movie.favorite-button :movie-id="$movie->id" :is-favorited="in_array($movie->id, $favoriteIds ?? [])" />
                                </div>

                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="absolute bottom-4 left-4 right-4">
                                        <div class="w-full py-2 bg-cinema-600 hover:bg-cinema-700 text-white font-semibold rounded-lg transition-colors duration-200 transform translate-y-4 group-hover:translate-y-0 text-center text-sm">
                                            {{ auth()->check() ? 'Beli Tiket' : 'Login untuk Beli Tiket' }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div class="absolute top-3 left-3">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-black/60 backdrop-blur-sm text-white">
                                        {{ $movie->getStatusBadge()['text'] }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Movie Info -->
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-cinema-600 dark:group-hover:text-cinema-400 transition-colors duration-200">
                                    {{ $movie->title }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-1">
                                    {{ $movie->genre }}
                                </p>
                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center space-x-1">
                                        <x-heroicon-o-clock class="w-4 h-4" />
                                        <span>{{ $movie->getFormattedDuration() }}</span>
                                    </div>
                                    @if($movie->rating)
                                        <div class="flex items-center space-x-1">
                                            <x-heroicon-o-star class="w-4 h-4 text-yellow-400" />
                                            <span>{{ $movie->rating }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                        @auth
                            </a>
                        @else
                            </div>
                        @endauth
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <x-heroicon-o-film class="w-12 h-12 text-gray-400" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Tidak Ada Film</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Belum ada film yang sesuai dengan filter pencarian Anda.
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- List View -->
            <div id="list-view" class="hidden space-y-4">
                @forelse($movies as $movie)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 overflow-hidden group">
                        @auth
                            <a href="{{ route('movies.show', $movie) }}" class="block">
                        @else
                            <div onclick="openAuthModal('login')" class="block cursor-pointer">
                        @endauth
                            
                            <div class="flex p-6">
                                <!-- Movie Poster -->
                                <div class="relative w-24 h-36 flex-shrink-0 rounded-xl overflow-hidden">
                                    @if($movie->poster_url)
                                        <img src="{{ $movie->poster_url }}" 
                                             alt="{{ $movie->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <img src="https://dummyimage.com/120x180/374151/ffffff?text={{ urlencode(substr($movie->title, 0, 8)) }}" 
                                             alt="{{ $movie->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @endif

                                    <!-- Favorite Button (overlay) -->
                                    <div class="absolute top-2 right-2 z-10">
                                        <x-movie.favorite-button :movie-id="$movie->id" :is-favorited="in_array($movie->id, $favoriteIds ?? [])" />
                                    </div>
                                </div>
                                
                                <!-- Movie Details -->
                                <div class="flex-1 ml-6">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-cinema-600 dark:group-hover:text-cinema-400 transition-colors duration-200">
                                                {{ $movie->title }}
                                            </h3>
                                            
                                            <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400 mb-3">
                                                <div class="flex items-center space-x-1">
                                                    <x-heroicon-o-film class="w-4 h-4" />
                                                    <span>{{ $movie->genre }}</span>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <x-heroicon-o-clock class="w-4 h-4" />
                                                    <span>{{ $movie->getFormattedDuration() }}</span>
                                                </div>
                                                @if($movie->rating)
                                                    <div class="flex items-center space-x-1">
                                                        <x-heroicon-o-star class="w-4 h-4 text-yellow-400" />
                                                        <span>{{ $movie->rating }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            @if($movie->synopsis)
                                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-4">
                                                    {{ Str::limit($movie->synopsis, 160) }}
                                                </p>
                                            @endif
                                            
                                            <div class="flex items-center space-x-3">
                                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $movie->getStatusBadge()['class'] }}">
                                                    {{ $movie->getStatusBadge()['text'] }}
                                                </span>
                                                @if($movie->director)
                                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                                        Dir: {{ $movie->director }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Action Button -->
                                        <div class="ml-4">
                                            <div class="px-6 py-2.5 bg-gradient-to-r from-cinema-600 to-cinema-700 hover:from-cinema-700 hover:to-cinema-800 text-white font-semibold rounded-xl transition-all duration-200 text-sm">
                                                {{ auth()->check() ? 'Beli Tiket' : 'Login' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        @auth
                            </a>
                        @else
                            </div>
                        @endauth
                    </div>
                @empty
                    <div class="text-center py-16">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <x-heroicon-o-film class="w-12 h-12 text-gray-400" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Tidak Ada Film</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Belum ada film yang sesuai dengan filter pencarian Anda.
                        </p>
                    </div>
                @endforelse
            </div>
            
        </div>

        <!-- Pagination -->
        @if($movies->hasPages())
            <div class="mt-12 flex justify-center">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-4">
                    {{ $movies->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Movie filter and view functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const sortSelect = document.getElementById('sort-select');
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');
        const gridViewBtn = document.getElementById('grid-view-btn');
        const listViewBtn = document.getElementById('list-view-btn');
        
        // Load saved view mode from localStorage
        const savedViewMode = localStorage.getItem('movieViewMode') || 'grid';
        setViewMode(savedViewMode);
        
        // Search functionality with debounce
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                updateFilters();
            }, 500); // Debounce 500ms
        });
        
        // Sort change handler
        sortSelect.addEventListener('change', updateFilters);
        
        function updateFilters() {
            const url = new URL(window.location);
            const searchValue = searchInput.value.trim();
            const sortValue = sortSelect.value;
            
            // Set parameters
            if (searchValue) {
                url.searchParams.set('search', searchValue);
            } else {
                url.searchParams.delete('search');
            }
            
            if (sortValue && sortValue !== 'latest') {
                url.searchParams.set('sort', sortValue);
            } else {
                url.searchParams.delete('sort');
            }
            
            // Maintain current status filter
            const currentStatus = new URLSearchParams(window.location.search).get('status');
            if (currentStatus) {
                url.searchParams.set('status', currentStatus);
            }
            
            window.location.href = url.toString();
        }
    });
    
    // Set movie filter (tabs)
    function setMovieFilter(status) {
        const url = new URL(window.location);
        
        if (status && status !== 'now_playing') {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }
        
        window.location.href = url.toString();
    }
    
    // Set view mode (grid/list)
    function setViewMode(mode) {
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');
        const gridViewBtn = document.getElementById('grid-view-btn');
        const listViewBtn = document.getElementById('list-view-btn');
        
        if (!gridView || !listView) return;
        
        // Save to localStorage
        localStorage.setItem('movieViewMode', mode);
        
        if (mode === 'grid') {
            // Show grid, hide list
            gridView.classList.remove('hidden');
            listView.classList.add('hidden');
            
            // Update button states
            gridViewBtn.classList.add('bg-white', 'dark:bg-gray-700', 'shadow-sm', 'text-cinema-600', 'dark:text-cinema-400');
            gridViewBtn.classList.remove('text-gray-600', 'dark:text-gray-400');
            
            listViewBtn.classList.remove('bg-white', 'dark:bg-gray-700', 'shadow-sm', 'text-cinema-600', 'dark:text-cinema-400');
            listViewBtn.classList.add('text-gray-600', 'dark:text-gray-400');
        } else {
            // Show list, hide grid
            gridView.classList.add('hidden');
            listView.classList.remove('hidden');
            
            // Update button states
            listViewBtn.classList.add('bg-white', 'dark:bg-gray-700', 'shadow-sm', 'text-cinema-600', 'dark:text-cinema-400');
            listViewBtn.classList.remove('text-gray-600', 'dark:text-gray-400');
            
            gridViewBtn.classList.remove('bg-white', 'dark:bg-gray-700', 'shadow-sm', 'text-cinema-600', 'dark:text-cinema-400');
            gridViewBtn.classList.add('text-gray-600', 'dark:text-gray-400');
        }
    }
    
    // Enhanced search with Enter key support
    document.addEventListener('keydown', function(e) {
        if (e.target.id === 'search-input' && e.key === 'Enter') {
            e.preventDefault();
            const searchInput = document.getElementById('search-input');
            const url = new URL(window.location);
            
            const searchValue = searchInput.value.trim();
            if (searchValue) {
                url.searchParams.set('search', searchValue);
            } else {
                url.searchParams.delete('search');
            }
            
            window.location.href = url.toString();
        }
    });
</script>

<!-- Custom Styles -->
<style>
    /* Line clamp utilities */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Custom scrollbar for webkit browsers */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    ::-webkit-scrollbar-track {
        background: rgb(243 244 246);
    }
    
    .dark ::-webkit-scrollbar-track {
        background: rgb(31 41 55);
    }
    
    ::-webkit-scrollbar-thumb {
        background: rgb(209 213 219);
        border-radius: 3px;
    }
    
    .dark ::-webkit-scrollbar-thumb {
        background: rgb(75 85 99);
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: rgb(156 163 175);
    }
    
    .dark ::-webkit-scrollbar-thumb:hover {
        background: rgb(107 114 128);
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        #grid-view {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
    }
    
    @media (max-width: 480px) {
        #grid-view {
            grid-template-columns: repeat(1, 1fr);
        }
        
        #list-view .flex {
            flex-direction: column;
        }
        
        #list-view .ml-6 {
            margin-left: 0;
            margin-top: 1rem;
        }
        
        #list-view .w-24 {
            width: 100%;
            height: 12rem;
            max-width: 8rem;
            margin: 0 auto;
        }
    }
</style>
@endpush
