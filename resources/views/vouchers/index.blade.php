@extends('layouts.public')

@section('title', 'Voucher Saya - ' . config('app.name', '7PLAY'))

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-black py-10">
	<div class="max-w-6xl mx-auto px-4">
		<div class="mb-8 flex items-center justify-between">
			<h1 class="text-2xl font-bold">Voucher Saya</h1>
			<a href="{{ route('points.index') }}" class="text-sm text-cinema-600 dark:text-cinema-400 hover:underline">&larr; Poin & Tukar Voucher</a>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			@forelse($user_vouchers as $uv)
				<div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
					<div>
						<div class="flex items-center justify-between mb-1">
							<div class="font-bold">{{ $uv->voucher->name }}</div>
							<span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700">{{ $uv->voucher->type === 'percentage' ? $uv->voucher->value . '% OFF' : 'Rp ' . number_format($uv->voucher->value,0,',','.') }}</span>
						</div>
						<div class="text-xs text-gray-500">Ditukar: {{ $uv->redeemed_at?->format('d M Y H:i') }}</div>
						@if($uv->voucher->min_purchase)
							<div class="text-xs text-gray-500 mt-1">Min. Pembelian: Rp {{ number_format($uv->voucher->min_purchase,0,',','.') }}</div>
						@endif
						<div class="text-xs text-gray-500 mt-1">Berlaku: {{ optional($uv->voucher->valid_from)->format('d M Y') }} - {{ optional($uv->voucher->valid_until)->format('d M Y') }}</div>
					</div>
					<div class="mt-4">
						@if($uv->is_used)
							<span class="text-xs px-2 py-1 rounded bg-gray-200 text-gray-700">Terpakai</span>
						@else
							<span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700">Belum dipakai</span>
						@endif
					</div>
				</div>
			@empty
				<div class="col-span-3 text-center text-gray-500">Belum ada voucher.</div>
			@endforelse
		</div>

		@if($user_vouchers->hasPages())
			<div class="mt-6">{{ $user_vouchers->links() }}</div>
		@endif
	</div>
</div>
@endsection


