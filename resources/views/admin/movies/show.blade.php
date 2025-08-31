@extends('admin.layouts.app')

@section('title', 'Detail Film - ' . $movie->title)

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('admin.movies.index') }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
                Kembali ke Daftar Film
            </a>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <x-heroicon-o-eye class="w-8 h-8 text-indigo-600" />
                    {{ $movie->title }}
                </h1>
                <p class="mt-2 text-gray-600">Detail informasi film</p>
            </div>
            <div class="mt-4 sm:mt-0 flex gap-2">
                <a href="{{ route('admin.movies.edit', $movie) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-heroicon-o-pencil-square class="w-4 h-4 mr-2" />
                    Edit Film
                </a>
                <button onclick="toggleStatus({{ $movie->id }}, '{{ $movie->title }}')"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    @if($movie->is_active)
                        <x-heroicon-o-eye-slash class="w-4 h-4 mr-2" />
                        Nonaktifkan
                    @else
                        <x-heroicon-o-eye class="w-4 h-4 mr-2" />
                        Aktifkan
                    @endif
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Movie Poster & Status -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Poster -->
                <div class="aspect-w-2 aspect-h-3 bg-gray-200">
                    @if($movie->poster_url)
                        <img src="{{ $movie->poster_url }}" 
                             alt="{{ $movie->title }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-96 bg-gray-100">
                            <x-heroicon-o-film class="w-20 h-20 text-gray-400" />
                        </div>
                    @endif
                </div>

                <!-- Status & Quick Info -->
                <div class="p-6">
                    <!-- Status Badges -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        @php $badge = $movie->getStatusBadge() @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badge['class'] }}">
                            <x-heroicon-o-clock class="w-4 h-4 mr-1" />
                            {{ $badge['text'] }}
                        </span>
                        @if($movie->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <x-heroicon-o-check-circle class="w-4 h-4 mr-1" />
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <x-heroicon-o-x-circle class="w-4 h-4 mr-1" />
                                Tidak Aktif
                            </span>
                        @endif
                    </div>

                    <!-- Quick Info -->
                    <div class="space-y-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <x-heroicon-o-star class="w-4 h-4 mr-2" />
                            <span class="font-medium">Rating:</span>
                            <span class="ml-1">{{ $movie->rating }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <x-heroicon-o-clock class="w-4 h-4 mr-2" />
                            <span class="font-medium">Durasi:</span>
                            <span class="ml-1">{{ $movie->getFormattedDuration() }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <x-heroicon-o-calendar class="w-4 h-4 mr-2" />
                            <span class="font-medium">Rilis:</span>
                            <span class="ml-1">{{ $movie->release_date->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <x-heroicon-o-globe-asia-australia class="w-4 h-4 mr-2" />
                            <span class="font-medium">Bahasa:</span>
                            <span class="ml-1">{{ $movie->language }}</span>
                        </div>
                    </div>

                    <!-- Trailer Button -->
                    @if($movie->trailer_url)
                        <div class="mt-4">
                            <a href="{{ $movie->trailer_url }}" 
                               target="_blank"
                               class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <x-heroicon-o-play class="w-4 h-4 mr-2" />
                                Tonton Trailer
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Movie Details -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Informasi Film</h2>
                </div>

                <div class="p-6 space-y-8">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $movie->title }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Sutradara</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $movie->director }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Genre</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $movie->genre }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rating</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $movie->rating }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Durasi</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $movie->getFormattedDuration() }} ({{ $movie->duration }} menit)</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bahasa</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $movie->language }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Rilis</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $movie->release_date->format('d F Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status Tayang</label>
                                @php $badge = $movie->getStatusBadge() @endphp
                                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge['class'] }}">
                                    {{ $badge['text'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Synopsis -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Sinopsis</h3>
                        <div class="prose prose-sm max-w-none">
                            <p class="text-gray-700 leading-relaxed">{{ $movie->synopsis }}</p>
                        </div>
                    </div>

                    <!-- Cast -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pemeran</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($movie->cast as $actor)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <x-heroicon-o-user class="w-4 h-4 mr-1" />
                                    {{ $actor }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Media URLs -->
                    @if($movie->poster_url || $movie->trailer_url)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Media</h3>
                            <div class="space-y-3">
                                @if($movie->poster_url)
                                    <div class="flex items-center gap-3">
                                        <x-heroicon-o-photo class="w-5 h-5 text-gray-400" />
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">Poster URL</p>
                                            <a href="{{ $movie->poster_url }}" 
                                               target="_blank" 
                                               class="text-sm text-indigo-600 hover:text-indigo-900 truncate block max-w-md">
                                                {{ $movie->poster_url }}
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @if($movie->trailer_url)
                                    <div class="flex items-center gap-3">
                                        <x-heroicon-o-play-circle class="w-5 h-5 text-gray-400" />
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">Trailer URL</p>
                                            <a href="{{ $movie->trailer_url }}" 
                                               target="_blank" 
                                               class="text-sm text-indigo-600 hover:text-indigo-900 truncate block max-w-md">
                                                {{ $movie->trailer_url }}
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- System Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Sistem</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">ID Film</label>
                                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $movie->id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status Aktif</label>
                                <p class="mt-1 text-sm">
                                    @if($movie->is_active)
                                        <span class="text-green-600 font-medium">✓ Aktif</span>
                                    @else
                                        <span class="text-red-600 font-medium">✗ Tidak Aktif</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dibuat</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $movie->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Terakhir Diperbarui</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $movie->updated_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Showtimes Section -->
    @if($movie->showtimes->count() > 0)
        <div class="mt-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                        <x-heroicon-o-calendar-days class="w-5 h-5" />
                        Jadwal Tayang ({{ $movie->showtimes->count() }})
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($movie->showtimes->take(6) as $showtime)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="mb-2">
                                    <h4 class="font-medium text-gray-900">{{ $showtime->cinemaHall->cinema->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $showtime->cinemaHall->cinema->city->name }}</p>
                                </div>
                                <div class="text-sm text-gray-600 space-y-1">
                                    <p>Hall: {{ $showtime->cinemaHall->name }}</p>
                                    <p>Tanggal: {{ $showtime->show_date->format('d M Y') }}</p>
                                    <p>Jam: {{ $showtime->show_time->format('H:i') }}</p>
                                    <p>Harga: Rp {{ number_format($showtime->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($movie->showtimes->count() > 6)
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-600">Dan {{ $movie->showtimes->count() - 6 }} jadwal lainnya...</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="mt-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                        <x-heroicon-o-calendar-days class="w-5 h-5" />
                        Jadwal Tayang
                    </h2>
                </div>
                <div class="p-6 text-center">
                    <x-heroicon-o-calendar-x class="mx-auto h-12 w-12 text-gray-400 mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Jadwal Tayang</h3>
                    <p class="text-gray-600 mb-4">Film ini belum memiliki jadwal tayang di bioskop manapun.</p>
                    <a href="#" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                        Tambah Jadwal Tayang
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

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
</script>
@endpush
@endsection
