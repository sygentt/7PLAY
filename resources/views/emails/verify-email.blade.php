@extends('emails.layout')

@section('content')
    <h2 class="email-title">Verifikasi Alamat Email Anda</h2>
    
    <p class="email-text">
        Halo <strong>{{ $user->name ?? 'Pengguna' }}</strong>,
    </p>
    
    <p class="email-text">
        Selamat datang di <strong>7PLAY</strong>! Terima kasih telah mendaftar di platform pemesanan tiket bioskop terpercaya Indonesia.
    </p>
    
    <p class="email-text">
        Untuk melengkapi proses pendaftaran dan mulai menikmati layanan kami, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini:
    </p>
    
    <div class="button-container">
        <a href="{{ $verificationUrl }}" class="email-button">
            Verifikasi Email Saya
        </a>
    </div>
    
    <div class="info-box">
        <p>
            <strong>💡 Tips:</strong> Setelah email Anda terverifikasi, Anda dapat:
        </p>
        <ul style="margin: 8px 0 0 20px; color: #1e40af;">
            <li>Memesan tiket film favorit Anda</li>
            <li>Mendapatkan poin reward setiap pembelian</li>
            <li>Menerima notifikasi film terbaru</li>
            <li>Menggunakan voucher dan promo eksklusif</li>
        </ul>
    </div>
    
    <div class="warning-box">
        <p>
            <strong>⚠️ Penting:</strong> Link verifikasi ini akan kadaluarsa dalam <strong>24 jam</strong>. 
            Jika Anda tidak mengklik link dalam waktu tersebut, silakan login ke akun Anda dan minta link verifikasi baru.
        </p>
    </div>
    
    <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 32px 0;">
    
    <p class="email-text" style="font-size: 14px; color: #9ca3af;">
        Jika tombol di atas tidak berfungsi, salin dan tempel link berikut ke browser Anda:
    </p>
    
    <div class="code-display">
        <div style="font-size: 12px; color: #6b7280; margin-bottom: 8px;">Link Verifikasi:</div>
        <div style="word-break: break-all; font-size: 13px; color: #3b82f6;">
            {{ $verificationUrl }}
        </div>
    </div>
    
    <p class="email-text" style="font-size: 14px; color: #9ca3af; text-align: center; margin-top: 24px;">
        Jika Anda tidak mendaftar di 7PLAY, abaikan email ini.
    </p>
@endsection
