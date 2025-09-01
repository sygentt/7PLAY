<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Kedaluwarsa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Expired Animation & Message -->
                    <div class="text-center mb-8">
                        <div class="mx-auto flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-red-600 mb-2">Pembayaran Kedaluwarsa</h1>
                        <p class="text-gray-600">Waktu pembayaran telah habis. Silakan lakukan pemesanan ulang untuk melanjutkan.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Payment Details -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Detail Pembayaran</h3>
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
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
                                        <span class="font-medium text-red-600">Kedaluwarsa</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Waktu Kedaluwarsa:</span>
                                        <span class="font-medium">{{ $payment->expiry_time->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between border-t pt-3">
                                        <span class="text-lg font-semibold">Total:</span>
                                        <span class="text-xl font-bold text-red-600">{{ $payment->formatted_amount }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- What Happened -->
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Apa yang Terjadi?</h4>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    <li>• Pembayaran tidak diselesaikan dalam waktu yang ditentukan (30 menit)</li>
                                    <li>• QR Code QRIS telah tidak berlaku</li>
                                    <li>• Pesanan tiket Anda telah dibatalkan secara otomatis</li>
                                    <li>• Kursi yang dipilih telah dilepaskan untuk pembeli lain</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Order Details (What was ordered) -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Pesanan yang Dibatalkan</h3>
                            <div class="space-y-4">
                                @foreach($payment->order->orderItems as $item)
                                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 opacity-75">
                                        <!-- Movie Header -->
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <h4 class="font-bold text-lg text-gray-700">{{ $payment->order->showtime?->movie?->title ?? 'Tiket' }}</h4>
                                                <div class="flex items-center space-x-2 mt-1">
                                                    @if($payment->order->showtime?->movie)
                                                        <span class="bg-gray-200 text-gray-600 text-xs font-medium px-2 py-1 rounded">{{ $payment->order->showtime->movie->rating }}</span>
                                                        <span class="text-sm text-gray-500">{{ $payment->order->showtime->movie->duration }} menit</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm text-gray-500">1 Tiket</div>
                                                <div class="font-bold text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                            </div>
                                        </div>

                                        <!-- Cinema & Schedule Info -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <div class="text-gray-500 mb-1">Bioskop:</div>
                                                <div class="font-medium text-gray-600">{{ $payment->order->showtime?->cinemaHall?->cinema?->name ?? '-' }}</div>
                                                <div class="text-gray-500">{{ $payment->order->showtime?->cinemaHall?->name ?? '-' }}</div>
                                            </div>
                                            <div>
                                                <div class="text-gray-500 mb-1">Jadwal:</div>
                                                @if($payment->order->showtime)
                                                    <div class="font-medium text-gray-600">{{ $payment->order->showtime->getFormattedDate() }}</div>
                                                    <div class="text-gray-500">{{ $payment->order->showtime->getFormattedTime() }} WIB</div>
                                                @else
                                                    <div class="font-medium text-gray-600">-</div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Seat Information (jika ada) -->
                                        @if(method_exists($item, 'seatReservations') && $item->seatReservations->count() > 0)
                                            <div class="mt-3 pt-3 border-t border-gray-200">
                                                <div class="text-gray-500 text-sm mb-1">Kursi yang dipilih:</div>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($item->seatReservations as $reservation)
                                                        <span class="bg-gray-200 text-gray-600 text-xs font-medium px-2 py-1 rounded">
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

                    <!-- Next Steps -->
                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-800 mb-2">Langkah Selanjutnya:</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Kembali ke halaman pemilihan film untuk memesan ulang</li>
                            <li>• Pastikan waktu pembayaran cukup (maksimal 30 menit)</li>
                            <li>• Siapkan aplikasi pembayaran sebelum melakukan pemesanan</li>
                            <li>• Kursi yang sama mungkin sudah tidak tersedia</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('home') }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-center transition-colors duration-200">
                            Pilih Film Lagi
                        </a>
                        
                        <a href="{{ route('home') }}" 
                           class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg text-center transition-colors duration-200">
                            Kembali ke Beranda
                        </a>
                        
                        <!-- Contact Support -->
                        <button type="button" 
                                onclick="contactSupport()"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                            Hubungi Customer Service
                        </button>
                    </div>

                    <!-- Tips for Next Time -->
                    <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h4 class="font-semibold text-yellow-800 mb-2">💡 Tips untuk Pemesanan Berikutnya:</h4>
                        <ul class="text-sm text-yellow-700 space-y-1">
                            <li>• Siapkan aplikasi e-wallet atau mobile banking sebelum checkout</li>
                            <li>• Pastikan koneksi internet stabil saat melakukan pembayaran</li>
                            <li>• Jangan tutup browser sebelum pembayaran selesai</li>
                            <li>• Selesaikan pembayaran dalam 30 menit setelah QR code dibuat</li>
                            <li>• Simpan screenshot QR code jika diperlukan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function contactSupport() {
            // Bisa redirect ke halaman contact atau membuka email client
            const subject = encodeURIComponent('Bantuan Pembayaran Kedaluwarsa - Order #{{ $payment->order->id }}');
            const body = encodeURIComponent(`
Halo Tim Customer Service 7PLAY,

Saya mengalami pembayaran kedaluwarsa untuk:
- Order ID: #{{ $payment->order->id }}
- Payment ID: {{ $payment->external_id }}
- Waktu Kedaluwarsa: {{ $payment->expiry_time->format('d M Y, H:i') }}

Mohon bantuan untuk penjelasan lebih lanjut.

Terima kasih.
            `);
            
            window.location.href = `mailto:cs@7play.com?subject=${subject}&body=${body}`;
        }

        // Show loading state when navigating away
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href]');
            links.forEach(link => {
                link.addEventListener('click', function() {
                    // Add loading state to the clicked button
                    this.innerHTML = '⏳ Memuat...';
                    this.style.opacity = '0.7';
                });
            });
        });
    </script>
</x-app-layout>
