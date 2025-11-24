@extends('admin.layouts.app')

@section('title', 'Manajemen Voucher')
@section('page-title', 'Manajemen Voucher')
@section('page-description', 'Kelola voucher diskon dan promosi')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <x-heroicon-o-ticket class="w-8 h-8 text-indigo-600" />
                Kelola Vouchers
            </h1>
            <p class="mt-2 text-gray-600">Kelola voucher diskon dan penukaran poin</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.vouchers.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                Tambah Voucher
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-7 gap-4 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-ticket class="h-5 w-5 text-gray-400" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">Total Vouchers</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['total']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-check-circle class="h-5 w-5 text-green-400" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">Active</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['active']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-x-circle class="h-5 w-5 text-red-400" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">Inactive</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['inactive']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-calculator class="h-5 w-5 text-blue-400" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">Percentage</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['percentage']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-banknotes class="h-5 w-5 text-purple-400" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">Fixed</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['fixed']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-clock class="h-5 w-5 text-orange-400" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">Expiring Soon</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ number_format($stats['expiring_soon']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-plus-circle class="h-5 w-5 text-green-500" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">New This Month</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ number_format($stats['new_this_month']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Cari Voucher</label>
                    <div class="mt-1 relative">
                        <input type="text" 
                               name="search" 
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Nama voucher..."
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
                        </div>
                    </div>
                </div>

                <!-- Type Filter -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipe</label>
                    <select name="type" id="type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Tipe</option>
                        <option value="percentage" {{ request('type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="fixed" {{ request('type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700">Created From</label>
                    <input type="date" 
                           name="date_from" 
                           id="date_from"
                           value="{{ request('date_from') }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <!-- Date To -->
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700">Created To</label>
                    <input type="date" 
                           name="date_to" 
                           id="date_to"
                           value="{{ request('date_to') }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <!-- Quick Date Filter -->
                <div>
                    <label for="date_filter" class="block text-sm font-medium text-gray-700">Quick Filter</label>
                    <select name="date_filter" id="date_filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Pilih Periode</option>
                        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
                    <select name="sort" id="sort" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="value" {{ request('sort') == 'value' ? 'selected' : '' }}>Value</option>
                        <option value="usage_count" {{ request('sort') == 'usage_count' ? 'selected' : '' }}>Usage Count</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                    <x-heroicon-o-magnifying-glass class="w-4 h-4 mr-2" />
                    Cari
                </button>
                <a href="{{ route('admin.vouchers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 transition ease-in-out duration-150">
                    <x-heroicon-o-arrow-path class="w-4 h-4 mr-2" />
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Vouchers Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        @if($vouchers->count() > 0)
            <div class="overflow-x-auto max-w-full">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Voucher
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type & Value
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Validity Period
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Usage
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($vouchers as $voucher)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <x-heroicon-o-ticket class="h-6 w-6 text-indigo-600" />
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $voucher->name }}</div>
                                            @if($voucher->description)
                                                <div class="text-sm text-gray-500">{{ Str::limit($voucher->description, 40) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ ucfirst($voucher->type) }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            @if($voucher->type === 'percentage')
                                                {{ number_format($voucher->value, 0) }}%
                                                @if($voucher->max_discount)
                                                    <span class="text-xs">(Max: Rp {{ number_format($voucher->max_discount, 0, ',', '.') }})</span>
                                                @endif
                                            @else
                                                Rp {{ number_format($voucher->value, 0, ',', '.') }}
                                            @endif
                                        </div>
                                        @if($voucher->min_purchase)
                                            <div class="text-xs text-gray-400">
                                                Min: Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>
                                        <div class="text-sm text-gray-900">{{ optional($voucher->valid_from)->format('d M Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ optional($voucher->valid_until)->format('d M Y') }}</div>
                                        @if($voucher->valid_until && $voucher->valid_until->isPast())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                Expired
                                            </span>
                                        @elseif($voucher->valid_until && $voucher->valid_until->diffInDays(now()) <= 7)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                                Expiring Soon
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <div class="font-medium">{{ $voucher->user_vouchers_count ?? 0 }} users</div>
                                        @if($voucher->points_required)
                                            <div class="text-xs text-gray-500">{{ number_format($voucher->points_required) }} points</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $voucher->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $voucher->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $voucher->created_at->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $voucher->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.vouchers.show', $voucher) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 p-1 rounded" title="View Details">
                                            <x-heroicon-o-eye class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('admin.vouchers.edit', $voucher) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 p-1 rounded" title="Edit">
                                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                                        </a>
                                        <button onclick="toggleStatus({{ $voucher->id }}, '{{ $voucher->name }}')"
                                                class="text-gray-600 hover:text-gray-900 p-1 rounded" title="{{ $voucher->is_active ? 'Deactivate' : 'Activate' }}">
                                            @if($voucher->is_active)
                                                <x-heroicon-o-eye-slash class="w-4 h-4" />
                                            @else
                                                <x-heroicon-o-eye class="w-4 h-4" />
                                            @endif
                                        </button>
                                        @if($voucher->userVouchers()->count() == 0)
                                            <button onclick="deleteVoucher({{ $voucher->id }}, '{{ $voucher->name }}')"
                                                    class="text-red-600 hover:text-red-900 p-1 rounded" title="Delete">
                                                <x-heroicon-o-trash class="w-4 h-4" />
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
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $vouchers->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <x-heroicon-o-ticket class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada voucher</h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ request()->anyFilled(['search', 'type', 'status', 'date_from', 'date_to', 'date_filter']) 
                        ? 'Tidak ada voucher yang sesuai dengan filter yang dipilih.' 
                        : 'Mulai dengan menambahkan voucher baru.' }}
                </p>
                @if(!request()->anyFilled(['search', 'type', 'status', 'date_from', 'date_to', 'date_filter']))
                    <div class="mt-6">
                        <a href="{{ route('admin.vouchers.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                            Tambah Voucher
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function toggleStatus(voucherId, voucherName) {
        if (confirm(`Apakah Anda yakin ingin mengubah status voucher "${voucherName}"?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/vouchers') }}/${voucherId}/toggle-status`;
            form.innerHTML = `
                @csrf
                @method('PATCH')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function deleteVoucher(voucherId, voucherName) {
        if (confirm(`Apakah Anda yakin ingin menghapus voucher "${voucherName}"?\n\nPerhatian: Voucher yang sudah dimiliki pengguna tidak dapat dihapus.`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/vouchers') }}/${voucherId}`;
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
@endsection
