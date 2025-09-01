@props([
	'href' => '#',
	'title' => '',
	'icon' => 'user',
	'subtitle' => null,
	'method' => 'get',
])

@if(strtolower($method) === 'post')
    <form method="POST" action="{{ $href }}">
    	@csrf
    	<button type="submit" class="w-full text-left group flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/60 dark:bg-gray-800/60 hover:bg-white dark:hover:bg-gray-800 transition-colors shadow-sm">
    		<div class="flex-shrink-0 mr-4">
    			<x-dynamic-component :component="'heroicon-o-' . $icon" class="w-6 h-6 text-cinema-600 dark:text-cinema-400 group-hover:scale-105 transition-transform" />
    		</div>
    		<div class="flex-1">
    			<div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $title }}</div>
    			@if($subtitle)
    				<div class="text-xs text-gray-500 dark:text-gray-400">{{ $subtitle }}</div>
    			@endif
    		</div>
    		<div>
    			<x-heroicon-o-chevron-right class="w-5 h-5 text-gray-400 group-hover:text-gray-500" />
    		</div>
    	</button>
    </form>
@else
    <a href="{{ $href }}" class="group flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/60 dark:bg-gray-800/60 hover:bg-white dark:hover:bg-gray-800 transition-colors shadow-sm">
		<div class="flex-shrink-0 mr-4">
			<x-dynamic-component :component="'heroicon-o-' . $icon" class="w-6 h-6 text-cinema-600 dark:text-cinema-400 group-hover:scale-105 transition-transform" />
		</div>
		<div class="flex-1">
			<div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $title }}</div>
			@if($subtitle)
				<div class="text-xs text-gray-500 dark:text-gray-400">{{ $subtitle }}</div>
			@endif
		</div>
		<div>
			<x-heroicon-o-chevron-right class="w-5 h-5 text-gray-400 group-hover:text-gray-500" />
		</div>
	</a>
@endif


