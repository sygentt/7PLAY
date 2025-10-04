<!-- Now Playing Section -->
<section id="now-playing" class="py-16 lg:py-24 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-xl flex items-center justify-center">
                    <x-heroicon-o-play-circle class="w-6 h-6 text-white" />
                </div>
                <div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">
                        Sedang Tayang
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        Film-film terbaru yang sedang tayang di bioskop
                    </p>
                </div>
            </div>
            
            <div class="hidden lg:flex items-center space-x-3">
                <div class="now-playing-swiper-button-prev w-12 h-12 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-cinema-50 dark:hover:bg-cinema-900/20 hover:text-cinema-600 dark:hover:text-cinema-400 hover:border-cinema-200 dark:hover:border-cinema-700 transition-all duration-200 cursor-pointer">
                    <x-heroicon-o-arrow-left class="w-5 h-5" />
                </div>
                <div class="now-playing-swiper-button-next w-12 h-12 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-cinema-50 dark:hover:bg-cinema-900/20 hover:text-cinema-600 dark:hover:text-cinema-400 hover:border-cinema-200 dark:hover:border-cinema-700 transition-all duration-200 cursor-pointer">
                    <x-heroicon-o-arrow-right class="w-5 h-5" />
                </div>
            </div>
        </div>

        <!-- Movies Carousel -->
        <div class="now-playing-swiper overflow-hidden">
            <div class="swiper-wrapper pb-8">
                @foreach($now_playing as $movie)
                <div class="swiper-slide">
                    <a href="{{ route('movies.show', $movie['id']) }}" class="group cursor-pointer block">
                        <!-- Movie Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700 h-full flex flex-col">
                            
                            <!-- Poster -->
                            <div class="relative overflow-hidden rounded-t-2xl aspect-[2/3]">
                                <img 
                                    src="{{ $movie['poster'] }}" 
                                    alt="{{ $movie['title'] }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                >

                                <!-- Rating Badge -->
                                @if($movie['rating'])
                                <div class="absolute top-4 left-4 px-3 py-1 bg-black/60 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                                    <span class="flex items-center space-x-1">
                                        <x-heroicon-o-star class="w-4 h-4 text-yellow-400" />
                                        <span>{{ $movie['rating'] }}</span>
                                    </span>
                                </div>
                                @endif
                                
                                <!-- Play Button -->
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-16 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-50 group-hover:scale-100">
                                    <x-heroicon-o-play class="w-8 h-8 text-white" />
                                </div>
                            </div>

                            <!-- Movie Info -->
                            <div class="p-6 flex-1 flex flex-col">
                                <!-- Title - Fixed height dengan line-clamp-2 -->
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-cinema-600 dark:group-hover:text-cinema-400 transition-colors duration-200 min-h-[3.5rem]">
                                    {{ $movie['title'] }}
                                </h3>
                                
                                <!-- Genre & Duration - Fixed height -->
                                <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mb-4 min-h-[2rem]">
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        {{ explode(', ', $movie['genre'])[0] }}
                                    </span>
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
                                    <div class="flex-1 py-2.5 px-4 bg-gradient-to-r from-cinema-600 to-cinema-700 hover:from-cinema-700 hover:to-cinema-800 text-white font-semibold rounded-xl transition-all duration-200 text-sm text-center">
                                        Lihat Detail
                                    </div>
                                    <div class="p-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-400 rounded-xl transition-colors duration-200">
                                        <x-heroicon-o-heart class="w-5 h-5" />
                                    </div>
                                    <div class="p-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-400 rounded-xl transition-colors duration-200">
                                        <x-heroicon-o-share class="w-5 h-5" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="lg:hidden flex items-center justify-center space-x-4 mt-8">
            <div class="now-playing-swiper-button-prev w-12 h-12 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-cinema-50 dark:hover:bg-cinema-900/20 hover:text-cinema-600 dark:hover:text-cinema-400 transition-all duration-200 cursor-pointer">
                <x-heroicon-o-arrow-left class="w-5 h-5" />
            </div>
            <div class="now-playing-swiper-pagination flex space-x-2"></div>
            <div class="now-playing-swiper-button-next w-12 h-12 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-cinema-50 dark:hover:bg-cinema-900/20 hover:text-cinema-600 dark:hover:text-cinema-400 transition-all duration-200 cursor-pointer">
                <x-heroicon-o-arrow-right class="w-5 h-5" />
            </div>
        </div>

        <!-- View All Button -->
        <div class="text-center mt-12">
            <a href="{{ route('movies.index', ['status' => 'now_playing']) }}" class="inline-flex items-center space-x-2 px-8 py-4 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-semibold rounded-xl border border-gray-200 dark:border-gray-700 transition-all duration-200 transform hover:scale-105">
                <span>Lihat Semua Film</span>
                <x-heroicon-o-arrow-right class="w-5 h-5" />
            </a>
        </div>
    </div>
</section>

<!-- Initialize Now Playing Swiper -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Initialize Now Playing Swiper
    const nowPlayingSwiper = new Swiper('.now-playing-swiper', {
        slidesPerView: 1.2,
        spaceBetween: 16,
        grabCursor: true,
        loop: true,
        loopFillGroupWithBlank: true,
        centeredSlides: false,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        navigation: {
            nextEl: '.now-playing-swiper-button-next',
            prevEl: '.now-playing-swiper-button-prev',
        },
        pagination: {
            el: '.now-playing-swiper-pagination',
            clickable: true,
            renderBullet: function (index, className) {
                return '<span class="' + className + ' w-2.5 h-2.5 bg-gray-300 dark:bg-gray-600 rounded-full cursor-pointer transition-all duration-200 hover:bg-cinema-400"></span>';
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
                const bullets = document.querySelectorAll('.now-playing-swiper-pagination .swiper-pagination-bullet');
                bullets.forEach(bullet => {
                    bullet.classList.add('!bg-gray-300', 'dark:!bg-gray-600');
                });
                
                const activeBullet = document.querySelector('.now-playing-swiper-pagination .swiper-pagination-bullet-active');
                if (activeBullet) {
                    activeBullet.classList.add('!bg-cinema-600');
                }
            },
            slideChange: function () {
                // Update active bullet styling
                const bullets = document.querySelectorAll('.now-playing-swiper-pagination .swiper-pagination-bullet');
                bullets.forEach(bullet => {
                    bullet.classList.remove('!bg-cinema-600');
                    bullet.classList.add('!bg-gray-300', 'dark:!bg-gray-600');
                });
                
                const activeBullet = document.querySelector('.now-playing-swiper-pagination .swiper-pagination-bullet-active');
                if (activeBullet) {
                    activeBullet.classList.add('!bg-cinema-600');
                }
            }
        }
    });
    
    }); // End DOMContentLoaded
</script>

<style>
    /* Custom Swiper Pagination Styles for Now Playing */
    .now-playing-swiper-pagination .swiper-pagination-bullet {
        opacity: 1 !important;
        background: rgb(209 213 219) !important; /* gray-300 */
        transition: all 0.3s ease !important;
    }
    
    .dark .now-playing-swiper-pagination .swiper-pagination-bullet {
        background: rgb(75 85 99) !important; /* gray-600 */
    }
    
    .now-playing-swiper-pagination .swiper-pagination-bullet-active {
        background: rgb(37 99 235) !important; /* cinema-600 */
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
