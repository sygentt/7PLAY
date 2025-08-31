@extends('admin.layouts.app')

@section('title', 'Manajemen Bioskop')
@section('page-title', 'Manajemen Bioskop')
@section('page-description', 'Kelola bioskop dan studio untuk sistem cinema booking')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Action Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <x-heroicon-s-building-storefront class="h-6 w-6 text-purple-600"/>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Bioskop</h2>
                    <p class="text-sm text-gray-500">{{ $cinemas->total() }} bioskop terdaftar</p>
                </div>
            </div>
            
            <a href="{{ route('admin.cinemas.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 transition-colors duration-200">
                <x-heroicon-m-plus class="h-4 w-4 mr-2"/>
                Tambah Bioskop
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('admin.cinemas.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-m-magnifying-glass class="h-5 w-5 text-gray-400"/>
                            </div>
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="Cari bioskop...">
                        </div>
                    </div>

                    <!-- City Filter -->
                    <div>
                        <label for="city_id" class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                        <select id="city_id" 
                                name="city_id" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Semua Kota</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Brand Filter -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                        <select id="brand" 
                                name="brand" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Semua Brand</option>
                            @foreach($brands as $value => $label)
                                <option value="{{ $value }}" {{ request('brand') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" 
                                name="status" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" 
                                class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-colors duration-200">
                            <x-heroicon-m-funnel class="h-4 w-4 mr-2"/>
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'city_id', 'brand', 'status']))
                            <a href="{{ route('admin.cinemas.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 transition-colors duration-200">
                                <x-heroicon-m-x-mark class="h-4 w-4"/>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Cinemas Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            @if($cinemas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Bioskop
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lokasi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Brand
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Studio
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cinemas as $cinema)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                                <x-heroicon-m-building-storefront class="h-4 w-4 text-purple-600"/>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $cinema->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $cinema->created_at->format('d M Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $cinema->city->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($cinema->address, 40) }}</div>
                                        @if($cinema->phone)
                                            <div class="text-xs text-gray-400">📞 {{ $cinema->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $cinema->brand }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div class="flex items-center">
                                            <span class="text-lg font-semibold text-purple-600">{{ $cinema->cinema_halls_count }}</span>
                                            <span class="text-sm text-gray-500 ml-1">total</span>
                                            @if($cinema->active_cinema_halls_count != $cinema->cinema_halls_count)
                                                <span class="text-sm text-gray-500 mx-1">•</span>
                                                <span class="text-sm font-medium text-green-600">{{ $cinema->active_cinema_halls_count }} aktif</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($cinema->is_active)
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
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.cinemas.show', $cinema) }}" 
                                               class="text-blue-600 hover:text-blue-900 p-1">
                                                <x-heroicon-m-eye class="h-4 w-4"/>
                                            </a>
                                            <a href="{{ route('admin.cinemas.edit', $cinema) }}" 
                                               class="text-yellow-600 hover:text-yellow-900 p-1">
                                                <x-heroicon-m-pencil-square class="h-4 w-4"/>
                                            </a>
                                            @if($cinema->cinema_halls_count == 0)
                                                <button type="button" 
                                                        class="text-red-600 hover:text-red-900 p-1"
                                                        onclick="confirmDelete('{{ $cinema->full_name }}', '{{ route('admin.cinemas.destroy', $cinema) }}')">
                                                    <x-heroicon-m-trash class="h-4 w-4"/>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $cinemas->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <x-heroicon-o-building-storefront class="mx-auto h-12 w-12 text-gray-400"/>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada bioskop</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan bioskop baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.cinemas.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700">
                            <x-heroicon-m-plus class="h-4 w-4 mr-2"/>
                            Tambah Bioskop
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
function confirmDelete(cinemaName, deleteUrl) {
    if (confirm(`Apakah Anda yakin ingin menghapus bioskop "${cinemaName}"? Aksi ini tidak dapat dibatalkan.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
