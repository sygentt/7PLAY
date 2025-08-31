<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - 7PLAY</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8 p-6">
        <!-- Logo and Title -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                <x-heroicon-s-film class="h-10 w-10 text-white"/>
            </div>
            <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">
                7PLAY Admin
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Masuk ke dashboard admin
            </p>
        </div>

        <!-- Login Form -->
        <div class="bg-white py-8 px-6 shadow-lg rounded-xl">
            <form class="space-y-6" action="{{ route('admin.login') }}" method="POST">
                @csrf
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
                        Email Admin
                    </label>
                    <div class="mt-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-m-envelope class="h-5 w-5 text-gray-400"/>
                        </div>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               autocomplete="email" 
                               required 
                               value="{{ old('email') }}"
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm sm:leading-6 @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" 
                               placeholder="admin@7play.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
                        Password
                    </label>
                    <div class="mt-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-m-lock-closed class="h-5 w-5 text-gray-400"/>
                        </div>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               autocomplete="current-password" 
                               required 
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm sm:leading-6 @error('password') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" 
                               placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember" 
                           name="remember" 
                           type="checkbox" 
                           {{ old('remember') ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        Ingat saya
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <x-heroicon-m-shield-check class="h-5 w-5 text-blue-300 group-hover:text-blue-200"/>
                        </span>
                        Masuk Admin
                    </button>
                </div>
            </form>

            <!-- Demo Credentials Info -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-heroicon-m-information-circle class="h-5 w-5 text-blue-400"/>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Demo Credentials</h3>
                            <div class="mt-2 text-sm text-blue-700 space-y-1">
                                <p><strong>Email:</strong> admin@7play.com</p>
                                <p><strong>Password:</strong> admin123</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Site -->
        <div class="text-center">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">
                <x-heroicon-m-arrow-left class="h-4 w-4 mr-2"/>
                Kembali ke Situs Utama
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <div class="flex items-center">
                <x-heroicon-s-check-circle class="h-5 w-5 mr-2"/>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <div class="flex items-center">
                <x-heroicon-s-x-circle class="h-5 w-5 mr-2"/>
                {{ session('error') }}
            </div>
        </div>
    @endif
</body>
</html>
