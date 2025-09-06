@extends('layouts.public')

@section('title', 'Pembayaran Kedaluwarsa - 7PLAY')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="max-w-lg w-full bg-white dark:bg-gray-800 rounded-2xl p-8 text-center border border-gray-100 dark:border-gray-700 mx-4">
        <div class="mx-auto w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-bold mb-2">Pembayaran Kedaluwarsa</h1>
        <p class="text-gray-600 dark:text-gray-300 mb-6">Maaf, waktu pembayaran untuk pesanan Anda telah habis.</p>
        <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-cinema-600 text-white rounded-lg">Kembali ke Beranda</a>
    </div>
    
</div>
@endsection
