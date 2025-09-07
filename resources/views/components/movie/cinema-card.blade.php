@props(['cinema', 'showtimes'])

<div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 mb-4">
    <!-- Cinema Header -->
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $cinema->full_name }}</h3>
            <div class="flex items-center mt-1">
                <!-- Cinema info removed as requested -->
            </div>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500 dark:text-gray-400">Regular 2D</div>
            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                {{ $showtimes->first()?->getFormattedPrice() ?? 'Rp60.000' }}
            </div>
        </div>
    </div>

    <!-- Showtimes -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
        @php
            $availableShowtimes = $showtimes->filter(fn($s) => $s->isUpcoming());
        @endphp
        @forelse($availableShowtimes as $showtime)
            <button
                @auth
                    onclick="openSeatCountModal({{ $showtime->id }})"
                @else
                    onclick="requireAuth(() => openSeatCountModal({{ $showtime->id }}))"
                @endauth
                class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                {{ $showtime->getFormattedTime() }}
            </button>
        @empty
            <div class="col-span-full text-center text-gray-500 py-4">
                Tidak ada jadwal tersedia untuk tanggal ini
            </div>
        @endforelse
    </div>
</div>
