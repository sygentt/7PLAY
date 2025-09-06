<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 7PLAY Cinema Booking

Platform pemesanan tiket bioskop berbasis Laravel 11 dengan pembayaran Midtrans (QRIS), reservasi kursi, voucher, loyalti poin, dan dashboard admin.

### Fitur
- Reservasi kursi dengan TTL terpusat (`config/booking.php`)
- Pembayaran Midtrans QRIS (opsi VA/e-wallet/kartu siap ekspansi)
- Webhook Midtrans dengan hardening (callback token/IP allowlist)
- Poin loyalti & voucher
- Check-in QR sekali-pakai
- Admin dashboard & laporan terintegrasi

### Instalasi Cepat
```
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
npm ci
```

### Build Frontend
- Dev (Vite): `npm run dev`
- Prod: `npm run build`

Jika share via ngrok, gunakan build prod agar tidak memuat Vite lintas-origin.

### Konfigurasi Midtrans (Sandbox)
Tambahkan di `.env`:
```
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxx
MIDTRANS_MERCHANT_ID=YOUR_SANDBOX_MERCHANT_ID
MIDTRANS_CALLBACK_TOKEN=
MIDTRANS_ALLOWED_IPS=
APP_URL=https://your-ngrok-domain.ngrok-free.app
```
Webhook: `APP_URL/api/midtrans/notification`

Enabled methods UI di `config/midtrans.php`:
```php
'enabled_methods' => ['qris'/*, 'va','ewallet','credit_card'*/],
```

### Queue & Scheduler
Jalankan worker queue (email e-ticket, proses async):
```
php artisan queue:work --queue=default --tries=3 --backoff=5
```
Scheduler:
```
php artisan schedule:work
# atau cron: * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```
Jobs terjadwal: `ExpireSeatReservationsJob`, `CancelExpiredOrdersJob`, `ShowtimeReminderJob`.

### Testing
```
php artisan test
```

### Keamanan Webhook
Gunakan `webhook.callback_token` atau `webhook.allowed_ips` pada `config/midtrans.php`.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
