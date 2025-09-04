@extends('layouts.public')

@section('title', 'Tiket Saya - ' . config('app.name', '7PLAY'))

@section('content')
	<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
			<x-ui.breadcrumb :items="[
		['title' => 'Beranda', 'url' => route('home')],
		['title' => 'Profil', 'url' => route('profile.edit')],
		['title' => 'Tiket Saya']
	]" />

		<h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Tiket Saya</h1>

			<div x-data="{ tab: 'active' }">
		<div class="flex space-x-2 mb-6">
			<button @click="tab='active'" :class="tab==='active' ? 'bg-cinema-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300'" class="px-4 py-2 rounded-lg font-medium">
				Tiket Aktif ({{ $activeTickets->count() }})
			</button>
			<button @click="tab='expired'" :class="tab==='expired' ? 'bg-cinema-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300'" class="px-4 py-2 rounded-lg font-medium">
				Tiket Kadaluarsa ({{ $expiredTickets->total() }})
			</button>
		</div>

		<!-- Active Tickets Tab -->
		<div x-show="tab==='active'" class="space-y-4">
			@if($activeTickets->count() > 0)
				@foreach($activeTickets as $order)
					<div class="bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:shadow-lg transition-shadow">
						<div class="flex justify-between items-start mb-4">
							<div>
								<h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
									Order #{{ $order->order_number }}
								</h3>
								<p class="text-sm text-gray-500 dark:text-gray-400">
									Dibuat pada {{ $order->created_at->format('d F Y, H:i') }}
								</p>
							</div>
							<span class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 text-sm rounded-full">
								Aktif
							</span>
						</div>

						@foreach($order->orderItems as $item)
							<div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4">
								<div class="flex items-start space-x-4">
									<div class="w-16 h-24 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden flex-shrink-0">
										@if($item->showtime->movie->poster_url)
											<img src="{{ $item->showtime->movie->poster_url }}" alt="{{ $item->showtime->movie->title }}" class="w-full h-full object-cover">
										@else
											<img src="https://dummyimage.com/64x96/cccccc/000000&text={{ urlencode($item->showtime->movie->title) }}" alt="{{ $item->showtime->movie->title }}" class="w-full h-full object-cover">
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
											1 tiket • Rp {{ number_format($item->price, 0, ',', '.') }}
										</p>
									</div>

									<div class="text-right">
										<a href="{{ route('profile.tickets.eticket', $order) }}" class="inline-flex items-center px-3 py-1 bg-cinema-600 hover:bg-cinema-700 text-white text-sm rounded-lg transition-colors">
											<x-heroicon-o-ticket class="w-4 h-4 mr-1" />
											E-tiket
										</a>
									</div>
								</div>
							</div>
						@endforeach

						<div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4">
							<div class="flex justify-between items-center">
								<span class="font-semibold text-gray-900 dark:text-gray-100">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
							</div>
						</div>
					</div>
				@endforeach
			@else
				<div class="text-center py-12">
					<x-heroicon-o-ticket class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" />
					<h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Belum ada tiket aktif</h3>
					<p class="text-gray-500 dark:text-gray-400 mb-6">Pesan tiket film favorit Anda sekarang!</p>
					<a href="{{ route('movies.index') }}" class="inline-flex items-center px-4 py-2 bg-cinema-600 hover:bg-cinema-700 text-white rounded-lg transition-colors">
						<x-heroicon-o-film class="w-4 h-4 mr-2" />
						Jelajahi Film
					</a>
				</div>
			@endif
		</div>

		<!-- Expired Tickets Tab -->
		<div x-show="tab==='expired'" class="space-y-4">
			@if($expiredTickets->count() > 0)
				@foreach($expiredTickets as $order)
					<div class="bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
						<div class="flex items-center justify-between">
							<!-- Order Info -->
							<div class="flex-1">
								<div class="flex items-center gap-3 mb-2">
									<h3 class="font-semibold text-gray-900 dark:text-gray-100">
										#{{ $order->order_number }}
									</h3>
									<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">Kadaluarsa</span>
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

				<!-- Pagination for expired -->
				@if($expiredTickets->hasPages())
					<div class="mt-6">
						{{ $expiredTickets->links() }}
					</div>
				@endif
			@else
				<div class="text-center py-12">
					<x-heroicon-o-clock class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" />
					<h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Belum ada tiket kadaluarsa</h3>
					<p class="text-gray-500 dark:text-gray-400">Tiket yang sudah lewat akan muncul di sini.</p>
				</div>
			@endif
		</div>
	</div>
	</section>
@endsection

