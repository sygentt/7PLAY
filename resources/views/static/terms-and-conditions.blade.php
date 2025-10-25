@extends('layouts.public')

@section('title', 'Syarat & Ketentuan - ' . config('app.name', '7PLAY'))

@section('description', 'Syarat dan ketentuan penggunaan layanan 7PLAY yang harus Anda pahami dan setujui.')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-cinema-900 via-cinema-800 to-gray-900 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.02\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-2xl mb-6 shadow-2xl">
            <x-heroicon-o-document-text class="w-10 h-10 text-white" />
        </div>
        <h1 class="text-4xl lg:text-5xl font-bold mb-6">
            Syarat & Ketentuan
        </h1>
        <p class="text-xl text-cinema-100">
            Terakhir diperbarui: {{ date('d F Y') }}
        </p>
    </div>
</section>

<!-- Content Section -->
<section class="py-16 lg:py-24 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <!-- Introduction -->
            <div class="bg-cinema-50 dark:bg-cinema-900/20 border-l-4 border-cinema-600 p-6 rounded-r-xl mb-8">
                <p class="text-gray-700 dark:text-gray-300 mb-0">
                    Selamat datang di 7PLAY. Dengan mengakses dan menggunakan layanan kami, Anda setuju untuk terikat dengan Syarat dan Ketentuan berikut. Harap baca dengan saksama sebelum menggunakan layanan kami.
                </p>
            </div>

            <!-- Section 1 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">1</span>
                    Penerimaan Syarat
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Dengan menggunakan platform 7PLAY, Anda menyatakan bahwa:</p>
                    <ul class="space-y-2">
                        <li>• Anda berusia minimal 13 tahun atau mendapat izin dari orang tua/wali</li>
                        <li>• Anda memiliki kapasitas hukum untuk menyetujui syarat ini</li>
                        <li>• Informasi yang Anda berikan adalah benar dan akurat</li>
                        <li>• Anda akan mematuhi semua hukum dan peraturan yang berlaku</li>
                    </ul>
                </div>
            </div>

            <!-- Section 2 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">2</span>
                    Layanan
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>7PLAY menyediakan platform pemesanan tiket bioskop online yang memungkinkan Anda untuk:</p>
                    <ul class="space-y-2">
                        <li>• Menjelajahi informasi film</li>
                        <li>• Memesan tiket bioskop secara online</li>
                        <li>• Memilih kursi dan jadwal tayang</li>
                        <li>• Melakukan pembayaran secara aman</li>
                        <li>• Menerima e-ticket digital</li>
                        <li>• Mengelola riwayat pemesanan</li>
                        <li>• Mengumpulkan dan menukar poin loyalitas</li>
                    </ul>
                </div>
            </div>

            <!-- Section 3 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">3</span>
                    Pendaftaran dan Akun
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">3.1 Pembuatan Akun</h3>
                    <ul class="space-y-2">
                        <li>• Anda harus membuat akun untuk memesan tiket</li>
                        <li>• Informasi akun harus akurat dan terkini</li>
                        <li>• Anda bertanggung jawab menjaga kerahasiaan password</li>
                        <li>• Anda bertanggung jawab atas semua aktivitas yang terjadi di akun Anda</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">3.2 Keamanan Akun</h3>
                    <ul class="space-y-2">
                        <li>• Jangan berbagi password dengan siapa pun</li>
                        <li>• Segera laporkan penggunaan akun yang tidak sah</li>
                        <li>• Kami tidak bertanggung jawab atas kerugian akibat kelalaian Anda</li>
                    </ul>
                </div>
            </div>

            <!-- Section 4 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">4</span>
                    Pemesanan dan Pembayaran
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">4.1 Proses Pemesanan</h3>
                    <ul class="space-y-2">
                        <li>• Harga tiket dapat berubah sewaktu-waktu tanpa pemberitahuan</li>
                        <li>• Ketersediaan kursi bersifat real-time</li>
                        <li>• Reservasi kursi berlaku 15 menit sejak dipilih</li>
                        <li>• Pemesanan final setelah pembayaran berhasil</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">4.2 Pembayaran</h3>
                    <ul class="space-y-2">
                        <li>• Pembayaran diproses melalui Midtrans</li>
                        <li>• Anda harus menyelesaikan pembayaran dalam waktu yang ditentukan</li>
                        <li>• Kami menerima berbagai metode pembayaran</li>
                        <li>• Biaya administrasi dapat dikenakan sesuai metode pembayaran</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">4.3 E-Ticket</h3>
                    <ul class="space-y-2">
                        <li>• E-ticket dikirim via email setelah pembayaran berhasil</li>
                        <li>• Anda bertanggung jawab untuk menunjukkan e-ticket yang valid</li>
                        <li>• Satu e-ticket hanya berlaku untuk satu kali scan</li>
                        <li>• E-ticket tidak dapat ditransfer ke orang lain</li>
                    </ul>
                </div>
            </div>

            <!-- Section 5 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">5</span>
                    Pembatalan dan Refund
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-600 p-4 rounded-r-lg">
                        <p class="text-sm font-semibold">
                            PENTING: Tiket yang sudah dibeli tidak dapat dibatalkan atau di-refund
                        </p>
                    </div>
                    <p>Pengecualian:</p>
                    <ul class="space-y-2">
                        <li>• Pembatalan jadwal film oleh pihak bioskop</li>
                        <li>• Masalah teknis pada sistem kami yang mengakibatkan kesalahan pemesanan</li>
                        <li>• Kesalahan pengenaan biaya ganda</li>
                    </ul>
                    <p class="mt-4">Dalam kasus pengecualian, refund akan diproses dalam 7-14 hari kerja.</p>
                </div>
            </div>

            <!-- Section 6 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">6</span>
                    Program Loyalitas
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <ul class="space-y-2">
                        <li>• Poin diberikan untuk setiap pembelian tiket yang berhasil</li>
                        <li>• Poin dapat ditukar dengan voucher diskon</li>
                        <li>• Poin tidak memiliki nilai tunai</li>
                        <li>• Poin tidak dapat ditransfer ke akun lain</li>
                        <li>• Kami berhak mengubah syarat program loyalitas</li>
                        <li>• Poin tidak akan expired</li>
                        <li>• Voucher memiliki masa berlaku tertentu</li>
                    </ul>
                </div>
            </div>

            <!-- Section 7 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">7</span>
                    Larangan Penggunaan
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Anda dilarang untuk:</p>
                    <ul class="space-y-2">
                        <li>• Menggunakan layanan untuk tujuan ilegal</li>
                        <li>• Membuat akun palsu atau menggunakan identitas orang lain</li>
                        <li>• Melakukan penipuan atau manipulasi sistem</li>
                        <li>• Menggunakan bot atau script otomatis</li>
                        <li>• Menjual kembali tiket dengan harga lebih tinggi (scalping)</li>
                        <li>• Mengganggu atau merusak sistem kami</li>
                        <li>• Mengakses akun orang lain tanpa izin</li>
                        <li>• Menyalahgunakan program loyalitas atau voucher</li>
                    </ul>
                </div>
            </div>

            <!-- Section 8 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">8</span>
                    Hak Kekayaan Intelektual
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Semua konten di platform 7PLAY, termasuk namun tidak terbatas pada:</p>
                    <ul class="space-y-2">
                        <li>• Logo, merek dagang, dan desain</li>
                        <li>• Teks, gambar, dan grafis</li>
                        <li>• Kode sumber dan teknologi</li>
                        <li>• Layout dan tampilan website</li>
                    </ul>
                    <p class="mt-4">Dilindungi oleh hak cipta dan tidak boleh digunakan tanpa izin tertulis dari kami.</p>
                </div>
            </div>

            <!-- Section 9 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">9</span>
                    Batasan Tanggung Jawab
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>7PLAY tidak bertanggung jawab atas:</p>
                    <ul class="space-y-2">
                        <li>• Kualitas film atau layanan bioskop partner</li>
                        <li>• Perubahan jadwal film oleh pihak bioskop</li>
                        <li>• Kehilangan atau kerusakan perangkat Anda</li>
                        <li>• Kerugian tidak langsung atau insidental</li>
                        <li>• Gangguan internet atau masalah teknis di luar kontrol kami</li>
                        <li>• Kesalahan informasi yang disediakan oleh pihak ketiga</li>
                    </ul>
                </div>
            </div>

            <!-- Section 10 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">10</span>
                    Penangguhan dan Penghentian Akun
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Kami berhak menangguhkan atau menghentikan akun Anda jika:</p>
                    <ul class="space-y-2">
                        <li>• Anda melanggar Syarat dan Ketentuan ini</li>
                        <li>• Kami mencurigai aktivitas penipuan</li>
                        <li>• Anda tidak aktif dalam waktu yang lama</li>
                        <li>• Atas permintaan Anda sendiri</li>
                        <li>• Diwajibkan oleh hukum</li>
                    </ul>
                </div>
            </div>

            <!-- Section 11 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">11</span>
                    Perubahan Syarat dan Ketentuan
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Kami dapat mengubah Syarat dan Ketentuan ini sewaktu-waktu. Perubahan akan:</p>
                    <ul class="space-y-2">
                        <li>• Diberitahukan melalui email atau notifikasi di website</li>
                        <li>• Berlaku efektif setelah 7 hari sejak pemberitahuan</li>
                        <li>• Ditandai dengan tanggal "Terakhir diperbarui"</li>
                    </ul>
                    <p class="mt-4">Penggunaan layanan setelah perubahan berarti Anda menyetujui syarat yang baru.</p>
                </div>
            </div>

            <!-- Section 12 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">12</span>
                    Hukum yang Berlaku
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Syarat dan Ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum Republik Indonesia. Setiap perselisihan akan diselesaikan melalui:</p>
                    <ul class="space-y-2">
                        <li>• Musyawarah terlebih dahulu</li>
                        <li>• Mediasi jika diperlukan</li>
                        <li>• Pengadilan Jakarta Pusat sebagai pilihan terakhir</li>
                    </ul>
                </div>
            </div>

            <!-- Section 13 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">13</span>
                    Kontak
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Untuk pertanyaan tentang Syarat dan Ketentuan ini, hubungi kami:</p>
                    <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl">
                        <div class="space-y-3">
                            <p><strong>Email:</strong> <a href="mailto:legal@7play.id" class="text-cinema-600 dark:text-cinema-400 hover:underline">legal@7play.id</a></p>
                            <p><strong>Telepon:</strong> <a href="tel:+622150001234" class="text-cinema-600 dark:text-cinema-400 hover:underline">(021) 5000-1234</a></p>
                            <p><strong>Alamat:</strong> Jl. Sudirman No. 123, Jakarta Pusat 10110, Indonesia</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
            Dengan menggunakan 7PLAY, Anda setuju dengan Syarat & Ketentuan ini
        </h2>
        <p class="text-gray-600 dark:text-gray-300 mb-8">
            Jika Anda tidak setuju, harap tidak menggunakan layanan kami
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-gradient-to-r from-cinema-600 to-cinema-700 hover:from-cinema-700 hover:to-cinema-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <x-heroicon-o-check-circle class="w-5 h-5" />
                <span>Saya Setuju & Lanjutkan</span>
            </a>
            <a href="{{ route('static.contact') }}" class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-white dark:bg-gray-800 border-2 border-cinema-600 text-cinema-600 dark:text-cinema-400 font-semibold rounded-xl hover:bg-cinema-50 dark:hover:bg-gray-700 transition-all duration-200">
                <x-heroicon-o-phone class="w-5 h-5" />
                <span>Hubungi Kami</span>
            </a>
        </div>
    </div>
</section>

@endsection

