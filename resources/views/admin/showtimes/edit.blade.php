@extends('admin.layouts.app')

@section('title', 'Edit Jadwal Tayang')
@section('page-title', 'Edit Jadwal Tayang')
@section('page-description', 'Edit informasi jadwal tayang film')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <x-heroicon-m-home class="mr-2 h-4 w-4"/>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="h-4 w-4 text-gray-400"/>
                        <a href="{{ route('admin.showtimes.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Showtimes</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="h-4 w-4 text-gray-400"/>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit {{ $showtime->movie->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Showtime</h1>
            <p class="mt-1 text-sm text-gray-600">Update jadwal tayang {{ $showtime->movie->title }}</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.showtimes.update', $showtime) }}" method="POST" class="divide-y divide-gray-200">
                @csrf
                @method('PUT')
                
                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Film & Bioskop</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Movie -->
                        <div>
                            <label for="movie_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Film <span class="text-red-500">*</span>
                            </label>
                            <select name="movie_id" 
                                    id="movie_id" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('movie_id') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Film</option>
                                @foreach(\App\Models\Movie::orderBy('title')->get() as $movie)
                                    <option value="{{ $movie->id }}" {{ old('movie_id', $showtime->movie_id) == $movie->id ? 'selected' : '' }}>
                                        {{ $movie->title }} ({{ $movie->duration }} menit)
                                    </option>
                                @endforeach
                            </select>
                            @error('movie_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cinema Hall -->
                        <div>
                            <label for="cinema_hall_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Studio <span class="text-red-500">*</span>
                            </label>
                            <select name="cinema_hall_id" 
                                    id="cinema_hall_id" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('cinema_hall_id') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Studio</option>
                                @foreach(\App\Models\CinemaHall::with('cinema.city')->orderBy('cinema_id')->get() as $hall)
                                    <option value="{{ $hall->id }}" {{ old('cinema_hall_id', $showtime->cinema_hall_id) == $hall->id ? 'selected' : '' }}>
                                        {{ $hall->cinema->brand }} {{ $hall->cinema->name }} - {{ $hall->name }} ({{ $hall->cinema->city->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('cinema_hall_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Jadwal & Harga</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Show Date -->
                        <div>
                            <label for="show_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Tayang <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="show_date" 
                                   id="show_date" 
                                   value="{{ old('show_date', $showtime->show_date->format('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('show_date') border-red-500 @enderror"
                                   required>
                            @error('show_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Show Time -->
                        <div>
                            <label for="show_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Jam Tayang <span class="text-red-500">*</span>
                            </label>
                            <input type="time" 
                                   name="show_time" 
                                   id="show_time" 
                                   value="{{ old('show_time', $showtime->show_time->format('H:i')) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('show_time') border-red-500 @enderror"
                                   required>
                            @error('show_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga Tiket <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" 
                                       name="price" 
                                       id="price" 
                                       step="1000"
                                       min="10000"
                                       value="{{ old('price', $showtime->price) }}"
                                       class="block w-full pl-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('price') border-red-500 @enderror"
                                       placeholder="50000"
                                       required>
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Harga dalam Rupiah (minimal Rp 10.000)
                            </p>
                        </div>

                        <!-- Available Seats -->
                        <div>
                            <label for="available_seats" class="block text-sm font-medium text-gray-700 mb-2">
                                Kursi Tersedia <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="available_seats" 
                                   id="available_seats" 
                                   min="0"
                                   value="{{ old('available_seats', $showtime->available_seats) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('available_seats') border-red-500 @enderror"
                                   required>
                            @error('available_seats')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Akan otomatis disesuaikan dengan kapasitas studio
                            </p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="is_active" 
                                    id="is_active" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('is_active') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Status</option>
                                <option value="1" {{ old('is_active', $showtime->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $showtime->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('is_active')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Current Statistics -->
                <div class="px-6 py-6 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Showtime</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-lg border">
                            <div class="flex items-center">
                                <x-heroicon-m-users class="h-5 w-5 text-blue-500 mr-2"/>
                                <div>
                                    <p class="text-sm text-gray-600">Total Kursi</p>
                                    <p class="text-lg font-semibold">{{ $showtime->cinemaHall->total_seats }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border">
                            <div class="flex items-center">
                                <x-heroicon-m-shopping-bag class="h-5 w-5 text-red-500 mr-2"/>
                                <div>
                                    <p class="text-sm text-gray-600">Terpesan</p>
                                    <p class="text-lg font-semibold">{{ $showtime->getOccupiedSeatsCount() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border">
                            <div class="flex items-center">
                                <x-heroicon-m-check-circle class="h-5 w-5 text-green-500 mr-2"/>
                                <div>
                                    <p class="text-sm text-gray-600">Tersedia</p>
                                    <p class="text-lg font-semibold">{{ $showtime->getAvailableSeatsCount() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border">
                            <div class="flex items-center">
                                <x-heroicon-m-currency-dollar class="h-5 w-5 text-purple-500 mr-2"/>
                                <div>
                                    <p class="text-sm text-gray-600">Revenue</p>
                                    <p class="text-lg font-semibold">Rp {{ number_format($showtime->price * $showtime->getOccupiedSeatsCount(), 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Warning Box -->
                <div class="px-6 py-4 bg-yellow-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-heroicon-m-exclamation-triangle class="h-5 w-5 text-yellow-400"/>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Perhatian Saat Edit Showtime</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Perubahan jadwal akan mempengaruhi customer yang sudah booking</li>
                                    <li>Mengganti film atau studio akan mereset semua reservasi kursi</li>
                                    <li>Perubahan harga tidak berlaku untuk tiket yang sudah dibeli</li>
                                    <li>Menonaktifkan showtime akan menyembunyikannya dari customer</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <a href="{{ route('admin.showtimes.show', $showtime) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <x-heroicon-m-x-mark class="mr-2 h-4 w-4"/>
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <x-heroicon-m-pencil class="mr-2 h-4 w-4"/>
                        Update Showtime
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-update available seats based on selected cinema hall
document.getElementById('cinema_hall_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
        // You could fetch cinema hall capacity via AJAX here
        // For now, we'll leave the available_seats field for manual input
    }
});

// Price formatting
document.getElementById('price').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    this.value = value;
});
</script>
@endpush
@endsection


