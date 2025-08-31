@extends('layouts.app')

@section('title', 'Daftar Film')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Daftar Film</h1>
            
            <!-- Filters -->
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           placeholder="Cari film, genre, atau sutradara..."
                           value="{{ request('search') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
                
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\Movie::getStatuses() as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Movies Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
            @forelse($movies as $movie)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <a href="{{ route('movies.show', $movie) }}" class="block">
                        <!-- Movie Poster -->
                        <div class="aspect-[2/3] bg-gray-200">
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
                        
                        <!-- Movie Info -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1 line-clamp-2">{{ $movie->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $movie->genre }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs {{ $movie->getStatusBadge()['class'] }} px-2 py-1 rounded-full">
                                    {{ $movie->getStatusBadge()['text'] }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $movie->getFormattedDuration() }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Film</h3>
                    <p class="text-gray-500">Belum ada film yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($movies->hasPages())
            <div class="mt-8">
                {{ $movies->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        const statusSelect = document.querySelector('select[name="status"]');
        
        function updateFilters() {
            const url = new URL(window.location);
            url.searchParams.set('search', searchInput.value);
            url.searchParams.set('status', statusSelect.value);
            
            // Remove empty parameters
            if (!searchInput.value) url.searchParams.delete('search');
            if (!statusSelect.value) url.searchParams.delete('status');
            
            window.location.href = url.toString();
        }
        
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                updateFilters();
            }
        });
        
        statusSelect.addEventListener('change', updateFilters);
    });
</script>
@endpush
