@extends('layouts.public')

@section('title', 'Kebijakan Privasi - ' . config('app.name', '7PLAY'))

@section('description', 'Kebijakan privasi 7PLAY mengenai pengumpulan, penggunaan, dan perlindungan data pribadi Anda.')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-cinema-900 via-cinema-800 to-gray-900 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.02\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-2xl mb-6 shadow-2xl">
            <x-heroicon-o-shield-check class="w-10 h-10 text-white" />
        </div>
        <h1 class="text-4xl lg:text-5xl font-bold mb-6">
            Kebijakan Privasi
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
                    7PLAY ("kami", "kami", atau "milik kami") berkomitmen untuk melindungi privasi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat Anda menggunakan platform kami.
                </p>
            </div>

            <!-- Section 1 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">1</span>
                    Informasi yang Kami Kumpulkan
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Kami mengumpulkan beberapa jenis informasi dari pengguna kami:</p>
                    
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">1.1 Informasi yang Anda Berikan</h3>
                    <ul class="space-y-2">
                        <li>• Nama lengkap</li>
                        <li>• Alamat email</li>
                        <li>• Nomor telepon</li>
                        <li>• Password (terenkripsi)</li>
                        <li>• Informasi pembayaran (diproses melalui Midtrans)</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">1.2 Informasi yang Dikumpulkan Secara Otomatis</h3>
                    <ul class="space-y-2">
                        <li>• Alamat IP</li>
                        <li>• Jenis browser dan perangkat</li>
                        <li>• Halaman yang Anda kunjungi</li>
                        <li>• Waktu dan tanggal kunjungan</li>
                        <li>• Cookies dan teknologi pelacakan serupa</li>
                    </ul>
                </div>
            </div>

            <!-- Section 2 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">2</span>
                    Bagaimana Kami Menggunakan Informasi Anda
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Kami menggunakan informasi yang dikumpulkan untuk:</p>
                    <ul class="space-y-2">
                        <li>• Memproses pemesanan dan pembayaran tiket</li>
                        <li>• Mengirimkan e-ticket dan konfirmasi pemesanan</li>
                        <li>• Mengelola akun Anda</li>
                        <li>• Memberikan layanan pelanggan</li>
                        <li>• Mengirimkan notifikasi penting terkait layanan</li>
                        <li>• Mengirimkan informasi promosi dan penawaran (jika Anda setuju)</li>
                        <li>• Meningkatkan layanan dan pengalaman pengguna</li>
                        <li>• Mencegah penipuan dan aktivitas ilegal</li>
                        <li>• Mematuhi kewajiban hukum</li>
                    </ul>
                </div>
            </div>

            <!-- Section 3 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">3</span>
                    Berbagi Informasi dengan Pihak Ketiga
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Kami hanya membagikan informasi Anda dalam situasi berikut:</p>
                    
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">3.1 Partner Bioskop</h3>
                    <p>Informasi pemesanan Anda (nama, detail tiket) dibagikan dengan bioskop partner untuk verifikasi masuk.</p>

                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">3.2 Payment Gateway</h3>
                    <p>Informasi pembayaran diproses melalui Midtrans, partner pembayaran terpercaya kami. Kami tidak menyimpan detail kartu kredit Anda.</p>

                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mt-6 mb-3">3.3 Kewajiban Hukum</h3>
                    <p>Jika diwajibkan oleh hukum atau untuk melindungi hak, properti, atau keamanan kami dan pengguna lain.</p>
                </div>
            </div>

            <!-- Section 4 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">4</span>
                    Keamanan Data
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Kami menerapkan langkah-langkah keamanan yang sesuai untuk melindungi data Anda:</p>
                    <ul class="space-y-2">
                        <li>• Enkripsi SSL/TLS untuk semua transmisi data</li>
                        <li>• Password terenkripsi menggunakan algoritma bcrypt</li>
                        <li>• Akses terbatas ke data pribadi</li>
                        <li>• Monitoring keamanan secara berkala</li>
                        <li>• Backup data rutin</li>
                    </ul>
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-600 p-4 rounded-r-lg mt-4">
                        <p class="text-sm">
                            <strong>Catatan:</strong> Meskipun kami berusaha melindungi informasi Anda, tidak ada metode transmisi melalui internet yang 100% aman.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Section 5 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">5</span>
                    Cookies dan Teknologi Pelacakan
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Kami menggunakan cookies dan teknologi serupa untuk:</p>
                    <ul class="space-y-2">
                        <li>• Menjaga sesi login Anda</li>
                        <li>• Mengingat preferensi Anda</li>
                        <li>• Menganalisis penggunaan website</li>
                        <li>• Meningkatkan fungsionalitas dan kinerja</li>
                    </ul>
                    <p class="mt-4">Anda dapat mengatur browser Anda untuk menolak cookies, namun beberapa fitur mungkin tidak berfungsi dengan baik.</p>
                </div>
            </div>

            <!-- Section 6 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">6</span>
                    Hak Anda
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Anda memiliki hak berikut terkait data pribadi Anda:</p>
                    <ul class="space-y-2">
                        <li>• <strong>Akses:</strong> Meminta salinan data pribadi Anda</li>
                        <li>• <strong>Koreksi:</strong> Memperbarui atau memperbaiki data yang tidak akurat</li>
                        <li>• <strong>Penghapusan:</strong> Meminta penghapusan akun dan data Anda</li>
                        <li>• <strong>Portabilitas:</strong> Mendapatkan data Anda dalam format yang dapat dibaca mesin</li>
                        <li>• <strong>Keberatan:</strong> Menolak pemrosesan data tertentu</li>
                    </ul>
                    <p class="mt-4">Untuk menggunakan hak-hak ini, hubungi kami di: <a href="mailto:privacy@7play.id" class="text-cinema-600 dark:text-cinema-400 hover:underline">privacy@7play.id</a></p>
                </div>
            </div>

            <!-- Section 7 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">7</span>
                    Penyimpanan Data
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Kami menyimpan data Anda selama:</p>
                    <ul class="space-y-2">
                        <li>• Akun aktif: Selama akun Anda masih aktif</li>
                        <li>• Data transaksi: 5 tahun untuk keperluan perpajakan dan hukum</li>
                        <li>• Data marketing: Sampai Anda mencabut persetujuan</li>
                    </ul>
                </div>
            </div>

            <!-- Section 8 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">8</span>
                    Privasi Anak-anak
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Layanan kami tidak ditujukan untuk anak-anak di bawah 13 tahun. Kami tidak dengan sengaja mengumpulkan informasi pribadi dari anak-anak. Jika Anda adalah orang tua dan mengetahui bahwa anak Anda telah memberikan informasi pribadi kepada kami, silakan hubungi kami.</p>
                </div>
            </div>

            <!-- Section 9 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">9</span>
                    Perubahan Kebijakan Privasi
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan akan diberitahukan melalui:</p>
                    <ul class="space-y-2">
                        <li>• Email ke alamat terdaftar Anda</li>
                        <li>• Notifikasi di website</li>
                        <li>• Tanggal "Terakhir diperbarui" di bagian atas halaman ini</li>
                    </ul>
                </div>
            </div>

            <!-- Section 10 -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 bg-cinema-600 text-white rounded-lg mr-3 text-base">10</span>
                    Hubungi Kami
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                    <p>Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi kami:</p>
                    <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-xl">
                        <div class="space-y-3">
                            <p><strong>Email:</strong> <a href="mailto:privacy@7play.id" class="text-cinema-600 dark:text-cinema-400 hover:underline">privacy@7play.id</a></p>
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
            Ada Pertanyaan?
        </h2>
        <p class="text-gray-600 dark:text-gray-300 mb-8">
            Kami siap membantu Anda memahami kebijakan privasi kami
        </p>
        <a href="{{ route('static.contact') }}" class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-gradient-to-r from-cinema-600 to-cinema-700 hover:from-cinema-700 hover:to-cinema-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
            <x-heroicon-o-phone class="w-5 h-5" />
            <span>Hubungi Kami</span>
        </a>
    </div>
</section>

@endsection

