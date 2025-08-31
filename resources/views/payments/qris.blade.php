<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran QRIS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Payment Status Alert -->
                    <div id="status-alert" class="mb-6 hidden">
                        <!-- Alert akan di-generate oleh JavaScript -->
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- QR Code Section -->
                        <div class="text-center">
                            <h3 class="text-lg font-semibold mb-4">Scan QR Code untuk Bayar</h3>
                            
                            @if($payment->qr_code_url)
                                <div class="bg-white border-2 border-gray-200 rounded-lg p-6 inline-block">
                                    <img src="{{ $payment->qr_code_url }}" 
                                         alt="QR Code QRIS" 
                                         class="w-64 h-64 mx-auto"
                                         id="qr-code">
                                </div>
                            @else
                                <div class="bg-gray-100 border-2 border-gray-200 rounded-lg p-6 inline-block">
                                    <div class="w-64 h-64 flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                            </svg>
                                            <p class="text-gray-500">QR Code sedang dimuat...</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Payment Apps Icons -->
                            <div class="mt-6">
                                <p class="text-sm text-gray-600 mb-3">Dapat dibayar menggunakan:</p>
                                <div class="flex justify-center space-x-4">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-1">
                                            <span class="text-green-600 font-bold text-xs">GP</span>
                                        </div>
                                        <span class="text-xs text-gray-600">GoPay</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-1">
                                            <span class="text-purple-600 font-bold text-xs">OVO</span>
                                        </div>
                                        <span class="text-xs text-gray-600">OVO</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-1">
                                            <span class="text-blue-600 font-bold text-xs">DANA</span>
                                        </div>
                                        <span class="text-xs text-gray-600">DANA</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-1">
                                            <span class="text-orange-600 font-bold text-xs">SP</span>
                                        </div>
                                        <span class="text-xs text-gray-600">ShopeePay</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mb-1">
                                            <span class="text-gray-600 font-bold text-xs">mBanking</span>
                                        </div>
                                        <span class="text-xs text-gray-600">Mobile Banking</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Timer -->
                            <div class="mt-6 p-4 bg-orange-50 rounded-lg">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm text-orange-700">Waktu tersisa: <span id="countdown" class="font-bold">--:--</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Details Section -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Detail Pembayaran</h3>
                            
                            <!-- Payment Info -->
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Order ID:</span>
                                        <span class="font-medium">#{{ $payment->order->id }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Payment ID:</span>
                                        <span class="font-medium">{{ $payment->external_id }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Metode:</span>
                                        <span class="font-medium">QRIS</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Status:</span>
                                        <span id="payment-status" class="font-medium capitalize">{{ $payment->status }}</span>
                                    </div>
                                    <div class="flex justify-between border-t pt-3">
                                        <span class="text-lg font-semibold">Total:</span>
                                        <span class="text-xl font-bold text-blue-600">{{ $payment->formatted_amount }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="mb-6">
                                <h4 class="font-semibold mb-3">Detail Tiket:</h4>
                                <div class="space-y-3">
                                    @foreach($payment->order->orderItems as $item)
                                        <div class="border border-gray-200 rounded-lg p-3">
                                            <div class="font-medium">{{ $item->showtime->movie->title }}</div>
                                            <div class="text-sm text-gray-600">
                                                {{ $item->showtime->cinemaHall->cinema->name }} - {{ $item->showtime->cinemaHall->name }}
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                {{ $item->showtime->start_time->format('d M Y, H:i') }}
                                            </div>
                                            <div class="text-sm font-medium mt-1">
                                                {{ $item->quantity }} tiket × Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Instructions -->
                            <div class="bg-blue-50 p-4 rounded-lg mb-6">
                                <h4 class="font-semibold text-blue-800 mb-2">Cara Pembayaran:</h4>
                                <ol class="text-sm text-blue-700 space-y-1">
                                    <li>1. Buka aplikasi mobile banking atau e-wallet Anda</li>
                                    <li>2. Pilih menu "Scan QR" atau "QRIS"</li>
                                    <li>3. Arahkan kamera ke QR code di sebelah kiri</li>
                                    <li>4. Pastikan nominal pembayaran sesuai</li>
                                    <li>5. Konfirmasi pembayaran</li>
                                    <li>6. Halaman akan otomatis terupdate setelah pembayaran berhasil</li>
                                </ol>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <button onclick="checkPaymentStatus()" 
                                        id="check-status-btn"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                                    Cek Status Pembayaran
                                </button>
                                
                                <button onclick="cancelPayment()" 
                                        id="cancel-btn"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                                    Batalkan Pembayaran
                                </button>
                                
                                <a href="{{ route('home') }}" 
                                   class="block w-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded-lg text-center transition-colors">
                                    Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let paymentStatusInterval;
        let countdownInterval;
        
        // Inisialisasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            startPaymentStatusCheck();
            startCountdown();
        });

        // Auto check payment status setiap 5 detik
        function startPaymentStatusCheck() {
            checkPaymentStatus();
            paymentStatusInterval = setInterval(checkPaymentStatus, 5000);
        }

        function checkPaymentStatus() {
            fetch(`{{ route('payment.qris.status', $payment) }}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updatePaymentStatus(data.status);
                        
                        if (data.is_paid) {
                            clearInterval(paymentStatusInterval);
                            clearInterval(countdownInterval);
                            showSuccessAlert('Pembayaran berhasil! Anda akan diarahkan ke halaman sukses...');
                            setTimeout(() => {
                                window.location.href = `{{ route('payment.success', $payment) }}`;
                            }, 2000);
                        } else if (data.is_expired) {
                            clearInterval(paymentStatusInterval);
                            clearInterval(countdownInterval);
                            showErrorAlert('Pembayaran telah kedaluwarsa.');
                            document.getElementById('qr-code').style.opacity = '0.5';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                });
        }

        function updatePaymentStatus(status) {
            const statusElement = document.getElementById('payment-status');
            statusElement.textContent = status;
            
            // Update warna berdasarkan status
            statusElement.className = 'font-medium capitalize';
            if (status === 'settlement') {
                statusElement.classList.add('text-green-600');
            } else if (status === 'pending') {
                statusElement.classList.add('text-yellow-600');
            } else {
                statusElement.classList.add('text-red-600');
            }
        }

        function startCountdown() {
            const expiryTime = new Date('{{ $payment->expiry_time }}').getTime();
            
            countdownInterval = setInterval(function() {
                const now = new Date().getTime();
                const distance = expiryTime - now;
                
                if (distance < 0) {
                    clearInterval(countdownInterval);
                    document.getElementById('countdown').textContent = '00:00';
                    showErrorAlert('Waktu pembayaran telah habis.');
                    return;
                }
                
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                document.getElementById('countdown').textContent = 
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        function cancelPayment() {
            if (confirm('Apakah Anda yakin ingin membatalkan pembayaran ini?')) {
                fetch(`{{ route('payment.qris.cancel', $payment) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        clearInterval(paymentStatusInterval);
                        clearInterval(countdownInterval);
                        alert(data.message);
                        window.location.href = data.redirect_url;
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat membatalkan pembayaran.');
                });
            }
        }

        function showSuccessAlert(message) {
            const alertDiv = document.getElementById('status-alert');
            alertDiv.innerHTML = `
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        ${message}
                    </div>
                </div>
            `;
            alertDiv.classList.remove('hidden');
        }

        function showErrorAlert(message) {
            const alertDiv = document.getElementById('status-alert');
            alertDiv.innerHTML = `
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        ${message}
                    </div>
                </div>
            `;
            alertDiv.classList.remove('hidden');
        }

        // Cleanup intervals when page unloads
        window.addEventListener('beforeunload', function() {
            if (paymentStatusInterval) clearInterval(paymentStatusInterval);
            if (countdownInterval) clearInterval(countdownInterval);
        });
    </script>
</x-app-layout>
