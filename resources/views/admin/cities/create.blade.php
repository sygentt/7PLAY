@extends('admin.layouts.app')

@section('title', 'Tambah Kota')
@section('page-title', 'Tambah Kota')
@section('page-description', 'Tambah kota baru ke dalam sistem')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('admin.cities.index') }}" class="text-gray-400 hover:text-gray-600">
                        <x-heroicon-m-building-office-2 class="h-5 w-5"/>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="h-5 w-5 text-gray-400"/>
                        <a href="{{ route('admin.cities.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Kota
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="h-5 w-5 text-gray-400"/>
                        <span class="ml-4 text-sm font-medium text-gray-900">Tambah</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <x-heroicon-m-plus class="h-5 w-5 text-blue-600"/>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Form Tambah Kota</h3>
                </div>
                <p class="mt-1 text-sm text-gray-600">Isi informasi kota yang akan ditambahkan ke dalam sistem.</p>
            </div>
            
            <form method="POST" action="{{ route('admin.cities.store') }}" class="px-6 py-6 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Kota <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-m-building-office-2 class="h-5 w-5 text-gray-400"/>
                            </div>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Contoh: Jakarta">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Province -->
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                            Provinsi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-m-map class="h-5 w-5 text-gray-400"/>
                            </div>
                            <input type="text" 
                                   id="province" 
                                   name="province" 
                                   value="{{ old('province') }}"
                                   required
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('province') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Contoh: DKI Jakarta">
                        </div>
                        @error('province')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Code -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Kota <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-m-hashtag class="h-5 w-5 text-gray-400"/>
                            </div>
                            <input type="text" 
                                   id="code" 
                                   name="code" 
                                   value="{{ old('code') }}"
                                   required
                                   maxlength="10"
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('code') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Contoh: JKT"
                                   style="text-transform: uppercase;">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Kode unik maksimal 10 karakter (huruf kapital)</p>
                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <div class="relative">
                            <select id="is_active" 
                                    name="is_active" 
                                    class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('is_active') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.cities.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition-colors duration-200">
                        <x-heroicon-m-arrow-left class="h-4 w-4 mr-2"/>
                        Batal
                    </a>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <x-heroicon-m-check class="h-4 w-4 mr-2"/>
                        Simpan Kota
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Help Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-heroicon-m-information-circle class="h-5 w-5 text-blue-400"/>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Tips Pengisian Form</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Nama kota harus unik dan mudah dikenali</li>
                            <li>Provinsi diisi dengan nama lengkap provinsi</li>
                            <li>Kode kota dibuat singkat dan mudah diingat (contoh: JKT untuk Jakarta)</li>
                            <li>Status aktif menentukan apakah kota akan muncul dalam pilihan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
// Auto uppercase for code field
document.getElementById('code').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});
</script>
@endpush
