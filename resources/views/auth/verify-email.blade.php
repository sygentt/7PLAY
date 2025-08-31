<x-guest-layout>
    <x-slot name="title">Verifikasi Email</x-slot>

    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            Verifikasi Email Anda
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            Satu langkah lagi untuk bergabung dengan 7PLAY
        </p>
    </div>

    <!-- Description -->
    <div class="mb-6 p-4 bg-cinema-50/50 dark:bg-cinema-900/20 rounded-lg border border-cinema-200/50 dark:border-cinema-700/50">
        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
            Terima kasih telah mendaftar di <strong>7PLAY</strong>! Kami telah mengirimkan link verifikasi ke email Anda. 
            Silakan cek inbox atau spam untuk mengaktifkan akun Anda. Jika belum menerima email, klik tombol di bawah untuk mengirim ulang.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50/50 dark:bg-green-900/20 rounded-lg border border-green-200/50 dark:border-green-700/50">
            <div class="flex items-center space-x-3">
                <x-heroicon-o-check-circle class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" />
                <p class="text-sm text-green-800 dark:text-green-200 font-medium">
                    Link verifikasi baru telah dikirim ke email Anda!
                </p>
            </div>
        </div>
    @endif

    <!-- Actions -->
    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-button-gradient hover:bg-button-gradient-hover text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                <x-heroicon-o-envelope class="w-5 h-5" />
                <span>Kirim Ulang Email Verifikasi</span>
            </button>
        </form>

        <!-- Divider -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-card-gradient-light dark:bg-card-gradient-dark text-gray-500 dark:text-gray-400">
                    Sudah terverifikasi?
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-white/50 dark:bg-gray-800/50 text-cinema-700 dark:text-cinema-300 font-semibold py-3 px-6 rounded-xl border border-cinema-200 dark:border-cinema-700 hover:bg-cinema-50 dark:hover:bg-cinema-900/30 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 flex items-center justify-center space-x-2">
                <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5" />
                <span>Logout</span>
            </button>
        </form>
    </div>

    <!-- Info Box -->
    <div class="mt-8 info-box bg-blue-50/50 dark:bg-blue-900/20 border border-blue-200/50 dark:border-blue-700/50 rounded-lg p-4">
        <div class="flex items-start space-x-3">
            <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" />
            <div class="text-sm text-blue-800 dark:text-blue-200">
                <p class="font-medium mb-1">Tips Verifikasi Email:</p>
                <ul class="space-y-1 text-xs">
                    <li>• Cek folder spam/junk jika email tidak masuk ke inbox</li>
                    <li>• Link verifikasi berlaku selama 24 jam</li>
                    <li>• Setelah verifikasi, Anda bisa langsung memesan tiket</li>
                </ul>
            </div>
        </div>
    </div>
</x-guest-layout>
