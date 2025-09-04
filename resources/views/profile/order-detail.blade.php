@extends('layouts.public')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - ' . config('app.name', '7PLAY'))

@section('content')
	<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
		<!-- Breadcrumb -->
		<x-ui.breadcrumb :items="[
			['title' => 'Beranda', 'url' => route('home')],
			['title' => 'Profil', 'url' => route('profile.edit')],
			['title' => 'Riwayat Pesanan', 'url' => route('profile.orders-history')],
			['title' => 'Detail Order']
		]" />

		<!-- Header -->
		<div class="flex items-center justify-between mb-6">
			<div>
				<h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Detail Pesanan</h1>
				<p class="text-sm text-gray-500 dark:text-gray-400">Order #{{ $order->order_number }}</p>
			</div>
			<x-ui.order-status-badge :order="$order" />
		</div>

		<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
			<!-- Order Details -->
			<div class="lg:col-span-2">
				<!-- Order Info -->
				<div class="bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 rounded-xl p-6 mb-6">
					<h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Pesanan</h2>
					<div class="grid grid-cols-2 gap-4 text-sm">
						<div>
							<span class="text-gray-500 dark:text-gray-400">Nomor Order:</span>
							<p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->order_number }}</p>
						</div>
						<div>
							<span class="text-gray-500 dark:text-gray-400">Tanggal Pemesanan:</span>
							<p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->created_at->format('d F Y, H:i') }}</p>
						</div>
						<div>
							<span class="text-gray-500 dark:text-gray-400">Status:</span>
							<div class="mt-1">
								<x-ui.order-status-badge :order="$order" />
							</div>
						</div>
						<div>
							<span class="text-gray-500 dark:text-gray-400">Total Tiket:</span>
							<p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->getTicketCount() }} tiket</p>
						</div>
					</div>
				</div>

				<!-- Ticket Details -->
				<div class="bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 rounded-xl p-6 mb-6" x-data="{ showAll: false }">
					<div class="flex items-center justify-between mb-4">
						<h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Detail Tiket</h2>
						@if($order->orderItems->count() > 2)
							<button @click="showAll = !showAll" 
									class="text-sm text-cinema-600 hover:text-cinema-700 dark:text-cinema-400 dark:hover:text-cinema-300 font-medium flex items-center gap-1">
								<span x-text="showAll ? 'Sembunyikan' : 'Lihat Semua ({{ $order->orderItems->count() }})'"></span>
								<x-heroicon-o-chevron-down x-show="!showAll" class="w-4 h-4 transition-transform" />
								<x-heroicon-o-chevron-up x-show="showAll" class="w-4 h-4 transition-transform" />
							</button>
						@endif
					</div>
					
					<div class="space-y-4">
						@foreach($order->orderItems as $index => $item)
							<div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg"
								 x-show="showAll || {{ $index }} < 2"
								 x-transition:enter="transition ease-out duration-300"
								 x-transition:enter-start="opacity-0 transform scale-95"
								 x-transition:enter-end="opacity-100 transform scale-100">
								<div class="w-16 h-24 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden flex-shrink-0">
									@if($item->showtime->movie->poster_url)
										<img src="{{ $item->showtime->movie->poster_url }}" alt="{{ $item->showtime->movie->title }}" class="w-full h-full object-cover">
									@else
										<img src="https://dummyimage.com/64x96/cccccc/000000&text={{ urlencode($item->showtime->movie->title) }}" alt="{{ $item->showtime->movie->title }}" class="w-full h-full object-cover">
									@endif
								</div>
								
								<div class="flex-1">
									<h3 class="font-semibold text-gray-900 dark:text-gray-100">
										{{ $item->showtime->movie->title }}
									</h3>
									<div class="mt-2 space-y-1 text-sm text-gray-600 dark:text-gray-300">
										<p><strong>Bioskop:</strong> {{ $item->showtime->cinemaHall->cinema->name }}</p>
										<p><strong>Studio:</strong> {{ $item->showtime->cinemaHall->name }}</p>
										<p><strong>Waktu Tayang:</strong> {{ $item->showtime->show_time->format('d F Y, H:i') }}</p>
										<p><strong>Kursi:</strong> {{ $item->seat->row_label }}{{ $item->seat->seat_number }} ({{ ucfirst($item->seat->type) }})</p>
									</div>
								</div>
								
								<div class="text-right">
									<p class="font-semibold text-gray-900 dark:text-gray-100">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
									@if($order->status === 'confirmed' && $item->showtime->show_time > now())
										<span class="inline-flex items-center text-xs bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-100 px-2 py-1 rounded-full mt-2">
											<x-heroicon-o-check-circle class="w-3 h-3 mr-1" />
											Aktif
										</span>
									@elseif($order->status === 'confirmed' && $item->showtime->show_time <= now())
										<span class="inline-flex items-center text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-full mt-2">
											<x-heroicon-o-clock class="w-3 h-3 mr-1" />
											Selesai
										</span>
									@endif
								</div>
							</div>
						@endforeach
						
						@if($order->orderItems->count() > 2)
							<div x-show="!showAll" class="text-center py-3">
								<p class="text-sm text-gray-500 dark:text-gray-400">
									+ {{ $order->orderItems->count() - 2 }} tiket lainnya
								</p>
							</div>
						@endif
					</div>
				</div>

				<!-- Payment Details -->
				@if($order->payment)
					<div class="bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
						<h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Pembayaran</h2>
						<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
							<div>
								<span class="text-gray-500 dark:text-gray-400">Metode Pembayaran:</span>
								<div class="mt-1">
									<x-ui.payment-method :payment="$order->payment" />
								</div>
							</div>
							@if(($order->payment->reference_no ?? null) || $order->payment_reference)
								<div>
									<span class="text-gray-500 dark:text-gray-400">Referensi:</span>
									<p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->payment->reference_no ?? $order->payment_reference }}</p>
								</div>
							@endif
							@if($order->payment->settlement_time)
								<div>
									<span class="text-gray-500 dark:text-gray-400">Waktu Pembayaran:</span>
									<p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->payment->settlement_time->format('d F Y, H:i') }}</p>
								</div>
							@elseif($order->payment->transaction_time)
								<div>
									<span class="text-gray-500 dark:text-gray-400">Waktu Transaksi:</span>
									<p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->payment->transaction_time->format('d F Y, H:i') }}</p>
								</div>
							@endif
							@if($order->payment->status)
								<div>
									<span class="text-gray-500 dark:text-gray-400">Status Pembayaran:</span>
									<p class="font-medium text-gray-900 dark:text-gray-100">{{ ucfirst($order->payment->status) }}</p>
								</div>
							@endif
						</div>
					</div>
				@endif
			</div>

			<!-- Order Summary -->
			<div class="lg:col-span-1">
				<div class="bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 rounded-xl p-6 sticky top-8">
					<h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ringkasan Pesanan</h2>
					
					<div class="space-y-3 text-sm">
						<div class="flex justify-between">
							<span class="text-gray-600 dark:text-gray-300">Subtotal:</span>
							<span class="font-medium text-gray-900 dark:text-gray-100">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
						</div>
						
						@if($order->discount_amount > 0)
							<div class="flex justify-between text-green-600 dark:text-green-400">
								<span>Diskon:</span>
								<span>-Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
							</div>
						@endif
						
						@if($order->points_used > 0)
							<div class="flex justify-between text-blue-600 dark:text-blue-400">
								<span>Poin Digunakan:</span>
								<span>{{ number_format($order->points_used) }} poin</span>
							</div>
						@endif
						
						<div class="border-t border-gray-200 dark:border-gray-600 pt-3">
							<div class="flex justify-between text-lg font-semibold text-gray-900 dark:text-gray-100">
								<span>Total:</span>
								<span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
							</div>
						</div>
						
						@if($order->points_earned > 0)
							<div class="text-center text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 p-2 rounded">
								Poin yang didapat: {{ number_format($order->points_earned) }} poin
							</div>
						@endif
					</div>

					<!-- Action Buttons -->
					<div class="mt-6 space-y-2">
						@if(in_array($order->status, ['confirmed', 'paid']) && $order->orderItems->where('showtime.show_time', '>', now())->count() > 0)
							<a href="{{ route('profile.tickets.eticket', $order) }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-cinema-600 hover:bg-cinema-700 text-white rounded-lg transition-colors">
								<x-heroicon-o-ticket class="w-4 h-4 mr-2" />
								Tampilkan E-tiket
							</a>
						@endif
						
						<a href="{{ route('profile.orders-history') }}" 
						   class="w-full inline-flex items-center justify-center px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
							<x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
							Kembali ke Riwayat
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
