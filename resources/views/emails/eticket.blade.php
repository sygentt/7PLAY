<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>E-Ticket 7PLAY</title>
    <style>
        body{font-family:Arial, sans-serif; color:#111}
        .card{border:1px solid #eee; border-radius:12px; padding:16px}
        .muted{color:#666; font-size:12px}
    </style>
    </head>
<body>
    <h2>E-Ticket 7PLAY</h2>
    <p>Hai {{ $order->user->name }}, pembayaran Anda telah berhasil. Berikut detail e-ticket Anda:</p>
    <div class="card">
        <p><strong>Order #</strong> {{ $order->order_number }} (ID: {{ $order->id }})</p>
        <p><strong>Film</strong> {{ $order->showtime?->movie?->title ?? 'Tiket' }}</p>
        <p><strong>Studio</strong> {{ $order->showtime?->cinemaHall?->name }} - {{ $order->showtime?->cinemaHall?->cinema?->name }}</p>
        <p><strong>Jadwal</strong> {{ $order->showtime?->show_date?->format('d M Y') }} {{ $order->showtime?->show_time?->format('H:i') }}</p>
        <p><strong>Kursi</strong> {{ $order->getSeatNumbers() }}</p>
        <p><strong>Total</strong> {{ $order->getFormattedTotal() }}</p>
        <p class="muted">QR Verifikasi: {{ $order->getQrVerificationUrl() }}</p>
    </div>
    <p class="muted">Tunjukkan QR atau kode booking di lokasi untuk check-in. Terima kasih.</p>
</body>
</html>


