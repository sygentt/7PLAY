@extends('layouts.public')

@section('title', 'Favorit - ' . config('app.name', '7PLAY'))

@section('content')
	<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
			<x-ui.breadcrumb :items="[
		['title' => 'Beranda', 'url' => route('home')],
		['title' => 'Profil', 'url' => route('profile.edit')],
		['title' => 'Film Favorit']
	]" />

			<h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Film Favorit</h1>
	
	@if($favorites->count() > 0)
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
			@foreach($favorites as $movie)
				<div class="bg-white/80 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
					<!-- Movie Poster -->
					<div class="aspect-[2/3] bg-gray-200 dark:bg-gray-700 relative">
						@if($movie->poster_url)
							<img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" 
								 class="w-full h-full object-cover">
						@else
							<div class="w-full h-full flex items-center justify-center">
								<x-heroicon-o-film class="w-12 h-12 text-gray-400" />
							</div>
						@endif
						
						<!-- Remove from favorites button -->
						<button onclick="removeFavorite({{ $movie->id }})" 
								class="absolute top-2 right-2 p-2 bg-red-500 hover:bg-red-600 text-white rounded-full transition-colors"
								title="Hapus dari favorit">
							<x-heroicon-o-heart class="w-4 h-4 fill-current" />
						</button>
					</div>
					
					<!-- Movie Info -->
					<div class="p-4">
						<h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-1 line-clamp-2">
							{{ $movie->title }}
						</h3>
						<p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
							{{ $movie->genre }} • {{ $movie->duration }} menit
						</p>
						<p class="text-xs text-gray-400 dark:text-gray-500 mb-3">
							Rating: {{ $movie->rating }}
						</p>
						
						@if($movie->showtimes->count() > 0)
							<a href="{{ route('movies.show', $movie->id) }}" 
							   class="inline-flex items-center text-xs bg-cinema-600 hover:bg-cinema-700 text-white px-3 py-1 rounded-full transition-colors">
								<x-heroicon-o-ticket class="w-3 h-3 mr-1" />
								Lihat Jadwal
							</a>
						@else
							<span class="inline-flex items-center text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-3 py-1 rounded-full">
								Tidak ada jadwal
							</span>
						@endif
					</div>
				</div>
			@endforeach
		</div>
		
		<!-- Pagination -->
		@if($favorites->hasPages())
			<div class="mt-8">
				{{ $favorites->links() }}
			</div>
		@endif
	@else
		<div class="text-center py-12">
			<x-heroicon-o-heart class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" />
			<h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Belum ada film favorit</h3>
			<p class="text-gray-500 dark:text-gray-400 mb-6">Tambahkan film ke favorit untuk melihatnya di sini.</p>
			<a href="{{ route('movies.index') }}" 
			   class="inline-flex items-center px-4 py-2 bg-cinema-600 hover:bg-cinema-700 text-white rounded-lg transition-colors">
				<x-heroicon-o-film class="w-4 h-4 mr-2" />
				Jelajahi Film
			</a>
		</div>
	@endif
	</section>
@endsection

<script>
async function removeFavorite(movieId) {
	try {
		const response = await fetch(`/favorites/${movieId}`, {
			method: 'DELETE',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			}
		});

		const data = await response.json();

		if (data.success) {
			// Show success message
			if (window.Toast) {
				window.Toast.show(data.message, 'success', 3000);
			}
			
			// Reload page to update the list
			setTimeout(() => {
				window.location.reload();
			}, 1000);
		} else {
			if (window.Toast) {
				window.Toast.show(data.message || 'Terjadi kesalahan saat menghapus favorit.', 'error', 5000);
			}
		}
	} catch (error) {
		console.error('Error removing favorite:', error);
		if (window.Toast) {
			window.Toast.show('Terjadi kesalahan jaringan. Silakan coba lagi.', 'error', 5000);
		}
	}
}
</script>

