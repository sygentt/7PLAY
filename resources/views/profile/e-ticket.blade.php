@extends('layouts.public')

@section('title', 'E-Tiket #' . $order->order_number . ' - ' . config('app.name', '7PLAY'))

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8">
	<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
		<!-- Breadcrumb -->
		<x-ui.breadcrumb :items="[
			['title' => 'Beranda', 'url' => route('home')],
			['title' => 'Profil', 'url' => route('profile.edit')],
			['title' => 'Tiket Saya', 'url' => route('profile.tickets')],
			['title' => 'E-Tiket']
		]" />

		<!-- E-Ticket Card -->
		<div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
			<!-- Header Section (Cinema Theme Background) -->
			<div class="bg-gradient-to-br from-cinema-900 via-cinema-800 to-cinema-900 text-white p-8">
				<div class="flex items-start space-x-6">
					<!-- Movie Poster -->
					<div class="flex-shrink-0">
						<div class="w-32 h-48 bg-gray-700 rounded-xl overflow-hidden shadow-xl">
							@if($order->orderItems->first()->showtime->movie->poster_url)
								<img src="{{ $order->orderItems->first()->showtime->movie->poster_url }}" 
									 alt="{{ $order->orderItems->first()->showtime->movie->title }}" 
									 class="w-full h-full object-cover">
							@else
								<img src="https://dummyimage.com/128x192/4B5563/FFFFFF&text={{ urlencode($order->orderItems->first()->showtime->movie->title) }}" 
									 alt="{{ $order->orderItems->first()->showtime->movie->title }}" 
									 class="w-full h-full object-cover">
							@endif
						</div>
					</div>

					<!-- Movie Info -->
					<div class="flex-1">
						<h1 class="text-3xl font-bold text-gold-400 mb-6">
							{{ $order->orderItems->first()->showtime->movie->title }}
						</h1>

						<div class="space-y-4">
							<div class="flex items-center">
								<span class="text-gray-300 w-20 text-sm">Tanggal</span>
								<span class="text-white font-semibold text-xl">
									{{ $order->orderItems->first()->showtime->show_time->format('D, d M Y') }}
								</span>
							</div>

							<div class="flex items-center">
								<span class="text-gray-300 w-20 text-sm">Jam</span>
								<span class="text-white font-semibold text-xl">
									{{ $order->orderItems->first()->showtime->show_time->format('H:i') }}
								</span>
							</div>

							<div class="flex items-start">
								<span class="text-gray-300 w-20 text-sm">Bioskop</span>
								<div class="text-white font-semibold text-lg leading-tight">
									{{ strtoupper($order->orderItems->first()->showtime->cinemaHall->cinema->name) }}<br>
									<span class="text-base">{{ $order->orderItems->first()->showtime->cinemaHall->name }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Ticket Info Section (Gold Background) -->
			<div class="bg-gradient-to-r from-gold-400 to-gold-500 text-gray-900 p-8">
				<div class="flex items-center justify-between">
					<!-- Left Section -->
					<div class="space-y-4">
						<div>
							<h3 class="text-lg font-semibold mb-2">Jumlah Tiket</h3>
							<div class="text-2xl font-bold">
								{{ $order->getTicketCount() }} Orang
							</div>
							<div class="text-lg font-medium">
								@foreach($order->orderItems as $item)
									{{ $item->seat->row_label }}{{ $item->seat->seat_number }}@if(!$loop->last), @endif
								@endforeach
							</div>
						</div>

						<div>
							<h3 class="text-lg font-semibold mb-2">Kode Transaksi</h3>
							<div class="text-3xl font-bold tracking-wider">
								{{ substr($order->order_number, -5) }}
							</div>
						</div>
					</div>

					<!-- QR Code Section -->
					<div class="text-center">
						<div class="bg-white p-4 rounded-xl shadow-lg">
							<canvas id="qrcode" class="w-24 h-24 mx-auto" width="96" height="96"></canvas>
						</div>
						<div class="bg-cinema-900 text-white px-4 py-2 rounded-lg text-sm font-semibold mt-2">
							Kode QR
						</div>
					</div>
				</div>
			</div>

			<!-- Dotted Separator -->
			<div class="border-t-2 border-dashed border-gray-300"></div>

			<!-- Order Number Section -->
			<div class="bg-gray-50 p-6 text-center">
				<div class="text-gray-600 text-sm mb-1">NOMOR ORDER:</div>
				<div class="text-gray-900 text-xl font-mono font-bold tracking-wider">
					{{ $order->order_number }}
				</div>
			</div>
		</div>

		<!-- Action Buttons -->
		<div class="mt-8 flex flex-col sm:flex-row gap-4">
			<a href="{{ route('profile.tickets') }}" 
			   class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
				<x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
				Kembali ke Tiket Saya
			</a>
			
			<button onclick="window.print()" 
					class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-cinema-600 hover:bg-cinema-700 text-white rounded-lg transition-colors">
				<x-heroicon-o-printer class="w-5 h-5 mr-2" />
				Cetak E-Tiket
			</button>
		</div>
	</div>
</div>

<!-- QR Code Generation -->
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const qrCodeUrl = '{{ $order->getQrVerificationUrl() }}';
		const canvas = document.getElementById('qrcode');
		
		console.log('QR URL:', qrCodeUrl);
		console.log('Canvas element:', canvas);
		console.log('QRCode available:', !!window.QRCode);
		
		if (!canvas) {
			console.error('Canvas element not found');
			return;
		}
		
		if (window.QRCode) {
			// Use the correct API signature from Node QRCode documentation
			window.QRCode.toCanvas(canvas, qrCodeUrl, {
				errorCorrectionLevel: 'M',
				margin: 1,
				color: {
					dark: '#000000',  // hitam
					light: '#ffffff'
				},
				width: 96
			}, function (error) {
				if (error) {
					console.error('QR Code generation error:', error);
					// Show error on canvas
					const ctx = canvas.getContext('2d');
					ctx.fillStyle = '#f3f4f6';
					ctx.fillRect(0, 0, 96, 96);
					ctx.fillStyle = '#374151';
					ctx.font = '10px Arial';
					ctx.textAlign = 'center';
					ctx.fillText('QR Error', 48, 48);
				} else {
					console.log('QR Code generated successfully');
				}
			});
		} else {
			console.error('QRCode library not loaded');
			// Show placeholder on canvas
			const ctx = canvas.getContext('2d');
			ctx.fillStyle = '#f3f4f6';
			ctx.fillRect(0, 0, 96, 96);
			ctx.fillStyle = '#374151';
			ctx.font = '10px Arial';
			ctx.textAlign = 'center';
			ctx.fillText('QR N/A', 48, 48);
		}
	});
</script>

<style>
	@media print {
		body * {
			visibility: hidden;
		}
		
		.bg-gray-100, .max-w-2xl, .max-w-2xl * {
			visibility: visible;
		}
		
		.max-w-2xl {
			position: absolute;
			left: 0;
			top: 0;
			width: 100% !important;
			max-width: none !important;
		}
		
		/* Hide navigation and buttons when printing */
		nav, .breadcrumb, .mt-8 {
			display: none !important;
		}
		
		/* Ensure colors print properly */
		.bg-gradient-to-br,
		.bg-gradient-to-r {
			-webkit-print-color-adjust: exact;
			color-adjust: exact;
		}
	}
</style>
@endsection
