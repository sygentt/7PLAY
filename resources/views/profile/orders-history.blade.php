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
		<div class="space-y-6">
			@foreach($orders as $order)
				<div class="bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:shadow-lg transition-shadow">
					<div class="flex justify-between items-start mb-4">
						<div>
							<h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
								Order #{{ $order->order_number }}
							</h3>
							<p class="text-sm text-gray-500 dark:text-gray-400">
								{{ $order->created_at->format('d F Y, H:i') }}
							</p>
						</div>
						<div class="text-right">
							@php
								$statusConfig = [
									'pending' => ['text' => 'Menunggu Pembayaran', 'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100'],
									'confirmed' => ['text' => 'Dikonfirmasi', 'class' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'],
									'cancelled' => ['text' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100'],
									'expired' => ['text' => 'Kadaluarsa', 'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100'],
								];
								$config = $statusConfig[$order->status] ?? $statusConfig['pending'];
							@endphp
							<span class="px-3 py-1 {{ $config['class'] }} text-sm rounded-full">
								{{ $config['text'] }}
							</span>
							<p class="text-sm font-semibold text-gray-900 dark:text-gray-100 mt-1">
								Rp {{ number_format($order->total_amount, 0, ',', '.') }}
							</p>
						</div>
					</div>

					@foreach($order->orderItems as $item)
						<div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4">
							<div class="flex items-start space-x-4">
								<div class="w-16 h-24 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden flex-shrink-0">
									@if($item->showtime->movie->poster_url)
										<img src="{{ $item->showtime->movie->poster_url }}" alt="{{ $item->showtime->movie->title }}" class="w-full h-full object-cover">
									@else
										<div class="w-full h-full flex items-center justify-center">
											<x-heroicon-o-film class="w-6 h-6 text-gray-400" />
										</div>
									@endif
								</div>
								
								<div class="flex-1">
									<h4 class="font-semibold text-gray-900 dark:text-gray-100">
										{{ $item->showtime->movie->title }}
									</h4>
									<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
										{{ $item->showtime->cinemaHall->cinema->name }} - {{ $item->showtime->cinemaHall->name }}
									</p>
									<p class="text-sm text-gray-500 dark:text-gray-400">
										{{ $item->showtime->show_time->format('d F Y, H:i') }}
									</p>
									<p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
										{{ $item->quantity }} tiket • Rp {{ number_format($item->subtotal, 0, ',', '.') }}
									</p>
								</div>

								<div class="text-right">
									@if($order->status === 'confirmed' && $item->showtime->show_time > now())
										<span class="inline-flex items-center text-xs bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-100 px-2 py-1 rounded-full">
											<x-heroicon-o-check-circle class="w-3 h-3 mr-1" />
											Aktif
										</span>
									@elseif($order->status === 'confirmed' && $item->showtime->show_time <= now())
										<span class="inline-flex items-center text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-full">
											<x-heroicon-o-clock class="w-3 h-3 mr-1" />
											Selesai
										</span>
									@endif
								</div>
							</div>
						</div>
					@endforeach

					@if($order->payment)
						<div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4">
							<div class="text-sm text-gray-500 dark:text-gray-400">
								<p><strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment->payment_method) }}</p>
								@if($order->payment->payment_reference)
									<p><strong>Referensi:</strong> {{ $order->payment->payment_reference }}</p>
								@endif
								@if($order->payment->paid_at)
									<p><strong>Dibayar pada:</strong> {{ $order->payment->paid_at->format('d F Y, H:i') }}</p>
								@endif
							</div>
						</div>
					@endif
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

