@props(['movie', 'type' => 'now_playing'])

@php
    $isComingSoon = $type === 'coming_soon';
    $primaryColor = $isComingSoon ? 'gold' : 'cinema';
    $bgColor = $isComingSoon ? 'bg-white dark:bg-gray-700' : 'bg-white dark:bg-gray-800';
    $borderColor = $isComingSoon ? 'border-gray-200 dark:border-gray-600' : 'border-gray-200 dark:border-gray-700';
@endphp

<a href="{{ route('movies.show', $movie['id']) }}" class="group cursor-pointer block">
    <!-- Movie Card -->
    <div class="{{ $bgColor }} rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border {{ $borderColor }} h-full flex flex-col">
        
        <!-- Poster -->
        <div class="relative overflow-hidden rounded-t-2xl aspect-[2/3]">
            <img 
                src="{{ $movie['poster'] }}" 
                alt="{{ $movie['title'] }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            >
            
            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="absolute bottom-4 left-4 right-4">
                    <div class="w-full py-3 bg-{{ $primaryColor }}-600 hover:bg-{{ $primaryColor }}-700 text-white font-semibold rounded-xl transition-colors duration-200 transform translate-y-4 group-hover:translate-y-0 text-center">
                        {{ $isComingSoon ? 'Lihat Detail' : 'Beli Tiket' }}
                    </div>
                </div>
            </div>

            @if($isComingSoon)
                <!-- Coming Soon Badge -->
                <div class="absolute top-4 left-4 px-3 py-1 bg-gold-600 rounded-full text-white text-sm font-medium shadow-lg">
                    <span class="flex items-center space-x-1">
                        <x-heroicon-o-clock class="w-4 h-4" />
                        <span>Segera</span>
                    </span>
                </div>
                
                <!-- Release Date -->
                <div class="absolute top-4 right-4 px-3 py-1 bg-black/60 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                    {{ date('d M Y', strtotime($movie['release_date'])) }}
                </div>
            @else
                <!-- Rating Badge -->
                @if($movie['rating'])
                <div class="absolute top-4 left-4 px-3 py-1 bg-black/60 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                    <span class="flex items-center space-x-1">
                        <x-heroicon-o-star class="w-4 h-4 text-yellow-400" />
                        <span>{{ $movie['rating'] }}</span>
                    </span>
                </div>
                @endif
            @endif
            
            <!-- Play Button -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-16 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-50 group-hover:scale-100">
                <x-heroicon-o-play class="w-8 h-8 text-white" />
            </div>
        </div>

        <!-- Movie Info -->
        <div class="p-6 flex-1 flex flex-col">
            <!-- Title - Fixed height dengan line-clamp-2 -->
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-{{ $primaryColor }}-600 dark:group-hover:text-{{ $primaryColor }}-400 transition-colors duration-200 min-h-[3.5rem]">
                {{ $movie['title'] }}
            </h3>
            
            <!-- Genre & Duration - Fixed height -->
            <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mb-4 min-h-[2rem]">
                @if($isComingSoon)
                    <span class="px-2 py-1 bg-gold-100 dark:bg-gold-900/30 text-gold-700 dark:text-gold-300 rounded-lg">
                        {{ explode(', ', $movie['genre'])[0] }}
                    </span>
                @else
                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        {{ explode(', ', $movie['genre'])[0] }}
                    </span>
                @endif
                <span class="flex items-center space-x-1">
                    <x-heroicon-o-clock class="w-4 h-4" />
                    <span>{{ $movie['duration'] }}</span>
                </span>
            </div>

            <!-- Description - Fixed height dengan line-clamp-3 -->
            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-6 leading-relaxed flex-1 min-h-[4.5rem]">
                {{ $movie['description'] }}
            </p>

            <!-- Action Buttons -->
            <div class="flex space-x-3 mt-auto">
                <div class="flex-1 py-2.5 px-4 bg-gradient-to-r from-{{ $primaryColor }}-600 to-{{ $primaryColor }}-700 hover:from-{{ $primaryColor }}-700 hover:to-{{ $primaryColor }}-800 text-white font-semibold rounded-xl transition-all duration-200 text-sm text-center">
                    {{ $isComingSoon ? 'Lihat Detail' : 'Beli Tiket' }}
                </div>
                <div class="p-2.5 bg-gray-100 dark:bg-gray-{{ $isComingSoon ? '6' : '7' }}00 hover:bg-gray-200 dark:hover:bg-gray-{{ $isComingSoon ? '5' : '6' }}00 text-gray-600 dark:text-gray-400 rounded-xl transition-colors duration-200">
                    @if($isComingSoon)
                        <x-heroicon-o-bell class="w-5 h-5" />
                    @else
                        <x-heroicon-o-heart class="w-5 h-5" />
                    @endif
                </div>
                <div class="p-2.5 bg-gray-100 dark:bg-gray-{{ $isComingSoon ? '6' : '7' }}00 hover:bg-gray-200 dark:hover:bg-gray-{{ $isComingSoon ? '5' : '6' }}00 text-gray-600 dark:text-gray-400 rounded-xl transition-colors duration-200">
                    <x-heroicon-o-share class="w-5 h-5" />
                </div>
            </div>
        </div>
    </div>
</a>

<style>
    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
