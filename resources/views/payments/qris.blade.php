@extends('layouts.public')

@section('title', 'Pembayaran QRIS - 7PLAY')

@section('content')
<div class="py-12">
    <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                    
                    <!-- Payment Status Alert -->
                    <div id="status-alert" class="mb-6 hidden">
                        <!-- Alert akan di-generate oleh JavaScript -->
                    </div>

                    <div class="space-y-8 max-h-[80vh] overflow-y-auto pr-2">

                        <!-- 1) QR Code Section -->
                        <section class="text-center">
                            <h3 class="text-lg font-semibold mb-4">Scan QR Code untuk Bayar</h3>

                            @php
                                $qrUrl = $payment->qr_code_url
                                    ?? data_get($payment->raw_response, 'qr_url')
                                    ?? (function($actions){
                                            if (!is_array($actions)) return null;
                                            foreach ($actions as $a) {
                                                if (($a['name'] ?? null) === 'generate-qr-code' && !empty($a['url'])) {
                                                    return $a['url'];
                                                }
                                            }
                                            return null;
                                        })(data_get($payment->raw_response, 'actions', []));
                            @endphp

                            @if($qrUrl)
                                <div class="bg-white border-2 border-gray-200 rounded-lg p-6 inline-block">
                                    <img src="{{ $qrUrl }}" alt="QR Code QRIS" class="w-64 h-64 mx-auto" id="qr-code">
                                </div>
                            @else
                                <div class="bg-gray-100 border-2 border-gray-200 rounded-lg p-6 inline-block">
                                    <div class="w-64 h-64 flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                            </svg>
                                            <p class="text-gray-500">QR Code sedang dimuat...</p>
                                            @if(app()->environment('local'))
                                                <p class="text-xs text-gray-400 mt-1">Jika lama, klik "Cek Status Pembayaran" di bawah.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            
                        </section>

                        <!-- 2) Timer -->
                        <section class="p-4 bg-orange-50 rounded-lg">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-orange-700">Waktu tersisa: <span id="countdown" class="font-bold">--:--</span></span>
                            </div>
                        </section>

                        <!-- 3) Payment Info -->
                        <section>
                            <h3 class="text-lg font-semibold mb-4">Detail Pembayaran</h3>
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
                                    <div class="flex justify-between border-t pt-3">
                                        <span class="text-lg font-semibold">Total:</span>
                                        <span class="text-xl font-bold text-blue-600">{{ $payment->formatted_amount }}</span>
                                    </div>
                                </div>
                            </div>
                            
                        </section>

                        <!-- 4) Cara Pembayaran -->
                        <section class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-2">Cara Pembayaran:</h4>
                            <ol class="text-sm text-blue-700 space-y-1">
                                <li>1. Buka aplikasi mobile banking atau e-wallet Anda</li>
                                <li>2. Pilih menu "Scan QR" atau "QRIS"</li>
                                <li>3. Arahkan kamera ke QR code di atas</li>
                                <li>4. Pastikan nominal pembayaran sesuai</li>
                                <li>5. Konfirmasi pembayaran</li>
                                <li>6. Halaman akan otomatis terupdate setelah pembayaran berhasil</li>
                            </ol>
                        </section>

                        <!-- 5) Hanya tombol cek status pembayaran -->
                        <section>
                            <button onclick="onManualCheckStatus()" id="check-status-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">Cek Status Pembayaran</button>
                        </section>

                    </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
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
            checkPaymentStatus(false);
            paymentStatusInterval = setInterval(() => checkPaymentStatus(false), 5000);
        }

        function checkPaymentStatus(manual = false) {
            return fetch(`{{ route('payment.qris.status', $payment) }}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Status tidak lagi diupdate pada label, tampilkan melalui alert saja
                        if (data.qr_code_url) {
                            const img = document.getElementById('qr-code');
                            if (img) {
                                img.src = data.qr_code_url;
                                img.style.opacity = '1';
                            }
                        }
                        
                        if (data.is_paid) {
                            clearInterval(paymentStatusInterval);
                            clearInterval(countdownInterval);
                            if (manual) { alert('Pembayaran berhasil!'); }
                            window.location.href = `{{ route('payment.success', $payment) }}`;
                        } else if (data.is_expired) {
                            clearInterval(paymentStatusInterval);
                            clearInterval(countdownInterval);
                            if (manual) { alert('Pembayaran telah kedaluwarsa.'); }
                            document.getElementById('qr-code').style.opacity = '0.5';
                        } else {
                            if (manual) { alert(data.message || 'Menunggu pembayaran...'); }
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                    if (manual) { alert('Gagal mengecek status pembayaran.'); }
                });
        }

        function onManualCheckStatus(){
            const btn = document.getElementById('check-status-btn');
            const original = btn.textContent;
            btn.disabled = true;
            btn.textContent = 'Mengecek status...';
            checkPaymentStatus(true).finally(() => {
                btn.disabled = false;
                btn.textContent = original;
            });
        }

        // updatePaymentStatus dihapus; gunakan alert untuk memberi feedback status

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

        // Toggle show more/less for order items
        function togglePaymentItems(){
            const extras = document.querySelectorAll('.payment-item-extra');
            const showMore = document.getElementById('show-more-btn');
            const showLess = document.getElementById('show-less-btn');
            const hidden = Array.from(extras).some(el => el.classList.contains('hidden'));
            extras.forEach(el => el.classList.toggle('hidden'));
            if(hidden){
                if(showMore) showMore.classList.add('hidden');
                if(showLess) showLess.classList.remove('hidden');
            }else{
                if(showMore) showMore.classList.remove('hidden');
                if(showLess) showLess.classList.add('hidden');
            }
        }
    </script>
@endpush
@endsection
