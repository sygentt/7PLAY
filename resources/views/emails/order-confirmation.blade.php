@extends('emails.layout')

@section('content')
    <h2 class="email-title">Konfirmasi Pemesanan Tiket</h2>
    
    <p class="email-text">
        Halo <strong>{{ $user->name ?? 'Pengguna' }}</strong>,
    </p>
    
    <p class="email-text">
        Selamat! Pemesanan tiket bioskop Anda telah berhasil dikonfirmasi. Berikut adalah detail pemesanan Anda:
    </p>
    
    <!-- Order Details -->
    <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin: 24px 0;">
        <h3 style="color: #1f2937; font-size: 18px; font-weight: 600; margin: 0 0 16px 0; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
            📋 Detail Pemesanan
        </h3>
        
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px solid #e5e7eb;">
                <td style="padding: 8px 0; font-weight: 500; color: #374151; width: 40%;">Nomor Pesanan:</td>
                <td style="padding: 8px 0; color: #1f2937; font-weight: 600;">{{ $order->order_number ?? 'ORD-XXXXXX' }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #e5e7eb;">
                <td style="padding: 8px 0; font-weight: 500; color: #374151;">Film:</td>
                <td style="padding: 8px 0; color: #1f2937; font-weight: 600;">{{ $order->showtime->movie->title ?? 'Judul Film' }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #e5e7eb;">
                <td style="padding: 8px 0; font-weight: 500; color: #374151;">Bioskop:</td>
                <td style="padding: 8px 0; color: #1f2937;">{{ $order->showtime->cinemaHall->cinema->name ?? 'Nama Bioskop' }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #e5e7eb;">
                <td style="padding: 8px 0; font-weight: 500; color: #374151;">Studio:</td>
                <td style="padding: 8px 0; color: #1f2937;">{{ $order->showtime->cinemaHall->name ?? 'Studio 1' }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #e5e7eb;">
                <td style="padding: 8px 0; font-weight: 500; color: #374151;">Tanggal & Waktu:</td>
                <td style="padding: 8px 0; color: #1f2937;">
                    {{ $order->showtime->show_date ?? '2024-01-01' }} | {{ $order->showtime->show_time ?? '19:30' }}
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #e5e7eb;">
                <td style="padding: 8px 0; font-weight: 500; color: #374151;">Kursi:</td>
                <td style="padding: 8px 0; color: #1f2937; font-weight: 600;">
                    @if(isset($order->orderItems))
                        @foreach($order->orderItems as $item)
                            {{ $item->seat->row_label }}{{ $item->seat->seat_number }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    @else
                        A1, A2
                    @endif
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: 500; color: #374151;">Total Bayar:</td>
                <td style="padding: 8px 0; color: #059669; font-weight: 700; font-size: 18px;">
                    Rp {{ number_format($order->total_amount ?? 50000, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>
    
    <!-- QR Code E-Ticket -->
    @if(isset($order->qr_code))
    <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 2px solid #3b82f6; border-radius: 12px; padding: 24px; margin: 24px 0; text-align: center;">
        <h3 style="color: #1e40af; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">
            🎫 E-Ticket Anda
        </h3>
        <p style="color: #1e40af; margin-bottom: 16px;">Tunjukkan QR Code ini di bioskop</p>
        
        <!-- QR Code placeholder - in real implementation, you'd generate this -->
        <div style="width: 200px; height: 200px; background: #ffffff; border: 2px solid #e5e7eb; border-radius: 8px; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #6b7280;">
            QR CODE<br>
            {{ $order->qr_code }}
        </div>
        
        <p style="font-size: 12px; color: #6b7280; margin-top: 12px;">
            Kode: {{ $order->qr_code }}
        </p>
    </div>
    @endif
    
    <!-- Important Instructions -->
    <div class="info-box">
        <p>
            <strong>📌 Petunjuk Penting:</strong>
        </p>
        <ul style="margin: 8px 0 0 20px; color: #1e40af;">
            <li>Tiba di bioskop minimal 30 menit sebelum film dimulai</li>
            <li>Bawa kartu identitas yang valid</li>
            <li>Tunjukkan QR code e-ticket di atas untuk masuk</li>
            <li>Tempat duduk tidak dapat diubah setelah konfirmasi</li>
        </ul>
    </div>
    
    <!-- Points Earned -->
    @if(isset($order->points_earned) && $order->points_earned > 0)
    <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 1px solid #f59e0b; border-radius: 12px; padding: 20px; margin: 24px 0; text-align: center;">
        <p style="margin: 0; color: #92400e; font-weight: 600;">
            🎉 Selamat! Anda mendapat <strong>{{ $order->points_earned }} poin</strong> dari pembelian ini
        </p>
        <p style="margin: 8px 0 0 0; font-size: 14px; color: #92400e;">
            Gunakan poin untuk mendapat diskon di pembelian berikutnya
        </p>
    </div>
    @endif
    
    <!-- Customer Service -->
    <div class="warning-box">
        <p>
            <strong>❓ Butuh Bantuan?</strong><br>
            Jika ada pertanyaan tentang pemesanan ini, hubungi customer service kami di:
        </p>
        <ul style="margin: 8px 0 0 20px; color: #92400e;">
            <li>WhatsApp: +62 811-1234-567</li>
            <li>Email: support@7play.id</li>
            <li>Telepon: (021) 555-1234</li>
        </ul>
    </div>
    
    <p class="email-text" style="text-align: center; margin-top: 32px; font-style: italic;">
        Terima kasih telah memilih <strong>7PLAY</strong>.<br>
        Selamat menikmati film Anda! 🍿🎬
    </p>
@endsection
