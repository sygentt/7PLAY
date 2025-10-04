<x-guest-layout>
    <x-slot name="title">Admin Login</x-slot>

    <!-- Header -->
    <div class="mb-8 text-center">
        <h2 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">
            Admin Panel Login
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            Welcome back, please login to your account.
        </p>
    </div>

    <!-- Session Status -->
    <x-ui.auth-session-status class="mb-6" :status="session('status')" />

    <!-- Display General Errors -->
    @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
        <div
            class="mb-4 rounded-lg border border-red-200 bg-red-100 p-4 text-sm font-medium text-red-600 dark:border-red-800/50 dark:bg-red-900/20 dark:text-red-400">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-gray-900 dark:text-white">
                Alamat Email
            </label>
            <div class="relative">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username"
                    class="@if ($errors->has('email')) border-red-500 @else border-gray-200 dark:border-gray-600 @endif w-full rounded-xl border bg-white/50 px-4 py-3 text-gray-900 placeholder-gray-500 backdrop-blur-sm transition-all duration-200 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-cinema-500 dark:bg-gray-800/50 dark:text-white dark:placeholder-gray-400"
                    placeholder="nama@email.com" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-heroicon-o-envelope class="h-5 w-5 text-gray-400" />
                </div>
            </div>
            <x-form.input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-semibold text-gray-900 dark:text-white">
                Kata Sandi
            </label>
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="@if ($errors->has('password')) border-red-500 @else border-gray-200 dark:border-gray-600 @endif w-full rounded-xl border bg-white/50 px-4 py-3 text-gray-900 placeholder-gray-500 backdrop-blur-sm transition-all duration-200 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-cinema-500 dark:bg-gray-800/50 dark:text-white dark:placeholder-gray-400"
                    placeholder="••••••••" />
                <button type="button" onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <x-heroicon-o-eye id="eye-open" class="h-5 w-5" />
                    <x-heroicon-o-eye-slash id="eye-closed" class="hidden h-5 w-5" />
                </button>
            </div>
            <x-form.input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-cinema-600 focus:ring-2 focus:ring-cinema-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-cinema-600">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full transform rounded-xl bg-button-gradient px-6 py-3 font-semibold text-white shadow-lg transition-all duration-200 hover:scale-[1.02] hover:bg-button-gradient-hover hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-cinema-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
            Login
        </button>
    </form>

    <!-- Password Toggle Script -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>
