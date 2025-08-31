<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Berhasil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Success Animation & Message -->
                    <div class="text-center mb-8">
                        <div class="mx-auto flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-green-600 mb-2">Pembayaran Berhasil!</h1>
                        <p class="text-gray-600">Terima kasih atas pembayaran Anda. Tiket Anda telah dikonfirmasi.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Payment Summary -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Ringkasan Pembayaran</h3>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
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
                                        <span class="text-sm text-gray-600">Metode Pembayaran:</span>
                                        <span class="font-medium">QRIS</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Status:</span>
                                        <span class="font-medium text-green-600">Berhasil</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Waktu Pembayaran:</span>
                                        <span class="font-medium">{{ $payment->settlement_time->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between border-t pt-3">
                                        <span class="text-lg font-semibold">Total Dibayar:</span>
                                        <span class="text-xl font-bold text-green-600">{{ $payment->formatted_amount }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Next Steps -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="font-semibold text-blue-800 mb-2">Langkah Selanjutnya:</h4>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li>• Tiket elektronik akan dikirim ke email Anda</li>
                                    <li>• Tunjukkan tiket elektronik saat di bioskop</li>
                                    <li>• Datang 30 menit sebelum film dimulai</li>
                                    <li>• Bawa kartu identitas untuk verifikasi</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Ticket Details -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Detail Tiket</h3>
                            <div class="space-y-4">
                                @foreach($payment->order->orderItems as $item)
                                    <div class="border border-gray-200 rounded-lg p-4 bg-gradient-to-r from-blue-50 to-purple-50">
                                        <!-- Movie Header -->
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <h4 class="font-bold text-lg text-gray-900">{{ $item->showtime->movie->title }}</h4>
                                                <div class="flex items-center space-x-2 mt-1">
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded">{{ $item->showtime->movie->rating }}</span>
                                                    <span class="text-sm text-gray-600">{{ $item->showtime->movie->duration }} menit</span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm text-gray-600">{{ $item->quantity }} Tiket</div>
                                                <div class="font-bold text-blue-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                                            </div>
                                        </div>

                                        <!-- Cinema & Schedule Info -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <div class="text-gray-600 mb-1">Bioskop:</div>
                                                <div class="font-medium">{{ $item->showtime->cinemaHall->cinema->name }}</div>
                                                <div class="text-gray-600">{{ $item->showtime->cinemaHall->name }}</div>
                                            </div>
                                            <div>
                                                <div class="text-gray-600 mb-1">Jadwal:</div>
                                                <div class="font-medium">{{ $item->showtime->start_time->format('d M Y') }}</div>
                                                <div class="text-gray-600">{{ $item->showtime->start_time->format('H:i') }} WIB</div>
                                            </div>
                                        </div>

                                        <!-- Seat Information (jika ada) -->
                                        @if($item->seatReservations->count() > 0)
                                            <div class="mt-3 pt-3 border-t border-gray-200">
                                                <div class="text-gray-600 text-sm mb-1">Kursi:</div>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($item->seatReservations as $reservation)
                                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                                                            {{ $reservation->seat->row }}{{ $reservation->seat->number }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('dashboard') }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-center transition-colors duration-200">
                            Kembali ke Dashboard
                        </a>
                        
                        <!-- Download Ticket Button (untuk implementasi masa depan) -->
                        <button type="button" 
                                onclick="downloadTicket()"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                            Download Tiket (PDF)
                        </button>
                        
                        <!-- Share Button -->
                        <button type="button" 
                                onclick="shareTicket()"
                                class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                            Bagikan
                        </button>
                    </div>

                    <!-- Important Notes -->
                    <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h4 class="font-semibold text-yellow-800 mb-2">⚠️ Penting untuk Diingat:</h4>
                        <ul class="text-sm text-yellow-700 space-y-1">
                            <li>• Tiket tidak dapat dikembalikan atau ditukar setelah pembelian</li>
                            <li>• Simpan bukti pembayaran ini sebagai referensi</li>
                            <li>• Hubungi customer service jika ada kendala: cs@7play.com</li>
                            <li>• Cek email Anda untuk tiket elektronik dalam 5-10 menit</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadTicket() {
            // Implementasi download ticket PDF (untuk masa depan)
            alert('Fitur download tiket PDF sedang dalam pengembangan. Tiket elektronik akan dikirim ke email Anda.');
        }

        function shareTicket() {
            if (navigator.share) {
                navigator.share({
                    title: '7PLAY - Tiket Bioskop Berhasil Dibeli!',
                    text: 'Saya baru saja membeli tiket bioskop di 7PLAY! Order ID: #{{ $payment->order->id }}',
                    url: window.location.href
                }).catch(console.error);
            } else {
                // Fallback for browsers that don't support Web Share API
                const url = window.location.href;
                const text = 'Saya baru saja membeli tiket bioskop di 7PLAY! Order ID: #{{ $payment->order->id }}';
                
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(`${text} - ${url}`).then(() => {
                        alert('Link berhasil disalin ke clipboard!');
                    });
                } else {
                    // Even older fallback
                    prompt('Copy link ini untuk dibagikan:', `${text} - ${url}`);
                }
            }
        }

        // Auto-reload halaman setelah 30 detik untuk memastikan data terbaru
        setTimeout(() => {
            location.reload();
        }, 30000);
    </script>
</x-app-layout>
