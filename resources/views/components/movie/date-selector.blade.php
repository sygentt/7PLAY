@props(['dates', 'selectedDate', 'movieId'])

<div class="flex space-x-2 overflow-x-auto pb-2">
    @foreach($dates as $date)
        <a href="{{ route('movies.show', ['movie' => $movieId, 'date' => $date['date']->format('Y-m-d')]) }}" 
           class="flex-shrink-0 w-16 text-center py-3 px-2 rounded-lg border transition-colors {{ 
               $date['date']->isSameDay($selectedDate) 
                   ? 'bg-teal-600 text-white border-teal-600' 
                   : ($date['has_showtimes'] 
                       ? 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' 
                       : 'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed')
           }}">
            <div class="text-xs font-medium">
                {{ $date['formatted_day'] }}
            </div>
            <div class="text-lg font-bold">
                {{ $date['formatted_date'] }}
            </div>
            @if(!$date['has_showtimes'])
                <div class="text-xs text-gray-400 mt-1">
                    Tidak Ada
                </div>
            @endif
        </a>
    @endforeach
</div>
