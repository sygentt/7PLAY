<p align="center"><img src="logo.svg" width="200" alt="7PLAY"></p>

## 7PLAY Cinema Booking

Platform pemesanan tiket bioskop berbasis Laravel 12 dengan Tailwind CSS 4. Sistem terintegrasi dengan Midtrans payment gateway untuk pembayaran QRIS, email notifikasi, points reward system, dan voucher management.

---

## 🚀 Instalasi

### Prerequisites
- PHP 8.3+
- Composer
- Node.js & NPM
- MySQL 5.7+ / MariaDB
- Midtrans Account (untuk payment gateway)

### 1. Clone & Setup Environment
```bash
# Clone repository
git clone <repository-url>
cd 7PLAY

# Copy environment file
cp .env.example .env
```

### 2. Konfigurasi Database
Edit file `.env` dan sesuaikan kredensial database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=7play
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Konfigurasi Midtrans
Dapatkan credentials dari [Midtrans Dashboard](https://dashboard.midtrans.com/) dan update di `.env`:
```env
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_MERCHANT_ID=your-merchant-id

# SnapBI untuk QRIS
MIDTRANS_SNAPBI_CLIENT_ID=your-client-id
MIDTRANS_SNAPBI_CLIENT_SECRET=your-client-secret
MIDTRANS_SNAPBI_PARTNER_ID=your-partner-id
MIDTRANS_SNAPBI_CHANNEL_ID=7PLAY
MIDTRANS_SNAPBI_PRIVATE_KEY="-----BEGIN PRIVATE KEY-----
your-private-key-here
-----END PRIVATE KEY-----"
```

### 4. Konfigurasi Email (Opsional)
Untuk Gmail, gunakan App Password:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
```

### 5. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Generate application key
php artisan key:generate

# Create storage symlink
php artisan storage:link
```

### 6. Setup Database
```bash
# Run migrations dan seeders
php artisan migrate --seed
```

Seeder yang tersedia:
- `AdminUserSeeder` - User admin default
- `CitySeeder` - Data kota di Indonesia
- `CinemaSeeder` - Data bioskop
- `CinemaHallSeeder` - Studio bioskop & seats
- `MovieSeeder` - Sample data film
- `ShowtimeSeeder` - Jadwal tayang
- `VoucherSeeder` - 14 voucher dengan berbagai tipe
- `NotificationSeeder` - Sample notifications untuk testing
- `OrderSeeder` - Sample orders

### 7. Jalankan Aplikasi
```bash
# Development mode
php artisan serve
npm run dev

# Production build
npm run build
php artisan serve
```

> 💡 **Tip**: Untuk akses via ngrok/host publik, gunakan `npm run build` untuk menghindari pembatasan Vite dev server lintas-origin.

---

## 📖 Penggunaan

### Default Admin Account
Setelah seeding, gunakan kredensial berikut untuk login admin:
```
Email: admin@7play.com
Password: password
Admin URL: http://localhost:8000/admin
```

### User Flow - Booking Tiket
1. **Browse Movies** - Pilih film dari homepage atau halaman `/movies`
2. **Select Showtime** - Pilih tanggal, bioskop, dan jam tayang
3. **Choose Seats** - Pilih kursi yang tersedia (reservasi 10 menit)
4. **Apply Voucher** (opsional) - Gunakan voucher discount atau points
5. **Payment** - Bayar menggunakan QRIS via Midtrans
6. **E-ticket** - Terima e-ticket via email setelah pembayaran sukses
7. **Check-in** - Tunjukkan QR code di bioskop untuk check-in

### Admin Features
Admin panel menyediakan CRUD lengkap untuk:
- 🎬 **Movies Management** - Kelola film, genre, rating, trailer
- 🏢 **Cinemas & Halls** - Manajemen bioskop dan studio
- 📅 **Showtimes** - Atur jadwal tayang
- 🎫 **Orders** - Monitor dan kelola pemesanan
- 👥 **Users** - Manajemen user dan admin
- 🎁 **Vouchers** - Buat dan kelola voucher diskon
- 📢 **Notifications** - Kirim notifikasi ke user
- 📊 **Reports** - Laporan revenue dan statistik
- 🏙️ **Cities** - Kelola kota dan provinsi

### Points & Rewards System
- Dapatkan poin setiap pembelian tiket (configurable di `config/points.php`)
- Tukar poin dengan voucher
- 3 membership levels: Bronze, Silver, Gold
- Point history tracking

### Menjalankan Queue & Scheduler

**Queue Worker** (untuk processing jobs):
```bash
php artisan queue:work --queue=default --tries=3 --backoff=5
```

**Scheduler** (untuk scheduled jobs):
```bash
php artisan schedule:work

# Atau setup cron job di production:
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

**Jobs yang Berjalan:**
- `SendEticketEmailJob` - Kirim e-ticket setelah payment sukses
- `ExpireSeatReservationsJob` - Hapus reservasi expired (setiap menit)
- `CancelExpiredOrdersJob` - Cancel order yang belum dibayar (setiap 5 menit)
- `ShowtimeReminderJob` - Kirim reminder 2 jam sebelum showtime (setiap jam)

### Rute Penting

**Public Routes:**
- `/` - Homepage
- `/movies` - Daftar film
- `/movies/{movie}` - Detail film & booking
- `/cinemas` - Daftar bioskop
- `/qr/{token}` - QR verification

**Authenticated Routes:**
- `/profile` - User profile & settings
- `/profile/orders` - Order history
- `/profile/favorites` - Favorite movies
- `/points` - Points & rewards
- `/vouchers` - My vouchers
- `/booking/*` - Booking flow

**Admin Routes** (`/admin`):
- `/admin/dashboard` - Dashboard dengan statistik
- `/admin/movies` - Movies management
- `/admin/cinemas` - Cinemas management
- `/admin/showtimes` - Showtimes management
- `/admin/orders` - Orders management
- `/admin/users` - Users management
- `/admin/vouchers` - Vouchers management
- `/admin/notifications` - Notifications management
- `/admin/reports` - Reports & analytics
- `/admin/cities` - Cities management

**API Endpoints:**
- `GET /api/movies` - List movies
- `GET /api/cinemas` - List cinemas
- `GET /api/showtimes/{movie}` - Movie showtimes
- `GET /api/seats/availability/{showtime}` - Seat availability
- `GET /api/orders/{order}/status` - Order status
- `POST /api/midtrans/notification` - Midtrans webhook

---

## 🏗️ Arsitektur & Tech Stack

### Tech Stack
- **Backend**: Laravel 12 (PHP 8.3)
- **Frontend**: Blade Templates + Tailwind CSS 4 + Alpine.js
- **Database**: MySQL / MariaDB
- **Payment**: Midtrans (QRIS, SnapBI)
- **Email**: SMTP (Gmail / Mailhog)
- **Queue**: Database driver
- **Cache**: Database driver
- **Icons**: Heroicons (via blade-heroicons)

### Struktur Direktori Kunci
```
app/
├── Constants/
│   └── AdminIcons.php              # Icon mapping untuk admin sidebar
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                  # Admin CRUD controllers
│   │   ├── Auth/                   # Authentication controllers
│   │   ├── BookingController.php   # Booking flow
│   │   ├── PaymentController.php   # Payment handling
│   │   └── QrController.php        # QR verification
│   ├── Middleware/
│   │   └── AdminMiddleware.php     # Admin access control
│   └── Requests/                   # Form validation requests
├── Jobs/
│   ├── SendEticketEmailJob.php     # Email e-ticket dispatch
│   ├── ExpireSeatReservationsJob.php
│   ├── CancelExpiredOrdersJob.php
│   └── ShowtimeReminderJob.php
├── Mail/
│   └── EticketMail.php             # E-ticket email template
├── Models/                          # Eloquent models
│   ├── Movie.php
│   ├── Cinema.php
│   ├── Showtime.php
│   ├── Order.php
│   ├── Seat.php
│   ├── Voucher.php
│   ├── Notification.php
│   └── ...
└── Services/
    └── MidtransService.php         # Midtrans API abstraction

config/
├── booking.php                      # Booking TTL & settings
├── midtrans.php                     # Midtrans configuration
└── points.php                       # Points & rewards config

database/
├── migrations/                      # Database schema
└── seeders/                         # Sample data seeders
    ├── VoucherSeeder.php           # 14 vouchers
    ├── NotificationSeeder.php      # Sample notifications
    └── ...

resources/
└── views/
    ├── components/                  # Reusable Blade components
    │   ├── admin/                  # Admin-specific components
    │   ├── booking/                # Booking UI components
    │   ├── layouts/                # Layout components
    │   └── ...
    ├── admin/                       # Admin views
    ├── auth/                        # Auth views
    ├── booking/                     # Booking flow views
    └── ...

routes/
├── web.php                          # Public & authenticated routes
├── admin.php                        # Admin routes
├── api.php                          # API endpoints
├── auth.php                         # Auth routes (Breeze)
└── payment.php                      # Payment routes
```

### Design Patterns & Principles

**1. Component-Based UI**
- Semua halaman menggunakan reusable Blade components
- Komponen terorganisir di `resources/views/components`
- Konsisten dengan design system Tailwind CSS

**2. Service Layer**
- `MidtransService` untuk abstraksi payment gateway
- Memudahkan testing dan maintenance

**3. Job Queue System**
- Asynchronous processing untuk email & background tasks
- Retry mechanism dengan exponential backoff
- Dedicated jobs untuk scheduled tasks

**4. Configuration-Driven**
- TTL, points, payment settings via config files
- Environment-specific via `.env`

**5. Middleware Protection**
- `AdminMiddleware` untuk admin routes
- Laravel Sanctum untuk API authentication
- CSRF protection enabled

**6. Database Design**
- Foreign keys dengan cascade delete
- Indexes untuk optimasi query
- Soft deletes untuk data integrity

### Placeholder Images
Gunakan `dummyimage.com` untuk placeholder:
```html
<!-- Movie poster -->
<img src="https://dummyimage.com/300x450/374151/ffffff?text={{ urlencode($movie->title) }}" 
     alt="{{ $movie->title }}">

<!-- Cinema logo -->
<img src="https://dummyimage.com/200x100/1e293b/ffffff?text={{ urlencode($cinema->name) }}" 
     alt="{{ $cinema->name }}">
```

### Key Features Implementation

**Seat Reservation TTL**
- Konfigurasi di `config/booking.php`
- Auto-expire via scheduled job
- Real-time availability via API

**Payment Flow**
1. Create order → Generate QRIS via Midtrans
2. User scans & pays
3. Webhook updates order status
4. Email e-ticket dispatched via queue
5. QR code for check-in generated

**Points System**
- Configurable earn/redeem rates
- Membership level progression
- Point expiration (optional)
- Transaction history

---

## 🤝 Kontribusi

### Tim Desain Figma
High fidelity design 7PLAY dibuat oleh tim berikut:

**Andre:**
- Popup Login & Register
- Daftar Bioskop & Film
- Notification
- Favorites
- Settings
- Tiket Saya

**Ellycia:**
- Main Page
- Points System
- Profil User
- Detail Film
- Daftar Bioskop & Film
- Forgot & Reset Password
- Riwayat Pesanan
- Detail Pesanan

**Malvin:**
- Main Page
- Profil User
- E-ticket Design
- Payment Flow
- Info Ticket
- Select Seat
- Payment Success
- Checkout Details
- Select Voucher PopUp
- My Vouchers
- Website Implementation (dengan bantuan AI)

### Tech Stack & Libraries Used
- [Laravel 12](https://laravel.com)
- [Tailwind CSS 4](https://tailwindcss.com)
- [Alpine.js](https://alpinejs.dev)
- [Heroicons](https://heroicons.com)
- [Midtrans Payment Gateway](https://midtrans.com)
- [Laravel Breeze](https://laravel.com/docs/starter-kits#breeze)

---

## 📝 Dokumentasi Tambahan

- 📖 [Setup Guide](docs/SETUP.md) - Panduan setup lengkap
- 💳 [Midtrans Setup](MIDTRANS_SETUP.md) - Konfigurasi payment gateway
- 🛠️ [Admin Dashboard](ADMIN_DASHBOARD_README.md) - Admin panel documentation

---

## 🐛 Troubleshooting

### Database Connection Error
```bash
# Pastikan MySQL service running
# Cek kredensial di .env sesuai dengan MySQL

php artisan config:clear
php artisan cache:clear
```

### Queue Not Processing
```bash
# Restart queue worker
php artisan queue:restart

# Check failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all
```

### Midtrans Payment Failed
1. Cek credentials di `.env`
2. Pastikan `MIDTRANS_IS_PRODUCTION=false` untuk sandbox
3. Cek webhook URL accessible dari internet
4. Review logs: `storage/logs/laravel.log`

### Email Not Sending
1. Cek SMTP credentials di `.env`
2. Untuk Gmail, gunakan App Password bukan password biasa
3. Test koneksi: `php artisan tinker` → `Mail::raw('test', fn($m) => $m->to('test@example.com'))`

---

## 📄 Lisensi

Proyek ini dirilis di bawah lisensi **MIT**. Lihat berkas [LICENSE](LICENSE) untuk detail lengkap.

---

<p align="center">Made with ❤️ by 7PLAY Team</p>
