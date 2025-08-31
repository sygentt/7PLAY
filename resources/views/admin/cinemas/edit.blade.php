@extends('admin.layouts.app')

@section('title', 'Edit Cinema')

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
                        <a href="{{ route('admin.cinemas.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Cinemas</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="h-4 w-4 text-gray-400"/>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit {{ $cinema->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Cinema</h1>
            <p class="mt-1 text-sm text-gray-600">Update informasi cinema {{ $cinema->full_name }}</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.cinemas.update', $cinema) }}" method="POST" class="divide-y divide-gray-200">
                @csrf
                @method('PUT')
                
                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Dasar</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- City -->
                        <div>
                            <label for="city_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Kota <span class="text-red-500">*</span>
                            </label>
                            <select name="city_id" 
                                    id="city_id" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('city_id') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Kota</option>
                                @foreach(\App\Models\City::orderBy('name')->get() as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id', $cinema->city_id) == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}, {{ $city->province }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Brand -->
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">
                                Brand <span class="text-red-500">*</span>
                            </label>
                            <select name="brand" 
                                    id="brand" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('brand') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Brand</option>
                                @foreach(\App\Models\Cinema::getAvailableBrands() as $key => $value)
                                    <option value="{{ $key }}" {{ old('brand', $cinema->brand) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Cinema <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $cinema->name) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                   placeholder="Contoh: Grand Indonesia"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Nama lokasi cinema (tanpa brand, contoh: "Grand Indonesia" bukan "XXI Grand Indonesia")
                            </p>
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" 
                                      id="address" 
                                      rows="3"
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('address') border-red-500 @enderror"
                                      placeholder="Jl. MH Thamrin No.1, Gondangdia, Menteng"
                                      required>{{ old('address', $cinema->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon
                            </label>
                            <input type="text" 
                                   name="phone" 
                                   id="phone" 
                                   value="{{ old('phone', $cinema->phone) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                                   placeholder="(021) 123-4567">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                                <option value="1" {{ old('is_active', $cinema->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $cinema->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('is_active')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Koordinat Lokasi (Opsional)</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Latitude -->
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                                Latitude
                            </label>
                            <input type="number" 
                                   name="latitude" 
                                   id="latitude" 
                                   step="any"
                                   value="{{ old('latitude', $cinema->latitude) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('latitude') border-red-500 @enderror"
                                   placeholder="-6.200000">
                            @error('latitude')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Longitude -->
                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                                Longitude
                            </label>
                            <input type="number" 
                                   name="longitude" 
                                   id="longitude" 
                                   step="any"
                                   value="{{ old('longitude', $cinema->longitude) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('longitude') border-red-500 @enderror"
                                   placeholder="106.816666">
                            @error('longitude')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <x-heroicon-m-information-circle class="h-5 w-5 text-blue-400"/>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-blue-800">Info Koordinat</h4>
                                <p class="mt-1 text-sm text-blue-700">
                                    Koordinat digunakan untuk menampilkan lokasi cinema di peta. Anda bisa mendapatkan koordinat dari Google Maps atau layanan peta lainnya.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cinema Statistics -->
                @if($cinema->cinema_halls()->count() > 0)
                <div class="px-6 py-6 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Cinema</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white p-4 rounded-lg border">
                            <div class="flex items-center">
                                <x-heroicon-m-building-office class="h-5 w-5 text-blue-500 mr-2"/>
                                <div>
                                    <p class="text-sm text-gray-600">Total Studio</p>
                                    <p class="text-lg font-semibold">{{ $cinema->cinema_halls()->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border">
                            <div class="flex items-center">
                                <x-heroicon-m-check-circle class="h-5 w-5 text-green-500 mr-2"/>
                                <div>
                                    <p class="text-sm text-gray-600">Studio Aktif</p>
                                    <p class="text-lg font-semibold">{{ $cinema->cinema_halls()->where('is_active', true)->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border">
                            <div class="flex items-center">
                                <x-heroicon-m-calendar class="h-5 w-5 text-purple-500 mr-2"/>
                                <div>
                                    <p class="text-sm text-gray-600">Total Showtimes</p>
                                    <p class="text-lg font-semibold">{{ $cinema->cinema_halls()->withCount('showtimes')->get()->sum('showtimes_count') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Warning Box -->
                <div class="px-6 py-4 bg-yellow-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-heroicon-m-exclamation-triangle class="h-5 w-5 text-yellow-400"/>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Perubahan informasi akan mempengaruhi semua studio dalam cinema ini</li>
                                    <li>Menonaktifkan cinema akan menyembunyikan semua showtimes</li>
                                    <li>Pastikan alamat dan koordinat akurat untuk kemudahan customer</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <a href="{{ route('admin.cinemas.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <x-heroicon-m-x-mark class="mr-2 h-4 w-4"/>
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <x-heroicon-m-pencil class="mr-2 h-4 w-4"/>
                        Update Cinema
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


