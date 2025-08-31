@extends('admin.layouts.app')

@section('title', 'Tambah Jadwal Tayang')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('admin.showtimes.index') }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
                Kembali
            </a>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
            <x-heroicon-o-plus class="w-8 h-8 text-indigo-600" />
            Tambah Jadwal Tayang
        </h1>
        <p class="mt-2 text-gray-600">Tambahkan jadwal tayang film baru</p>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('admin.showtimes.store') }}" class="space-y-6 p-6">
            @csrf

            <!-- Movie & Cinema Selection -->
            <div class="space-y-6">
                <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">
                    Pilih Film & Bioskop
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Movie -->
                    <div>
                        <label for="movie_id" class="block text-sm font-medium text-gray-700">
                            Film <span class="text-red-500">*</span>
                        </label>
                        <select name="movie_id" 
                                id="movie_id" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md @error('movie_id') border-red-300 @enderror"
                                required>
                            <option value="">Pilih Film</option>
                            @foreach($movies as $movie)
                                <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                                    {{ $movie->title }} ({{ $movie->getFormattedDuration() }})
                                </option>
                            @endforeach
                        </select>
                        @error('movie_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city_select" class="block text-sm font-medium text-gray-700">
                            Kota <span class="text-red-500">*</span>
                        </label>
                        <select id="city_select" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                onchange="loadCinemasByCity(this.value)">
                            <option value="">Pilih Kota</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Cinema -->
                    <div>
                        <label for="cinema_select" class="block text-sm font-medium text-gray-700">
                            Bioskop <span class="text-red-500">*</span>
                        </label>
                        <select id="cinema_select" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                onchange="loadCinemaHallsByCinema(this.value)" disabled>
                            <option value="">Pilih kota terlebih dahulu</option>
                        </select>
                    </div>

                    <!-- Cinema Hall -->
                    <div>
                        <label for="cinema_hall_id" class="block text-sm font-medium text-gray-700">
                            Studio <span class="text-red-500">*</span>
                        </label>
                        <select name="cinema_hall_id" 
                                id="cinema_hall_id" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md @error('cinema_hall_id') border-red-300 @enderror"
                                required disabled>
                            <option value="">Pilih bioskop terlebih dahulu</option>
                        </select>
                        @error('cinema_hall_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Schedule Information -->
            <div class="space-y-6">
                <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">
                    Jadwal & Harga
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Show Date -->
                    <div>
                        <label for="show_date" class="block text-sm font-medium text-gray-700">
                            Tanggal Tayang <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="show_date" 
                               id="show_date"
                               value="{{ old('show_date', now()->format('Y-m-d')) }}"
                               min="{{ now()->format('Y-m-d') }}"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('show_date') border-red-300 @enderror"
                               required>
                        @error('show_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Show Time -->
                    <div>
                        <label for="show_time" class="block text-sm font-medium text-gray-700">
                            Jam Tayang <span class="text-red-500">*</span>
                        </label>
                        <input type="time" 
                               name="show_time" 
                               id="show_time"
                               value="{{ old('show_time') }}"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('show_time') border-red-300 @enderror"
                               required>
                        @error('show_time')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">
                            Harga Tiket <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" 
                                   name="price" 
                                   id="price"
                                   value="{{ old('price') }}"
                                   min="0" 
                                   max="999999.99"
                                   step="0.01"
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md @error('price') border-red-300 @enderror"
                                   placeholder="0.00"
                                   required>
                        </div>
                        @error('price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="space-y-6">
                <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">
                    Pengaturan
                </h3>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Aktifkan jadwal tayang
                    </label>
                </div>
                <p class="text-sm text-gray-500">Jadwal tayang yang tidak aktif tidak akan tampil di website publik</p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.showtimes.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-heroicon-o-x-mark class="w-4 h-4 mr-2" />
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-heroicon-o-check class="w-4 h-4 mr-2" />
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Load cinemas by city
    function loadCinemasByCity(cityId) {
        const cinemaSelect = document.getElementById('cinema_select');
        const cinemaHallSelect = document.getElementById('cinema_hall_id');
        
        // Reset cinema and cinema hall selects
        cinemaSelect.innerHTML = '<option value="">Memuat bioskop...</option>';
        cinemaSelect.disabled = true;
        cinemaHallSelect.innerHTML = '<option value="">Pilih bioskop terlebih dahulu</option>';
        cinemaHallSelect.disabled = true;
        
        if (!cityId) {
            cinemaSelect.innerHTML = '<option value="">Pilih kota terlebih dahulu</option>';
            return;
        }

        // Get cinemas for selected city
        const cinemas = @json($cinemas);
        const filteredCinemas = cinemas.filter(cinema => cinema.city_id == cityId);
        
        cinemaSelect.innerHTML = '<option value="">Pilih Bioskop</option>';
        filteredCinemas.forEach(cinema => {
            cinemaSelect.innerHTML += `<option value="${cinema.id}">${cinema.name} - ${cinema.brand}</option>`;
        });
        
        cinemaSelect.disabled = false;
    }

    // Load cinema halls by cinema
    function loadCinemaHallsByCinema(cinemaId) {
        const cinemaHallSelect = document.getElementById('cinema_hall_id');
        
        // Reset cinema hall select
        cinemaHallSelect.innerHTML = '<option value="">Memuat studio...</option>';
        cinemaHallSelect.disabled = true;
        
        if (!cinemaId) {
            cinemaHallSelect.innerHTML = '<option value="">Pilih bioskop terlebih dahulu</option>';
            return;
        }

        // Get cinema halls for selected cinema
        const cinemas = @json($cinemas);
        const selectedCinema = cinemas.find(cinema => cinema.id == cinemaId);
        
        if (selectedCinema && selectedCinema.cinema_halls) {
            cinemaHallSelect.innerHTML = '<option value="">Pilih Studio</option>';
            selectedCinema.cinema_halls.forEach(hall => {
                cinemaHallSelect.innerHTML += `<option value="${hall.id}">${hall.name} (${hall.type.toUpperCase()}) - ${hall.total_seats} kursi</option>`;
            });
            cinemaHallSelect.disabled = false;
        } else {
            cinemaHallSelect.innerHTML = '<option value="">Tidak ada studio tersedia</option>';
        }
    }

    // Format price input
    document.getElementById('price').addEventListener('input', function(e) {
        const value = e.target.value;
        if (value) {
            const formattedValue = parseFloat(value).toLocaleString('id-ID');
            // Update or create help text
            let helpElement = document.getElementById('price-help');
            if (!helpElement) {
                helpElement = document.createElement('p');
                helpElement.id = 'price-help';
                helpElement.className = 'mt-2 text-sm text-gray-500';
                e.target.parentNode.parentNode.appendChild(helpElement);
            }
            helpElement.textContent = `Rp ${formattedValue}`;
        }
    });

    // Validate show time
    document.getElementById('show_time').addEventListener('change', function(e) {
        const selectedTime = e.target.value;
        const currentTime = new Date();
        const showDate = document.getElementById('show_date').value;
        const today = currentTime.toISOString().split('T')[0];
        
        if (showDate === today && selectedTime) {
            const currentTimeStr = currentTime.toTimeString().slice(0, 5);
            if (selectedTime < currentTimeStr) {
                alert('Jam tayang tidak boleh kurang dari waktu sekarang untuk hari ini.');
                e.target.focus();
            }
        }
    });

    // Validate show date
    document.getElementById('show_date').addEventListener('change', function(e) {
        const showTimeInput = document.getElementById('show_time');
        if (showTimeInput.value) {
            // Trigger time validation
            showTimeInput.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
@endsection
