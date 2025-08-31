@props(['movie'])

<button class="flex items-center bg-white bg-opacity-90 hover:bg-opacity-100 text-gray-800 px-4 py-2 rounded-lg transition-all duration-200">
    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
    </svg>
    <span class="font-medium">Lihat trailer</span>
    <span class="ml-2 text-sm text-gray-600">{{ $movie->getFormattedDuration() }}</span>
    <span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
        {{ $movie->rating }}
    </span>
</button>
