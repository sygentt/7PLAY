@extends('emails.layout')

@section('content')
    <h2 class="email-title">E‑Ticket Anda Siap!</h2>
    <p class="email-text" style="text-align:center">
        Hai <strong>{{ $order->user->name }}</strong>, pembayaran Anda telah berhasil.
        Berikut detail e‑ticket untuk ditunjukkan saat check‑in.
    </p>

    <div class="info-box">
        <p><strong>Order</strong> #{{ $order->order_number }} (ID: {{ $order->id }})</p>
        <p><strong>Film</strong> {{ $order->showtime?->movie?->title ?? 'Tiket' }}</p>
        <p><strong>Studio</strong> {{ $order->showtime?->cinemaHall?->name }} - {{ $order->showtime?->cinemaHall?->cinema?->name }}</p>
        <p><strong>Jadwal</strong> {{ $order->showtime?->show_date?->format('d M Y') }} {{ $order->showtime?->show_time?->format('H:i') }}</p>
        <p><strong>Kursi</strong> {{ $order->getSeatNumbers() }}</p>
        <p><strong>Total</strong> {{ $order->getFormattedTotal() }}</p>
    </div>

    <div class="button-container">
        <a class="email-button" href="{{ $order->getQrVerificationUrl() }}" target="_blank" rel="noopener">Lihat QR Verifikasi</a>
    </div>

    <div class="warning-box">
        <p>
            Simpan email ini. Tunjukkan QR atau kode booking saat check‑in. Jangan bagikan QR kepada orang lain.
        </p>
    </div>
@endsection


