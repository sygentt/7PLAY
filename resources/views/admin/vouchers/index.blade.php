@extends('admin.layouts.app')

@section('title', 'Vouchers - 7PLAY Admin')
@section('page-title', 'Vouchers')
@section('page-description', 'Kelola voucher diskon dan penukaran poin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
	<div class="bg-white shadow-sm rounded-lg p-6">
		<div class="flex items-center justify-between mb-6">
			<form method="GET" class="flex items-center space-x-2">
				<input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama" class="border rounded px-3 py-2 text-sm" />
				<select name="status" class="border rounded px-3 py-2 text-sm">
					<option value="">Semua Status</option>
					<option value="active" @selected(request('status')==='active')>Aktif</option>
					<option value="inactive" @selected(request('status')==='inactive')>Nonaktif</option>
				</select>
				<button class="px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
			</form>
			<a href="{{ route('admin.vouchers.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Buat Voucher</a>
		</div>

		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
						<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
						<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
						<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
						<th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
						<th class="px-4 py-2"/>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					@forelse($vouchers as $voucher)
						<tr>
							<td class="px-4 py-2">{{ $voucher->name }}</td>
							<td class="px-4 py-2">{{ ucfirst($voucher->type) }}</td>
							<td class="px-4 py-2">
								@if($voucher->type === 'percentage')
									{{ number_format($voucher->value, 0) }}%
								@else
									Rp {{ number_format($voucher->value, 0, ',', '.') }}
								@endif
							</td>
							<td class="px-4 py-2 text-xs text-gray-600">{{ optional($voucher->valid_from)->format('d M Y') }} - {{ optional($voucher->valid_until)->format('d M Y') }}</td>
							<td class="px-4 py-2">
								<span class="px-2 py-1 text-xs rounded {{ $voucher->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
									{{ $voucher->is_active ? 'Aktif' : 'Nonaktif' }}
								</span>
							</td>
							<td class="px-4 py-2 text-right space-x-2 whitespace-nowrap">
								<a href="{{ route('admin.vouchers.show', $voucher) }}" class="text-blue-600 hover:underline">Detail</a>
								<a href="{{ route('admin.vouchers.edit', $voucher) }}" class="text-indigo-600 hover:underline">Edit</a>
								<form method="POST" action="{{ route('admin.vouchers.destroy', $voucher) }}" class="inline" onsubmit="return confirm('Hapus voucher ini?')">
									@csrf
									@method('DELETE')
									<button class="text-red-600 hover:underline">Hapus</button>
								</form>
								<form method="POST" action="{{ route('admin.vouchers.toggle-status', $voucher) }}" class="inline">
									@csrf
									@method('PATCH')
									<button class="text-gray-600 hover:underline">{{ $voucher->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
								</form>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada voucher.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		@if($vouchers->hasPages())
			<div class="mt-4">{{ $vouchers->links() }}</div>
		@endif
	</div>
</div>
@endsection


