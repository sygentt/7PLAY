@extends('layouts.public')

@section('title', 'Cara Pesan Tiket - ' . config('app.name', '7PLAY'))

@section('description', 'Panduan lengkap cara memesan tiket bioskop di 7PLAY dengan mudah dan cepat.')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-cinema-900 via-cinema-800 to-gray-900 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.02\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-2xl mb-6 shadow-2xl">
            <x-heroicon-o-ticket class="w-10 h-10 text-white" />
        </div>
        <h1 class="text-4xl lg:text-5xl font-bold mb-6">
            Cara Pesan Tiket
        </h1>
        <p class="text-xl text-cinema-100">
            Ikuti langkah mudah berikut untuk memesan tiket bioskop Anda
        </p>
    </div>
</section>

<!-- Steps Section -->
<section class="py-16 lg:py-24 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Step 1 -->
        <div class="relative pl-8 pb-16 border-l-4 border-cinema-600">
            <div class="absolute -left-6 top-0 w-12 h-12 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                1
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <x-heroicon-o-user-circle class="w-7 h-7 mr-3 text-cinema-600" />
                    Daftar atau Login
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Jika Anda belum memiliki akun, daftar terlebih dahulu dengan mengisi email dan password. Jika sudah punya akun, langsung login.
                </p>
                <div class="bg-cinema-50 dark:bg-cinema-900/20 border-l-4 border-cinema-600 p-4 rounded-r-lg">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Tips:</strong> Gunakan email aktif untuk menerima e-ticket dan notifikasi pemesanan.
                    </p>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="relative pl-8 pb-16 border-l-4 border-cinema-600">
            <div class="absolute -left-6 top-0 w-12 h-12 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                2
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <x-heroicon-o-film class="w-7 h-7 mr-3 text-cinema-600" />
                    Pilih Film
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Jelajahi daftar film yang sedang tayang atau akan datang. Klik pada film yang ingin Anda tonton untuk melihat detail lengkap.
                </p>
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div class="flex items-start space-x-3">
                        <x-heroicon-o-check-circle class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-600 dark:text-gray-300">Lihat sinopsis film</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <x-heroicon-o-check-circle class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-600 dark:text-gray-300">Tonton trailer</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <x-heroicon-o-check-circle class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-600 dark:text-gray-300">Cek rating & durasi</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <x-heroicon-o-check-circle class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-600 dark:text-gray-300">Simpan ke favorit</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="relative pl-8 pb-16 border-l-4 border-cinema-600">
            <div class="absolute -left-6 top-0 w-12 h-12 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                3
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <x-heroicon-o-calendar-days class="w-7 h-7 mr-3 text-cinema-600" />
                    Pilih Jadwal & Bioskop
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Pilih bioskop terdekat, tanggal, dan jam tayang yang sesuai dengan jadwal Anda.
                </p>
                <div class="bg-cinema-50 dark:bg-cinema-900/20 border-l-4 border-cinema-600 p-4 rounded-r-lg">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Tips:</strong> Periksa ketersediaan kursi sebelum memilih jadwal. Jadwal weekend biasanya lebih ramai.
                    </p>
                </div>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="relative pl-8 pb-16 border-l-4 border-cinema-600">
            <div class="absolute -left-6 top-0 w-12 h-12 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                4
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <x-heroicon-o-squares-2x2 class="w-7 h-7 mr-3 text-cinema-600" />
                    Pilih Kursi
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Pilih kursi favorit Anda dari layout kursi yang tersedia. Kursi yang berwarna hijau masih tersedia, sedangkan yang merah sudah terisi.
                </p>
                <div class="space-y-2 mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-500 rounded flex-shrink-0"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Tersedia</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-500 rounded flex-shrink-0"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Anda Pilih</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-red-500 rounded flex-shrink-0"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Sudah Terisi</span>
                    </div>
                </div>
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-600 p-4 rounded-r-lg">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Penting:</strong> Kursi akan direservasi selama 15 menit. Selesaikan pembayaran sebelum waktu habis.
                    </p>
                </div>
            </div>
        </div>

        <!-- Step 5 -->
        <div class="relative pl-8 pb-16 border-l-4 border-cinema-600">
            <div class="absolute -left-6 top-0 w-12 h-12 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                5
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <x-heroicon-o-credit-card class="w-7 h-7 mr-3 text-cinema-600" />
                    Lakukan Pembayaran
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Pilih metode pembayaran yang Anda inginkan dan selesaikan transaksi. Kami menerima berbagai metode pembayaran.
                </p>
                <div class="grid md:grid-cols-3 gap-3 mb-4">
                    <div class="bg-white dark:bg-gray-700 p-3 rounded-lg text-center border border-gray-200 dark:border-gray-600">
                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Transfer Bank</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-3 rounded-lg text-center border border-gray-200 dark:border-gray-600">
                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Virtual Account</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-3 rounded-lg text-center border border-gray-200 dark:border-gray-600">
                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">E-Wallet</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-3 rounded-lg text-center border border-gray-200 dark:border-gray-600">
                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Kartu Kredit</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-3 rounded-lg text-center border border-gray-200 dark:border-gray-600">
                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">QRIS</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-3 rounded-lg text-center border border-gray-200 dark:border-gray-600">
                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Voucher</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 6 -->
        <div class="relative pl-8">
            <div class="absolute -left-6 top-0 w-12 h-12 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                6
            </div>
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-8 shadow-lg border-2 border-green-200 dark:border-green-800">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <x-heroicon-o-qr-code class="w-7 h-7 mr-3 text-green-600" />
                    Dapatkan E-Ticket
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Setelah pembayaran berhasil, e-ticket akan otomatis dikirim ke email Anda. E-ticket juga dapat diakses melalui menu "Tiket Saya" di akun Anda.
                </p>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg mb-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">
                        <strong>E-ticket berisi:</strong>
                    </p>
                    <ul class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                        <li>• QR Code untuk masuk bioskop</li>
                        <li>• Detail film, jadwal, dan kursi</li>
                        <li>• Booking ID</li>
                        <li>• Informasi bioskop</li>
                    </ul>
                </div>
                <div class="bg-green-100 dark:bg-green-900/40 border-l-4 border-green-600 p-4 rounded-r-lg">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Selesai!</strong> Tunjukkan QR code pada e-ticket Anda ke petugas bioskop untuk masuk.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Tips Section -->
<section class="py-16 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 text-center">
            Tips Pemesanan
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-cinema-100 dark:bg-cinema-900/40 rounded-lg flex items-center justify-center">
                            <x-heroicon-o-clock class="w-6 h-6 text-cinema-600" />
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Pesan Lebih Awal</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Pesan tiket H-3 atau H-2 untuk mendapatkan kursi terbaik, terutama untuk film populer.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-cinema-100 dark:bg-cinema-900/40 rounded-lg flex items-center justify-center">
                            <x-heroicon-o-device-phone-mobile class="w-6 h-6 text-cinema-600" />
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Simpan Screenshot</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Screenshot e-ticket Anda sebagai backup jika terjadi masalah koneksi internet.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-cinema-100 dark:bg-cinema-900/40 rounded-lg flex items-center justify-center">
                            <x-heroicon-o-star class="w-6 h-6 text-cinema-600" />
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Manfaatkan Poin</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Kumpulkan poin dari setiap pembelian dan tukarkan dengan voucher diskon.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-cinema-100 dark:bg-cinema-900/40 rounded-lg flex items-center justify-center">
                            <x-heroicon-o-bell class="w-6 h-6 text-cinema-600" />
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Aktifkan Notifikasi</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Dapatkan info film terbaru, promo, dan pengingat jadwal nonton Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
            Siap Memesan Tiket?
        </h2>
        <p class="text-gray-600 dark:text-gray-300 mb-8">
            Mulai perjalanan menonton film Anda sekarang juga!
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-gradient-to-r from-cinema-600 to-cinema-700 hover:from-cinema-700 hover:to-cinema-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <x-heroicon-o-ticket class="w-5 h-5" />
                <span>Pesan Tiket Sekarang</span>
            </a>
            <a href="{{ route('static.faq') }}" class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-white dark:bg-gray-800 border-2 border-cinema-600 text-cinema-600 dark:text-cinema-400 font-semibold rounded-xl hover:bg-cinema-50 dark:hover:bg-gray-700 transition-all duration-200">
                <x-heroicon-o-question-mark-circle class="w-5 h-5" />
                <span>Lihat FAQ</span>
            </a>
        </div>
    </div>
</section>

@endsection

