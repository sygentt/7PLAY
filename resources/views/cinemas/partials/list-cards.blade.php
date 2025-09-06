@foreach(($cinemas ?? []) as $cinema)
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-lg transition-all duration-300 border border-gray-200 dark:border-gray-700 overflow-hidden">
	<div class="flex p-6">
		<div class="relative w-40 h-24 flex-shrink-0 rounded-xl overflow-hidden">
			<img 
				src="https://dummyimage.com/320x180/1f2937/ffffff&text={{ urlencode($cinema->brand . ' ' . $cinema->name) }}" 
				alt="{{ $cinema->full_name }}"
				class="w-full h-full object-cover"
			>
		</div>
		<div class="flex-1 ml-6">
			<div class="flex items-start justify-between">
				<div>
					<h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $cinema->full_name }}</h3>
					<div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 mb-2">
						<x-heroicon-o-map-pin class="w-4 h-4" />
						<span class="text-sm">{{ $cinema->city->name }}</span>
					</div>
					<div class="flex flex-wrap gap-2 mb-2">
						@foreach($cinema['facilities'] ?? [] as $facility)
							<span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-lg">{{ $facility }}</span>
						@endforeach
					</div>
				</div>
				<div class="ml-4">
					<a href="#" class="px-4 py-2 bg-cinema-600 hover:bg-cinema-700 text-white font-semibold rounded-lg transition-colors duration-200">Lihat Jadwal</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endforeach
