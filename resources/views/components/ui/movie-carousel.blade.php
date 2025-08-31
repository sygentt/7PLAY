@props([
    'title' => '',
    'subtitle' => '',
    'movies' => [],
    'icon' => 'play-circle',
    'theme' => 'cinema', // cinema or gold
    'type' => 'now-playing', // now-playing or coming-soon
    'id' => '',
    'buttonText' => 'Beli Tiket',
    'buttonLink' => '#',
    'showRating' => true,
    'showCountdown' => false,
    'autoplayDelay' => 5000
])

@php
    $carouselId = $id ?: Str::slug($title);
    $themeColors = [
        'cinema' => [
            'primary' => 'cinema',
            'gradient' => 'from-cinema-500 to-cinema-700',
            'hover' => 'hover:bg-cinema-50 dark:hover:bg-cinema-900/20 hover:text-cinema-600 dark:hover:text-cinema-400 hover:border-cinema-200 dark:hover:border-cinema-700',
            'button' => 'from-cinema-600 to-cinema-700 hover:from-cinema-700 hover:to-cinema-800',
            'badge' => 'bg-cinema-600'
        ],
        'gold' => [
            'primary' => 'gold',
            'gradient' => 'from-gold-500 to-gold-700',
            'hover' => 'hover:bg-gold-50 dark:hover:bg-gold-900/20 hover:text-gold-600 dark:hover:text-gold-400 hover:border-gold-200 dark:hover:border-gold-700',
            'button' => 'from-gold-600 to-gold-700 hover:from-gold-700 hover:to-gold-800',
            'badge' => 'bg-gold-600'
        ]
    ][$theme];
@endphp

<!-- Movie Carousel Section -->
<section id="{{ $carouselId }}" class="py-16 lg:py-24 {{ $theme === 'cinema' ? 'bg-white dark:bg-gray-900' : 'bg-gray-50 dark:bg-gray-800' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br {{ $themeColors['gradient'] }} rounded-xl flex items-center justify-center">
                    @if($icon === 'play-circle')
                        <x-heroicon-o-play-circle class="w-6 h-6 text-white" />
                    @elseif($icon === 'calendar-days')
                        <x-heroicon-o-calendar-days class="w-6 h-6 text-white" />
                    @elseif($icon === 'clock')
                        <x-heroicon-o-clock class="w-6 h-6 text-white" />
                    @else
                        <x-heroicon-o-film class="w-6 h-6 text-white" />
                    @endif
                </div>
                <div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">
                        {{ $title }}
                    </h2>
                    @if($subtitle)
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        {{ $subtitle }}
                    </p>
                    @endif
                </div>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-3">
                <div class="{{ $carouselId }}-swiper-button-prev w-12 h-12 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl flex items-center justify-center text-gray-600 dark:text-gray-400 {{ $themeColors['hover'] }} transition-all duration-200 cursor-pointer shadow-sm">
                    <x-heroicon-o-arrow-left class="w-5 h-5" />
                </div>
                <div class="{{ $carouselId }}-swiper-button-next w-12 h-12 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl flex items-center justify-center text-gray-600 dark:text-gray-400 {{ $themeColors['hover'] }} transition-all duration-200 cursor-pointer shadow-sm">
                    <x-heroicon-o-arrow-right class="w-5 h-5" />
                </div>
            </div>
        </div>

        <!-- Movies Carousel -->
        <div class="{{ $carouselId }}-swiper overflow-hidden">
            <div class="swiper-wrapper pb-8">
                @foreach($movies as $movie)
                <div class="swiper-slide">
                    <div class="group cursor-pointer">
                        <!-- Movie Card -->
                        <div class="bg-white dark:bg-gray-{{ $theme === 'cinema' ? '800' : '700' }} rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-{{ $theme === 'cinema' ? '700' : '600' }} h-full flex flex-col">
                            
                            <!-- Poster -->
                            <div class="relative overflow-hidden rounded-t-2xl aspect-[2/3]">
                                <img 
                                    src="{{ $movie['poster'] ?? 'https://dummyimage.com/400x600/e5e7eb/9ca3af?text=' . urlencode($movie['title'] ?? 'Movie Poster') }}" 
                                    alt="{{ $movie['title'] ?? 'Movie' }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                >
                                
                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="absolute bottom-4 left-4 right-4">
                                        <button class="w-full py-3 bg-gradient-to-r {{ $themeColors['button'] }} text-white font-semibold rounded-xl transition-colors duration-200 transform translate-y-4 group-hover:translate-y-0">
                                            {{ $buttonText }}
                                        </button>
                                    </div>
                                </div>

                                <!-- Badge (Rating or Coming Soon) -->
                                @if($showRating && isset($movie['rating']) && $movie['rating'])
                                <div class="absolute top-4 left-4 px-3 py-1 bg-black/60 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                                    <span class="flex items-center space-x-1">
                                        <x-heroicon-o-star class="w-4 h-4 text-yellow-400" />
                                        <span>{{ $movie['rating'] }}</span>
                                    </span>
                                </div>
                                @elseif($type === 'coming-soon')
                                <div class="absolute top-4 left-4 px-3 py-1 {{ $themeColors['badge'] }} rounded-full text-white text-sm font-medium shadow-lg">
                                    <span class="flex items-center space-x-1">
                                        <x-heroicon-o-clock class="w-4 h-4" />
                                        <span>Segera</span>
                                    </span>
                                </div>
                                @endif
                                
                                <!-- Release Date/Info -->
                                @if(isset($movie['release_date']) && $movie['release_date'])
                                <div class="absolute top-4 right-4 px-3 py-1 bg-black/60 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                                    {{ date('d M Y', strtotime($movie['release_date'])) }}
                                </div>
                                @endif

                                <!-- Countdown (for coming soon) -->
                                @if($showCountdown && isset($movie['id']))
                                <div class="absolute top-14 right-4 px-3 py-1 bg-black/60 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                                    <span id="countdown-{{ $movie['id'] }}">Loading...</span>
                                </div>
                                @endif
                                
                                <!-- Play Button -->
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-16 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-50 group-hover:scale-100">
                                    <x-heroicon-o-play class="w-8 h-8 text-white" />
                                </div>
                            </div>

                            <!-- Movie Info -->
                            <div class="p-6 flex-1 flex flex-col">
                                <!-- Title -->
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-{{ $themeColors['primary'] }}-600 dark:group-hover:text-{{ $themeColors['primary'] }}-400 transition-colors duration-200 min-h-[3.5rem]">
                                    {{ $movie['title'] ?? 'Movie Title' }}
                                </h3>
                                
                                <!-- Genre & Duration -->
                                <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mb-4 min-h-[2rem]">
                                    @if(isset($movie['genre']) && $movie['genre'])
                                    <span class="px-2 py-1 bg-{{ $theme === 'cinema' ? 'gray-100 dark:bg-gray-700' : 'gold-100 dark:bg-gold-900/30' }} text-{{ $theme === 'cinema' ? 'gray-700 dark:text-gray-300' : 'gold-700 dark:text-gold-300' }} rounded-lg">
                                        {{ explode(', ', $movie['genre'])[0] }}
                                    </span>
                                    @endif
                                    @if(isset($movie['duration']) && $movie['duration'])
                                    <span class="flex items-center space-x-1">
                                        <x-heroicon-o-clock class="w-4 h-4" />
                                        <span>{{ $movie['duration'] }}</span>
                                    </span>
                                    @endif
                                </div>

                                <!-- Description -->
                                @if(isset($movie['description']) && $movie['description'])
                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-6 leading-relaxed flex-1 min-h-[4.5rem]">
                                    {{ $movie['description'] }}
                                </p>
                                @endif

                                <!-- Action Buttons -->
                                <div class="flex space-x-3 mt-auto">
                                    <button class="flex-1 py-2.5 px-4 bg-gradient-to-r {{ $themeColors['button'] }} text-white font-semibold rounded-xl transition-all duration-200 text-sm">
                                        {{ $buttonText }}
                                    </button>
                                    <button class="p-2.5 bg-gray-100 dark:bg-gray-{{ $theme === 'cinema' ? '700' : '600' }} hover:bg-gray-200 dark:hover:bg-gray-{{ $theme === 'cinema' ? '600' : '500' }} text-gray-600 dark:text-gray-400 rounded-xl transition-colors duration-200">
                                        @if($type === 'coming-soon')
                                            <x-heroicon-o-bell class="w-5 h-5" />
                                        @else
                                            <x-heroicon-o-heart class="w-5 h-5" />
                                        @endif
                                    </button>
                                    <button class="p-2.5 bg-gray-100 dark:bg-gray-{{ $theme === 'cinema' ? '700' : '600' }} hover:bg-gray-200 dark:hover:bg-gray-{{ $theme === 'cinema' ? '600' : '500' }} text-gray-600 dark:text-gray-400 rounded-xl transition-colors duration-200">
                                        <x-heroicon-o-share class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="lg:hidden flex items-center justify-center space-x-4 mt-8">
            <div class="{{ $carouselId }}-swiper-button-prev w-12 h-12 bg-white dark:bg-gray-{{ $theme === 'cinema' ? '800' : '700' }} border border-gray-200 dark:border-gray-{{ $theme === 'cinema' ? '700' : '600' }} rounded-xl flex items-center justify-center text-gray-600 dark:text-gray-400 {{ $themeColors['hover'] }} transition-all duration-200 cursor-pointer">
                <x-heroicon-o-arrow-left class="w-5 h-5" />
            </div>
            <div class="{{ $carouselId }}-swiper-pagination flex space-x-2"></div>
            <div class="{{ $carouselId }}-swiper-button-next w-12 h-12 bg-white dark:bg-gray-{{ $theme === 'cinema' ? '800' : '700' }} border border-gray-200 dark:border-gray-{{ $theme === 'cinema' ? '700' : '600' }} rounded-xl flex items-center justify-center text-gray-600 dark:text-gray-400 {{ $themeColors['hover'] }} transition-all duration-200 cursor-pointer">
                <x-heroicon-o-arrow-right class="w-5 h-5" />
            </div>
        </div>

        <!-- View All Button -->
        @if($buttonLink !== '#')
        <div class="text-center mt-12">
            <a href="{{ $buttonLink }}" class="inline-flex items-center space-x-2 px-8 py-4 bg-white dark:bg-gray-{{ $theme === 'cinema' ? '800' : '700' }} hover:bg-gray-50 dark:hover:bg-gray-{{ $theme === 'cinema' ? '700' : '600' }} text-gray-900 dark:text-white font-semibold rounded-xl border border-gray-200 dark:border-gray-{{ $theme === 'cinema' ? '700' : '600' }} shadow-sm transition-all duration-200 transform hover:scale-105">
                <span>Lihat Semua {{ $title }}</span>
                <x-heroicon-o-arrow-right class="w-5 h-5" />
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Initialize Swiper Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize {{ $title }} Swiper
        const {{ Str::camel($carouselId) }}Swiper = new Swiper('.{{ $carouselId }}-swiper', {
            slidesPerView: 1.2,
            spaceBetween: 16,
            grabCursor: true,
            loop: true,
            loopFillGroupWithBlank: true,
            centeredSlides: false,
            autoplay: {
                delay: {{ $autoplayDelay }},
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            navigation: {
                nextEl: '.{{ $carouselId }}-swiper-button-next',
                prevEl: '.{{ $carouselId }}-swiper-button-prev',
            },
            pagination: {
                el: '.{{ $carouselId }}-swiper-pagination',
                clickable: true,
                renderBullet: function (index, className) {
                    return '<span class="' + className + ' w-2.5 h-2.5 bg-gray-300 dark:bg-gray-600 rounded-full cursor-pointer transition-all duration-200 hover:bg-{{ $themeColors['primary'] }}-400"></span>';
                },
            },
            breakpoints: {
                480: {
                    slidesPerView: 1.5,
                    spaceBetween: 20,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 24,
                },
                768: {
                    slidesPerView: 2.5,
                    spaceBetween: 24,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 32,
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 32,
                },
                1536: {
                    slidesPerView: 4,
                    spaceBetween: 32,
                },
            },
            on: {
                init: function () {
                    // Custom pagination styling
                    const bullets = document.querySelectorAll('.{{ $carouselId }}-swiper-pagination .swiper-pagination-bullet');
                    bullets.forEach(bullet => {
                        bullet.classList.add('!bg-gray-300', 'dark:!bg-gray-600');
                    });
                    
                    const activeBullet = document.querySelector('.{{ $carouselId }}-swiper-pagination .swiper-pagination-bullet-active');
                    if (activeBullet) {
                        activeBullet.classList.add('!bg-{{ $themeColors['primary'] }}-600');
                    }
                },
                slideChange: function () {
                    // Update active bullet styling
                    const bullets = document.querySelectorAll('.{{ $carouselId }}-swiper-pagination .swiper-pagination-bullet');
                    bullets.forEach(bullet => {
                        bullet.classList.remove('!bg-{{ $themeColors['primary'] }}-600');
                        bullet.classList.add('!bg-gray-300', 'dark:!bg-gray-600');
                    });
                    
                    const activeBullet = document.querySelector('.{{ $carouselId }}-swiper-pagination .swiper-pagination-bullet-active');
                    if (activeBullet) {
                        activeBullet.classList.add('!bg-{{ $themeColors['primary'] }}-600');
                    }
                }
            }
        });

        @if($showCountdown && $type === 'coming-soon')
        // Initialize countdown timers
        function initCountdowns() {
            const movies = @json($movies);
            
            movies.forEach(movie => {
                if (movie.id && movie.release_date) {
                    const releaseDate = new Date(movie.release_date).getTime();
                    const countdownElement = document.getElementById(`countdown-${movie.id}`);
                    
                    if (countdownElement) {
                        function updateCountdown() {
                            const now = new Date().getTime();
                            const distance = releaseDate - now;
                            
                            if (distance < 0) {
                                countdownElement.innerHTML = "Sudah Rilis!";
                                return;
                            }
                            
                            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            
                            if (days > 0) {
                                countdownElement.innerHTML = `${days} hari`;
                            } else if (hours > 0) {
                                countdownElement.innerHTML = `${hours} jam`;
                            } else {
                                countdownElement.innerHTML = `${minutes} menit`;
                            }
                        }
                        
                        updateCountdown();
                        setInterval(updateCountdown, 60000); // Update every minute
                    }
                }
            });
        }

        // Initialize countdown timers
        initCountdowns();
        @endif
    });
</script>

<style>
    /* Custom Swiper Pagination Styles for {{ $title }} */
    .{{ $carouselId }}-swiper-pagination .swiper-pagination-bullet {
        opacity: 1 !important;
        background: rgb(209 213 219) !important; /* gray-300 */
        transition: all 0.3s ease !important;
    }
    
    .dark .{{ $carouselId }}-swiper-pagination .swiper-pagination-bullet {
        background: rgb(75 85 99) !important; /* gray-600 */
    }
    
    .{{ $carouselId }}-swiper-pagination .swiper-pagination-bullet-active {
        @if($themeColors['primary'] === 'cinema')
        background: rgb(37 99 235) !important; /* cinema-600 */
        @else
        background: rgb(180 83 9) !important; /* gold-600 */
        @endif
    }

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
