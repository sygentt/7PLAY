@extends('layouts.public')

@section('title', 'Pembayaran Berhasil - 7PLAY')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="max-w-lg w-full bg-white dark:bg-gray-800 rounded-2xl p-8 text-center border border-gray-100 dark:border-gray-700 mx-4">
        <div class="mx-auto w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-bold mb-2">Pembayaran Berhasil</h1>
        <p class="text-gray-600 dark:text-gray-300 mb-6">Terima kasih! Pembayaran untuk pesanan Anda telah diterima.</p>
        <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-cinema-600 text-white rounded-lg">Kembali ke Beranda</a>
    </div>
    
</div>
@endsection

@extends('layouts.public')

@section('title', 'Terima kasih! Pembayaran Berhasil - 7PLAY')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-black py-10">
    <div class="max-w-5xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl shadow">
            <div class="p-6 md:p-10 text-gray-900 dark:text-gray-100">
                    
                    <!-- Success Animation & Message -->
                    <div class="text-center mb-8">
                        <div class="mx-auto flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full mb-4">
                            <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">Terima kasih! Pembayaran Berhasil</h1>
                        <p class="text-gray-600 dark:text-gray-300">Transaksi Anda sudah kami terima. E-tiket siap digunakan.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Payment Summary -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Ringkasan Pembayaran</h3>
                            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Order ID:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">#{{ $payment->order->id }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Payment ID:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $payment->external_id }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Metode Pembayaran:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">QRIS</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Status:</span>
                                        <span class="font-medium text-green-600">Berhasil</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Waktu Pembayaran:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $payment->settlement_time->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between border-t pt-3">
                                        <span class="text-lg font-semibold text-gray-900 dark:text-white">Total Dibayar:</span>
                                        <span class="text-xl font-bold text-green-600 dark:text-green-400">{{ $payment->formatted_amount }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Next Steps -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                <h4 class="font-semibold text-blue-800 dark:text-blue-300 mb-2">Langkah Selanjutnya:</h4>
                                <ul class="text-sm text-blue-700 dark:text-blue-200 space-y-1">
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
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-700">
                                        <!-- Movie Header -->
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <h4 class="font-bold text-lg text-gray-900 dark:text-white">{{ $payment->order->showtime?->movie?->title ?? 'Tiket' }}</h4>
                                                <div class="flex items-center space-x-2 mt-1">
                                                    @if($payment->order->showtime?->movie)
                                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded">{{ $payment->order->showtime->movie->rating }}</span>
                                                        <span class="text-sm text-gray-600 dark:text-gray-300">{{ $payment->order->showtime->movie->duration }} menit</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm text-gray-600 dark:text-gray-300">1 Tiket</div>
                                                <div class="font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                            </div>
                                        </div>

                                        <!-- Cinema & Schedule Info -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <div class="text-gray-600 dark:text-gray-300 mb-1">Bioskop:</div>
                                                <div class="font-medium">{{ $payment->order->showtime?->cinemaHall?->cinema?->name ?? '-' }}</div>
                                                <div class="text-gray-600 dark:text-gray-300">{{ $payment->order->showtime?->cinemaHall?->name ?? '-' }}</div>
                                            </div>
                                            <div>
                                                <div class="text-gray-600 dark:text-gray-300 mb-1">Jadwal:</div>
                                                @if($payment->order->showtime)
                                                    <div class="font-medium">{{ $payment->order->showtime->getFormattedDate() }}</div>
                                                    <div class="text-gray-600 dark:text-gray-300">{{ $payment->order->showtime->getFormattedTime() }} WIB</div>
                                                @else
                                                    <div class="font-medium">-</div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Seat Information (jika ada) -->
                                        @if(method_exists($item, 'seatReservations') && $item->seatReservations->count() > 0)
                                            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                                <div class="text-gray-600 dark:text-gray-300 text-sm mb-1">Kursi:</div>
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
                        <a href="{{ route('profile.tickets') }}" 
                           class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg text-center transition-colors duration-200">
                            Lihat E-tiket
                        </a>
                        <a href="{{ route('home') }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-center transition-colors duration-200">
                            Kembali ke Beranda
                        </a>
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
</div>
@endsection
