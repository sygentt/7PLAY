<p align="center"><img src="logo.svg" width="200" alt="7PLAY"></p>

## 7PLAY Cinema Booking

Platform pemesanan tiket bioskop berbasis Laravel 12 dengan Tailwind CSS 4. Fitur utama: reservasi kursi dengan TTL terpusat, pembayaran Midtrans (QRIS), voucher & poin loyalti, e-ticket via email, check-in QR sekali pakai, serta dashboard admin.

### Teknologi
- **Backend**: Laravel 12, PHP 8.3, MySQL
- **Frontend**: Blade, Tailwind CSS 4, Vite, Heroicons
- **Pembayaran**: Midtrans Snap/QRIS
- **Background Jobs**: Laravel Queue & Scheduler

---

## Persyaratan
- PHP 8.2+ (disarankan 8.3)
- MySQL 8 / MariaDB 10.6+
- Composer 2+
- Node.js 18+ dan npm 9+
- Opsional: Ngrok untuk webhook Midtrans

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

## Konfigurasi

### Variabel .env
```dotenv
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=7play
DB_USERNAME=root
DB_PASSWORD=

# Booking TTL (menit) untuk alur reservasi/pembayaran
BOOKING_TTL_MINUTES=10

# MIDTRANS (Sandbox)
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxx
MIDTRANS_MERCHANT_ID=YOUR_SANDBOX_MERCHANT_ID
MIDTRANS_CALLBACK_TOKEN=
MIDTRANS_ALLOWED_IPS=

# Email (untuk e-ticket)
MAIL_MAILER=log
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@7play.local
MAIL_FROM_NAME="7PLAY"
```

- TTL Booking juga tersedia di `config/booking.php`.
- Webhook Midtrans: `APP_URL/api/midtrans/notification` (lihat `MIDTRANS_SETUP.md`).

### Tailwind 4
Proyek ini dikonfigurasi dengan Tailwind via Vite. Pastikan `tailwindcss` pada `package.json` menggunakan versi 4.x. Jika masih 3.x, upgrade dengan:
```bash
npm i -D tailwindcss@^4 @tailwindcss/vite@^4 postcss autoprefixer
```
Konfigurasi opsional tersedia di `tailwind.config.js` (pastikan path Blade sudah tercakup).

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
- Semua halaman dirakit dari komponen di `resources/views/components` untuk reusability.
- Gunakan placeholder `dummyimage.com` dengan teks/ukuran kustom:
```html
<img src="https://dummyimage.com/300x450/374151/ffffff?text={{ urlencode($movie->title) }}" alt="{{ $movie->title }}">
```

---

## Pengembangan

### Perintah Harian
- Jalankan server: `php artisan serve`
- Jalankan Vite: `npm run dev`
- Build produksi: `npm run build`

### Kualitas Kode
- Gunakan Laravel Pint: `vendor/bin/pint`
- Ikuti konvensi Laravel dan praktik keamanan standar.

---

## Testing
Jalankan semua pengujian:
```bash
php artisan test
```
Tersedia pengujian fitur (auth, booking, profil) dan unit.

---

## Kontribusi

1) Fork repositori ini dan buat branch fitur: `feat/nama-fitur`
2) Jalankan linting & tes sebelum commit: `vendor/bin/pint && php artisan test`
3) Buat Pull Request dengan deskripsi perubahan, langkah uji, dan catatan kompatibilitas

Pedoman singkat:
- Ikuti standar commit konvensional (opsional namun disarankan)
- Tambahkan pengujian untuk fitur/bugfix yang signifikan
- Perubahan UI sebaiknya berupa komponen Blade reusable dalam `resources/views/components`

---

## Lisensi
Berbasis lisensi MIT. Lihat berkas `LICENSE`.
