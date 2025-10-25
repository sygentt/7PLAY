@extends('layouts.public')

@section('title', 'Hubungi Kami - ' . config('app.name', '7PLAY'))

@section('description', 'Hubungi tim customer service 7PLAY untuk bantuan, pertanyaan, atau masukan Anda.')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-cinema-900 via-cinema-800 to-gray-900 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.02\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-2xl mb-6 shadow-2xl">
            <x-heroicon-o-phone class="w-10 h-10 text-white" />
        </div>
        <h1 class="text-4xl lg:text-5xl font-bold mb-6">
            Hubungi Kami
        </h1>
        <p class="text-xl text-cinema-100">
            Tim kami siap membantu Anda. Jangan ragu untuk menghubungi kami
        </p>
    </div>
</section>

<!-- Contact Info -->
<section class="py-16 lg:py-24 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <!-- Email -->
            <div class="bg-gradient-to-br from-cinema-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-cinema-500 to-cinema-700 rounded-xl flex items-center justify-center mx-auto mb-6">
                    <x-heroicon-o-envelope class="w-8 h-8 text-white" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                    Email
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-2">
                    Kirim email ke:
                </p>
                <a href="mailto:support@7play.id" class="text-cinema-600 dark:text-cinema-400 font-semibold hover:underline">
                    support@7play.id
                </a>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                    Respon dalam 1x24 jam
                </p>
            </div>

            <!-- WhatsApp -->
            <div class="bg-gradient-to-br from-green-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-xl flex items-center justify-center mx-auto mb-6">
                    <x-heroicon-o-chat-bubble-left-right class="w-8 h-8 text-white" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                    WhatsApp
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-2">
                    Chat dengan kami:
                </p>
                <a href="https://wa.me/628123456789" target="_blank" class="text-green-600 dark:text-green-400 font-semibold hover:underline">
                    +62 812-3456-789
                </a>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                    Senin - Minggu, 09:00 - 21:00 WIB
                </p>
            </div>

            <!-- Phone -->
            <div class="bg-gradient-to-br from-blue-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mx-auto mb-6">
                    <x-heroicon-o-phone class="w-8 h-8 text-white" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                    Telepon
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-2">
                    Hubungi hotline:
                </p>
                <a href="tel:+622150001234" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                    (021) 5000-1234
                </a>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                    24/7 Customer Support
                </p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 lg:p-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2 text-center">
                    Kirim Pesan
                </h2>
                <p class="text-gray-600 dark:text-gray-300 mb-8 text-center">
                    Isi form di bawah ini dan kami akan segera menghubungi Anda
                </p>

                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Lengkap *
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-cinema-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                            placeholder="John Doe"
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email *
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-cinema-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                            placeholder="john@example.com"
                        >
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nomor Telepon
                        </label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-cinema-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                            placeholder="+62 812-3456-7890"
                        >
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Subjek *
                        </label>
                        <select 
                            id="subject" 
                            name="subject" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-cinema-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                        >
                            <option value="">Pilih subjek</option>
                            <option value="booking">Masalah Pemesanan</option>
                            <option value="payment">Masalah Pembayaran</option>
                            <option value="refund">Refund & Pembatalan</option>
                            <option value="technical">Masalah Teknis</option>
                            <option value="feedback">Saran & Masukan</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pesan *
                        </label>
                        <textarea 
                            id="message" 
                            name="message" 
                            rows="6" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-cinema-500 focus:border-transparent dark:bg-gray-700 dark:text-white resize-none"
                            placeholder="Tuliskan pesan Anda di sini..."
                        ></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button 
                            type="submit"
                            class="w-full px-8 py-4 bg-gradient-to-r from-cinema-600 to-cinema-700 hover:from-cinema-700 hover:to-cinema-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]"
                        >
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Office Location (Optional) -->
<section class="py-16 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                Kantor Kami
            </h2>
            <p class="text-gray-600 dark:text-gray-300">
                Kunjungi kantor kami untuk bantuan langsung
            </p>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl overflow-hidden">
            <div class="grid lg:grid-cols-2">
                <!-- Map Placeholder -->
                <div class="h-96 lg:h-auto bg-gray-200 dark:bg-gray-800">
                    <img 
                        src="https://dummyimage.com/800x600/e5e7eb/374151.png&text=Map+Location" 
                        alt="Office Location" 
                        class="w-full h-full object-cover"
                    >
                </div>

                <!-- Address Info -->
                <div class="p-8 lg:p-12">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                        7PLAY Headquarters
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <x-heroicon-o-map-pin class="w-6 h-6 text-cinema-600 flex-shrink-0 mt-1" />
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">Alamat</p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Jl. Sudirman No. 123<br>
                                    Jakarta Pusat 10110<br>
                                    Indonesia
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <x-heroicon-o-clock class="w-6 h-6 text-cinema-600 flex-shrink-0 mt-1" />
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">Jam Operasional</p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Senin - Jumat: 09:00 - 18:00 WIB<br>
                                    Sabtu: 09:00 - 15:00 WIB<br>
                                    Minggu & Libur: Tutup
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

