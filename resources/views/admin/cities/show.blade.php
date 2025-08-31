@extends('admin.layouts.app')

@section('title', 'Detail Kota ' . $city->name)
@section('page-title', 'Detail Kota')
@section('page-description', 'Informasi lengkap kota ' . $city->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                        <span class="ml-4 text-sm font-medium text-gray-900">{{ $city->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-building-office-2 class="h-7 w-7 text-blue-600"/>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $city->name }}</h1>
                    <p class="text-sm text-gray-600">{{ $city->province }}</p>
                </div>
                @if($city->is_active)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <x-heroicon-c-check-circle class="w-4 h-4 mr-1"/>
                        Aktif
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <x-heroicon-c-x-circle class="w-4 h-4 mr-1"/>
                        Tidak Aktif
                    </span>
                @endif
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.cities.edit', $city) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition-colors duration-200">
                    <x-heroicon-m-pencil-square class="h-4 w-4 mr-2"/>
                    Edit Kota
                </a>
                
                <a href="{{ route('admin.cities.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition-colors duration-200">
                    <x-heroicon-m-arrow-left class="h-4 w-4 mr-2"/>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- City Information -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kota</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Kota</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $city->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Provinsi</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $city->province }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Kode Kota</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $city->code }}
                                </span>
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <p class="mt-1">
                                @if($city->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <x-heroicon-c-check-circle class="w-3 h-3 mr-1"/>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <x-heroicon-c-x-circle class="w-3 h-3 mr-1"/>
                                        Tidak Aktif
                                    </span>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Dibuat</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $city->created_at->format('d M Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Terakhir Update</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $city->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <x-heroicon-m-building-storefront class="h-5 w-5 text-blue-500 mr-2"/>
                                <span class="text-sm text-gray-700">Total Bioskop</span>
                            </div>
                            <span class="text-lg font-semibold text-blue-600">{{ $city->cinemas->count() }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <x-heroicon-m-check-circle class="h-5 w-5 text-green-500 mr-2"/>
                                <span class="text-sm text-gray-700">Bioskop Aktif</span>
                            </div>
                            <span class="text-lg font-semibold text-green-600">{{ $city->cinemas->where('is_active', true)->count() }}</span>
                        </div>
                        
                        @if($city->cinemas->count() > 0)
                        <div class="pt-4 border-t border-gray-200">
                            <div class="text-sm text-gray-600">
                                <strong>Brand Bioskop:</strong>
                                <div class="mt-2 flex flex-wrap gap-1">
                                    @foreach($city->cinemas->groupBy('brand') as $brand => $cinemas)
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                                            {{ $brand }} ({{ $cinemas->count() }})
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Cinemas List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Daftar Bioskop</h3>
                            @if($city->cinemas->count() > 0)
                                <span class="text-sm text-gray-500">{{ $city->cinemas->count() }} bioskop</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($city->cinemas->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($city->cinemas as $cinema)
                                <div class="px-6 py-4 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                                <x-heroicon-s-building-storefront class="h-5 w-5 text-purple-600"/>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">{{ $cinema->brand }} {{ $cinema->name }}</h4>
                                                <p class="text-sm text-gray-500">{{ $cinema->address }}</p>
                                                @if($cinema->phone)
                                                    <p class="text-xs text-gray-400">📞 {{ $cinema->phone }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-3">
                                            @if($cinema->cinema_halls_count > 0)
                                                <span class="text-xs text-gray-500">{{ $cinema->cinema_halls_count }} studio</span>
                                            @endif
                                            
                                            @if($cinema->is_active)
                                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">
                                                    Tidak Aktif
                                                </span>
                                            @endif
                                            
                                            <a href="{{ route('admin.cinemas.show', $cinema) }}" 
                                               class="text-blue-600 hover:text-blue-900 text-sm">
                                                Lihat →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                            <a href="{{ route('admin.cinemas.create', ['city_id' => $city->id]) }}" 
                               class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                <x-heroicon-m-plus class="h-4 w-4 mr-1"/>
                                Tambah Bioskop Baru
                            </a>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <x-heroicon-o-building-storefront class="mx-auto h-12 w-12 text-gray-400"/>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada bioskop</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan bioskop pertama di kota ini.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.cinemas.create', ['city_id' => $city->id]) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                                    <x-heroicon-m-plus class="h-4 w-4 mr-2"/>
                                    Tambah Bioskop
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
