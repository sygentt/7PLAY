@extends('layouts.public')

@section('title', 'FAQ - Pertanyaan yang Sering Diajukan - ' . config('app.name', '7PLAY'))

@section('description', 'Temukan jawaban untuk pertanyaan yang sering diajukan seputar pemesanan tiket bioskop di 7PLAY.')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-cinema-900 via-cinema-800 to-gray-900 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.02\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-2xl mb-6 shadow-2xl">
            <x-heroicon-o-question-mark-circle class="w-10 h-10 text-white" />
        </div>
        <h1 class="text-4xl lg:text-5xl font-bold mb-6">
            Pertanyaan yang Sering Diajukan
        </h1>
        <p class="text-xl text-cinema-100">
            Temukan jawaban untuk pertanyaan Anda seputar layanan 7PLAY
        </p>
    </div>
</section>

<!-- FAQ Content -->
<section class="py-16 lg:py-24 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Pemesanan Tiket -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                <x-heroicon-o-ticket class="w-6 h-6 mr-3 text-cinema-600" />
                Pemesanan Tiket
            </h2>
            <div class="space-y-4">
                <!-- FAQ Item -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Bagaimana cara memesan tiket di 7PLAY?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Anda dapat memesan tiket dengan cara: (1) Login atau daftar akun, (2) Pilih film yang ingin ditonton, (3) Pilih bioskop, tanggal, dan jam tayang, (4) Pilih kursi, (5) Lakukan pembayaran, (6) E-ticket akan dikirim ke email Anda.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Apakah saya harus mendaftar untuk memesan tiket?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Ya, Anda perlu membuat akun terlebih dahulu. Ini untuk memastikan keamanan transaksi Anda dan memudahkan Anda mengakses riwayat pemesanan.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Berapa lama waktu yang diberikan untuk menyelesaikan pembayaran?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Anda memiliki waktu 15 menit untuk menyelesaikan pembayaran setelah memilih kursi. Jika waktu habis, kursi akan dirilis kembali untuk pengguna lain.
                    </p>
                </div>
            </div>
        </div>

        <!-- Pembayaran -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                <x-heroicon-o-credit-card class="w-6 h-6 mr-3 text-cinema-600" />
                Pembayaran
            </h2>
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Metode pembayaran apa saja yang tersedia?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Kami menerima berbagai metode pembayaran melalui Midtrans: Transfer Bank, Virtual Account (BCA, Mandiri, BNI, BRI), Kartu Kredit/Debit, E-Wallet (GoPay, OVO, DANA, ShopeePay), dan QRIS.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Apakah pembayaran di 7PLAY aman?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Sangat aman. Kami menggunakan sistem pembayaran Midtrans yang sudah terverifikasi dan menggunakan enkripsi SSL untuk melindungi data transaksi Anda.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Bagaimana jika pembayaran saya gagal?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Jika pembayaran gagal, Anda dapat mencoba kembali dengan memilih kursi yang sama atau kursi lain. Dana Anda tidak akan terdebet jika pembayaran gagal.
                    </p>
                </div>
            </div>
        </div>

        <!-- E-Ticket -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                <x-heroicon-o-qr-code class="w-6 h-6 mr-3 text-cinema-600" />
                E-Ticket & QR Code
            </h2>
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Bagaimana cara mendapatkan e-ticket saya?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Setelah pembayaran berhasil, e-ticket akan otomatis dikirim ke email Anda. Anda juga dapat mengaksesnya melalui menu "Tiket Saya" di profil akun.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Apakah saya harus mencetak e-ticket?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Tidak perlu. Anda cukup menunjukkan QR code pada e-ticket di smartphone Anda kepada petugas bioskop untuk di-scan.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Bagaimana jika QR code tidak bisa di-scan?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Pastikan layar smartphone Anda cukup terang dan tidak ada retak. Jika masih bermasalah, tunjukkan booking ID Anda kepada petugas bioskop.
                    </p>
                </div>
            </div>
        </div>

        <!-- Pembatalan & Refund -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                <x-heroicon-o-arrow-uturn-left class="w-6 h-6 mr-3 text-cinema-600" />
                Pembatalan & Refund
            </h2>
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Apakah tiket yang sudah dibeli bisa dibatalkan?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Saat ini, tiket yang sudah dibeli tidak dapat dibatalkan atau di-refund sesuai dengan kebijakan bioskop partner kami.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Bagaimana jika jadwal film dibatalkan oleh bioskop?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Jika jadwal film dibatalkan oleh pihak bioskop, kami akan mengirimkan notifikasi dan melakukan refund penuh ke metode pembayaran Anda dalam 7-14 hari kerja.
                    </p>
                </div>
            </div>
        </div>

        <!-- Program Loyalitas -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center">
                <x-heroicon-o-star class="w-6 h-6 mr-3 text-cinema-600" />
                Program Loyalitas & Voucher
            </h2>
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Bagaimana cara mendapatkan poin?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Anda mendapatkan poin setiap kali melakukan pembelian tiket. 1 tiket = 100 poin. Poin dapat ditukar dengan voucher diskon.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Bagaimana cara menggunakan voucher?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Pada halaman checkout, klik "Gunakan Voucher" dan pilih voucher yang ingin digunakan. Diskon akan otomatis diterapkan ke total pembayaran.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        Apakah poin dan voucher bisa expired?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Poin tidak akan expired. Namun voucher memiliki masa berlaku yang tertera pada detail voucher.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
            Masih Ada Pertanyaan?
        </h2>
        <p class="text-gray-600 dark:text-gray-300 mb-8">
            Tim customer service kami siap membantu Anda
        </p>
        <a href="{{ route('static.contact') }}" class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-gradient-to-r from-cinema-600 to-cinema-700 hover:from-cinema-700 hover:to-cinema-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
            <x-heroicon-o-phone class="w-5 h-5" />
            <span>Hubungi Kami</span>
        </a>
    </div>
</section>

@endsection

