@extends('emails.layout')

@section('content')
    <h2 class="email-title">Selamat Datang di 7PLAY! 🎬</h2>
    
    <p class="email-text">
        Halo <strong>{{ $user->name ?? 'Pengguna' }}</strong>,
    </p>
    
    <p class="email-text">
        Selamat datang di <strong>7PLAY</strong> - platform pemesanan tiket bioskop terpercaya di Indonesia! 
        Kami sangat senang Anda bergabung dengan komunitas pecinta film kami.
    </p>
    
    <!-- Welcome Benefits -->
    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #86efac; border-radius: 12px; padding: 24px; margin: 24px 0;">
        <h3 style="color: #166534; font-size: 18px; font-weight: 600; margin: 0 0 16px 0; text-align: center;">
            🎁 Keuntungan Menjadi Member 7PLAY
        </h3>
        
        <div style="display: grid; gap: 12px;">
            <div style="display: flex; align-items: center; padding: 8px 0;">
                <span style="width: 24px; height: 24px; background: #22c55e; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 12px; font-weight: bold;">✓</span>
                <span style="color: #166534; font-weight: 500;">Booking tiket online mudah dan cepat</span>
            </div>
            <div style="display: flex; align-items: center; padding: 8px 0;">
                <span style="width: 24px; height: 24px; background: #22c55e; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 12px; font-weight: bold;">✓</span>
                <span style="color: #166534; font-weight: 500;">Poin reward setiap pembelian tiket</span>
            </div>
            <div style="display: flex; align-items: center; padding: 8px 0;">
                <span style="width: 24px; height: 24px; background: #22c55e; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 12px; font-weight: bold;">✓</span>
                <span style="color: #166534; font-weight: 500;">Notifikasi film terbaru dan promo eksklusif</span>
            </div>
            <div style="display: flex; align-items: center; padding: 8px 0;">
                <span style="width: 24px; height: 24px; background: #22c55e; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 12px; font-weight: bold;">✓</span>
                <span style="color: #166534; font-weight: 500;">E-ticket digital tanpa perlu antri</span>
            </div>
            <div style="display: flex; align-items: center; padding: 8px 0;">
                <span style="width: 24px; height: 24px; background: #22c55e; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 12px; font-weight: bold;">✓</span>
                <span style="color: #166534; font-weight: 500;">Akses ke semua bioskop partner kami</span>
            </div>
        </div>
    </div>
    
    <!-- Quick Start Guide -->
    <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #3b82f6; border-radius: 12px; padding: 24px; margin: 24px 0;">
        <h3 style="color: #1e40af; font-size: 18px; font-weight: 600; margin: 0 0 16px 0; text-align: center;">
            🚀 Cara Mulai Menggunakan 7PLAY
        </h3>
        
        <div style="display: grid; gap: 16px;">
            <div style="display: flex; align-items: flex-start;">
                <div style="width: 32px; height: 32px; background: #3b82f6; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 16px; font-weight: bold; flex-shrink: 0;">1</div>
                <div>
                    <strong style="color: #1e40af;">Pilih Film & Bioskop</strong><br>
                    <span style="color: #1e40af; font-size: 14px;">Browse film yang sedang tayang dan pilih bioskop terdekat</span>
                </div>
            </div>
            <div style="display: flex; align-items: flex-start;">
                <div style="width: 32px; height: 32px; background: #3b82f6; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 16px; font-weight: bold; flex-shrink: 0;">2</div>
                <div>
                    <strong style="color: #1e40af;">Pilih Jadwal & Kursi</strong><br>
                    <span style="color: #1e40af; font-size: 14px;">Tentukan waktu tayang dan pilih kursi favorit Anda</span>
                </div>
            </div>
            <div style="display: flex; align-items: flex-start;">
                <div style="width: 32px; height: 32px; background: #3b82f6; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; margin-right: 16px; font-weight: bold; flex-shrink: 0;">3</div>
                <div>
                    <strong style="color: #1e40af;">Bayar & Dapatkan E-Ticket</strong><br>
                    <span style="color: #1e40af; font-size: 14px;">Lakukan pembayaran dan terima e-ticket langsung</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Button -->
    <div class="button-container">
        <a href="{{ url('/movies') }}" class="email-button">
            Jelajahi Film Sekarang
        </a>
    </div>
    
    <!-- Special Welcome Offer -->
    <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 2px solid #f59e0b; border-radius: 12px; padding: 24px; margin: 24px 0; text-align: center;">
        <h3 style="color: #92400e; font-size: 18px; font-weight: 600; margin: 0 0 12px 0;">
            🎫 Promo Khusus Member Baru!
        </h3>
        <p style="color: #92400e; font-size: 16px; font-weight: 600; margin: 0 0 8px 0;">
            Dapatkan <strong>10% DISKON</strong> untuk pembelian tiket pertama Anda
        </p>
        <p style="color: #92400e; font-size: 14px; margin: 0;">
            Gunakan kode: <strong style="font-size: 16px; background: #ffffff; padding: 4px 8px; border-radius: 4px;">WELCOME10</strong>
        </p>
        <p style="color: #a16207; font-size: 12px; margin: 12px 0 0 0; font-style: italic;">
            *Berlaku hingga 30 hari setelah registrasi
        </p>
    </div>
    
    <!-- Network Info -->
    <div class="info-box">
        <p>
            <strong>🏢 Jaringan Bioskop Partner:</strong><br>
            7PLAY bekerja sama dengan berbagai jaringan bioskop terpercaya di Indonesia termasuk XXI, CGV, Cinepolis, dan banyak lagi. 
            Temukan bioskop terdekat di aplikasi kami!
        </p>
    </div>
    
    <!-- Download App -->
    <div style="text-align: center; margin: 32px 0;">
        <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin-bottom: 16px;">
            📱 Download Aplikasi Mobile
        </h3>
        <p style="color: #6b7280; font-size: 14px; margin-bottom: 16px;">
            Nikmati pengalaman yang lebih baik dengan aplikasi mobile 7PLAY
        </p>
        <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
            <a href="#" style="display: inline-block; padding: 8px 16px; background: #000; color: white; text-decoration: none; border-radius: 8px; font-size: 14px;">
                📱 App Store
            </a>
            <a href="#" style="display: inline-block; padding: 8px 16px; background: #000; color: white; text-decoration: none; border-radius: 8px; font-size: 14px;">
                🤖 Google Play
            </a>
        </div>
    </div>
    
    <p class="email-text" style="text-align: center; margin-top: 32px; font-style: italic;">
        Selamat menikmati pengalaman menonton yang tak terlupakan bersama <strong>7PLAY</strong>! 🍿✨
    </p>
@endsection
