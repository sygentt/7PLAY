@extends('layouts.public')

@section('title', 'Checkout - ' . ($order->showtime->movie->title ?? 'Pesanan'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-white">
    <!-- Header -->
    <div class="bg-gray-900/80 backdrop-blur-sm border-b border-gray-800">
        <div class="max-w-4xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button onclick="history.back()" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <h1 class="text-xl font-semibold">Checkout</h1>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold">Cinema XXI</div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Order Summary -->
        <div class="bg-gray-800/50 rounded-xl p-6 mb-8">
            <h2 class="text-2xl font-bold mb-6">Ringkasan Pemesanan</h2>
            
            @php
                $orderItem = $order->orderItems->first();
                $showtime = $order->showtime;
                $movie = $showtime->movie ?? null;
                $cinema = $showtime->cinemaHall->cinema ?? null;
                $selectedSeats = $order->orderItems;
            @endphp
            
            <!-- Movie Info -->
            <div class="flex items-start space-x-4 mb-6">
                <img src="{{ ($movie->poster_url ?? null) ?: 'https://dummyimage.com/120x180/374151/ffffff?text=Movie+Poster' }}" 
                     alt="{{ $movie->title ?? 'Movie' }}" 
                     class="w-20 h-28 object-cover rounded-lg">
                <div class="flex-1">
                    <h3 class="text-xl font-bold mb-2">{{ $movie->title ?? 'Film' }}</h3>
                    <div class="text-gray-400 space-y-1">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $cinema->full_name ?? '-' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ optional($showtime->show_date)->format('l, d F Y') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L10 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $showtime->getFormattedTime() }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Kursi: {{ $selectedSeats->pluck('seat.row_label')->zip($selectedSeats->pluck('seat.seat_number'))->map(fn($seat) => $seat[0] . $seat[1])->join(', ') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price Breakdown -->
            <div class="border-t border-gray-700 pt-4">
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Tiket Regular 2D ({{ $order->orderItems->count() }}x)</span>
                        <span>{{ number_format($showtime->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Subtotal</span>
                        <span>{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="flex justify-between text-xl font-bold border-t border-gray-600 pt-2">
                    <span>Total</span>
                    <span data-total-amount>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Timer dipindahkan ke halaman payment/qris -->

        <!-- Payment Options -->
        <div class="space-y-4">
            <!-- Voucher Selector -->
            <div class="bg-gray-800/50 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 7a4 4 0 104 4 4 4 0 00-4-4zm0 6a6 6 0 116-6 6 6 0 01-6 6zM21 13a3 3 0 11-3 3 3 3 0 013-3zm0-2a5 5 0 105 5 5 5 0 00-5-5z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Voucher</h3>
                            <p class="text-sm text-gray-400">Pilih voucher untuk mendapatkan diskon</p>
                        </div>
                    </div>
                    <button id="btn-load-vouchers" onclick="openVoucherSelector()" class="px-6 py-2 bg-gray-700 text-gray-300 rounded-lg font-medium hover:bg-gray-600 transition-colors">
                        Pilih Voucher
                    </button>
                </div>

                <div id="voucher-selected" class="hidden mt-2 text-sm text-green-400"></div>
            </div>
            <!-- Metode Pembayaran (pilih di checkout dan lanjut ke halaman QRIS) -->
            <div class="bg-gray-800/50 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-lg">Metode Pembayaran</h3>
                        <p class="text-sm text-gray-400">QRIS</p>
                    </div>
                    <button onclick="createQrisAndRedirect()" class="px-6 py-2 bg-white text-gray-900 rounded-lg font-medium hover:bg-gray-100 transition-colors">Lanjutkan</button>
                </div>
            </div>
        </div>

        <!-- Order Info -->
        <div class="mt-8 text-center text-gray-400">
            <p>Order #{{ $order->order_number }}</p>
            <p class="text-sm mt-1">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div id="qr-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900 bg-opacity-75 backdrop-blur-sm">
    <div class="modal-content bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-md w-full mx-4 text-center text-gray-900 border border-gray-200 dark:border-gray-700 shadow-2xl">
        <div class="mb-6">
            <h3 class="text-2xl font-bold mb-2">Scan QR Code</h3>
            <p class="text-gray-600">Gunakan aplikasi e-wallet atau mobile banking untuk scan</p>
        </div>
        
        <!-- QR Code Placeholder -->
        <div class="bg-white p-6 rounded-xl border-2 border-dashed border-gray-300 mb-6">
            <div id="qr-code-container" class="flex items-center justify-center">
                <div class="w-48 h-48 bg-gray-100 rounded-lg flex items-center justify-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
                </div>
            </div>
        </div>

        <!-- Timer di modal dihapus: timer hanya tampil di halaman payment/qris -->

        <!-- Action Buttons -->
        <div class="flex space-x-4">
            <button 
                onclick="closeQRModal()"
                class="flex-1 px-4 py-3 bg-gray-200 text-gray-800 rounded-lg font-medium hover:bg-gray-300 transition-colors"
            >
                Batal
            </button>
            <button 
                onclick="checkPaymentStatus()"
                class="flex-1 px-4 py-3 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white rounded-lg font-semibold transition-all duration-200"
            >
                Cek Status
            </button>
        </div>
    </div>
</div>

<!-- Payment Methods Modal -->
<div id="payment-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900 bg-opacity-75 backdrop-blur-sm">
    <div class="modal-content bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-lg w-full mx-4 text-gray-900 border border-gray-200 dark:border-gray-700 shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold">Pilih Metode Pembayaran</h3>
            <button onclick="closePaymentModal()" class="text-gray-500 hover:text-gray-700">Tutup</button>
        </div>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-4 rounded-xl border border-gray-200">
                <div>
                    <div class="font-semibold">QRIS</div>
                    <div class="text-sm text-gray-500">Bayar dengan QR Code</div>
                </div>
                <button onclick="createQrisAndOpen()" class="px-4 py-2 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white rounded-lg font-semibold">Lanjutkan</button>
            </div>
            <div class="flex items-center justify-between p-4 rounded-xl border border-gray-200 opacity-60">
                <div>
                    <div class="font-semibold">Virtual Account</div>
                    <div class="text-sm text-gray-500">Segera tersedia</div>
                </div>
                <button disabled class="px-4 py-2 bg-gray-200 text-gray-500 rounded-lg">Segera</button>
            </div>
        </div>
    </div>
    
</div>

<!-- Voucher Modal -->
<div id="voucher-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900 bg-opacity-75 backdrop-blur-sm">
    <div class="modal-content bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-lg w-full mx-4 text-gray-900 border border-gray-200 dark:border-gray-700 shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold">Pilih Voucher</h3>
            <button onclick="closeVoucherModal()" class="text-gray-500 hover:text-gray-700">Tutup</button>
        </div>
        <div id="voucher-list" class="space-y-3">
            <div class="text-gray-500">Memuat voucher...</div>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script>
const order = @json($order);
let paymentCheckInterval;
let currentPaymentId = null;

async function selectPaymentMethod(method) {
    if (method === 'qris') {
        try {
            const response = await fetch('{{ route('payment.qris.create', $order) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            // Parse aman meski server balas HTML saat 500
            const raw = await response.text();
            let result;
            try { result = raw ? JSON.parse(raw) : {}; } catch (e) { result = { message: raw }; }

            if (!response.ok) {
                const msg = (result && typeof result === 'object' && result.message) ? result.message : `Request gagal (${response.status})`;
                console.error('QRIS create error:', { status: response.status, result });
                alert(msg);
                return;
            }

            if (result.success) {
                // Always show modal
                const payment = result.payment || {};
                let qrUrl = payment.qr_code_url || null;
                if (!qrUrl && payment.raw_response && Array.isArray(payment.raw_response.actions)) {
                    const action = payment.raw_response.actions.find(a => a.name === 'generate-qr-code');
                    if (action) qrUrl = action.url;
                }
                if (!qrUrl && payment.raw_response && payment.raw_response.qr_string) {
                    qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(payment.raw_response.qr_string)}`;
                }

                if (qrUrl) {
                    currentPaymentId = result.payment_id || payment.id || currentPaymentId;
                    showQRCode(qrUrl);
                    if (currentPaymentId) startPaymentStatusCheck(currentPaymentId);
                } else {
                    console.warn('QRIS created but no qr url/qr string in response', result);
                    alert('Pembayaran dibuat, namun belum ada URL QR. Coba lagi atau muat ulang.');
                }
            } else {
                console.error('QRIS create failed:', result);
                alert(result.message || 'Gagal membuat pembayaran');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    } else {
        alert('Metode pembayaran ini akan segera tersedia.');
    }
}

function showQRCode(qrCodeUrl) {
    const qrContainer = document.getElementById('qr-code-container');
    qrContainer.innerHTML = `<img src="${qrCodeUrl}" alt="QR Code" class="w-48 h-48 object-contain">`;
    
    const modal = document.getElementById('qr-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeQRModal() {
    const modal = document.getElementById('qr-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    
    if (paymentCheckInterval) {
        clearInterval(paymentCheckInterval);
    }
}

function openPaymentModal(){
    const modal = document.getElementById('payment-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closePaymentModal(){
    const modal = document.getElementById('payment-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

async function createQrisAndOpen(){
    try {
        const response = await fetch('{{ route('payment.qris.create', $order) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        const raw = await response.text();
        let result; try { result = raw ? JSON.parse(raw) : {}; } catch (e) { result = { message: raw }; }
        if (!response.ok || !result.success){
            alert(result.message || 'Gagal membuat pembayaran');
            return;
        }
        currentPaymentId = result.payment_id || currentPaymentId;
        const p = result.payment || {};
        let qrUrl = p.qr_code_url || null;
        if (!qrUrl && p.raw_response && Array.isArray(p.raw_response.actions)) {
            const a = p.raw_response.actions.find(x => x.name === 'generate-qr-code');
            if (a) qrUrl = a.url;
        }
        if (!qrUrl && p.raw_response && p.raw_response.qr_string) {
            qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(p.raw_response.qr_string)}`;
        }
        closePaymentModal();
        if (qrUrl) { showQRCode(qrUrl); if (currentPaymentId) startPaymentStatusCheck(currentPaymentId); }
    } catch (e) {
        alert('Gagal membuat pembayaran');
    }
}

// Buat payment QRIS lalu redirect ke halaman payment/qris/{id}
async function createQrisAndRedirect(){
    try {
        const response = await fetch('{{ route('payment.qris.create', $order) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        const raw = await response.text();
        let result; try { result = raw ? JSON.parse(raw) : {}; } catch (e) { result = { message: raw }; }
        if (!response.ok || !result.success){
            alert(result.message || 'Gagal membuat pembayaran');
            return;
        }
        const paymentId = result.payment_id || (result.payment && result.payment.id);
        if (!paymentId){
            alert('Gagal mendapatkan ID pembayaran.');
            return;
        }
        window.location.href = `{{ route('payment.qris.show', ':id') }}`.replace(':id', String(paymentId));
    } catch (e) {
        alert('Gagal membuat pembayaran');
    }
}

function startPaymentStatusCheck(paymentId) {
    currentPaymentId = paymentId || currentPaymentId;
    paymentCheckInterval = setInterval(async () => {
        try {
            const response = await fetch(`/payment/qris/${paymentId}/status`);
            const result = await response.json();

            // Consider paid when API marks is_paid or status is settlement/capture
            if (result.is_paid || result.status === 'settlement' || result.status === 'capture') {
                clearInterval(paymentCheckInterval);
                clearInterval(countdownInterval);
                alert('Pembayaran berhasil! Terima kasih atas pembelian tiket Anda.');
                window.location.href = result.redirect_url || '{{ route('payment.success', ['payment' => ':paymentId']) }}'.replace(':paymentId', paymentId);
            } else if (
                result.status === 'failure' ||
                result.status === 'failed' ||
                result.status === 'expire' ||
                result.status === 'expired' ||
                result.status === 'cancel' ||
                result.status === 'deny'
            ) {
                clearInterval(paymentCheckInterval);
                alert('Pembayaran gagal atau kedaluwarsa.');
                closeQRModal();
            }
        } catch (error) {
            console.error('Error checking payment status:', error);
        }
    }, 3000); // Check every 3 seconds
}

async function checkPaymentStatus() {
    try {
        if (!currentPaymentId) {
            alert('Belum ada pembayaran yang dibuat.');
            return;
        }
        const response = await fetch(`/payment/qris/${currentPaymentId}/status`);
        const result = await response.json();

        if (!response.ok || !result.success) {
            console.error('Status check failed:', result);
            alert(result.message || 'Gagal mengecek status pembayaran.');
            return;
        }

        if (result.is_paid || result.status === 'settlement' || result.status === 'capture') {
            alert('Pembayaran berhasil!');
            window.location.href = result.redirect_url || '{{ route('payment.success', ['payment' => ':paymentId']) }}'.replace(':paymentId', String(currentPaymentId));
            return;
        }

        if (result.is_expired || result.status === 'expire' || result.status === 'expired') {
            alert('Pembayaran telah kedaluwarsa.');
            closeQRModal();
            return;
        }

        // Update QR jika server mengembalikan URL baru
        if (result.qr_code_url) {
            showQRCode(result.qr_code_url);
        }

        alert(result.message || 'Menunggu pembayaran...');
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengecek status pembayaran.');
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Timer dinonaktifkan di halaman checkout
});

// Cleanup intervals when page is unloaded
window.addEventListener('beforeunload', function() {
    if (paymentCheckInterval) clearInterval(paymentCheckInterval);
});

// VOUCHER SELECTOR
async function openVoucherSelector() {
    try {
        const resp = await fetch(`{{ route('booking.checkout.vouchers', $order) }}`);
        const data = await resp.json();
        const container = document.getElementById('voucher-list');
        container.innerHTML = '';
        if (!data.success || !Array.isArray(data.vouchers) || data.vouchers.length === 0) {
            container.innerHTML = '<div class="text-gray-500">Tidak ada voucher tersedia.</div>';
        } else {
            data.vouchers.forEach(uv => {
                const v = uv.voucher;
                const badge = v.type === 'percentage' ? `${v.value}%` : `Rp ${Number(v.value).toLocaleString('id-ID')}`;
                const el = document.createElement('div');
                el.className = 'border rounded-xl p-4 flex items-center justify-between hover:bg-gray-50';
                el.innerHTML = `
                    <div>
                        <div class="font-semibold">${v.name}</div>
                        <div class="text-xs text-gray-500">${badge} OFF</div>
                    </div>
                    <button class="px-4 py-2 bg-cinema-600 text-white rounded-lg text-sm">Pakai</button>
                `;
                el.querySelector('button').addEventListener('click', () => applyVoucher(uv.id, v));
                container.appendChild(el);
            });
        }
        const modal = document.getElementById('voucher-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    } catch (e) {
        alert('Gagal memuat voucher');
    }
}

function closeVoucherModal() {
    const modal = document.getElementById('voucher-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

async function applyVoucher(userVoucherId, voucher) {
    try {
        const resp = await fetch(`{{ route('booking.checkout.apply-voucher', $order) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ user_voucher_id: userVoucherId })
        });
        const data = await resp.json();
        if (!resp.ok || !data.success) {
            alert(data.message || 'Gagal menerapkan voucher');
            return;
        }
        const disc = Number(data.discount || 0);
        const total = Number(data.total || 0);
        document.getElementById('voucher-selected').classList.remove('hidden');
        document.getElementById('voucher-selected').textContent = `Voucher diterapkan: ${voucher.name} - Diskon Rp ${disc.toLocaleString('id-ID')} | Total baru: Rp ${total.toLocaleString('id-ID')}`;
        // Optionally update total display in the summary section if present
        const totalEl = document.querySelector('[data-total-amount]');
        if (totalEl) totalEl.textContent = 'Rp' + Number(data.total).toLocaleString('id-ID');
        closeVoucherModal();
    } catch (e) {
        alert('Gagal menerapkan voucher');
    }
}
</script>
@endpush
