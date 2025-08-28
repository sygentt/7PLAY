<!-- Hero Banner Carousel -->
<section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.02"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    
    <!-- Banner Swiper -->
    <div class="banner-swiper relative">
        <div class="swiper-wrapper">
            @foreach($featured_movies as $index => $movie)
            <div class="swiper-slide">
                <div class="relative h-[70vh] lg:h-[80vh] flex items-center">
                    <!-- Background Image -->
                    <div class="absolute inset-0">
                        <img 
                            src="{{ $movie['banner'] }}" 
                            alt="{{ $movie['title'] }}"
                            class="w-full h-full object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    </div>

                    <!-- Content -->
                    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="max-w-2xl">
                            <!-- Badge -->
                            <div class="inline-flex items-center space-x-2 px-4 py-2 bg-cinema-600/20 backdrop-blur-sm border border-cinema-500/30 rounded-full text-cinema-300 text-sm font-medium mb-6">
                                <span class="i-solar-star-bold w-4 h-4"></span>
                                <span>Film Pilihan</span>
                            </div>

                            <!-- Title -->
                            <h1 class="text-4xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                                {{ $movie['title'] }}
                            </h1>

                            <!-- Meta Info -->
                            <div class="flex flex-wrap items-center gap-4 text-gray-300 mb-6">
                                <span class="flex items-center space-x-1">
                                    <span class="i-solar-calendar-bold w-4 h-4"></span>
                                    <span>{{ date('Y', strtotime($movie['release_date'])) }}</span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <span class="i-solar-clock-circle-bold w-4 h-4"></span>
                                    <span>{{ $movie['duration'] }}</span>
                                </span>
                                @if($movie['rating'])
                                <span class="flex items-center space-x-1">
                                    <span class="i-solar-star-bold w-4 h-4 text-yellow-400"></span>
                                    <span>{{ $movie['rating'] }}/10</span>
                                </span>
                                @endif
                                <span class="px-3 py-1 bg-white/10 backdrop-blur-sm rounded-full text-sm">
                                    {{ $movie['genre'] }}
                                </span>
                            </div>

                            <!-- Description -->
                            <p class="text-lg text-gray-300 mb-8 leading-relaxed">
                                {{ $movie['description'] }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-gradient-to-r from-cinema-600 to-cinema-700 hover:from-cinema-700 hover:to-cinema-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                    <span class="i-solar-ticket-bold w-5 h-5"></span>
                                    <span>Beli Tiket</span>
                                </button>
                                
                                <button class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-200">
                                    <span class="i-solar-play-bold w-5 h-5"></span>
                                    <span>Tonton Trailer</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Movie Poster -->
                    <div class="hidden lg:block absolute right-8 xl:right-16 top-1/2 -translate-y-1/2">
                        <div class="relative group">
                            <div class="w-64 xl:w-80 aspect-[2/3] rounded-2xl overflow-hidden shadow-2xl transform rotate-2 group-hover:rotate-0 transition-transform duration-300">
                                <img 
                                    src="{{ $movie['poster'] }}" 
                                    alt="{{ $movie['title'] }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            <!-- Floating Rating -->
                            @if($movie['rating'])
                            <div class="absolute -top-4 -left-4 w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center text-white font-bold shadow-xl">
                                <div class="text-center">
                                    <div class="text-sm leading-none">{{ $movie['rating'] }}</div>
                                    <div class="text-xs leading-none opacity-80">IMDb</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Navigation -->
        <div class="banner-swiper-button-prev absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-colors duration-200 cursor-pointer">
            <span class="i-solar-alt-arrow-left-bold w-6 h-6"></span>
        </div>
        
        <div class="banner-swiper-button-next absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-colors duration-200 cursor-pointer">
            <span class="i-solar-alt-arrow-right-bold w-6 h-6"></span>
        </div>

        <!-- Pagination -->
        <div class="banner-swiper-pagination absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex space-x-2">
        </div>
    </div>


</section>

<!-- Initialize Banner Swiper -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Initialize Banner Swiper
    const bannerSwiper = new Swiper('.banner-swiper', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        pagination: {
            el: '.banner-swiper-pagination',
            clickable: true,
            renderBullet: function (index, className) {
                return '<span class="' + className + ' w-3 h-3 bg-white/40 rounded-full cursor-pointer transition-all duration-200 hover:bg-white/60"></span>';
            },
        },
        navigation: {
            nextEl: '.banner-swiper-button-next',
            prevEl: '.banner-swiper-button-prev',
        },
        keyboard: {
            enabled: true,
        },
        on: {
            init: function () {
                // Custom pagination styling
                const bullets = document.querySelectorAll('.banner-swiper-pagination .swiper-pagination-bullet');
                bullets.forEach(bullet => {
                    bullet.classList.add('!bg-white/40');
                });
                
                const activeBullet = document.querySelector('.banner-swiper-pagination .swiper-pagination-bullet-active');
                if (activeBullet) {
                    activeBullet.classList.add('!bg-white', '!w-8');
                }
            },
            slideChange: function () {
                // Update active bullet styling
                const bullets = document.querySelectorAll('.banner-swiper-pagination .swiper-pagination-bullet');
                bullets.forEach(bullet => {
                    bullet.classList.remove('!bg-white', '!w-8');
                    bullet.classList.add('!bg-white/40');
                });
                
                const activeBullet = document.querySelector('.banner-swiper-pagination .swiper-pagination-bullet-active');
                if (activeBullet) {
                    activeBullet.classList.add('!bg-white', '!w-8');
                }
            }
        }
    });

    
    }); // End DOMContentLoaded
</script>

<style>
    /* Custom Swiper Pagination Styles */
    .banner-swiper-pagination .swiper-pagination-bullet {
        opacity: 1 !important;
        background: rgba(255, 255, 255, 0.4) !important;
        transition: all 0.3s ease !important;
    }
    
    .banner-swiper-pagination .swiper-pagination-bullet-active {
        background: white !important;
        width: 32px !important;
        border-radius: 12px !important;
    }
</style>
