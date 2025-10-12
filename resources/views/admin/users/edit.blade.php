@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('page-description', 'Edit informasi user yang sudah terdaftar')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <x-heroicon-m-home class="mr-2 h-4 w-4"/>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="h-4 w-4 text-gray-400"/>
                        <a href="{{ route('admin.users.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Users</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="h-4 w-4 text-gray-400"/>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit {{ $user->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit User</h1>
            <p class="mt-1 text-sm text-gray-600">Update informasi user {{ $user->name }}</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="divide-y divide-gray-200">
                @csrf
                @method('PUT')
                
                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Dasar</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $user->name) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                   placeholder="Contoh: John Doe"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $user->email) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                   placeholder="contoh@domain.com"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon
                            </label>
                            <input type="text" 
                                   name="phone" 
                                   id="phone" 
                                   value="{{ old('phone', $user->phone) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                                   placeholder="08123456789">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir
                            </label>
                            <input type="date" 
                                   name="date_of_birth" 
                                   id="date_of_birth" 
                                   value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('date_of_birth') border-red-500 @enderror">
                            @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin
                            </label>
                            <select name="gender" 
                                    id="gender" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('gender') border-red-500 @enderror">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password Baru
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Kosongkan field ini jika tidak ingin mengubah password
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Pengaturan Akun</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Role -->
                        <div>
                            <label for="is_admin" class="block text-sm font-medium text-gray-700 mb-2">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select name="is_admin" 
                                    id="is_admin" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('is_admin') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Role</option>
                                <option value="0" {{ old('is_admin', $user->is_admin ? '1' : '0') == '0' ? 'selected' : '' }}>Customer</option>
                                <option value="1" {{ old('is_admin', $user->is_admin ? '1' : '0') == '1' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('is_admin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="is_active" 
                                    id="is_active" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('is_active') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Status</option>
                                <option value="1" {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $user->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('is_active')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Verified -->
                        <div class="md:col-span-2">
                            <div class="flex items-center">
                                <input type="hidden" name="email_verified" value="0">
                                <input type="checkbox" 
                                       name="email_verified" 
                                       id="email_verified" 
                                       value="1"
                                       {{ old('email_verified', $user->email_verified_at ? '1' : '0') == '1' ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="email_verified" class="ml-2 block text-sm text-gray-700">
                                    Email sudah terverifikasi
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                Centang jika email user sudah terverifikasi
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Warning Box -->
                <div class="px-6 py-4 bg-yellow-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-heroicon-m-exclamation-triangle class="h-5 w-5 text-yellow-400"/>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Perubahan role akan mempengaruhi akses user ke sistem</li>
                                    <li>Menonaktifkan user akan mencegah mereka login</li>
                                    <li>Password hanya akan berubah jika field diisi</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <x-heroicon-m-x-mark class="mr-2 h-4 w-4"/>
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <x-heroicon-m-pencil class="mr-2 h-4 w-4"/>
                        Update User
                    </button>
                </div>
            </form>
        </div>

        <!-- User Points Management (Separate Form) -->
        <div class="bg-white shadow rounded-lg mt-6">
            <div class="px-6 py-6 bg-blue-50">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Manajemen Poin User</h3>
                    
                    <!-- Current Points Display -->
                    <div class="bg-white p-4 rounded-lg border border-blue-200 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Poin Saat Ini</p>
                                <p class="text-3xl font-bold text-blue-600">{{ number_format($user_points->total_points) }}</p>
                                <p class="text-xs text-gray-500 mt-1">Membership Level: <span class="font-semibold">{{ ucfirst($user_points->membership_level) }}</span></p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Total Orders</p>
                                <p class="text-xl font-semibold text-gray-900">{{ number_format($user_points->total_orders) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Points Adjustment Form -->
                    <div class="bg-white p-5 rounded-lg border">
                        <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                            <x-heroicon-m-cog class="h-5 w-5 mr-2 text-blue-500"/>
                            Sesuaikan Poin User
                        </h4>
                        
                        <form action="{{ route('admin.users.update-points', $user) }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Action Type -->
                                <div>
                                    <label for="points_action" class="block text-sm font-medium text-gray-700 mb-2">
                                        Aksi <span class="text-red-500">*</span>
                                    </label>
                                    <select name="points_action" 
                                            id="points_action" 
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            required>
                                        <option value="">Pilih Aksi</option>
                                        <option value="add">Tambah Poin</option>
                                        <option value="subtract">Kurangi Poin</option>
                                    </select>
                                </div>

                                <!-- Points Amount -->
                                <div>
                                    <label for="points_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jumlah Poin <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="points_amount" 
                                           id="points_amount" 
                                           min="1"
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Contoh: 100"
                                           required>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="points_description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Keterangan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="points_description" 
                                       id="points_description" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="Contoh: Bonus poin promo"
                                       required>
                                <p class="mt-1 text-xs text-gray-500">
                                    Keterangan akan dicatat dalam riwayat transaksi poin user
                                </p>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <x-heroicon-m-check class="mr-2 h-4 w-4"/>
                                    Terapkan Perubahan Poin
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex">
                            <x-heroicon-m-information-circle class="h-5 w-5 text-yellow-600 mr-2 flex-shrink-0"/>
                            <div class="text-xs text-yellow-800">
                                <p class="font-semibold mb-1">Catatan:</p>
                                <ul class="list-disc pl-4 space-y-1">
                                    <li>Perubahan poin akan tercatat dalam riwayat transaksi</li>
                                    <li>Pastikan jumlah poin yang dikurangi tidak melebihi saldo saat ini</li>
                                    <li>Setiap perubahan akan ditandai sebagai "oleh admin" dalam sistem</li>
                                </ul>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <!-- User Statistics -->
        @if($user->orders()->count() > 0)
        <div class="bg-white shadow rounded-lg mt-6">
            <div class="px-6 py-6 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik User</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white p-4 rounded-lg border">
                            <div class="flex items-center">
                                <x-heroicon-m-shopping-bag class="h-5 w-5 text-blue-500 mr-2"/>
                                <div>
                                    <p class="text-sm text-gray-600">Total Orders</p>
                                    <p class="text-lg font-semibold">{{ $user->orders()->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border">
                            <div class="flex items-center">
                                <x-heroicon-m-currency-dollar class="h-5 w-5 text-green-500 mr-2"/>
                                <div>
                                    <p class="text-sm text-gray-600">Total Spent</p>
                                    <p class="text-lg font-semibold">Rp {{ number_format($user->orders()->whereIn('status', ['confirmed', 'paid'])->sum('total_amount'), 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border">
                            <div class="flex items-center">
                                <x-heroicon-m-calendar class="h-5 w-5 text-purple-500 mr-2"/>
                                <div>
                                    <p class="text-sm text-gray-600">Member Since</p>
                                    <p class="text-lg font-semibold">{{ $user->created_at->format('M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection


