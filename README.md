<p align="center"><img src="logo.svg" width="200" alt="7PLAY"></p>

## 7PLAY Cinema Booking

Platform pemesanan tiket bioskop berbasis Laravel 12 dengan Tailwind CSS 4. Sistem terintegrasi dengan Midtrans payment gateway untuk pembayaran QRIS, email notifikasi, points reward system, dan voucher management.

---

## 📋 Deskripsi Proyek

Website 7PLAY adalah solusi digital untuk menyelesaikan permasalahan sistem pemesanan tiket bioskop yang masih manual dan tidak efisien. Proyek ini dibangun dari nol menggunakan **Laravel** sebagai backend framework dan **Tailwind CSS** untuk frontend styling, sebagai bagian dari proyek kolaboratif yang melibatkan berbagai peran dalam pengembangan web.

### 🎯 Latar Belakang Masalah

Sistem pemesanan tiket bioskop konvensional sering menghadapi beberapa kendala:
- Antrian panjang di loket pembelian tiket
- Ketidakpastian ketersediaan kursi sebelum datang ke bioskop
- Pembayaran hanya dapat dilakukan secara tunai atau kartu di tempat
- Tidak ada sistem reward atau loyalty program untuk pelanggan setia
- Informasi film dan jadwal tayang yang sulit diakses secara real-time

### 🔍 Identifikasi Masalah

**Bagaimana membuat sistem pemesanan tiket bioskop yang efisien, mudah diakses, dan dapat meningkatkan pengalaman pengguna dalam memesan tiket secara online?**

### 👥 Target Pengguna

- **Penonton Film**: Masyarakat umum yang ingin menonton film di bioskop dengan cara yang praktis
- **Pelanggan Setia**: Pengguna yang sering menonton dan ingin mendapatkan benefit dari sistem reward
- **Admin Bioskop**: Pengelola bioskop yang membutuhkan sistem manajemen jadwal, film, dan pesanan yang terintegrasi

### 🎯 Tujuan Aplikasi

1. Memudahkan proses pemesanan tiket bioskop secara online
2. Memberikan informasi real-time tentang ketersediaan kursi dan jadwal tayang
3. Menyediakan berbagai metode pembayaran digital yang aman
4. Mengimplementasikan sistem reward points untuk meningkatkan loyalitas pelanggan
5. Menyediakan dashboard admin yang komprehensif untuk pengelolaan bioskop

### 💡 Solusi yang Ditawarkan

7PLAY menyediakan platform booking online yang lengkap dengan fitur-fitur modern:
- Sistem pemilihan kursi real-time dengan seat reservation
- Integrasi payment gateway (Midtrans QRIS)
- E-ticket dengan QR code untuk check-in
- Points & rewards system dengan membership levels
- Voucher management untuk promosi dan diskon
- Admin panel untuk manajemen lengkap bioskop

---

## 👨‍💻 Tim Pengembang

Proyek ini dikembangkan oleh tim dengan pembagian peran sebagai berikut:

### UI/UX Designer
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

### Front-End & Back-End Developer
**Malvin:**
- Main Page Implementation
- Profil User
- E-ticket Design & Implementation
- Payment Flow Integration
- Info Ticket
- Select Seat System
- Payment Success Flow
- Checkout Details
- Select Voucher PopUp
- My Vouchers
- Full Website Implementation (dengan bantuan AI)
- Database Design & Backend Logic
- API Integration

---

## ✨ Fitur Utama Aplikasi

### Untuk User (Pengguna)
1. **Browse & Search Movies** - Lihat daftar film yang sedang tayang dengan informasi lengkap (poster, rating, genre, durasi, sinopsis)
2. **Seat Selection System** - Pilih kursi favorit dengan visualisasi real-time availability dan auto-expire reservation (10 menit)
3. **Multi-Cinema Support** - Pilih bioskop berdasarkan kota dan lokasi yang tersedia
4. **Flexible Scheduling** - Pilih tanggal dan jam tayang sesuai keinginan
5. **Secure Payment (QRIS)** - Pembayaran aman via Midtrans dengan metode QRIS
6. **E-Ticket & QR Code** - Terima e-ticket digital via email dengan QR code untuk check-in
7. **Points & Rewards System** - Kumpulkan poin setiap pembelian, dengan 3 membership levels (Bronze, Silver, Gold)
8. **Voucher Management** - Gunakan voucher diskon atau tukar points dengan voucher
9. **Order History** - Lihat riwayat pemesanan dan detail transaksi
10. **Favorites** - Simpan film favorit untuk akses cepat
11. **Notifications** - Terima notifikasi untuk update film baru, promosi, dan reminder showtime
12. **Profile Management** - Kelola informasi profil dan preferensi akun

### Untuk Admin (Pengelola Bioskop)
1. **Dashboard Analytics** - Statistik revenue, total orders, dan performa bisnis
2. **Movies Management** - CRUD lengkap untuk film, genre, rating, dan trailer
3. **Cinemas & Halls Management** - Kelola data bioskop, studio, dan konfigurasi kursi
4. **Showtimes Management** - Atur jadwal tayang dengan validasi konflik
5. **Orders Monitoring** - Monitor dan kelola semua pesanan dengan berbagai status
6. **Users Management** - Manajemen user dan admin dengan role-based access
7. **Vouchers Management** - Buat dan kelola voucher dengan berbagai tipe (percentage, fixed, points)
8. **Notifications Broadcasting** - Kirim notifikasi ke semua user atau user tertentu
9. **Reports & Analytics** - Laporan revenue, popular movies, dan performa bioskop
10. **Cities Management** - Kelola data kota dan provinsi untuk multi-location support

---

## 🗄️ Database & Entitas Utama

Aplikasi ini menggunakan beberapa entitas utama yang saling berelasi:

### Core Entities

| Entitas | Deskripsi | Relasi Utama |
|---------|-----------|--------------|
| **User** | Data pengguna (customer & admin) | Has many Orders, Favorites, Points, Notifications |
| **Movie** | Informasi film (judul, poster, genre, rating, durasi) | Has many Showtimes, Favorites |
| **Cinema** | Data bioskop (nama, alamat, kota) | Has many CinemaHalls, Showtimes |
| **CinemaHall** | Studio bioskop dengan konfigurasi seat | Belongs to Cinema, Has many Seats, Showtimes |
| **Showtime** | Jadwal tayang film di studio tertentu | Belongs to Movie & CinemaHall, Has many Orders |
| **Seat** | Kursi di setiap studio (row, number, type) | Belongs to CinemaHall, Has many SeatReservations |
| **Order** | Transaksi pemesanan tiket | Belongs to User & Showtime, Has many OrderSeats |
| **OrderSeat** | Detail kursi yang dipesan | Belongs to Order & Seat |
| **SeatReservation** | Temporary reservation kursi (10 menit) | Belongs to Seat, User, Showtime |
| **Voucher** | Voucher diskon atau reward | Belongs to User (optional), Has many OrderVouchers |
| **Point** | Sistem poin untuk user | Belongs to User |
| **PointHistory** | Riwayat earn/redeem points | Belongs to User |
| **Notification** | Notifikasi untuk user | Belongs to User |
| **City** | Data kota dan provinsi | Has many Cinemas |

### Database Schema Highlights

**Key Features:**
- Foreign keys dengan cascade delete untuk data integrity
- Indexes pada kolom yang sering di-query (email, cinema_id, movie_id)
- Soft deletes untuk Movies, Cinemas, Vouchers
- Timestamps untuk tracking created/updated time
- Enum types untuk status (pending, paid, cancelled, completed)
- JSON columns untuk flexible data (seat_config, notification_data)

### Seeders Tersedia

```bash
# Jalankan semua seeders
php artisan migrate --seed
```

Data yang di-seed:
- **AdminUserSeeder**: Default admin account
- **CitySeeder**: 38 provinsi dan kota-kota besar di Indonesia
- **CinemaSeeder**: Sample bioskop (CGV, Cinepolis, XXI)
- **CinemaHallSeeder**: Studio dengan konfigurasi kursi otomatis
- **MovieSeeder**: Sample 10+ film dengan berbagai genre
- **ShowtimeSeeder**: Jadwal tayang untuk minggu ini
- **VoucherSeeder**: 14 voucher dengan berbagai tipe
- **NotificationSeeder**: Sample notifications
- **OrderSeeder**: Sample orders untuk testing

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
git clone https://github.com/sygentt/7PLAY.git
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
- Dapatkan poin setiap pembelian tiket
- Tukar poin dengan voucher
- 3 membership levels: Bronze, Silver, Gold
- Point history tracking

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
├── Http/Controllers/        # Admin, Auth, Booking, Payment controllers
├── Models/                  # Movie, Cinema, Order, User, dll
├── Jobs/                    # Background jobs (Email, Queue)
├── Mail/                    # Email templates
└── Services/                # MidtransService

database/
├── migrations/              # Database schema
└── seeders/                 # Sample data

resources/views/
├── components/              # Reusable components
├── admin/                   # Admin panel views
├── auth/                    # Auth pages
└── booking/                 # Booking flow

routes/
├── web.php                  # Public routes
├── admin.php                # Admin routes
└── api.php                  # API endpoints
```

### Design Patterns & Principles
- **MVC Architecture**: Mengikuti Laravel MVC pattern
- **Component-Based UI**: Reusable Blade components dengan Tailwind CSS
- **Service Layer**: Abstraksi untuk payment gateway dan business logic
- **Job Queue System**: Asynchronous processing untuk email dan background tasks
- **Middleware Protection**: Role-based access control untuk admin
- **Database Design**: Relasi antar tabel dengan foreign keys dan indexes

---

## 🤝 Workflow & Kolaborasi

### Git Workflow
Proyek ini menggunakan Git & GitHub untuk version control dan kolaborasi tim:

**Branch Strategy:**
- `main` - Production-ready code
- `feature/*` - Feature development branches
- `bugfix/*` - Bug fixes
- `hotfix/*` - Urgent production fixes

**Commit Convention:**
```bash
# Format: <type>: <description>

# Contoh:
feat: add seat reservation system
fix: resolve payment callback issue
docs: update installation guide
style: improve booking page UI
refactor: optimize database queries
```

**Pull Request Process:**
1. Create feature branch from `main`
2. Develop & commit changes
3. Push branch to remote
4. Create Pull Request with clear description
5. Code review by team members
6. Merge setelah approval

**GitHub Project Management:**
- Gunakan GitHub Projects untuk task tracking
- Assign issues ke team members
- Label untuk kategori (bug, enhancement, documentation)
- Milestone untuk phase development

### Design to Code Process
1. **UI/UX Designer** membuat wireframe & high-fidelity design di Figma
2. **Front-End Developer** menerjemahkan design ke HTML + Tailwind CSS
3. **Back-End Developer** membuat controller, model, dan API endpoints
4. **Integration** - Front-end & back-end digabungkan dan di-test
5. **Review** - Team review functionality dan UI/UX
6. **Deploy** - Push ke production setelah approval

### Tech Stack & Libraries Used
- [Laravel 12](https://laravel.com) - Backend Framework
- [Tailwind CSS 4](https://tailwindcss.com) - CSS Framework
- [Alpine.js](https://alpinejs.dev) - Lightweight JavaScript Framework
- [Heroicons](https://heroicons.com) - Icon Library
- [Midtrans Payment Gateway](https://midtrans.com) - Payment Integration
- [Laravel Breeze](https://laravel.com/docs/starter-kits#breeze) - Authentication Scaffolding
- [MySQL](https://www.mysql.com) - Database
- [Composer](https://getcomposer.org) - PHP Dependency Manager
- [NPM](https://www.npmjs.com) - Node Package Manager

---

## 📊 Kriteria Proyek & Penilaian

### Ketentuan yang Dipenuhi

**✅ Tim dan Peran**
- Tim terdiri dari 3 orang dengan pembagian peran jelas
- UI/UX Designer: Andre & Ellycia
- Front-End & Back-End Developer: Malvin

**✅ Permasalahan yang Diselesaikan**
- Masalah nyata: Sistem pemesanan tiket bioskop yang masih manual
- Solusi: Platform booking online yang efisien dengan fitur modern

**✅ Teknologi Wajib**
- ✓ Laravel 12.x.x
- ✓ Tailwind CSS 4
- ✓ Git & GitHub dengan commit history yang jelas
- ✓ Branch strategy: `main` dan feature branches
- ✓ UI/UX design menggunakan Figma

**✅ Dokumentasi & Proses**
- ✓ GitHub repository dengan commit history terstruktur
- ✓ Pesan commit yang jelas dan deskriptif
- ✓ README.md lengkap dengan instalasi, arsitektur, dan dokumentasi teknis
- ✓ Design high-fidelity di Figma

**✅ Deliverable**
- ✓ Website fungsional (dapat dijalankan lokal)
- ✓ Dokumentasi lengkap (README.md, problem & solution description)
- ✓ Database setup dengan migrations & seeders
- ✓ Admin panel untuk manajemen

### Compliance dengan Rubrik Penilaian

| Kriteria | Status | Keterangan |
|----------|--------|------------|
| **Integrasi Frontend–Backend** | ✅ Skor 5 | Integrasi penuh dengan komunikasi data lancar via API dan Blade |
| **Struktur Kode & Arsitektur** | ✅ Skor 5 | Mengikuti MVC pattern Laravel, modular, clean code |
| **Implementasi Frontend** | ✅ Skor 5 | Tampilan modern dengan Tailwind CSS, responsive, fungsional |
| **Implementasi Backend & Database** | ✅ Skor 5 | CRUD lengkap, relasi tabel terstruktur rapi, logika efisien |
| **Penggunaan Git & Kolaborasi** | ✅ Skor 5 | Branch strategy, commit deskriptif, workflow profesional |
| **Dokumentasi** | ✅ Skor 5 | README sangat lengkap (instalasi, arsitektur, fitur, database setup, tech stack) |
| **Kualitas Teknis & Kerapian** | ✅ Skor 5 | Kode bersih, mengikuti Laravel conventions, naming jelas |

### Fitur Tambahan (Nilai Plus)
- ✨ Payment Gateway Integration (Midtrans QRIS)
- ✨ Email Notification System
- ✨ Queue & Scheduled Jobs
- ✨ Points & Rewards System
- ✨ Voucher Management
- ✨ Real-time Seat Reservation
- ✨ QR Code Check-in System
- ✨ Admin Dashboard dengan Analytics
- ✨ Multi-city & Multi-cinema Support
- ✨ Responsive Design untuk Mobile & Desktop

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
