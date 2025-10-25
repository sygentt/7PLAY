@extends('layouts.public')

@section('title', 'Tentang Kami - ' . config('app.name', '7PLAY'))

@section('description', 'Kenali lebih dekat 7PLAY, platform pemesanan tiket bioskop online terpercaya di Indonesia.')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-cinema-900 via-cinema-800 to-gray-900 text-white py-20 lg:py-32 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.02\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- Logo -->
            <div class="flex items-center justify-center space-x-4 mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-cinema-400 to-cinema-600 rounded-2xl flex items-center justify-center shadow-2xl transform rotate-3">
                    <span class="text-white font-bold text-4xl">7</span>
                </div>
                <span class="text-6xl font-bold bg-gradient-to-r from-white to-cinema-100 bg-clip-text text-transparent">
                    PLAY
                </span>
            </div>

            <h1 class="text-4xl lg:text-5xl font-bold mb-6">
                Tentang Kami
            </h1>
            <p class="text-xl text-cinema-100 max-w-3xl mx-auto leading-relaxed">
                Platform pemesanan tiket bioskop online terpercaya yang menghadirkan pengalaman menonton film yang mudah, cepat, dan menyenangkan.
            </p>
        </div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white dark:from-gray-900 to-transparent"></div>
</section>

<!-- Our Story Section -->
<section class="py-16 lg:py-24 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Content -->
            <div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    Cerita Kami
                </h2>
                <div class="prose prose-lg dark:prose-invert max-w-none">
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        <strong class="text-cinema-600 dark:text-cinema-400">7PLAY</strong> lahir dari kecintaan kami terhadap dunia perfilman dan keinginan untuk memberikan pengalaman menonton yang lebih baik bagi seluruh masyarakat Indonesia.
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Kami memahami bahwa menonton film di bioskop bukan sekadar hiburan, tetapi juga pengalaman yang menciptakan kenangan berharga bersama orang-orang terkasih. Oleh karena itu, kami berkomitmen untuk menyediakan platform yang memudahkan Anda dalam menemukan film favorit, memilih jadwal yang sesuai, dan memesan tiket dengan mudah.
                    </p>
                    <p class="text-gray-600 dark:text-gray-300">
                        Dengan teknologi terkini dan tim yang berdedikasi, kami terus berinovasi untuk memberikan layanan terbaik kepada jutaan pencinta film di seluruh Indonesia.
                    </p>
                </div>
            </div>

            <!-- Image -->
            <div class="order-first lg:order-last">
                <div class="relative">
                    <div class="aspect-square rounded-2xl overflow-hidden shadow-2xl">
                        <img 
                            src="https://dummyimage.com/600x600/1e3a8a/ffffff.png&text=Cinema+Experience" 
                            alt="Cinema Experience" 
                            class="w-full h-full object-cover"
                        >
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-cinema-600 rounded-2xl flex items-center justify-center shadow-xl">
                        <div class="text-center text-white">
                            <div class="text-3xl font-bold">7+</div>
                            <div class="text-sm">Tahun</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Values Section -->
<section class="py-16 lg:py-24 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Nilai-Nilai Kami
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                Prinsip yang menjadi fondasi dalam setiap layanan yang kami berikan
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Value 1 -->
            <div class="bg-white dark:bg-gray-900 rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-xl flex items-center justify-center mb-6">
                    <x-heroicon-o-heart class="w-8 h-8 text-white" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                    Customer First
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Kepuasan pelanggan adalah prioritas utama kami dalam setiap keputusan dan layanan.
                </p>
            </div>

            <!-- Value 2 -->
            <div class="bg-white dark:bg-gray-900 rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mb-6">
                    <x-heroicon-o-shield-check class="w-8 h-8 text-white" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                    Terpercaya
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Keamanan data dan transaksi Anda dijamin dengan sistem enkripsi terbaik.
                </p>
            </div>

            <!-- Value 3 -->
            <div class="bg-white dark:bg-gray-900 rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-xl flex items-center justify-center mb-6">
                    <x-heroicon-o-bolt class="w-8 h-8 text-white" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                    Inovasi
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Terus berinovasi untuk memberikan pengalaman pemesanan tiket yang lebih baik.
                </p>
            </div>

            <!-- Value 4 -->
            <div class="bg-white dark:bg-gray-900 rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl flex items-center justify-center mb-6">
                    <x-heroicon-o-sparkles class="w-8 h-8 text-white" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                    Kualitas
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Berkomitmen memberikan layanan berkualitas tinggi di setiap aspek.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 lg:py-24 bg-gradient-to-br from-cinema-900 via-cinema-800 to-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold mb-4">
                7PLAY dalam Angka
            </h2>
            <p class="text-xl text-cinema-100">
                Kepercayaan yang kami bangun bersama Anda
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Stat 1 -->
            <div class="text-center">
                <div class="text-5xl lg:text-6xl font-bold mb-2 bg-gradient-to-r from-cinema-400 to-cinema-300 bg-clip-text text-transparent">
                    1M+
                </div>
                <div class="text-cinema-100 text-lg">
                    Pengguna Aktif
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="text-center">
                <div class="text-5xl lg:text-6xl font-bold mb-2 bg-gradient-to-r from-cinema-400 to-cinema-300 bg-clip-text text-transparent">
                    100+
                </div>
                <div class="text-cinema-100 text-lg">
                    Bioskop Partner
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="text-center">
                <div class="text-5xl lg:text-6xl font-bold mb-2 bg-gradient-to-r from-cinema-400 to-cinema-300 bg-clip-text text-transparent">
                    50+
                </div>
                <div class="text-cinema-100 text-lg">
                    Kota di Indonesia
                </div>
            </div>

            <!-- Stat 4 -->
            <div class="text-center">
                <div class="text-5xl lg:text-6xl font-bold mb-2 bg-gradient-to-r from-cinema-400 to-cinema-300 bg-clip-text text-transparent">
                    5M+
                </div>
                <div class="text-cinema-100 text-lg">
                    Tiket Terjual
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA Section -->
<section class="py-16 lg:py-24 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">
            Ada Pertanyaan?
        </h2>
        <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
            Tim kami siap membantu Anda. Jangan ragu untuk menghubungi kami.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#" class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-gradient-to-r from-cinema-600 to-cinema-700 hover:from-cinema-700 hover:to-cinema-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <x-heroicon-o-phone class="w-5 h-5" />
                <span>Hubungi Kami</span>
            </a>
            <a href="#" class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-white dark:bg-gray-800 border-2 border-cinema-600 text-cinema-600 dark:text-cinema-400 font-semibold rounded-xl hover:bg-cinema-50 dark:hover:bg-gray-700 transition-all duration-200">
                <x-heroicon-o-question-mark-circle class="w-5 h-5" />
                <span>FAQ</span>
            </a>
        </div>
    </div>
</section>

@endsection

