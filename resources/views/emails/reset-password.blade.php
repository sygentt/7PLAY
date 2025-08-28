@extends('emails.layout')

@section('content')
    <h2 class="email-title">Reset Kata Sandi Akun 7PLAY</h2>
    
    <p class="email-text">
        Halo <strong>{{ $user->name ?? 'Pengguna' }}</strong>,
    </p>
    
    <p class="email-text">
        Kami menerima permintaan untuk mengatur ulang kata sandi akun 7PLAY Anda yang terkait dengan email <strong>{{ $user->email ?? 'alamat email ini' }}</strong>.
    </p>
    
    <p class="email-text">
        Jika Anda yang membuat permintaan ini, klik tombol di bawah untuk membuat kata sandi baru:
    </p>
    
    <div class="button-container">
        <a href="{{ $resetUrl }}" class="email-button">
            Reset Kata Sandi
        </a>
    </div>
    
    <div class="info-box">
        <p>
            <strong>🔒 Keamanan Akun:</strong> Untuk melindungi akun Anda, pastikan kata sandi baru memenuhi kriteria berikut:
        </p>
        <ul style="margin: 8px 0 0 20px; color: #1e40af;">
            <li>Minimal 8 karakter</li>
            <li>Kombinasi huruf besar dan kecil</li>
            <li>Mengandung angka</li>
            <li>Mengandung karakter khusus (!@#$%^&*)</li>
        </ul>
    </div>
    
    <div class="warning-box">
        <p>
            <strong>⚠️ Penting:</strong> Link reset kata sandi ini akan kadaluarsa dalam <strong>60 menit</strong>. 
            Jika link ini kadaluarsa, Anda dapat meminta reset kata sandi baru melalui halaman login.
        </p>
    </div>
    
    <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 32px 0;">
    
    <p class="email-text" style="font-size: 14px; color: #9ca3af;">
        Jika tombol di atas tidak berfungsi, salin dan tempel link berikut ke browser Anda:
    </p>
    
    <div class="code-display">
        <div style="font-size: 12px; color: #6b7280; margin-bottom: 8px;">Link Reset Password:</div>
        <div style="word-break: break-all; font-size: 13px; color: #3b82f6;">
            {{ $resetUrl }}
        </div>
    </div>
    
    <div style="background: #fef2f2; border: 1px solid #fca5a5; border-radius: 12px; padding: 20px; margin: 24px 0;">
        <p style="margin: 0; font-size: 14px; color: #991b1b; line-height: 1.5;">
            <strong>🚨 Tidak Meminta Reset?</strong><br>
            Jika Anda tidak meminta reset kata sandi, abaikan email ini. Kata sandi Anda tetap aman dan tidak akan berubah. 
            Namun, kami sarankan Anda untuk segera mengganti kata sandi jika Anda merasa akun Anda mungkin telah dikompromikan.
        </p>
    </div>
    
    <p class="email-text" style="font-size: 14px; color: #9ca3af; text-align: center; margin-top: 24px;">
        Jika Anda mengalami kesulitan, hubungi tim customer service kami.
    </p>
@endsection
