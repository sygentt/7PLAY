@extends('admin.layouts.app')

@section('title', 'Manajemen Kota')
@section('page-title', 'Manajemen Kota')
@section('page-description', 'Kelola kota dan provinsi untuk sistem bioskop')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Action Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <x-heroicon-s-building-office-2 class="h-6 w-6 text-blue-600"/>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Kota</h2>
                    <p class="text-sm text-gray-500">{{ $cities->total() }} kota terdaftar</p>
                </div>
            </div>
            
            <a href="{{ route('admin.cities.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition-colors duration-200">
                <x-heroicon-m-plus class="h-4 w-4 mr-2"/>
                Tambah Kota
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('admin.cities.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Cari kota, provinsi, atau kode...">
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" 
                                name="status" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select id="sort" 
                                name="sort" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nama Kota</option>
                            <option value="province" {{ request('sort') === 'province' ? 'selected' : '' }}>Provinsi</option>
                            <option value="code" {{ request('sort') === 'code' ? 'selected' : '' }}>Kode</option>
                            <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" 
                                class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-colors duration-200">
                            <x-heroicon-m-funnel class="h-4 w-4 mr-2"/>
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'status', 'sort']))
                            <a href="{{ route('admin.cities.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 transition-colors duration-200">
                                <x-heroicon-m-x-mark class="h-4 w-4"/>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Cities Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            @if($cities->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kota
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Provinsi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Bioskop
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
                            @foreach($cities as $city)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                <x-heroicon-m-map-pin class="h-4 w-4 text-blue-600"/>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $city->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $city->created_at->format('d M Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $city->province }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $city->code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div class="flex items-center">
                                            <span class="text-lg font-semibold text-blue-600">{{ $city->cinemas_count }}</span>
                                            <span class="text-sm text-gray-500 ml-1">total</span>
                                            @if($city->active_cinemas_count != $city->cinemas_count)
                                                <span class="text-sm text-gray-500 mx-1">•</span>
                                                <span class="text-sm font-medium text-green-600">{{ $city->active_cinemas_count }} aktif</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.cities.show', $city) }}" 
                                               class="text-blue-600 hover:text-blue-900 p-1">
                                                <x-heroicon-m-eye class="h-4 w-4"/>
                                            </a>
                                            <a href="{{ route('admin.cities.edit', $city) }}" 
                                               class="text-yellow-600 hover:text-yellow-900 p-1">
                                                <x-heroicon-m-pencil-square class="h-4 w-4"/>
                                            </a>
                                            @if($city->cinemas_count == 0)
                                                <button type="button" 
                                                        class="text-red-600 hover:text-red-900 p-1"
                                                        onclick="confirmDelete('{{ $city->name }}', '{{ route('admin.cities.destroy', $city) }}')">
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
                    {{ $cities->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <x-heroicon-o-building-office-2 class="mx-auto h-12 w-12 text-gray-400"/>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada kota</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan kota baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.cities.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                            <x-heroicon-m-plus class="h-4 w-4 mr-2"/>
                            Tambah Kota
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
function confirmDelete(cityName, deleteUrl) {
    if (confirm(`Apakah Anda yakin ingin menghapus kota "${cityName}"? Aksi ini tidak dapat dibatalkan.`)) {
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
