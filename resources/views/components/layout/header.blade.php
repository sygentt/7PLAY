<!-- Header Navigation -->
<header class="sticky top-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg border-b border-gray-200/50 dark:border-gray-700/50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            
            <!-- Logo & Brand -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-xl flex items-center justify-center group-hover:scale-105 transition-all duration-300 shadow-lg group-hover:shadow-xl">
                        <span class="text-white font-bold text-xl lg:text-2xl">7</span>
                    </div>
                    <span class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-cinema-600 to-cinema-800 dark:from-cinema-400 dark:to-cinema-600 bg-clip-text text-transparent tracking-tight">
                        PLAY
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-1">
                <!-- Films Dropdown -->
                <div class="relative group">
                    <button class="flex items-center space-x-2 px-4 py-2.5 text-gray-700 dark:text-gray-300 hover:text-cinema-600 dark:hover:text-cinema-400 font-medium transition-all duration-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/50 {{ $current_page === 'movies' ? 'text-cinema-600 dark:text-cinema-400 bg-cinema-50 dark:bg-cinema-900/20' : '' }}">
                        <span class="text-sm">Film</span>
                        <x-heroicon-o-chevron-down class="w-4 h-4 group-hover:rotate-180 transition-transform duration-200" />
                    </button>
                    
                    <div class="absolute top-full left-0 mt-3 w-64 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 backdrop-blur-lg">
                        <div class="p-3">
                            <a href="{{ route('home') }}#now-playing" class="nav-scroll-link flex items-center space-x-4 px-4 py-3.5 text-gray-700 dark:text-gray-300 hover:bg-cinema-50 dark:hover:bg-cinema-900/20 hover:text-cinema-600 dark:hover:text-cinema-400 rounded-xl transition-all duration-200 group/item">
                                <div class="w-10 h-10 bg-gradient-to-br from-cinema-100 to-cinema-200 dark:from-cinema-900/30 dark:to-cinema-800/30 rounded-lg flex items-center justify-center group-hover/item:scale-110 transition-transform duration-200">
                                    <x-heroicon-o-play-circle class="w-5 h-5 text-cinema-600 dark:text-cinema-400" />
                                </div>
                                <div>
                                    <div class="font-semibold text-sm">Sedang Tayang</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Film yang sedang tayang</div>
                                </div>
                            </a>
                            <a href="{{ route('home') }}#coming-soon" class="nav-scroll-link flex items-center space-x-4 px-4 py-3.5 text-gray-700 dark:text-gray-300 hover:bg-cinema-50 dark:hover:bg-cinema-900/20 hover:text-cinema-600 dark:hover:text-cinema-400 rounded-xl transition-all duration-200 group/item">
                                <div class="w-10 h-10 bg-gradient-to-br from-gold-100 to-gold-200 dark:from-gold-900/30 dark:to-gold-800/30 rounded-lg flex items-center justify-center group-hover/item:scale-110 transition-transform duration-200">
                                    <x-heroicon-o-calendar-days class="w-5 h-5 text-gold-600 dark:text-gold-400" />
                                </div>
                                <div>
                                    <div class="font-semibold text-sm">Akan Datang</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Film yang akan tayang</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Cinemas Link -->
                <a href="{{ route('cinemas.index') }}" class="flex items-center space-x-2 px-4 py-2.5 text-gray-700 dark:text-gray-300 hover:text-cinema-600 dark:hover:text-cinema-400 font-medium transition-all duration-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/50 {{ $current_page === 'cinemas' ? 'text-cinema-600 dark:text-cinema-400 bg-cinema-50 dark:bg-cinema-900/20' : '' }}">
                    <x-heroicon-o-building-office class="w-4 h-4" />
                    <span class="text-sm">Bioskop</span>
                </a>

                <!-- Points Link -->
                <a href="{{ route('points.index') }}" class="flex items-center space-x-2 px-4 py-2.5 text-gray-700 dark:text-gray-300 hover:text-cinema-600 dark:hover:text-cinema-400 font-medium transition-all duration-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/50 {{ $current_page === 'points' ? 'text-cinema-600 dark:text-cinema-400 bg-cinema-50 dark:bg-cinema-900/20' : '' }}">
                    <x-heroicon-o-star class="w-4 h-4" />
                    <span class="text-sm">Poin</span>
                </a>
            </nav>

            <!-- Search & Location & Dark Mode Toggle -->
            <div class="flex items-center space-x-3">
                <!-- Search Bar -->
                <div class="hidden md:block relative">
                    <div class="relative">
                        <input 
                            id="global-search-input"
                            type="text" 
                            placeholder="Cari film..." 
                            class="w-64 lg:w-80 pl-11 pr-4 py-2.5 bg-gray-50 dark:bg-gray-800/50 border border-gray-200/50 dark:border-gray-700/50 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cinema-500/50 focus:border-cinema-500 transition-all duration-200 text-sm"
                        >
                        <x-heroicon-o-magnifying-glass class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                    </div>
                </div>

                <!-- Location Dropdown -->
                <div class="hidden lg:block relative group">
                    <button class="flex items-center space-x-2 px-4 py-2.5 bg-gray-50 dark:bg-gray-800/50 border border-gray-200/50 dark:border-gray-700/50 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all duration-200">
                        <x-heroicon-o-map-pin class="w-4 h-4 text-cinema-500" />
                        <span class="text-sm font-medium" id="current-city">Jakarta</span>
                        <x-heroicon-o-chevron-down class="w-4 h-4 group-hover:rotate-180 transition-transform duration-200" />
                    </button>
                    
                    @if(count($cities) > 0)
                        <div class="absolute top-full right-0 mt-3 w-48 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 backdrop-blur-lg">
                            <div class="p-2">
                                @foreach($cities as $city)
                                    <button 
                                        onclick="selectCity('{{ $city['name'] ?? $city }}')"
                                        class="w-full flex items-center space-x-3 px-4 py-2.5 text-left text-gray-700 dark:text-gray-300 hover:bg-cinema-50 dark:hover:bg-cinema-900/20 hover:text-cinema-600 dark:hover:text-cinema-400 rounded-xl transition-all duration-200 text-sm"
                                    >
                                        <x-heroicon-o-map-pin class="w-4 h-4" />
                                        <span class="font-medium">{{ $city['name'] ?? $city }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Notifications Dropdown -->
                <div class="relative" x-data="{ open:false }">
                    <button 
                        class="p-2.5 bg-gray-50 dark:bg-gray-800/50 border border-gray-200/50 dark:border-gray-700/50 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all duration-200 hover:scale-105 relative"
                        aria-label="Notifikasi"
                        x-on:click="open = !open"
                    >
                        <x-heroicon-o-bell class="w-5 h-5" />
                        <span id="notif-badge" class="hidden absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full"></span>
                    </button>
                    <div 
                        class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-2"
                        x-show="open" x-transition style="display:none"
                        x-on:click.outside="open=false"
                    >
                        <a href="{{ route('profile.notifications') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-sm text-gray-700 dark:text-gray-200">
                            <x-heroicon-o-bell class="w-4 h-4 mr-2" /> Lihat Notifikasi
                        </a>
                        <button onclick="markAllNotificationsRead()" class="w-full text-left flex items-center px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-sm text-gray-700 dark:text-gray-200">
                            <x-heroicon-o-check class="w-4 h-4 mr-2" /> Tandai semua terbaca
                        </button>
                    </div>
                </div>

                <!-- Auth Buttons -->
                @auth
                    <div class="hidden lg:flex items-center space-x-3">
                        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 group">
                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://dummyimage.com/40x40/e5e7eb/111827&text=' . urlencode(substr(auth()->user()->name,0,1)) }}"
                                 alt="Avatar"
                                 class="w-10 h-10 rounded-full ring-2 ring-transparent group-hover:ring-cinema-500 transition" />
                            <span class="sr-only">Profil</span>
                        </a>
                    </div>
                @else
                    <div class="hidden lg:flex items-center space-x-3">
                        <button onclick="openAuthModal('login')" class="px-4 py-2.5 text-cinema-600 dark:text-cinema-400 hover:text-cinema-700 dark:hover:text-cinema-300 font-medium transition-colors duration-200 text-sm">
                            Masuk
                        </button>
                        <button onclick="openAuthModal('register')" class="px-6 py-2.5 bg-gradient-to-r from-cinema-600 to-cinema-700 hover:from-cinema-700 hover:to-cinema-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 text-sm">
                            Daftar Yuk
                        </button>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button 
                    onclick="toggleMobileMenu()"
                    class="lg:hidden p-2.5 text-gray-700 dark:text-gray-300 hover:text-cinema-600 dark:hover:text-cinema-400 transition-colors duration-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    aria-label="Toggle mobile menu"
                >
                    <x-heroicon-o-bars-3 class="w-6 h-6 block" id="menu-open-icon" />
                    <x-heroicon-o-x-mark class="w-6 h-6 hidden" id="menu-close-icon" />
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-200/50 dark:border-gray-700/50 py-6">
            <!-- Mobile Search -->
            <div class="mb-6">
                <div class="relative">
                    <input 
                        id="global-search-input-mobile"
                        type="text" 
                        placeholder="{{ __('nav.search_placeholder') }}" 
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200/50 dark:border-gray-700/50 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cinema-500/50 focus:border-cinema-500 transition-all duration-200 text-sm"
                    >
                    <x-heroicon-o-magnifying-glass class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                </div>
            </div>

            <!-- Mobile Navigation -->
            <nav class="space-y-3">
                <a href="{{ route('home') }}#now-playing" class="nav-scroll-link flex items-center space-x-4 px-4 py-3.5 text-gray-700 dark:text-gray-300 hover:bg-cinema-50 dark:hover:bg-cinema-900/20 hover:text-cinema-600 dark:hover:text-cinema-400 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-cinema-100 to-cinema-200 dark:from-cinema-900/30 dark:to-cinema-800/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <x-heroicon-o-play-circle class="w-5 h-5 text-cinema-600 dark:text-cinema-400" />
                    </div>
                    <span class="font-medium">Sedang Tayang</span>
                </a>
                <a href="{{ route('home') }}#coming-soon" class="nav-scroll-link flex items-center space-x-4 px-4 py-3.5 text-gray-700 dark:text-gray-300 hover:bg-cinema-50 dark:hover:bg-cinema-900/20 hover:text-cinema-600 dark:hover:text-cinema-400 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-gold-100 to-gold-200 dark:from-gold-900/30 dark:to-gold-800/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <x-heroicon-o-calendar-days class="w-5 h-5 text-gold-600 dark:text-gold-400" />
                    </div>
                    <span class="font-medium">Akan Datang</span>
                </a>
                <a href="{{ route('cinemas.index') }}" class="flex items-center space-x-4 px-4 py-3.5 text-gray-700 dark:text-gray-300 hover:bg-cinema-50 dark:hover:bg-cinema-900/20 hover:text-cinema-600 dark:hover:text-cinema-400 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <x-heroicon-o-building-office class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    <span class="font-medium">Bioskop</span>
                </a>
                <a href="{{ route('points.index') }}" class="flex items-center space-x-4 px-4 py-3.5 text-gray-700 dark:text-gray-300 hover:bg-cinema-50 dark:hover:bg-cinema-900/20 hover:text-cinema-600 dark:hover:text-cinema-400 rounded-xl transition-all duration-200 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/30 dark:to-purple-800/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <x-heroicon-o-star class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                    </div>
                    <span class="font-medium">Poin</span>
                </a>
                
                @guest
                    <div class="pt-6 border-t border-gray-200/50 dark:border-gray-700/50 space-y-3">
                        <button onclick="openAuthModal('login')" class="block w-full px-4 py-3.5 text-cinema-600 dark:text-cinema-400 hover:bg-cinema-50 dark:hover:bg-cinema-900/20 rounded-xl transition-all duration-200 font-medium text-center">
                            Masuk
                        </button>
                        <button onclick="openAuthModal('register')" class="block w-full px-4 py-3.5 bg-gradient-to-r from-cinema-600 to-cinema-700 text-white font-semibold rounded-xl text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            Daftar Yuk
                        </button>
                    </div>
                @endguest
            </nav>
        </div>
    </div>
</header>

<script>
    // Mobile menu toggle
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('menu-open-icon');
        const closeIcon = document.getElementById('menu-close-icon');
        
        if (mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.remove('hidden');
            openIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
        } else {
            mobileMenu.classList.add('hidden');
            openIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        }
    }

    // City selection
    function selectCity(cityName) {
        // Update the displayed city name
        const currentCityElement = document.getElementById('current-city');
        if (currentCityElement) {
            currentCityElement.textContent = cityName;
        }
        
        // Here you could add logic to filter cinemas/movies by city
        console.log('Selected city:', cityName);
        
        // You can emit an event or call an API to update the content based on selected city
        window.dispatchEvent(new CustomEvent('cityChanged', { detail: { cityName } }));
    }

    // Navigation scroll handler for anchor links
    document.addEventListener('DOMContentLoaded', function() {
        const navScrollLinks = document.querySelectorAll('.nav-scroll-link');
        const homeUrl = '{{ route('home') }}';
        const currentUrl = window.location.origin + window.location.pathname;
        const isHomePage = currentUrl === homeUrl || currentUrl === homeUrl + '/';
        
        navScrollLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // Extract the anchor part (after #)
                if (href && href.includes('#')) {
                    const parts = href.split('#');
                    const targetId = parts[1];
                    
                    // If we're on the home page, try to scroll
                    if (isHomePage) {
                        const targetElement = document.getElementById(targetId);
                        
                        if (targetElement) {
                            e.preventDefault();
                            
                            // Close mobile menu if open
                            const mobileMenu = document.getElementById('mobile-menu');
                            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                                toggleMobileMenu();
                            }
                            
                            // Calculate offset for sticky header
                            const headerHeight = document.querySelector('header').offsetHeight;
                            const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
                            
                            // Smooth scroll to target
                            window.scrollTo({
                                top: targetPosition,
                                behavior: 'smooth'
                            });
                        }
                    }
                    // If not on home page, let the browser navigate to home with anchor
                    // The scroll will happen after page load
                }
            });
        });
        
        // Handle scroll to anchor on page load (when coming from another page)
        if (window.location.hash) {
            setTimeout(function() {
                const targetId = window.location.hash.substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    const headerHeight = document.querySelector('header').offsetHeight;
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }, 100);
        }
    });
</script>

<script>
    // Global search handlers (desktop & mobile)
    (function(){
        function performSearch(value){
            const q = (value || '').trim();
            const url = new URL(window.location.origin + '{{ route('movies.index') }}'.replace(window.location.origin, ''));
            if(q){
                url.searchParams.set('search', q);
            }
            window.location.href = url.toString();
        }

        function attachEnterHandler(inputId){
            const el = document.getElementById(inputId);
            if(!el) return;
            el.addEventListener('keydown', function(e){
                if(e.key === 'Enter'){
                    e.preventDefault();
                    performSearch(el.value);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function(){
            attachEnterHandler('global-search-input');
            attachEnterHandler('global-search-input-mobile');
        });
    })();

    // Fetch unread count and update badge
    async function refreshUnreadCount(){
        try{
            const resp = await fetch('{{ route('notifications.unread-count') }}');
            const data = await resp.json();
            const badge = document.getElementById('notif-badge');
            if(badge){
                const n = Number(data.count||0);
                badge.textContent = n>99? '99+': String(n);
                badge.classList.toggle('hidden', n<=0);
            }
        }catch(e){/* ignore */}
    }
    async function markAllNotificationsRead(){
        try{
            const resp = await fetch('{{ route('notifications.mark-all-read') }}',{method:'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}});
            await resp.json();
            refreshUnreadCount();
        }catch(e){/* ignore */}
    }
    document.addEventListener('DOMContentLoaded', function(){
        const isAuthenticated = document.querySelector('meta[name="user-authenticated"]')?.content === 'true';
        if (isAuthenticated) refreshUnreadCount();
    });
</script>

