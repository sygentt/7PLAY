<p align="center"><img src="https://raw.githubusercontent.com/sygentt/7PLAY/refs/heads/main/logo.svg?token=GHSAT0AAAAAADHMVW3IYVNJHARXDZERYZAI2F3YQ6A" width="200" alt="7PLAY"></a></p>

## 7PLAY Cinema Booking

Aplikasi pemesanan tiket bioskop berbasis Laravel 12. Fitur utama: reservasi kursi (TTL terpusat), pembayaran Midtrans (QRIS), voucher & poin loyalti, e-ticket via email, check-in QR sekali pakai, serta dashboard admin lengkap.

### Teknologi
- **Backend**: Laravel 12, PHP 8.3, MySQL
- **Frontend**: Blade, Tailwind CSS, Vite, Heroicons
- **Pembayaran**: Midtrans Snap/QRIS
- **Pekerjaan Latar**: Laravel Queue, Scheduler

---

## Persyaratan
- PHP 8.2+ (disarankan 8.3)
- MySQL 8 / MariaDB 10.6+
- Composer 2+
- Node.js 18+ dan npm 9+
- Opsional: Ngrok untuk pengujian webhook

## Instalasi Cepat
```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
npm ci
```

> Jika menggunakan Windows/Laragon, jalankan perintah di atas pada terminal Laragon. Jalankan juga `php artisan storage:link` bila membutuhkan akses ke berkas di `storage/app/public`.

## Menjalankan Aplikasi
- Backend: `php artisan serve`
- Frontend Dev (Vite): `npm run dev`
- Frontend Prod Build: `npm run build`

Jika dibuka melalui ngrok, gunakan build produksi (`npm run build`) agar tidak ada Vite dev server lintas-origin.

---

## Konfigurasi Lingkungan (.env)
Tambahkan variabel berikut sesuai kebutuhan:

```dotenv
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=7play
DB_USERNAME=root
DB_PASSWORD=

# Booking TTL (menit) dipakai untuk seluruh alur reservasi/pembayaran
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

- **TTL Booking** diatur di `config/booking.php` (kunci: `ttl_minutes`).
- **Webhook Midtrans**: `APP_URL/api/midtrans/notification`. Lihat juga `MIDTRANS_SETUP.md`.

---

## Data Seeder & Kredensial
Seeder default akan membuat data contoh kota, bioskop, studio, kursi, film, jadwal, order, dan pengguna admin.

- **Admin**: `admin@7play.com` / `admin123`
- **Super Admin**: `superadmin@7play.com` / `superadmin123`
- **User Uji**: `test@example.com` (password acak dari factory; buat sendiri via register bila perlu)

Jalankan ulang seeder bila dibutuhkan:

```bash
php artisan migrate:fresh --seed
```

---

## Alur Booking & Pembayaran (Ringkas)
1. Pengguna memilih film dan tanggal, lalu memilih kursi pada showtime.
2. Sistem membuat reservasi kursi dengan batas waktu sesuai `BOOKING_TTL_MINUTES`.
3. Pengguna checkout dan membayar via Midtrans (QRIS). Status order diperbarui via webhook.
4. Saat pembayaran selesai, e-ticket dikirim ke email (diproses oleh queue).
5. Check-in di pintu masuk dengan QR token sekali-pakai.

> Worker queue wajib aktif agar email e-ticket dan proses async berjalan.

### Menjalankan Queue & Scheduler
```bash
php artisan queue:work --queue=default --tries=3 --backoff=5
php artisan schedule:work
# Alternatif cron: * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

Job terjadwal: `ExpireSeatReservationsJob`, `CancelExpiredOrdersJob`, `ShowtimeReminderJob`.

---

## Rute Penting

### Publik (tanpa login)
- `/` — Beranda (film unggulan, daftar kini tayang/akan tayang)
- `/movies` — Daftar film (pencarian: `search`, urut: `sort`)
- `/movies/{movie}` — Detail film + showtimes
- `/cinemas` — Daftar bioskop
- `/qr/{token}` — Verifikasi QR e-ticket

### Autentikasi & Profil (auth + verified + active_user)
- `/booking/select-seats/{showtime}` — Pilih kursi
- `/booking/reserve-seats` — Reservasi kursi (POST)
- `/booking/checkout/{order}` — Checkout
- `/booking/checkout/{order}/vouchers` — Daftar voucher
- `/booking/checkout/{order}/apply-voucher` — Terapkan voucher (POST)
- `/points` — Poin & penukaran voucher
- `/vouchers` — Voucher milik pengguna
- `/profile` — Edit profil, notifikasi, tiket, riwayat pesanan, favorit, pengaturan

### Admin Panel
Panel admin tersedia di prefix `/admin` dan meliputi modul:
- Kota (`admin.cities.*`)
- Bioskop (`admin.cinemas.*`)
- Film (`admin.movies.*`)
- Jadwal (`admin.showtimes.*`)
- Pesanan (`admin.orders.*`)
- Pengguna (`admin.users.*`)
- Voucher (`admin.vouchers.*`)
- Notifikasi (`admin.notifications.*`)
- Laporan (`admin.reports.*`)

Pastikan login sebagai admin (`is_admin = true`).

### API (ringkas)
- `GET /api/movies` — Daftar film aktif (paginate)
- `GET /api/cinemas` — Daftar bioskop aktif (paginate)
- `GET /api/showtimes/{movie}` — Jadwal film (≥ hari ini)
- `GET /api/seats/availability/{showtime}` — Kursi tidak tersedia
- `GET /api/orders/{order}/status` — Status order (auth:sanctum)

---

## Komponen UI & Placeholder Gambar
- Halaman dibangun dengan komponen Blade yang reusable di `resources/views/components`.
- Placeholder gambar menggunakan `dummyimage.com` dengan teks dan ukuran yang dapat dikustom:

```html
<img src="https://dummyimage.com/300x450/374151/ffffff?text={{ urlencode($movie->title) }}" alt="{{ $movie->title }}">
```

---

## Keamanan Webhook Midtrans
Aktifkan salah satu atau keduanya untuk keamanan callback:
- **Callback Token**: tetapkan `MIDTRANS_CALLBACK_TOKEN` dan verifikasi pada endpoint.
- **IP Allowlist**: tetapkan `MIDTRANS_ALLOWED_IPS` dengan daftar IP Midtrans.

Detail langkah integrasi tersedia di `MIDTRANS_SETUP.md`.

---

## Testing
```bash
php artisan test
```
Tersedia pengujian fitur (auth, booking, profil) dan unit.

---

## Troubleshooting
- **Asset tidak tampil saat dibuka via ngrok**: gunakan `npm run build` alih-alih dev server.
- **Email tidak terkirim**: ganti `MAIL_MAILER=log` ke SMTP yang valid.
- **Pembayaran tidak update**: pastikan webhook Midtrans mengarah ke `APP_URL/api/midtrans/notification` dan queue berjalan.
- **Kursi tidak kembali tersedia**: periksa `BOOKING_TTL_MINUTES` dan jalankan scheduler.

---

## Lisensi
Proyek ini berlisensi MIT.

