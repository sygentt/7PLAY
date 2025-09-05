@extends('layouts.public')

@section('title', 'Notifikasi - ' . config('app.name', '7PLAY'))

@section('content')
	<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
			<x-ui.breadcrumb :items="[
		['title' => 'Beranda', 'url' => route('home')],
		['title' => 'Profil', 'url' => route('profile.edit')],
		['title' => 'Notifikasi']
	]" />

			<div class="flex justify-between items-center mb-6">
		<h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Notifikasi</h1>
		@if($notifications->count() > 0)
			<button onclick="markAllAsRead()" class="text-sm text-cinema-600 hover:text-cinema-700 dark:text-cinema-400 dark:hover:text-cinema-300">
				Tandai semua dibaca
			</button>
		@endif
	</div>
	
	@if($notifications->count() > 0)
		<div class="space-y-4">
			@foreach($notifications as $notification)
				<div class="bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:shadow-md transition-shadow {{ !$notification->is_read ? 'border-l-4 border-l-cinema-500' : '' }}">
					<div class="flex items-start space-x-3">
						<div class="flex-shrink-0 mt-1">
							<div class="w-8 h-8 rounded-full bg-cinema-100 dark:bg-cinema-900 flex items-center justify-center">
								<x-dynamic-component :component="'heroicon-o-' . $notification->icon" class="w-4 h-4 {{ $notification->color_class }}" />
							</div>
						</div>
						
						<div class="flex-1 min-w-0">
							<div class="flex items-start justify-between">
								<div class="flex-1">
									<h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 {{ !$notification->is_read ? 'font-bold' : '' }}">
										{{ $notification->title }}
									</h3>
									<p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
										{{ $notification->message }}
									</p>
									<p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
										{{ $notification->created_at->diffForHumans() }}
									</p>
								</div>
								
								@if(!$notification->is_read)
									<div class="ml-2">
										<div class="w-2 h-2 bg-cinema-500 rounded-full"></div>
									</div>
								@endif
							</div>
							
							@if($notification->data && isset($notification->data['action_url']))
								<div class="mt-3">
									<a href="{{ $notification->data['action_url'] }}" 
									   class="inline-flex items-center text-xs bg-cinema-600 hover:bg-cinema-700 text-white px-3 py-1 rounded-full transition-colors">
										Lihat Detail
										<x-heroicon-o-arrow-right class="w-3 h-3 ml-1" />
									</a>
								</div>
							@endif
						</div>
					</div>
				</div>
			@endforeach
		</div>

		<!-- Pagination -->
		@if($notifications->hasPages())
			<div class="mt-8">
				{{ $notifications->links() }}
			</div>
		@endif
	@else
		<div class="text-center py-12">
			<x-heroicon-o-bell-slash class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" />
			<h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Belum ada notifikasi</h3>
			<p class="text-gray-500 dark:text-gray-400">Notifikasi Anda akan muncul di sini.</p>
		</div>
	@endif
	</section>
@endsection

<script>
async function markAllAsRead() {
	try {
		const response = await fetch('{{ route("notifications.mark-all-read") }}', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			}
		});

		const data = await response.json();

		if (data.success) {
			// Reload page to update the notifications
			window.location.reload();
		}
	} catch (error) {
		console.error('Error marking notifications as read:', error);
	}
}
</script>

