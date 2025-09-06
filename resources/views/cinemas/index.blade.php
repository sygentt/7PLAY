@extends('layouts.public')

@section('title', 'Daftar Bioskop - ' . config('app.name', '7PLAY'))

@section('description', 'Temukan bioskop terdekat dengan mudah. Lihat lokasi, fasilitas, dan jadwal film di berbagai bioskop di seluruh Indonesia.')

@section('content')
    <!-- Hero Section -->
    <section class="relative py-20 bg-gradient-to-br from-cinema-600 via-cinema-700 to-cinema-800">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-white mb-6">
                Daftar Bioskop
            </h1>
            <p class="text-xl text-cinema-100 max-w-2xl mx-auto">
                Temukan bioskop terdekat dan nikmati pengalaman menonton yang tak terlupakan
            </p>
        </div>
    </section>

    <!-- Search & Filter Section -->
    <section class="py-8 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6 items-center">
                
                <!-- Search Bar -->
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input 
                            type="text" 
                            placeholder="Cari bioskop atau lokasi..." 
                            class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:border-cinema-500 transition-all duration-200"
                            value="{{ $search ?? '' }}"
                            onkeydown="if(event.key==='Enter'){window.location='{{ route('cinemas.index') }}?'+new URLSearchParams({q: this.value, city_id: document.getElementById('city-select')?.value||''});}"
                        >
                        <x-heroicon-o-magnifying-glass class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                    </div>
                </div>

                <!-- City Filter -->
                <div class="relative">
                    <select id="city-select" class="appearance-none bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-6 py-3 pr-10 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:border-cinema-500 transition-all duration-200" onchange="window.location='{{ route('cinemas.index') }}?'+new URLSearchParams({q: '{{ $search ?? '' }}', city_id: this.value}).toString()">
                        <option value="">Semua Kota</option>
                        @foreach(($cities ?? []) as $city)
                            <option value="{{ $city->id }}" @selected(isset($cityId) && $cityId == $city->id)>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <x-heroicon-o-chevron-down class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                </div>

                <!-- View Toggle -->
                <div class="flex bg-gray-100 dark:bg-gray-800 rounded-xl p-1">
                    <button id="cinemas-grid-btn" class="px-4 py-2 rounded-lg bg-cinema-600 text-white font-medium transition-all duration-200">
                        <x-heroicon-o-squares-2x2 class="w-4 h-4" />
                    </button>
                    <button id="cinemas-list-btn" class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:text-cinema-600 dark:hover:text-cinema-400 transition-all duration-200">
                        <x-heroicon-o-list-bullet class="w-4 h-4" />
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Cinemas Grid/List -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="cinemas-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-container="grid">
                
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
                            
                            <!-- Cinema Chain Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-cinema-600 text-white text-sm font-semibold rounded-full">
                                    {{ $cinema->brand ?? 'Cinema' }}
                                </span>
                            </div>
                        </div>

                        <!-- Cinema Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ $cinema->full_name }}
                            </h3>
                            
                            <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 mb-4">
                                <x-heroicon-o-map-pin class="w-4 h-4" />
                                <span class="text-sm">{{ $cinema->city->name }}</span>
                            </div>

                            <!-- Facilities -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach($cinema['facilities'] ?? [] as $facility)
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-lg">
                                        {{ $facility }}
                                    </span>
                                @endforeach
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-3">
                                <button class="flex-1 px-4 py-2 bg-cinema-600 hover:bg-cinema-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                    Lihat Jadwal
                                </button>
                                <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
                                    <x-heroicon-o-map-pin class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Sample Cinema Cards (if no data) -->
                @if(empty($cinemas))
                    @for($i = 1; $i <= 6; $i++)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 group">
                            
                            <!-- Cinema Image -->
                            <div class="relative h-48 overflow-hidden">
                                <img 
                                    src="https://via.placeholder.com/400x200/6366f1/ffffff?text=Cinema+{{ $i }}" 
                                    alt="Cinema {{ $i }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                
                                <!-- Cinema Chain Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-cinema-600 text-white text-sm font-semibold rounded-full">
                                        CGV
                                    </span>
                                </div>
                            </div>

                            <!-- Cinema Info -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                    CGV Grand Indonesia
                                </h3>
                                
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 mb-4">
                                    <x-heroicon-o-map-pin class="w-4 h-4" />
                                    <span class="text-sm">Jakarta Pusat</span>
                                </div>

                                <!-- Facilities -->
                                <div class="flex flex-wrap gap-2 mb-6">
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-lg">
                                        IMAX
                                    </span>
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-lg">
                                        4DX
                                    </span>
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-lg">
                                        Dolby Atmos
                                    </span>
                                </div>

                                <!-- Actions -->
                                <div class="flex space-x-3">
                                    <button class="flex-1 px-4 py-2 bg-cinema-600 hover:bg-cinema-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                        Lihat Jadwal
                                    </button>
                                    <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
                                        <x-heroicon-o-map-pin class="w-4 h-4" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>

            <!-- List view -->
            <div id="cinemas-list" class="hidden space-y-6" data-container="list">
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
            </div>

            @if(($cinemas ?? null) && method_exists($cinemas, 'hasPages') && $cinemas->hasPages())
                <div class="mt-12 flex justify-center">
                    <button id="cinemas-load-more" data-next-url="{{ $cinemas->nextPageUrl() }}"
                            class="px-8 py-3 bg-cinema-600 hover:bg-cinema-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                        Muat Lebih Banyak
                    </button>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[placeholder="Cari bioskop atau lokasi..."]');
        const citySelect = document.getElementById('city-select');
        const gridBtn = document.getElementById('cinemas-grid-btn');
        const listBtn = document.getElementById('cinemas-list-btn');
        const gridView = document.getElementById('cinemas-grid');
        const listView = document.getElementById('cinemas-list');

        if (searchInput) {
            searchInput.addEventListener('keydown', function(e){
                if(e.key === 'Enter'){
                    const params = new URLSearchParams({
                        q: this.value,
                        city_id: document.getElementById('city-select')?.value || ''
                    });
                    window.location = '{{ route('cinemas.index') }}?' + params.toString();
                }
            });
        }

        if (citySelect) {
            citySelect.addEventListener('change', function() {
                const params = new URLSearchParams({
                    q: searchInput?.value || '',
                    city_id: this.value || ''
                });
                window.location = '{{ route('cinemas.index') }}?' + params.toString();
            });
        }

        function setView(mode){
            if(!gridView || !listView) return;
            localStorage.setItem('cinemaViewMode', mode);
            if(mode === 'grid'){
                gridView.classList.remove('hidden');
                listView.classList.add('hidden');
                gridBtn?.classList.add('bg-cinema-600','text-white');
                listBtn?.classList.remove('bg-cinema-600','text-white');
            } else {
                gridView.classList.add('hidden');
                listView.classList.remove('hidden');
                listBtn?.classList.add('bg-cinema-600','text-white');
                gridBtn?.classList.remove('bg-cinema-600','text-white');
            }
        }
        gridBtn?.addEventListener('click', () => setView('grid'));
        listBtn?.addEventListener('click', () => setView('list'));
        setView(localStorage.getItem('cinemaViewMode') || 'grid');

        // Load more (AJAX)
        const loadMoreBtn = document.getElementById('cinemas-load-more');
        async function loadMore(){
            if(!loadMoreBtn) return;
            const nextUrl = loadMoreBtn.getAttribute('data-next-url');
            if(!nextUrl){
                loadMoreBtn.classList.add('hidden');
                return;
            }
            const url = new URL(nextUrl);
            url.searchParams.set('ajax','1');
            try{
                loadMoreBtn.disabled = true;
                loadMoreBtn.textContent = 'Memuat...';
                const resp = await fetch(url.toString(), {headers:{'X-Requested-With':'XMLHttpRequest'}});
                const data = await resp.json();
                if(data && (data.html_grid || data.html_list)){
                    if(gridView && data.html_grid){
                        const temp = document.createElement('div');
                        temp.innerHTML = data.html_grid;
                        Array.from(temp.children).forEach(c => gridView.appendChild(c));
                    }
                    if(listView && data.html_list){
                        const temp2 = document.createElement('div');
                        temp2.innerHTML = data.html_list;
                        Array.from(temp2.children).forEach(c => listView.appendChild(c));
                    }
                    if(data.has_more && data.next_page_url){
                        loadMoreBtn.setAttribute('data-next-url', data.next_page_url);
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.textContent = 'Muat Lebih Banyak';
                    } else {
                        loadMoreBtn.classList.add('hidden');
                    }
                } else {
                    loadMoreBtn.classList.add('hidden');
                }
            }catch(e){
                console.error(e);
                loadMoreBtn.disabled = false;
                loadMoreBtn.textContent = 'Muat Lebih Banyak';
            }
        }
        loadMoreBtn?.addEventListener('click', loadMore);
    });
</script>
@endpush


