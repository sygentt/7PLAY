@props(['movieId', 'isFavorited' => false])

<button
	x-data="{ isFavorited: @js($isFavorited), loading: false }"
	@click="async () => {
		if (loading) return;
		loading = true;
		try {
			const payload = { movie_id: {{ (int) $movieId }} };
			const response = await fetch('{{ route('favorites.toggle') }}', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
				},
				body: JSON.stringify(payload)
			});
			const data = await response.json();
			if (data && data.success !== undefined) {
				isFavorited = !!data.favorited;
				if (window.Toast) {
					window.Toast.show(data.message || (isFavorited ? 'Ditambahkan ke favorit' : 'Dihapus dari favorit'), isFavorited ? 'success' : 'info', 2500);
				}
			}
		} catch (e) {
			console.error(e);
			if (window.Toast) window.Toast.show('Gagal memperbarui favorit', 'error', 3000);
		} finally {
			loading = false;
		}
	}"
	:aria-pressed="isFavorited"
	class="p-2.5 rounded-xl transition-colors duration-200"
	:class="isFavorited ? 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600'"
	title="{{ $isFavorited ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}"
>
	<template x-if="isFavorited">
		<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path d="M11.645 20.91l-.007-.003-.022-.01a15.247 15.247 0 01-.383-.173 25.18 25.18 0 01-4.244-2.479C4.688 16.045 2.25 13.349 2.25 9.75 2.25 7.126 4.3 5.25 6.75 5.25c1.525 0 2.838.593 3.78 1.564a5.53 5.53 0 013.72-1.514h.04l.19.003c1.466.054 2.786.643 3.714 1.666.934 1.03 1.356 2.388 1.356 3.78 0 3.6-2.438 6.295-4.739 8.103a25.175 25.175 0 01-4.244 2.479 15.247 15.247 0 01-.383.173l-.022.01-.007.003-.003.001a.75.75 0 01-.574 0l-.003-.001z"/></svg>
	</template>
	<template x-if="!isFavorited">
		<x-heroicon-o-heart class="w-5 h-5" />
	</template>
</button>
