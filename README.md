<p align="center">
  <img src="logo.svg" width="180" alt="7PLAY" />
</p>

<p align="center">
  <strong>7PLAY Cinema Booking</strong><br>
  Pemesanan tiket bioskop modern dengan Laravel 12 + Tailwind CSS 4
</p>

<p align="center">
  <a href="https://www.php.net/"><img alt="PHP" src="https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white"></a>
  <a href="https://laravel.com/"><img alt="Laravel" src="https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white"></a>
  <a href="https://tailwindcss.com/"><img alt="Tailwind CSS" src="https://img.shields.io/badge/Tailwind-4-38B2AC?logo=tailwindcss&logoColor=white"></a>
  <a href="https://vitejs.dev/"><img alt="Vite" src="https://img.shields.io/badge/Vite-7-646CFF?logo=vite&logoColor=white"></a>
  <a href="LICENSE"><img alt="License" src="https://img.shields.io/badge/License-MIT-blue.svg"></a>
</p>

---

## Ringkasan
Aplikasi pemesanan tiket bioskop berbasis Laravel 12 yang fokus pada DX dan keandalan. Fitur utama: reservasi kursi dengan TTL terpusat, pembayaran Midtrans (QRIS), voucher dan poin loyalti, e‑ticket via email, check‑in QR sekali pakai, serta dashboard admin lengkap. UI dibangun dengan komponen Blade reusable dan Tailwind CSS 4.

### Tumpukan Teknologi
- **Backend**: Laravel 12, PHP 8.3, MySQL 8
- **Frontend**: Blade, Tailwind CSS 4, Vite, Heroicons
- **Pembayaran**: Midtrans Snap/QRIS
- **Latar**: Laravel Queue, Scheduler

---

## Daftar Isi
- [Persyaratan](#persyaratan)
- [Instalasi](#instalasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Konfigurasi Lingkungan](#konfigurasi-lingkungan-env)
- [Data Seeder & Kredensial](#data-seeder--kredensial)
- [Arsitektur & Struktur Proyek](#arsitektur--struktur-proyek)
- [Alur Booking & Pembayaran](#alur-booking--pembayaran)
- [Queue & Scheduler](#queue--scheduler)
- [Rute Penting](#rute-penting)
- [API Singkat](#api-singkat)
- [Komponen UI & Placeholder Gambar](#komponen-ui--placeholder-gambar)
- [Midtrans & Keamanan Webhook](#midtrans--keamanan-webhook)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)

---

## Persyaratan
- PHP 8.2+ (disarankan 8.3)
- MySQL 8 / MariaDB 10.6+
- Composer 2+
- Node.js 18+ dan npm 9+
- Opsional: Ngrok untuk pengujian webhook

> Catatan: Proyek ini menargetkan Tailwind CSS v4. Jika lingkungan Anda masih menggunakan Tailwind v3, ikuti catatan upgrade pada bagian Instalasi.

---

## Instalasi

### 1) Setup Proyek
```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
```

### 2) Frontend (Tailwind CSS 4 + Vite)
```bash
# Pastikan menggunakan Tailwind CSS v4
npm i -D tailwindcss@^4 @tailwindcss/vite@^4 @tailwindcss/forms postcss autoprefixer

# Instal dependensi lain
npm i
```

Tailwind sudah terintegrasi via `@tailwindcss/vite`. Berkas entri: `resources/css/app.css` dan `resources/js/app.js` (lihat `vite.config.js`).

Jika sebelumnya Anda memakai Tailwind v3:
- Periksa konfigurasi di `tailwind.config.js` dan sesuaikan bila ada API yang deprecated
- Pastikan plugin `@tailwindcss/forms` versi terbaru kompatibel
- Jalankan kembali build: `npm run dev` atau `npm run build`

### 3) Storage Link (opsional)
```bash
php artisan storage:link
```

> Windows/Laragon: Jalankan perintah pada terminal Laragon. Jika ada isu izin, jalankan terminal sebagai Administrator.

---

## Menjalankan Aplikasi
- Backend (Laravel): `php artisan serve`
- Frontend Dev (Vite): `npm run dev`
- Build Produksi: `npm run build`

Atau gunakan skrip terintegrasi dengan proses paralel (server + queue + scheduler + vite):
```bash
composer dev
```

> Jika mengakses via ngrok, gunakan build produksi (`npm run build`) untuk menghindari isu CORS/dev server.

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

- **TTL Booking** diatur juga di `config/booking.php` (`ttl_minutes`).
- **Webhook Midtrans**: `APP_URL/api/midtrans/notification` (lihat juga `MIDTRANS_SETUP.md`).

---

## Data Seeder & Kredensial
Seeder default membuat data contoh kota, bioskop, studio, kursi, film, jadwal, order, dan pengguna admin.

- **Admin**: `admin@7play.com` / `admin123`
- **Super Admin**: `superadmin@7play.com` / `superadmin123`
- **User Uji**: `test@example.com` (password acak dari factory; atau daftar baru)

Jalankan ulang seeder bila dibutuhkan:
```bash
php artisan migrate:fresh --seed
```

---

## Arsitektur & Struktur Proyek

Struktur direktori utama (ringkas):

```text
app/
  Http/Controllers/        # Controller publik, auth, admin, payment
  Jobs/                    # Pekerjaan async: Expire, Cancel, Reminder
  Mail/                    # EticketMail
  Models/                  # Model utama: Movie, Cinema, Order, Payment, dsb
  Services/                # MidtransService (abstraksi integrasi pembayaran)
  View/Components/         # Blade components kelas (opsional)

config/
  booking.php              # Konfigurasi TTL booking
  points.php               # Poin & loyalti
  midtrans.php             # Kunci & opsi Midtrans

resources/
  views/                   # Blade views
    components/            # Komponen Blade reusable (disarankan)
    admin/                 # Halaman & partial admin panel
    payments/              # Alur pembayaran (QRIS, dsb)

routes/
  web.php                  # Rute publik
  admin.php                # Rute admin panel
  api.php                  # API publik/terbatas
  payment.php              # Rute alur pembayaran
```

Prinsip:
- UI dibangun sebagai komponen Blade reusable pada `resources/views/components`.
- Placeholder gambar menggunakan `dummyimage.com` (lihat contoh di bawah).
- Helper digunakan seperlunya untuk DX, dengan tipe & docblock yang jelas.
- Background worker menangani proses TTL, email, dan webhook.

---

## Alur Booking & Pembayaran
1. Pengguna memilih film & tanggal, lalu memilih kursi pada showtime.
2. Sistem membuat reservasi kursi dengan batas waktu `BOOKING_TTL_MINUTES`.
3. Pengguna checkout dan membayar via Midtrans (QRIS). Status order diperbarui via webhook.
4. Saat pembayaran selesai, e‑ticket dikirim ke email (diproses oleh queue).
5. Check‑in di pintu masuk menggunakan QR token sekali‑pakai.

---

## Queue & Scheduler
Worker queue wajib aktif agar email e‑ticket dan proses async berjalan.

```bash
php artisan queue:work --queue=default --tries=3 --backoff=5
php artisan schedule:work
# Cron alternatif: * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

Contoh konfigurasi Supervisor & cron tersedia di `docs/SETUP.md`.

Pekerjaan terjadwal utama: `ExpireSeatReservationsJob`, `CancelExpiredOrdersJob`, `ShowtimeReminderJob`.

Email sudah dikirim melalui queue secara default:
- `App\Mail\EticketMail` mengimplementasi `ShouldQueue` dan dikirim via `Mail::to(...)->queue()` pada job terkait
- `App\Mail\GenericNotificationMail` (baru) menggantikan `Mail::raw` sinkron pada `AppServiceProvider`, juga dikirim via queue

---

## Rute Penting

### Publik
- `/` — Beranda (film unggulan, kini tayang/akan tayang)
- `/movies` — Daftar film (pencarian `search`, urut `sort`)
- `/movies/{movie}` — Detail film + showtimes
- `/cinemas` — Daftar bioskop
- `/qr/{token}` — Verifikasi QR e‑ticket

### Autentikasi & Profil (auth + verified + active_user)
- `/booking/select-seats/{showtime}` — Pilih kursi
- `/booking/reserve-seats` — Reservasi kursi (POST)
- `/booking/checkout/{order}` — Checkout
- `/booking/checkout/{order}/vouchers` — Kelola voucher
- `/booking/checkout/{order}/apply-voucher` — Terapkan voucher (POST)
- `/points` — Poin & penukaran voucher
- `/vouchers` — Voucher pengguna
- `/profile` — Profil, notifikasi, tiket, riwayat pesanan, favorit, pengaturan

### Admin Panel (`/admin`)
- Kota, Bioskop, Film, Jadwal, Pesanan, Pengguna, Voucher, Notifikasi, Laporan

> Pastikan akun admin memiliki `is_admin = true`.

---

## API Singkat
- `GET /api/movies` — Daftar film aktif (paginate)
- `GET /api/cinemas` — Daftar bioskop aktif (paginate)
- `GET /api/showtimes/{movie}` — Jadwal film (≥ hari ini)
- `GET /api/seats/availability/{showtime}` — Kursi tidak tersedia
- `GET /api/orders/{order}/status` — Status order (auth:sanctum)

---

## Komponen UI & Placeholder Gambar
- Komponen disimpan di `resources/views/components` dan dipakai ulang pada halaman.
- Placeholder gambar menggunakan `dummyimage.com` dengan teks & ukuran kustom:

```html
<img src="https://dummyimage.com/300x450/374151/ffffff?text={{ urlencode($movie->title) }}" alt="{{ $movie->title }}">
```

> Warna dan ukuran dapat diubah sesuai skema warna tema (`cinema`, `gold`) pada `tailwind.config.js`.

---

## Midtrans & Keamanan Webhook
Aktifkan salah satu/dua pendekatan berikut pada callback:
- **Callback Token**: isi `MIDTRANS_CALLBACK_TOKEN` dan verifikasi pada endpoint.
- **IP Allowlist**: isi `MIDTRANS_ALLOWED_IPS` dengan daftar IP Midtrans.

Langkah integrasi detail tersedia di `MIDTRANS_SETUP.md`.

---

## Testing
```bash
php artisan test
```
Pengujian fitur (auth, booking, profil) dan unit tersedia.

---

## Troubleshooting
- **Asset tidak tampil via ngrok**: gunakan `npm run build` alih‑alih dev server.
- **Email tidak terkirim**: ubah `MAIL_MAILER=log` ke SMTP valid.
- **Pembayaran tidak update**: pastikan webhook Midtrans ke `APP_URL/api/midtrans/notification` dan queue aktif.
- **Kursi tidak kembali tersedia**: cek `BOOKING_TTL_MINUTES` dan jalankan scheduler.

---

## Kontribusi
Terima kasih atas ketertarikan Anda untuk berkontribusi! Ikuti panduan berikut agar pengalaman kolaborasi konsisten.

### Alur Kerja
1. Fork repo, buat branch dari `main`
2. Penamaan branch: `feat/…`, `fix/…`, `chore/…`, `docs/…`
3. Jalankan test dan styling sebelum mengajukan PR
4. Buat PR ringkas, sertakan deskripsi, tangkapan layar (jika UI)

### Gaya Commit (Conventional Commits)
- Format: `type(scope): subject`
- Contoh:
  - `feat(booking): dukung apply voucher pada checkout`
  - `fix(seat): perbaiki race condition pada reservasi kursi`
  - `chore(ci): jalankan tests pada PHP 8.3`

### Styling Kode (Pint)
Jalankan Laravel Pint untuk konsistensi gaya kode PHP:
```bash
./vendor/bin/pint
```

> Gunakan tipe & docblock yang jelas, lebih suka helpers dibanding facade bila cocok, dan pastikan DX (autocompletion, type safety) terjaga.

### Standar UI (Tailwind)
- Gunakan utility‑first; hindari CSS kustom bila tidak perlu
- Kelompokkan utilitas dengan `@apply` seperlunya
- Konsisten dark mode (`class`), responsive, dan state variants

---

## Lisensi
Proyek ini berlisensi **MIT**. Lihat berkas [`LICENSE`](LICENSE).
