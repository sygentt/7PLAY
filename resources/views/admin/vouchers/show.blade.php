@extends('admin.layouts.app')

@section('title', 'Detail Voucher - 7PLAY Admin')
@section('page-title', 'Detail Voucher')
@section('page-description', 'Informasi lengkap voucher')

@section('content')
<div class="max-w-4xl mx-auto px-4">
	<div class="bg-white shadow-sm rounded-lg p-6 space-y-4">
		<div class="grid grid-cols-2 gap-4">
			
			<div>
				<div class="text-xs text-gray-500">Nama</div>
				<div>{{ $voucher->name }}</div>
			</div>
			<div>
				<div class="text-xs text-gray-500">Tipe</div>
				<div>{{ ucfirst($voucher->type) }}</div>
			</div>
			<div>
				<div class="text-xs text-gray-500">Nilai</div>
				<div>
					@if($voucher->type === 'percentage')
						{{ number_format($voucher->value, 0) }}%
					@else
						Rp {{ number_format($voucher->value, 0, ',', '.') }}
					@endif
				</div>
			</div>
			<div>
				<div class="text-xs text-gray-500">Periode</div>
				<div>{{ optional($voucher->valid_from)->format('d M Y') }} - {{ optional($voucher->valid_until)->format('d M Y') }}</div>
			</div>
			<div>
				<div class="text-xs text-gray-500">Status</div>
				<div>{{ $voucher->is_active ? 'Aktif' : 'Nonaktif' }}</div>
			</div>
		</div>

		<div class="pt-4">
			<a href="{{ route('admin.vouchers.edit', $voucher) }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Edit</a>
			<a href="{{ route('admin.vouchers.index') }}" class="ml-2 px-4 py-2 bg-gray-100 text-gray-700 rounded">Kembali</a>
		</div>
	</div>
</div>
@endsection


