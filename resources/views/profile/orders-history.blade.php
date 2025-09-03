@extends('layouts.public')

@section('title', 'Riwayat Pesanan - ' . config('app.name', '7PLAY'))

@section('content')
	<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
			<x-ui.breadcrumb :items="[
		['title' => 'Beranda', 'url' => route('home')],
		['title' => 'Profil', 'url' => route('profile.edit')],
		['title' => 'Riwayat Pesanan']
	]" />

			<h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Riwayat Pesanan</h1>
	
	@if($orders->count() > 0)
		<div class="space-y-4">
			@foreach($orders as $order)
				<div class="bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
					<div class="flex items-center justify-between">
						<!-- Order Info -->
						<div class="flex-1">
							<div class="flex items-center gap-3 mb-2">
								<h3 class="font-semibold text-gray-900 dark:text-gray-100">
									#{{ $order->order_number }}
								</h3>
								<x-ui.order-status-badge :order="$order" />
							</div>
							<div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
								<span>{{ $order->created_at->format('d M Y, H:i') }}</span>
								<span>{{ $order->getTicketCount() }} tiket</span>
								<span class="font-medium text-gray-900 dark:text-gray-100">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
							</div>
						</div>

						<!-- Action Button -->
						<div class="ml-4">
							<a href="{{ route('profile.orders.show', $order) }}" 
							   class="inline-flex items-center px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
								<x-heroicon-o-eye class="w-4 h-4 mr-1" />
								Detail
							</a>
						</div>
					</div>
				</div>
			@endforeach
		</div>

		<!-- Pagination -->
		@if($orders->hasPages())
			<div class="mt-8">
				{{ $orders->links() }}
			</div>
		@endif
	@else
		<div class="text-center py-12">
			<x-heroicon-o-receipt-percent class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" />
			<h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Belum ada riwayat pesanan</h3>
			<p class="text-gray-500 dark:text-gray-400 mb-6">Riwayat pesanan Anda akan muncul di sini setelah melakukan transaksi.</p>
			<a href="{{ route('movies.index') }}" 
			   class="inline-flex items-center px-4 py-2 bg-cinema-600 hover:bg-cinema-700 text-white rounded-lg transition-colors">
				<x-heroicon-o-film class="w-4 h-4 mr-2" />
				Jelajahi Film
			</a>
		</div>
	@endif
	</section>
@endsection

