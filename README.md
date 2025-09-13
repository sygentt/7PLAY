<p align="center"><img src="logo.svg" width="200" alt="7PLAY"></p>

## 7PLAY Cinema Booking

Platform pemesanan tiket bioskop berbasis Laravel 12 dengan Tailwind CSS 4.

---

## Instalasi
1) Siapkan file lingkungan
```bash
cp .env.example .env
```

2) Pasang dependensi PHP & aplikasi
```bash
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

3) Pasang dependensi frontend
```bash
npm ci
```

4) Jalankan aplikasi (mode pengembangan)
```bash
php artisan serve
npm run dev
```

> Untuk akses via ngrok/host publik, gunakan build produksi `npm run build` agar menghindari pembatasan Vite dev server lintas-origin.

---

## Penggunaan

### Alur Booking
1. Pilih film dan tanggal, kemudian pilih kursi pada showtime.
2. Sistem membuat reservasi kursi sesuai `BOOKING_TTL_MINUTES`.
3. Checkout dan bayar via Midtrans. Status order diperbarui melalui webhook.
4. E-ticket dikirim via email (diproses queue).
5. Check-in menggunakan QR token sekali pakai.

### Menjalankan Queue & Scheduler
```bash
php artisan queue:work --queue=default --tries=3 --backoff=5
php artisan schedule:work
# Cron alternatif: * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

Job terjadwal utama: `ExpireSeatReservationsJob`, `CancelExpiredOrdersJob`, `ShowtimeReminderJob`.

### Rute Penting
- **Publik**: `/`, `/movies`, `/movies/{movie}`, `/cinemas`, `/qr/{token}`
- **Auth/Profil**: `/booking/*`, `/points`, `/vouchers`, `/profile`
- **Admin** (`/admin`): kota, bioskop, film, showtime, pesanan, pengguna, voucher, notifikasi, laporan
- **API ringkas**: `GET /api/movies`, `GET /api/cinemas`, `GET /api/showtimes/{movie}`, `GET /api/seats/availability/{showtime}`, `GET /api/orders/{order}/status`

---

## Arsitektur

### Struktur Direktori Kunci
- `app/Models` — Model Eloquent seperti `Movie`, `Cinema`, `Showtime`, `Order`, `Seat`, dll.
- `app/Http/Controllers` — Controller publik, auth, admin, dan webhook Midtrans.
- `app/Jobs` — Worker untuk email e-ticket, TTL, reminder, pembatalan order expired.
- `app/Services/MidtransService.php` — Abstraksi pemanggilan API Midtrans.
- `config/booking.php`, `config/midtrans.php`, `config/points.php` — Konfigurasi domain.
- `resources/views/components` — Komponen Blade reusable untuk semua UI.
- `routes/web.php`, `routes/admin.php`, `routes/api.php`, `routes/payment.php` — Definisi rute.

### Pola & Prinsip
- TTL reservasi terpusat via `config/booking.php`, digunakan pada alur reservasi dan pembayaran.
- Event-driven untuk proses async (email e-ticket, reminder) melalui Queue.
- Validasi & Form Request pada endpoint sensitif.

### Komponen UI & Placeholder Gambar
- Semua halaman dirakit dari komponen di `resources/views/components` agar reusable.
- Gunakan placeholder `dummyimage.com` dengan teks/ukuran kustom:
```html
<img src="https://dummyimage.com/300x450/374151/ffffff?text={{ urlencode($movie->title) }}" alt="{{ $movie->title }}">
```

---

## Kontribusi

Berikut daftar kontribusi dalam pembuatan high fidelity desain Figma 7PLAY:

- Popup Login: Andre
- Popup Register: Andre
- Main Page: Ellycia, Malvin
- Points: Ellycia
- Profil: Ellycia, Malvin
- Detail Film: Ellycia
- Daftar Bioskop: Ellycia, Andre
- Daftar Film: Ellycia, Andre
- Forgot Password: Ellycia
- Reset Password: Ellycia
- Riwayat Pesanan: Ellycia
- Detail Pesanan: Ellycia
- E-ticket: Malvin
- Payment: Malvin
- info-ticket: Malvin
- e-ticket: Malvin
- payment: Malvin
- select-seat: Malvin
- payment-success: Malvin
- checkout-details: Malvin
- Select-Voucher-PopUp: Malvin
- my-vouchers: Malvin
- Notification: Andre
- Favorites: Andre
- Settings: Andre
- tiket-saya: Andre

Untuk websitenya, dibuat Malvin dengan bantuan AI.

---

## Lisensi
Proyek ini dirilis di bawah lisensi MIT. Lihat berkas `LICENSE`.
