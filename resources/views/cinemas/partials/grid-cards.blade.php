@foreach(($cinemas ?? []) as $cinema)
<div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 group">
	<!-- Cinema Image -->
	<div class="relative h-48 overflow-hidden">
		<img 
			src="https://dummyimage.com/400x200/1f2937/ffffff&text={{ urlencode($cinema->brand . ' ' . $cinema->name) }}" 
			alt="{{ $cinema->full_name }}"
			class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
		>
		<div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
		<div class="absolute top-4 left-4">
			<span class="px-3 py-1 bg-cinema-600 text-white text-sm font-semibold rounded-full">
				{{ $cinema->brand ?? 'Cinema' }}
			</span>
		</div>
	</div>
	<!-- Cinema Info -->
	<div class="p-6">
		<h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $cinema->full_name }}</h3>
		<div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 mb-4">
			<x-heroicon-o-map-pin class="w-4 h-4" />
			<span class="text-sm">{{ $cinema->city->name }}</span>
		</div>
		<div class="flex flex-wrap gap-2 mb-6">
			@foreach($cinema['facilities'] ?? [] as $facility)
				<span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-lg">{{ $facility }}</span>
			@endforeach
		</div>
		<div class="flex space-x-3">
			<a href="#" class="flex-1 px-4 py-2 bg-cinema-600 hover:bg-cinema-700 text-white font-semibold rounded-lg transition-colors duration-200">Lihat Jadwal</a>
			<button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
				<x-heroicon-o-map-pin class="w-4 h-4" />
			</button>
		</div>
	</div>
</div>
@endforeach
