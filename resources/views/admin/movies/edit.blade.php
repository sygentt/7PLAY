@extends('admin.layouts.app')

@section('title', 'Edit Film - ' . $movie->title)

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('admin.movies.index') }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
                Kembali
            </a>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
            <x-heroicon-o-pencil-square class="w-8 h-8 text-indigo-600" />
            Edit Film
        </h1>
        <p class="mt-2 text-gray-600">Edit informasi film "{{ $movie->title }}"</p>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('admin.movies.update', $movie) }}" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="space-y-6">
                <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">
                    Informasi Dasar
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            Judul Film <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title"
                               value="{{ old('title', $movie->title) }}"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('title') border-red-300 @enderror"
                               placeholder="Masukkan judul film"
                               required>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Director -->
                    <div>
                        <label for="director" class="block text-sm font-medium text-gray-700">
                            Sutradara <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="director" 
                               id="director"
                               value="{{ old('director', $movie->director) }}"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('director') border-red-300 @enderror"
                               placeholder="Masukkan nama sutradara"
                               required>
                        @error('director')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Genre -->
                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-700">
                            Genre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="genre" 
                               id="genre"
                               value="{{ old('genre', $movie->genre) }}"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('genre') border-red-300 @enderror"
                               placeholder="Contoh: Action, Drama, Comedy"
                               required>
                        @error('genre')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Language -->
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700">
                            Bahasa <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="language" 
                               id="language"
                               value="{{ old('language', $movie->language) }}"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('language') border-red-300 @enderror"
                               placeholder="Contoh: Indonesia, English, Mandarin"
                               required>
                        @error('language')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700">
                            Durasi (menit) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="duration" 
                               id="duration"
                               value="{{ old('duration', $movie->duration) }}"
                               min="1" 
                               max="300"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('duration') border-red-300 @enderror"
                               placeholder="Contoh: 120"
                               required>
                        <p class="mt-2 text-sm text-gray-500">{{ $movie->getFormattedDuration() }}</p>
                        @error('duration')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rating -->
                    <div>
                        <label for="rating" class="block text-sm font-medium text-gray-700">
                            Rating <span class="text-red-500">*</span>
                        </label>
                        <select name="rating" 
                                id="rating" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md @error('rating') border-red-300 @enderror"
                                required>
                            <option value="">Pilih Rating</option>
                            @foreach($ratings as $key => $label)
                                <option value="{{ $key }}" {{ old('rating', $movie->rating) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('rating')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Release Date -->
                    <div>
                        <label for="release_date" class="block text-sm font-medium text-gray-700">
                            Tanggal Rilis <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="release_date" 
                               id="release_date"
                               value="{{ old('release_date', $movie->release_date->format('Y-m-d')) }}"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('release_date') border-red-300 @enderror"
                               required>
                        @error('release_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">
                            Status Tayang <span class="text-red-500">*</span>
                        </label>
                        <select name="status" 
                                id="status" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md @error('status') border-red-300 @enderror"
                                required>
                            <option value="">Pilih Status</option>
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ old('status', $movie->status) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Synopsis -->
                <div>
                    <label for="synopsis" class="block text-sm font-medium text-gray-700">
                        Sinopsis <span class="text-red-500">*</span>
                    </label>
                    <textarea name="synopsis" 
                              id="synopsis" 
                              rows="4"
                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('synopsis') border-red-300 @enderror"
                              placeholder="Masukkan sinopsis film..."
                              required>{{ old('synopsis', $movie->synopsis) }}</textarea>
                    @error('synopsis')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cast -->
                <div>
                    <label for="cast" class="block text-sm font-medium text-gray-700">
                        Pemeran <span class="text-red-500">*</span>
                    </label>
                    <textarea name="cast" 
                              id="cast" 
                              rows="3"
                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('cast') border-red-300 @enderror"
                              placeholder="Masukkan nama-nama pemeran, pisahkan dengan koma"
                              required>{{ old('cast', $movie->getCastString()) }}</textarea>
                    <p class="mt-2 text-sm text-gray-500">Pisahkan nama pemeran dengan koma. Contoh: Tom Hanks, Meg Ryan, Bill Pullman</p>
                    @error('cast')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Media Information -->
            <div class="space-y-6">
                <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">
                    Media & Gambar
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Poster URL -->
                    <div>
                        <label for="poster_url" class="block text-sm font-medium text-gray-700">
                            URL Poster Film
                        </label>
                        <input type="url" 
                               name="poster_url" 
                               id="poster_url"
                               value="{{ old('poster_url', $movie->poster_url) }}"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('poster_url') border-red-300 @enderror"
                               placeholder="https://example.com/poster.jpg">
                        <p class="mt-2 text-sm text-gray-500">Masukkan URL gambar poster film</p>
                        
                        <!-- Current Poster Preview -->
                        @if($movie->poster_url)
                            <div class="mt-2" id="current-poster">
                                <p class="text-sm text-gray-600 mb-2">Poster saat ini:</p>
                                <img src="{{ $movie->poster_url }}" 
                                     alt="Current Poster" 
                                     class="w-32 h-48 object-cover rounded border shadow-sm"
                                     onerror="this.parentElement.style.display='none'">
                            </div>
                        @endif
                        
                        @error('poster_url')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Trailer URL -->
                    <div>
                        <label for="trailer_url" class="block text-sm font-medium text-gray-700">
                            URL Trailer Film
                        </label>
                        <input type="url" 
                               name="trailer_url" 
                               id="trailer_url"
                               value="{{ old('trailer_url', $movie->trailer_url) }}"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('trailer_url') border-red-300 @enderror"
                               placeholder="https://youtube.com/watch?v=...">
                        <p class="mt-2 text-sm text-gray-500">Masukkan URL trailer film (YouTube, Vimeo, dll)</p>
                        
                        <!-- Current Trailer Link -->
                        @if($movie->trailer_url)
                            <div class="mt-2">
                                <p class="text-sm text-gray-600 mb-1">Trailer saat ini:</p>
                                <a href="{{ $movie->trailer_url }}" target="_blank" 
                                   class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                                    <x-heroicon-o-play class="w-4 h-4 mr-1" />
                                    Lihat Trailer
                                </a>
                            </div>
                        @endif
                        
                        @error('trailer_url')
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
                           {{ old('is_active', $movie->is_active) ? 'checked' : '' }}
                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Aktifkan film
                    </label>
                </div>
                <p class="text-sm text-gray-500">Film yang tidak aktif tidak akan ditampilkan di website publik</p>

                <!-- Movie Statistics -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Statistik Film</h4>
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Jumlah Jadwal Tayang</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $movie->showtimes_count ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Dibuat</p>
                            <p class="text-sm text-gray-900">{{ $movie->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Terakhir Diperbarui</p>
                            <p class="text-sm text-gray-900">{{ $movie->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.movies.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-heroicon-o-x-mark class="w-4 h-4 mr-2" />
                    Batal
                </a>
                <a href="{{ route('admin.movies.show', $movie) }}" 
                   class="inline-flex items-center px-4 py-2 border border-indigo-300 text-sm font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-heroicon-o-eye class="w-4 h-4 mr-2" />
                    Lihat Detail
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-heroicon-o-check class="w-4 h-4 mr-2" />
                    Perbarui Film
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Auto-format duration input
    document.getElementById('duration').addEventListener('input', function(e) {
        const value = e.target.value;
        if (value) {
            const hours = Math.floor(value / 60);
            const minutes = value % 60;
            let helpText = '';
            
            if (hours > 0) {
                helpText = `${hours} jam ${minutes} menit`;
            } else {
                helpText = `${minutes} menit`;
            }
            
            // Update or create help text
            let helpElement = document.getElementById('duration-help');
            if (!helpElement) {
                helpElement = document.createElement('p');
                helpElement.id = 'duration-help';
                helpElement.className = 'mt-2 text-sm text-gray-500';
                e.target.parentNode.appendChild(helpElement);
            }
            helpElement.textContent = helpText;
        }
    });

    // Preview new poster when URL is changed
    document.getElementById('poster_url').addEventListener('input', function(e) {
        const url = e.target.value;
        let previewElement = document.getElementById('poster-preview');
        
        if (url && url.startsWith('http') && url !== '{{ $movie->poster_url }}') {
            if (!previewElement) {
                previewElement = document.createElement('div');
                previewElement.id = 'poster-preview';
                previewElement.className = 'mt-2';
                e.target.parentNode.appendChild(previewElement);
            }
            
            previewElement.innerHTML = `
                <p class="text-sm text-gray-600 mb-2">Preview poster baru:</p>
                <img src="${url}" 
                     alt="Preview Poster" 
                     class="w-32 h-48 object-cover rounded border shadow-sm"
                     onerror="this.parentElement.style.display='none'">
            `;
        } else if (previewElement) {
            previewElement.remove();
        }
    });
</script>
@endpush
@endsection
