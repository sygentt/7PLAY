@extends('admin.layouts.app')

@section('title', 'Kelola Film')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <x-heroicon-o-film class="w-8 h-8 text-indigo-600" />
                Kelola Film
            </h1>
            <p class="mt-2 text-gray-600">Kelola film yang tersedia di bioskop</p>
        </div>
        <a href="{{ route('admin.movies.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
            <x-heroicon-o-plus class="w-4 h-4 mr-2" />
            Tambah Film
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-film class="h-6 w-6 text-gray-400" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Film</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['total']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-play class="h-6 w-6 text-green-400" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Sedang Tayang</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['now_playing']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-clock class="h-6 w-6 text-blue-400" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Coming Soon</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['coming_soon']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-check-circle class="h-6 w-6 text-gray-400" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Selesai Tayang</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['finished']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Cari Film</label>
                    <div class="mt-1 relative">
                        <input type="text" 
                               name="search" 
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Judul, sutradara, genre..."
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
                        </div>
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status Tayang</label>
                    <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Rating Filter -->
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                    <select name="rating" id="rating" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Rating</option>
                        @foreach($ratings as $key => $label)
                            <option value="{{ $key }}" {{ request('rating') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Active Status Filter -->
                <div>
                    <label for="active_status" class="block text-sm font-medium text-gray-700">Status Aktif</label>
                    <select name="active_status" id="active_status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua</option>
                        <option value="active" {{ request('active_status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('active_status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                    <x-heroicon-o-magnifying-glass class="w-4 h-4 mr-2" />
                    Cari
                </button>
                <a href="{{ route('admin.movies.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 transition ease-in-out duration-150">
                    <x-heroicon-o-arrow-path class="w-4 h-4 mr-2" />
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Movies Grid -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        @if($movies->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-6">
                @foreach($movies as $movie)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <!-- Movie Poster -->
                        <div class="aspect-w-2 aspect-h-3 bg-gray-200 rounded-t-lg overflow-hidden">
                            @if($movie->poster_url)
                                <img src="{{ $movie->poster_url }}" 
                                     alt="{{ $movie->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-48 bg-gray-100">
                                    <x-heroicon-o-film class="w-12 h-12 text-gray-400" />
                                </div>
                            @endif
                            
                            <!-- Status Badge -->
                            @php $badge = $movie->getStatusBadge() @endphp
                            <div class="absolute top-2 left-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge['class'] }}">
                                    {{ $badge['text'] }}
                                </span>
                            </div>

                            <!-- Active Status Badge -->
                            @if(!$movie->is_active)
                                <div class="absolute top-2 right-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Tidak Aktif
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Movie Info -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-1">{{ $movie->title }}</h3>
                            
                            <div class="space-y-2 text-sm text-gray-600 mb-4">
                                <div class="flex items-center gap-2">
                                    <x-heroicon-o-user class="w-4 h-4" />
                                    <span>{{ $movie->director }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-heroicon-o-film class="w-4 h-4" />
                                    <span>{{ $movie->genre }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-heroicon-o-clock class="w-4 h-4" />
                                    <span>{{ $movie->getFormattedDuration() }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-heroicon-o-star class="w-4 h-4" />
                                    <span>{{ $movie->rating }}</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.movies.show', $movie) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <x-heroicon-o-eye class="w-4 h-4 mr-1" />
                                    Detail
                                </a>
                                <a href="{{ route('admin.movies.edit', $movie) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <x-heroicon-o-pencil-square class="w-4 h-4 mr-1" />
                                    Edit
                                </a>
                                <button onclick="toggleStatus({{ $movie->id }}, '{{ $movie->title }}')"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    @if($movie->is_active)
                                        <x-heroicon-o-eye-slash class="w-4 h-4" />
                                    @else
                                        <x-heroicon-o-eye class="w-4 h-4" />
                                    @endif
                                </button>
                                <button onclick="deleteMovie({{ $movie->id }}, '{{ $movie->title }}')"
                                        class="inline-flex items-center px-3 py-2 border border-red-300 text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $movies->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <x-heroicon-o-film class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada film</h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ request()->anyFilled(['search', 'status', 'rating', 'active_status']) 
                        ? 'Tidak ada film yang sesuai dengan filter yang dipilih.' 
                        : 'Mulai dengan menambahkan film baru.' }}
                </p>
                @if(!request()->anyFilled(['search', 'status', 'rating', 'active_status']))
                    <div class="mt-6">
                        <a href="{{ route('admin.movies.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                            Tambah Film
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Delete Movie Form -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    function toggleStatus(movieId, movieTitle) {
        if (confirm(`Apakah Anda yakin ingin mengubah status film "${movieTitle}"?`)) {
            fetch(`{{ url('admin/movies') }}/${movieId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Terjadi kesalahan: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengubah status film.');
            });
        }
    }

    function deleteMovie(movieId, movieTitle) {
        if (confirm(`Apakah Anda yakin ingin menghapus film "${movieTitle}"?\n\nPerhatian: Film yang sudah memiliki jadwal tayang tidak dapat dihapus.`)) {
            const form = document.getElementById('delete-form');
            form.action = `{{ url('admin/movies') }}/${movieId}`;
            form.submit();
        }
    }
</script>
@endpush
@endsection
