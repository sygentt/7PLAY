@extends('layouts.public')

@section('title', 'Verifikasi Tiket - ' . config('app.name', '7PLAY'))

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
		<!-- Header -->
		<div class="text-center mb-8">
			<div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
				<x-heroicon-o-check-circle class="w-12 h-12 text-green-600" />
			</div>
			<h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Tiket Valid</h1>
			<p class="text-lg text-gray-600 dark:text-gray-400">QR Code berhasil diverifikasi</p>
		</div>

		<!-- Ticket Information Card -->
		<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
			<!-- Owner Information -->
			<div class="bg-gradient-to-r from-cinema-600 to-cinema-700 text-white p-6">
				<h2 class="text-xl font-semibold mb-2">Informasi Pemilik Tiket</h2>
				<p class="text-cinema-100">
					Tiket ini dimiliki oleh <strong class="text-white">{{ $order->user->name }}</strong>
				</p>
				<p class="text-cinema-100 text-sm mt-1">
					Dipesan pada {{ $order->created_at->format('d F Y, H:i') }}
				</p>
			</div>

			<!-- Movie & Showtime Information -->
			<div class="p-6">
				<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
					<!-- Movie Poster -->
					<div class="lg:col-span-1">
						<div class="w-full max-w-xs mx-auto">
							<div class="aspect-[3/4] bg-gray-200 dark:bg-gray-700 rounded-xl overflow-hidden shadow-lg">
								@if($order->orderItems->first()->showtime->movie->poster_url)
									<img src="{{ $order->orderItems->first()->showtime->movie->poster_url }}" 
										 alt="{{ $order->orderItems->first()->showtime->movie->title }}" 
										 class="w-full h-full object-cover">
								@else
									<img src="https://dummyimage.com/300x400/9CA3AF/FFFFFF&text={{ urlencode($order->orderItems->first()->showtime->movie->title) }}" 
										 alt="{{ $order->orderItems->first()->showtime->movie->title }}" 
										 class="w-full h-full object-cover">
								@endif
							</div>
						</div>
					</div>

					<!-- Movie Details -->
					<div class="lg:col-span-2">
						<h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
							{{ $order->orderItems->first()->showtime->movie->title }}
						</h3>

						<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
							<!-- Showtime Info -->
							<div class="space-y-4">
								<div>
									<span class="text-gray-500 dark:text-gray-400 block">Tanggal & Waktu Tayang:</span>
									<p class="font-semibold text-gray-900 dark:text-gray-100">
										{{ $order->orderItems->first()->showtime->show_date->format('l, d F Y') }}
									</p>
									<p class="font-semibold text-gray-900 dark:text-gray-100">
										{{ $order->orderItems->first()->showtime->show_time->format('H:i') }} WIB
									</p>
								</div>

								<div>
									<span class="text-gray-500 dark:text-gray-400 block">Bioskop:</span>
									<p class="font-semibold text-gray-900 dark:text-gray-100">
										{{ $order->orderItems->first()->showtime->cinemaHall->cinema->name }}
									</p>
									<p class="text-gray-600 dark:text-gray-300">
										{{ $order->orderItems->first()->showtime->cinemaHall->name }}
									</p>
								</div>
							</div>

							<!-- Seat Info -->
							<div class="space-y-4">
								<div>
									<span class="text-gray-500 dark:text-gray-400 block">Kursi:</span>
									@foreach($order->orderItems as $item)
										<div class="flex items-center gap-2 mt-1">
											<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cinema-100 text-cinema-800">
												{{ $item->seat->row_label }}{{ $item->seat->seat_number }}
											</span>
											<span class="text-gray-500 text-xs">({{ ucfirst($item->seat->type) }})</span>
										</div>
									@endforeach
								</div>

								<div>
									<span class="text-gray-500 dark:text-gray-400 block">Total Tiket:</span>
									<p class="font-semibold text-gray-900 dark:text-gray-100">
										{{ $order->getTicketCount() }} tiket
									</p>
								</div>

								<div>
									<span class="text-gray-500 dark:text-gray-400 block">Total Harga:</span>
									<p class="font-semibold text-gray-900 dark:text-gray-100">
										Rp {{ number_format($order->total_amount, 0, ',', '.') }}
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Order Status -->
			<div class="border-t border-gray-200 dark:border-gray-600 p-6">
				<div class="flex items-center justify-between">
					<div>
						<span class="text-gray-500 dark:text-gray-400">Status Pesanan:</span>
						<div class="mt-1">
							<x-ui.order-status-badge :order="$order" />
						</div>
					</div>
					<div class="text-right">
						<span class="text-gray-500 dark:text-gray-400 text-sm">Nomor Order:</span>
						<p class="font-mono font-semibold text-gray-900 dark:text-gray-100">{{ $order->order_number }}</p>
					</div>
				</div>
			</div>
		</div>

		<!-- Verification Info -->
		<div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
			<div class="flex items-start">
				<x-heroicon-o-information-circle class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-3 mt-0.5 flex-shrink-0" />
				<div>
					<h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Informasi Verifikasi</h4>
					<ul class="text-blue-800 dark:text-blue-200 text-sm space-y-1">
						<li>• Tiket ini telah diverifikasi dan valid untuk digunakan</li>
						<li>• Pastikan identitas pemegang tiket sesuai dengan yang tertera</li>
						<li>• Tiket berlaku sesuai tanggal dan waktu yang tercantum</li>
						<li>• Silakan tunjukkan tiket fisik atau e-tiket saat masuk bioskop</li>
					</ul>
				</div>
			</div>
		</div>

		<!-- Footer -->
		<div class="mt-8 text-center">
			<p class="text-gray-500 dark:text-gray-400 text-sm">
				Verifikasi dilakukan pada {{ now()->format('d F Y, H:i') }} WIB
			</p>
			<div class="mt-4">
				<a href="{{ route('home') }}" 
				   class="inline-flex items-center px-6 py-2 bg-cinema-600 hover:bg-cinema-700 text-white rounded-lg transition-colors">
					<x-heroicon-o-home class="w-5 h-5 mr-2" />
					Kembali ke Beranda
				</a>
			</div>
		</div>
	</div>
</div>
@endsection

