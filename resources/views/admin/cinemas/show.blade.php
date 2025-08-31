@extends('admin.layouts.app')

@section('title', 'Detail Bioskop')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header / Breadcrumbs -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.cinemas.index') }}" class="hover:text-blue-600">Cinemas</a>
            <span>/</span>
            <span class="text-gray-900 font-medium">Detail</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.cinemas.edit', $cinema) }}"
               class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                <x-heroicon-o-pencil-square class="w-4 h-4 mr-1"/>
                Edit
            </a>
            @if($cinema->cinema_halls->isEmpty())
                <form method="POST" action="{{ route('admin.cinemas.destroy', $cinema) }}" onsubmit="return confirm('Hapus bioskop ini? Aksi tidak dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700">
                        <x-heroicon-o-trash class="w-4 h-4 mr-1"/>
                        Hapus
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Cover / Banner -->
    <div class="rounded-lg overflow-hidden border border-gray-200 mb-6">
        <img src="https://dummyimage.com/1200x240/edf2f7/a0aec0&text={{ urlencode('Cinema '.$cinema->brand.' '.$cinema->name) }}" alt="{{ $cinema->name }}" class="w-full h-48 object-cover">
    </div>

    <!-- Header Card -->
    <div class="bg-white shadow rounded-lg border border-gray-200 p-6 mb-6">
        <div class="flex items-start justify-between">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <x-heroicon-o-building-storefront class="w-6 h-6 text-purple-600"/>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $cinema->name }}</h1>
                    <p class="text-gray-500">Brand {{ $cinema->brand }} • {{ $cinema->city->name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if($cinema->is_active)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <x-heroicon-o-check-circle class="w-3 h-3 mr-1"/> Aktif
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <x-heroicon-o-x-circle class="w-3 h-3 mr-1"/> Tidak Aktif
                    </span>
                @endif
                <form method="POST" action="{{ route('admin.cinemas.toggle-status', $cinema) }}" onsubmit="return confirm('Ubah status aktif bioskop ini?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm rounded-md bg-white hover:bg-gray-50">
                        @if($cinema->is_active)
                            <x-heroicon-o-eye-slash class="w-4 h-4 mr-1"/> Nonaktifkan
                        @else
                            <x-heroicon-o-eye class="w-4 h-4 mr-1"/> Aktifkan
                        @endif
                    </button>
                </form>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="p-4 border border-gray-100 rounded-md">
                <div class="text-xs text-gray-500">Alamat</div>
                <div class="text-sm text-gray-900 mt-1">{{ $cinema->address }}</div>
            </div>
            <div class="p-4 border border-gray-100 rounded-md">
                <div class="text-xs text-gray-500">Telepon</div>
                <div class="text-sm text-gray-900 mt-1">{{ $cinema->phone ?? '-' }}</div>
            </div>
            <div class="p-4 border border-gray-100 rounded-md">
                <div class="text-xs text-gray-500">Koordinat</div>
                <div class="text-sm text-gray-900 mt-1">{{ $cinema->latitude ?? '-' }}, {{ $cinema->longitude ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow rounded-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            <a href="{{ route('admin.showtimes.index', ['cinema_id' => $cinema->id]) }}" class="flex items-center justify-center px-3 py-2 border-2 border-blue-200 rounded-lg hover:bg-blue-50">
                <x-heroicon-o-calendar-days class="w-5 h-5 text-blue-600 mr-2"/>
                <span class="text-sm text-blue-700 font-medium">Lihat Showtimes</span>
            </a>
            <a href="{{ route('admin.cinemas.index') }}" class="flex items-center justify-center px-3 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-50">
                <x-heroicon-o-arrow-left class="w-5 h-5 text-gray-600 mr-2"/>
                <span class="text-sm text-gray-700 font-medium">Kembali</span>
            </a>
        </div>
    </div>

    <!-- Cinema Halls -->
    <div class="bg-white shadow rounded-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Daftar Studio</h2>
                <p class="text-sm text-gray-500">{{ $cinema->cinema_halls->count() }} studio terdaftar</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Studio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kapasitas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($cinema->cinema_halls as $hall)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $hall->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $hall->type ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $hall->total_seats }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($hall->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <x-heroicon-o-check-circle class="w-3 h-3 mr-1"/> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <x-heroicon-o-x-circle class="w-3 h-3 mr-1"/> Tidak Aktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-sm text-gray-500">Belum ada studio untuk bioskop ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


