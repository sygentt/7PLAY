@extends('layouts.public')

@section('title', 'Pilih Metode Pembayaran - 7PLAY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-black py-10">
	<div class="max-w-3xl mx-auto px-4">
		<h1 class="text-2xl font-bold mb-6">Pilih Metode Pembayaran</h1>

		<div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
			<div class="space-y-4">
				<!-- QRIS -->
				<div class="flex items-center justify-between p-4 rounded-xl border border-gray-200 dark:border-gray-700">
					<div>
						<div class="font-semibold">QRIS</div>
						<div class="text-sm text-gray-500">Bayar dengan QR Code</div>
					</div>
					<button onclick="startQris()" class="px-4 py-2 bg-cinema-600 text-white rounded-lg">Lanjutkan</button>
				</div>

				<!-- VA (placeholder) -->
				<div class="flex items-center justify-between p-4 rounded-xl border border-gray-200 dark:border-gray-700 opacity-60">
					<div>
						<div class="font-semibold">Virtual Account</div>
						<div class="text-sm text-gray-500">Transfer via bank</div>
					</div>
					<button disabled class="px-4 py-2 bg-gray-200 text-gray-500 rounded-lg">Segera</button>
				</div>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script>
async function startQris(){
	try{
		const resp = await fetch(`{{ route('payment.qris.create', $order) }}`, {
			method: 'POST',
			headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
		});
		const data = await resp.json();
		if(!resp.ok || !data.success){
			alert(data.message || 'Gagal membuat pembayaran');
			return;
		}
		window.location.href = `{{ route('payment.qris.show', ':id') }}`.replace(':id', data.payment_id);
	}catch(e){
		alert('Gagal membuat pembayaran');
	}
}
</script>
@endpush
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilih Metode Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Order Summary -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Order ID:</span>
                                <span class="font-medium">#{{ $order->id }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Total Tiket:</span>
                                <span class="font-medium">{{ $order->orderItems->count() }} tiket</span>
                            </div>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm text-gray-600">Total Pembayaran:</span>
                                <span class="text-xl font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            
                            <!-- Detail Tiket -->
                            <div class="border-t pt-4">
                                <h4 class="text-sm font-semibold mb-2">Detail Tiket:</h4>
                                @foreach($order->orderItems as $item)
                                    <div class="text-sm text-gray-600 mb-1">
                                        {{ $order->showtime?->movie?->title ?? 'Tiket' }} - {{ $order->showtime?->cinemaHall?->cinema?->name ?? '-' }}
                                        <br>
                                        <span class="text-xs">{{ $order->showtime ? $order->showtime->getFormattedDateTime() : '-' }} | 1 tiket | Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Pilih Metode Pembayaran</h3>
                        
                        <!-- QRIS Payment -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors" id="qris-method">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">QRIS (Quick Response Code Indonesian Standard)</h4>
                                        <p class="text-sm text-gray-600">Bayar dengan scan QR code menggunakan aplikasi mobile banking atau e-wallet</p>
                                        <div class="flex space-x-2 mt-2">
                                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">GoPay</span>
                                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">OVO</span>
                                            <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded">DANA</span>
                                            <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded">ShopeePay</span>
                                            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">Mobile Banking</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-green-600 font-medium">Instant</div>
                                    <div class="text-xs text-gray-500">Berlaku 30 menit</div>
                                </div>
                            </div>
                        </div>

                        <!-- Metode pembayaran lain (untuk implementasi masa depan) -->
                        @php($enabled = config('midtrans.enabled_methods', ['qris']))
                        @if(in_array('va', $enabled) || in_array('ewallet', $enabled) || in_array('credit_card', $enabled))
                        <div class="mt-4 space-y-3">
                            @if(in_array('va', $enabled))
                            <div class="border border-gray-200 rounded-lg p-4 opacity-70">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Virtual Account</h4>
                                        <p class="text-sm text-gray-600">BCA/BNI/BRI/Mandiri/Permata</p>
                                    </div>
                                    <button disabled class="px-3 py-2 bg-gray-200 text-gray-500 rounded">Segera</button>
                                </div>
                            </div>
                            @endif
                            @if(in_array('ewallet', $enabled))
                            <div class="border border-gray-200 rounded-lg p-4 opacity-70">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">E-Wallet</h4>
                                        <p class="text-sm text-gray-600">GoPay/OVO/DANA/ShopeePay</p>
                                    </div>
                                    <button disabled class="px-3 py-2 bg-gray-200 text-gray-500 rounded">Segera</button>
                                </div>
                            </div>
                            @endif
                            @if(in_array('credit_card', $enabled))
                            <div class="border border-gray-200 rounded-lg p-4 opacity-70">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Kartu Kredit</h4>
                                        <p class="text-sm text-gray-600">Visa/Mastercard/JCB</p>
                                    </div>
                                    <button disabled class="px-3 py-2 bg-gray-200 text-gray-500 rounded">Segera</button>
                                </div>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600 text-center">
                                Metode pembayaran lain seperti Virtual Account, E-Wallet, atau Kartu Kredit akan segera tersedia.
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        <button type="button" 
                                onclick="event.preventDefault(); event.stopPropagation(); createQrisPayment(); return false;"
                                id="pay-button"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="pay-text">Bayar dengan QRIS</span>
                            <span id="loading-text" class="hidden">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Membuat pembayaran...
                            </span>
                        </button>
                        
                        <a href="{{ route('home') }}" 
                           class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-3 px-6 rounded-lg text-center transition-colors duration-200">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div id="qr-modal" class="fixed inset-0 hidden items-center justify-center bg-gray-900 bg-opacity-75 backdrop-blur-sm z-50">
        <div class="modal-content relative w-11/12 md:w-2/3 lg:w-1/2 max-w-3xl mx-auto p-6 border border-gray-200 dark:border-gray-700 shadow-2xl rounded-2xl bg-white dark:bg-gray-800">
            <div class="mt-3">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Pembayaran QRIS</h3>
                    <button onclick="closeQrModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Order Info -->
                <div id="modal-order-info" class="bg-gray-50 rounded-lg p-4 mb-6">
                    <!-- Order details will be inserted here -->
                </div>

                <!-- QR Code Section -->
                <div class="text-center mb-6">
                    <h4 class="text-lg font-semibold mb-4">Scan QR Code untuk Bayar</h4>
                    
                    <div id="qr-loading" class="text-center py-8">
                        <svg class="animate-spin h-8 w-8 text-blue-600 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-600">Memuat QR Code...</p>
                    </div>

                    <div id="qr-code-container" class="hidden">
                        <div class="bg-white border-2 border-gray-200 rounded-lg p-6 inline-block">
                            <img id="qr-code-image" 
                                 alt="QR Code QRIS" 
                                 class="w-64 h-64 mx-auto"
                                 style="opacity: 0; transition: opacity 0.3s;">
                        </div>
                        <p class="text-sm text-gray-600 mt-4">
                            Scan QR code di atas menggunakan aplikasi mobile banking atau e-wallet Anda
                        </p>
                    </div>

                    <div id="qr-error" class="hidden text-center py-8">
                        <div class="text-red-600 mb-2">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600">Gagal memuat QR Code. Silakan coba lagi.</p>
                        <button onclick="retryQrCode()" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            Coba Lagi
                        </button>
                    </div>
                </div>

                <!-- Payment Status -->
                <div id="payment-status" class="text-center mb-6">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-center justify-center">
                            <div class="animate-pulse w-3 h-3 bg-yellow-400 rounded-full mr-2"></div>
                            <span class="text-yellow-800 font-medium">Menunggu Pembayaran</span>
                        </div>
                        <p class="text-sm text-yellow-700 mt-2">
                            Pembayaran akan dikonfirmasi secara otomatis setelah Anda menyelesaikan transaksi.
                        </p>
                    </div>
                </div>

                <!-- Timer -->
                <div id="payment-timer" class="text-center mb-6">
                    <p class="text-sm text-gray-600">
                        Pembayaran berakhir dalam: <span id="countdown" class="font-mono font-bold text-red-600">29:59</span>
                    </p>
                </div>

                <!-- Modal Actions -->
                <div class="flex space-x-4">
                    <button onclick="checkPaymentStatus()" 
                            id="check-status-btn"
                            class="flex-1 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        Cek Status Pembayaran
                    </button>
                    <button onclick="closeQrModal()" 
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function createQrisPayment() {
            console.log('createQrisPayment() called');
            alert('createQrisPayment function started!');
            const payButton = document.getElementById('pay-button');
            const payText = document.getElementById('pay-text');
            const loadingText = document.getElementById('loading-text');
            
            // Disable button dan show loading
            payButton.disabled = true;
            payText.classList.add('hidden');
            loadingText.classList.remove('hidden');
            
            fetch(`{{ route('payment.qris.create', $order) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('PAYMENT RESPONSE:', data);
                
                // Reset button
                payButton.disabled = false;
                payText.classList.remove('hidden');
                loadingText.classList.add('hidden');
                
                if (data.success) {
                    console.log('SUCCESS - showing modal with payment:', data.payment);
                    // Jika deep_link_url tersedia (misal e-wallet), arahkan agar pengguna bisa bayar di app
                    if (data.payment && data.payment.deep_link_url) {
                        try { window.location.href = data.payment.deep_link_url; } catch (e) {}
                    }
                    // Show modal instead of redirect
                    currentPayment = data.payment;
                    showQrModal(data.payment);
                } else {
                    alert('Error: ' + data.message + '\n\nFull response:\n' + JSON.stringify(data, null, 2));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat membuat pembayaran. Silakan coba lagi.');
                // Reset button
                payButton.disabled = false;
                payText.classList.remove('hidden');
                loadingText.classList.add('hidden');
            });
        }

        let currentPayment = null;
        let paymentStatusInterval = null;
        let countdownInterval = null;

        function showQrModal(payment) {
            console.log('showQrModal called with payment:', payment);
            // Show modal
            document.getElementById('qr-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Populate order info
            const orderInfo = `
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="font-bold text-lg text-gray-900">${payment.order?.showtime?.movie?.title || 'Tiket'}</h4>
                        <div class="text-sm text-gray-600 mt-1">
                            <p>${payment.order?.showtime?.cinema_hall?.cinema?.name || 'Cinema'} - ${payment.order?.showtime?.cinema_hall?.name || 'Hall'}</p>
                            <p>${payment.order?.showtime?.start_time ? new Date(payment.order.showtime.start_time).toLocaleDateString('id-ID', { 
                                weekday: 'long', 
                                year: 'numeric', 
                                month: 'long', 
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            }) : ''}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-gray-900">Rp ${new Intl.NumberFormat('id-ID').format(payment.amount)}</div>
                        <div class="text-sm text-gray-600">Order #${payment.external_id}</div>
                    </div>
                </div>
            `;
            document.getElementById('modal-order-info').innerHTML = orderInfo;

            // Load QR code
            loadQrCode(payment);

            // Start countdown timer
            startCountdown(payment.expiry_time);

            // Start status polling
            startStatusPolling(payment.id);
        }

        function loadQrCode(payment) {
            const qrLoading = document.getElementById('qr-loading');
            const qrContainer = document.getElementById('qr-code-container');
            const qrError = document.getElementById('qr-error');
            const qrImage = document.getElementById('qr-code-image');

            // Show loading
            qrLoading.classList.remove('hidden');
            qrContainer.classList.add('hidden');
            qrError.classList.add('hidden');

            // Determine QR URL
            let qrUrl = payment.qr_code_url;
            if (!qrUrl && payment.raw_response?.actions) {
                const action = payment.raw_response.actions.find(a => a.name === 'generate-qr-code');
                if (action) qrUrl = action.url;
            }
            if (!qrUrl && payment.raw_response?.qr_string) {
                qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(payment.raw_response.qr_string)}`;
            }

            if (qrUrl) {
                qrImage.onload = function() {
                    qrLoading.classList.add('hidden');
                    qrContainer.classList.remove('hidden');
                    qrImage.style.opacity = '1';
                };
                qrImage.onerror = function() {
                    qrLoading.classList.add('hidden');
                    qrError.classList.remove('hidden');
                };
                qrImage.src = qrUrl;
            } else {
                qrLoading.classList.add('hidden');
                qrError.classList.remove('hidden');
            }
        }

        function retryQrCode() {
            if (currentPayment) {
                loadQrCode(currentPayment);
            }
        }

        function closeQrModal() {
            document.getElementById('qr-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Clear intervals
            if (paymentStatusInterval) {
                clearInterval(paymentStatusInterval);
                paymentStatusInterval = null;
            }
            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }
            
            currentPayment = null;
        }

        function startCountdown(expiryTime) {
            const countdownElement = document.getElementById('countdown');
            const expiryDate = new Date(expiryTime);

            countdownInterval = setInterval(() => {
                const now = new Date();
                const timeLeft = expiryDate - now;

                if (timeLeft <= 0) {
                    countdownElement.textContent = '00:00';
                    clearInterval(countdownInterval);
                    updatePaymentStatus('expired');
                    return;
                }

                const minutes = Math.floor(timeLeft / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                countdownElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        function startStatusPolling(paymentId) {
            paymentStatusInterval = setInterval(() => {
                checkPaymentStatusById(paymentId);
            }, 5000); // Check every 5 seconds
        }

        function checkPaymentStatus() {
            if (currentPayment) {
                checkPaymentStatusById(currentPayment.id, true);
            }
        }

        function checkPaymentStatusById(paymentId, showAlert = false) {
            fetch(`/payment/qris/${paymentId}/status`)
                .then(response => response.json())
                .then(data => {
                    if (showAlert) {
                        alert(JSON.stringify(data, null, 2));
                    }
                    
                    if (data.success) {
                        updatePaymentStatus(data.status);
                        
                        if (data.is_paid) {
                            clearInterval(paymentStatusInterval);
                            clearInterval(countdownInterval);
                            window.location.href = `/payment/success/${paymentId}`;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                });
        }

        function updatePaymentStatus(status) {
            const statusElement = document.getElementById('payment-status');
            let statusHTML = '';

            switch (status) {
                case 'settlement':
                case 'capture':
                    statusHTML = `
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-green-800 font-medium">Pembayaran Berhasil</span>
                            </div>
                        </div>
                    `;
                    break;
                case 'expired':
                    statusHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-800 font-medium">Pembayaran Kedaluwarsa</span>
                            </div>
                        </div>
                    `;
                    break;
                default:
                    statusHTML = `
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center justify-center">
                                <div class="animate-pulse w-3 h-3 bg-yellow-400 rounded-full mr-2"></div>
                                <span class="text-yellow-800 font-medium">Menunggu Pembayaran</span>
                            </div>
                        </div>
                    `;
            }

            statusElement.innerHTML = statusHTML;
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('qr-modal');
            if (event.target === modal) {
                closeQrModal();
            }
        });
    </script>
</x-app-layout>
