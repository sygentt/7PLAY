@extends('layouts.public')

@section('title', 'Pilih Kursi - ' . $showtime->movie->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-white">
    <!-- Header -->
    <div class="bg-gray-900/80 backdrop-blur-sm border-b border-gray-800">
        <div class="max-w-6xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button onclick="history.back()" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <h1 class="text-xl font-semibold">Pilih kursi kamu</h1>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold">Cinema XXI</div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-8 flex gap-8">
        <!-- Seat Selection Area -->
        <div class="flex-1">
            <!-- Movie Info -->
            <div class="flex items-center space-x-4 mb-8 bg-gray-800/50 rounded-xl p-6">
                <img src="{{ $showtime->movie->poster_url ?? 'https://dummyimage.com/150x200/374151/ffffff?text=Movie+Poster' }}" 
                     alt="{{ $showtime->movie->title }}" 
                     class="w-20 h-28 object-cover rounded-lg">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold mb-2">{{ $showtime->movie->title }}</h2>
                    <div class="text-gray-400 space-y-1">
                        <div>{{ $showtime->cinemaHall->cinema->full_name }}</div>
                        <div>{{ $showtime->show_date->format('l, d F Y') ?? '' }} • {{ $showtime->getFormattedTime() }}</div>
                    </div>
                </div>
            </div>

            <!-- Screen -->
            <div class="text-center mb-8">
                <div class="inline-block bg-gradient-to-r from-gray-600 via-gray-300 to-gray-600 rounded-t-3xl px-32 py-3 text-gray-900 font-semibold">
                    Area Layar
                </div>
                <div class="text-sm text-gray-400 mt-2">Cinema XXI</div>
            </div>

            <!-- Legend -->
            <div class="flex justify-center space-x-6 mb-6 text-sm">
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 bg-green-500 rounded"></div>
                    <span class="text-gray-400">Tersedia</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 bg-orange-500 rounded"></div>
                    <span class="text-gray-400">Terisi</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 bg-red-500 rounded"></div>
                    <span class="text-gray-400">Terpilih</span>
                </div>
            </div>

            <!-- Seats Grid -->
            <div class="bg-gray-800/30 rounded-xl p-6">
                @foreach($seatsByRow as $row => $seats)
                    <div class="flex items-center justify-center mb-3">
                        <!-- Row Label -->
                        <div class="w-8 text-center text-gray-400 font-semibold">{{ $row }}</div>
                        
                        <!-- Seats -->
                        <div class="flex space-x-2 mx-4">
                            @foreach($seats as $seat)
                                <button
                                    type="button"
                                    data-seat-id="{{ $seat->id }}"
                                    data-seat-row="{{ $seat->row_label }}"
                                    data-seat-number="{{ $seat->seat_number }}"
                                    data-is-reserved="{{ in_array($seat->id, $reservedSeatIds) ? 'true' : 'false' }}"
                                    onclick="toggleSeat(this)"
                                    class="seat-btn w-8 h-8 rounded text-xs font-semibold transition-all duration-200 
                                           {{ in_array($seat->id, $reservedSeatIds) 
                                              ? 'bg-orange-500 cursor-not-allowed' 
                                              : 'bg-green-500 hover:bg-green-400' }}
                                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    {{ in_array($seat->id, $reservedSeatIds) ? 'disabled' : '' }}
                                >
                                    {{ $seat->seat_number }}
                                </button>
                            @endforeach
                        </div>
                        
                        <!-- Row Label (right side) -->
                        <div class="w-8 text-center text-gray-400 font-semibold">{{ $row }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Sidebar -->
        <div class="w-80 bg-gray-800/50 rounded-xl p-6 h-fit">
            <!-- Showtime Info -->
            <div class="mb-6">
                <div class="text-center mb-4">
                    <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L10 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold">{{ $showtime->getFormattedTime() }}</div>
                </div>
            </div>

            <!-- Selected Seats Info -->
            <div class="mb-6">
                <div class="text-sm text-gray-400 mb-2">Nomor kursi</div>
                <div id="selected-seats-display" class="text-gray-400">
                    Kamu belum pilih kursi
                </div>
                <div class="mt-2">
                    <span id="selected-count">0</span> kursi terpilih
                </div>
            </div>

            <!-- Pricing -->
            <div class="border-t border-gray-700 pt-4 mb-6">
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-400">Regular 2D</span>
                    <span>{{ $showtime->getFormattedPrice() }}</span>
                </div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-400">Qty</span>
                    <span id="ticket-quantity">0</span>
                </div>
                <div class="flex justify-between font-bold text-lg border-t border-gray-700 pt-2">
                    <span>Total</span>
                    <span id="total-price">Rp0</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button 
                    type="button" 
                    onclick="clearSelectedSeats()"
                    class="w-full px-4 py-3 bg-gray-700 text-gray-300 rounded-lg font-medium hover:bg-gray-600 transition-colors"
                >
                    Hapus pilihan
                </button>
                <button 
                    type="button" 
                    id="continue-btn"
                    onclick="proceedToCheckout()"
                    disabled
                    class="w-full px-4 py-3 bg-white text-gray-900 rounded-lg font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-100"
                >
                    Lanjut
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
    <div class="bg-white rounded-lg p-6 text-center">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900 mx-auto mb-4"></div>
        <p class="text-gray-900">Memproses reservasi kursi...</p>
    </div>
</div>

@endsection

@push('scripts')
<script>
const showtime = @json($showtime);
const seatCount = {{ $seatCount }};
const seatPrice = {{ $showtime->price }};
let selectedSeats = [];

function toggleSeat(button) {
    if (button.disabled) return;
    
    const seatId = parseInt(button.dataset.seatId);
    const seatRow = button.dataset.seatRow;
    const seatNumber = button.dataset.seatNumber;
    const seatLabel = seatRow + seatNumber;
    
    if (button.classList.contains('bg-red-500')) {
        // Deselect seat
        button.classList.remove('bg-red-500');
        button.classList.add('bg-green-500');
        selectedSeats = selectedSeats.filter(seat => seat.id !== seatId);
    } else if (selectedSeats.length < seatCount) {
        // Select seat
        button.classList.remove('bg-green-500');
        button.classList.add('bg-red-500');
        selectedSeats.push({ id: seatId, row: seatRow, number: seatNumber, label: seatLabel });
    } else {
        // Maximum seats reached
        alert(`Maksimal ${seatCount} kursi yang dapat dipilih.`);
        return;
    }
    
    updateSidebar();
}

function updateSidebar() {
    const selectedCount = selectedSeats.length;
    const totalPrice = selectedCount * seatPrice;
    
    // Update selected seats display
    document.getElementById('selected-count').textContent = selectedCount;
    document.getElementById('ticket-quantity').textContent = selectedCount;
    document.getElementById('total-price').textContent = formatPrice(totalPrice);
    
    const seatsDisplay = document.getElementById('selected-seats-display');
    if (selectedCount === 0) {
        seatsDisplay.textContent = 'Kamu belum pilih kursi';
        seatsDisplay.className = 'text-gray-400';
    } else {
        const seatLabels = selectedSeats.map(seat => seat.label).join(', ');
        seatsDisplay.textContent = seatLabels;
        seatsDisplay.className = 'text-white font-semibold';
    }
    
    // Update continue button
    const continueBtn = document.getElementById('continue-btn');
    continueBtn.disabled = selectedCount !== seatCount;
}

function clearSelectedSeats() {
    selectedSeats.forEach(seat => {
        const button = document.querySelector(`[data-seat-id="${seat.id}"]`);
        if (button && !button.disabled) {
            button.classList.remove('bg-red-500');
            button.classList.add('bg-green-500');
        }
    });
    selectedSeats = [];
    updateSidebar();
}

async function proceedToCheckout() {
    if (selectedSeats.length !== seatCount) {
        alert(`Silakan pilih ${seatCount} kursi.`);
        return;
    }
    
    const loadingModal = document.getElementById('loading-modal');
    loadingModal.classList.remove('hidden');
    loadingModal.classList.add('flex');
    
    try {
        const response = await fetch('{{ route('booking.reserve-seats') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                showtime_id: showtime.id,
                seat_ids: selectedSeats.map(seat => seat.id)
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            window.location.href = result.redirect_url;
        } else {
            alert(result.message || 'Terjadi kesalahan saat memesan kursi.');
            // Refresh the page to get updated seat availability
            window.location.reload();
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
    } finally {
        loadingModal.classList.add('hidden');
        loadingModal.classList.remove('flex');
    }
}

function formatPrice(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount);
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateSidebar();
    
    // Add meta tag for user authentication status
    if (!document.querySelector('meta[name="user-authenticated"]')) {
        const meta = document.createElement('meta');
        meta.name = 'user-authenticated';
        meta.content = '{{ auth()->check() ? 'true' : 'false' }}';
        document.head.appendChild(meta);
    }
});
</script>
@endpush
