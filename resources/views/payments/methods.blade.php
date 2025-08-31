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
                                        {{ $item->showtime->movie->title }} - {{ $item->showtime->cinemaHall->cinema->name }}
                                        <br>
                                        <span class="text-xs">{{ $item->showtime->start_time->format('d M Y H:i') }} | {{ $item->quantity }} tiket | Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
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
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600 text-center">
                                Metode pembayaran lain seperti Virtual Account dan Transfer Bank akan segera tersedia.
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        <button type="button" 
                                onclick="createQrisPayment()"
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

    <script>
        function createQrisPayment() {
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
                if (data.success) {
                    window.location.href = data.redirect_url;
                } else {
                    alert('Error: ' + data.message);
                    // Reset button
                    payButton.disabled = false;
                    payText.classList.remove('hidden');
                    loadingText.classList.add('hidden');
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
    </script>
</x-app-layout>
