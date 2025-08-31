@extends('admin.layouts.app')

@section('title', 'Kelola Jadwal Tayang')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <x-heroicon-o-calendar-days class="w-8 h-8 text-indigo-600" />
                Kelola Jadwal Tayang
            </h1>
            <p class="mt-2 text-gray-600">Kelola jadwal tayang film di semua bioskop</p>
        </div>
        <a href="{{ route('admin.showtimes.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
            <x-heroicon-o-plus class="w-4 h-4 mr-2" />
            Tambah Jadwal
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-calendar-days class="h-6 w-6 text-gray-400" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Jadwal</dt>
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
                        <x-heroicon-o-clock class="h-6 w-6 text-blue-400" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Hari Ini</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['today']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-arrow-trending-up class="h-6 w-6 text-green-400" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Mendatang</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['upcoming']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-archive-box class="h-6 w-6 text-gray-400" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['past']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Cari Film/Cinema</label>
                    <div class="mt-1 relative">
                        <input type="text" 
                               name="search" 
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Nama film atau bioskop..."
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
                        </div>
                    </div>
                </div>

                <!-- Movie Filter -->
                <div>
                    <label for="movie_id" class="block text-sm font-medium text-gray-700">Film</label>
                    <select name="movie_id" id="movie_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Film</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" {{ request('movie_id') == $movie->id ? 'selected' : '' }}>
                                {{ $movie->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- City Filter -->
                <div>
                    <label for="city_id" class="block text-sm font-medium text-gray-700">Kota</label>
                    <select name="city_id" id="city_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Cinema Filter -->
                <div>
                    <label for="cinema_id" class="block text-sm font-medium text-gray-700">Bioskop</label>
                    <select name="cinema_id" id="cinema_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Bioskop</option>
                        @foreach($cinemas as $cinema)
                            <option value="{{ $cinema->id }}" {{ request('cinema_id') == $cinema->id ? 'selected' : '' }}>
                                {{ $cinema->name }} - {{ $cinema->city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Filter -->
                <div>
                    <label for="date_filter" class="block text-sm font-medium text-gray-700">Periode</label>
                    <select name="date_filter" id="date_filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Periode</option>
                        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="tomorrow" {{ request('date_filter') == 'tomorrow' ? 'selected' : '' }}>Besok</option>
                        <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="upcoming" {{ request('date_filter') == 'upcoming' ? 'selected' : '' }}>Mendatang</option>
                        <option value="past" {{ request('date_filter') == 'past' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <!-- Active Status Filter -->
                <div>
                    <label for="active_status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="active_status" id="active_status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Status</option>
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
                <a href="{{ route('admin.showtimes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 transition ease-in-out duration-150">
                    <x-heroicon-o-arrow-path class="w-4 h-4 mr-2" />
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Showtimes Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        @if($showtimes->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Film & Studio
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal & Waktu
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kursi
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($showtimes as $showtime)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-12">
                                            @if($showtime->movie->poster_url)
                                                <img class="h-16 w-12 rounded object-cover" src="{{ $showtime->movie->poster_url }}" alt="{{ $showtime->movie->title }}">
                                            @else
                                                <div class="h-16 w-12 rounded bg-gray-100 flex items-center justify-center">
                                                    <x-heroicon-o-film class="h-6 w-6 text-gray-400" />
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $showtime->movie->title }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $showtime->cinemaHall->cinema->name }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $showtime->cinemaHall->name }} - {{ $showtime->cinemaHall->cinema->city->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $showtime->getFormattedDate() }}</div>
                                    <div class="text-sm text-gray-500">{{ $showtime->getFormattedTime() }}</div>
                                    @if($showtime->hasPassed())
                                        <div class="text-xs text-red-500 font-medium">Sudah Lewat</div>
                                    @elseif($showtime->isToday())
                                        <div class="text-xs text-blue-500 font-medium">Hari Ini</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $showtime->getFormattedPrice() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        @if($showtime->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <x-heroicon-o-check-circle class="w-3 h-3 mr-1" />
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <x-heroicon-o-x-circle class="w-3 h-3 mr-1" />
                                                Tidak Aktif
                                            </span>
                                        @endif
                                        
                                        @php $bookingStatus = $showtime->getBookingStatus() @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bookingStatus['class'] }}">
                                            {{ $bookingStatus['text'] }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="text-sm">{{ $showtime->getAvailableSeatsCount() }}/{{ $showtime->cinemaHall->total_seats }}</div>
                                    <div class="text-xs text-gray-500">tersisa</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.showtimes.show', $showtime) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 p-1 rounded">
                                            <x-heroicon-o-eye class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('admin.showtimes.edit', $showtime) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 p-1 rounded">
                                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                                        </a>
                                        <button onclick="toggleStatus({{ $showtime->id }})"
                                                class="text-gray-600 hover:text-gray-900 p-1 rounded">
                                            @if($showtime->is_active)
                                                <x-heroicon-o-eye-slash class="w-4 h-4" />
                                            @else
                                                <x-heroicon-o-eye class="w-4 h-4" />
                                            @endif
                                        </button>
                                        <button onclick="deleteShowtime({{ $showtime->id }}, '{{ $showtime->movie->title }}', '{{ $showtime->getFormattedDateTime() }}')"
                                                class="text-red-600 hover:text-red-900 p-1 rounded">
                                            <x-heroicon-o-trash class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $showtimes->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <x-heroicon-o-calendar-days class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada jadwal tayang</h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ request()->anyFilled(['search', 'movie_id', 'city_id', 'cinema_id', 'date_filter', 'active_status']) 
                        ? 'Tidak ada jadwal tayang yang sesuai dengan filter yang dipilih.' 
                        : 'Mulai dengan menambahkan jadwal tayang baru.' }}
                </p>
                @if(!request()->anyFilled(['search', 'movie_id', 'city_id', 'cinema_id', 'date_filter', 'active_status']))
                    <div class="mt-6">
                        <a href="{{ route('admin.showtimes.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                            Tambah Jadwal Tayang
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Delete Showtime Form -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    function toggleStatus(showtimeId) {
        if (confirm('Apakah Anda yakin ingin mengubah status jadwal tayang ini?')) {
            fetch(`{{ url('admin/showtimes') }}/${showtimeId}/toggle-status`, {
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
                alert('Terjadi kesalahan saat mengubah status jadwal tayang.');
            });
        }
    }

    function deleteShowtime(showtimeId, movieTitle, dateTime) {
        if (confirm(`Apakah Anda yakin ingin menghapus jadwal tayang "${movieTitle}" pada ${dateTime}?\n\nPerhatian: Jadwal yang sudah ada reservasi tidak dapat dihapus.`)) {
            const form = document.getElementById('delete-form');
            form.action = `{{ url('admin/showtimes') }}/${showtimeId}`;
            form.submit();
        }
    }
</script>
@endpush
@endsection
