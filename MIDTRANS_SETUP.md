# Setup Integarsi Midtrans QRIS untuk 7PLAY

## Konfigurasi Environment

Tambahkan konfigurasi berikut ke file `.env` Anda:

```env
# Midtrans Configuration
# Set MIDTRANS_IS_PRODUCTION=true untuk production environment
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SERVER_KEY=Mid-server-pSaqAaMhFYK7A9J15DU6VKQs
MIDTRANS_CLIENT_KEY=Mid-client-i5PF_vLGtwjdWEke
MIDTRANS_MERCHANT_ID=G434349515
```

## Cara Setup

### 1. Install Dependencies
Package Midtrans PHP sudah terinstall melalui composer. Jika belum:
```bash
composer require midtrans/midtrans-php
```

### 2. Jalankan Migration
```bash
php artisan migrate
```

### 3. Seed Database (Optional)
```bash
php artisan db:seed
```

### 4. Generate Application Key (jika belum)
```bash
php artisan key:generate
```

## Cara Penggunaan

### 1. Membuat Pembayaran QRIS

```php
use App\Services\MidtransService;
use App\Models\Order;

$midtransService = new MidtransService();
$order = Order::find(1);

try {
    $payment = $midtransService->createQrisPayment($order);
    
    // QR Code URL tersedia di $payment->qr_code_url
    // Deep Link URL tersedia di $payment->deep_link_url
    
} catch (Exception $e) {
    // Handle error
    echo "Error: " . $e->getMessage();
}
```

### 2. Cek Status Pembayaran

```php
$result = $midtransService->checkPaymentStatus($payment);

if ($result['status'] === 'success') {
    echo "Payment status: " . $result['payment_status'];
} else {
    echo "Error: " . $result['message'];
}
```

### 3. Handle Webhook Notification

Webhook sudah disetup di route: `POST /api/midtrans/notification`

URL webhook untuk diset di Midtrans Dashboard:
```
https://yourdomain.com/api/midtrans/notification
```

## Routes yang Tersedia

### User Routes (dengan authentication)
- `GET /payment/methods/{order}` - Pilih metode pembayaran
- `POST /payment/qris/create/{order}` - Buat pembayaran QRIS
- `GET /payment/qris/{payment}` - Halaman pembayaran QRIS
- `GET /payment/qris/{payment}/status` - Cek status pembayaran (AJAX)
- `POST /payment/qris/{payment}/cancel` - Batalkan pembayaran
- `GET /payment/success/{payment}` - Halaman sukses pembayaran

### Webhook Route (tanpa authentication)
- `POST /api/midtrans/notification` - Handle notification dari Midtrans

## Views yang Tersedia

1. **`payments/methods.blade.php`** - Halaman pilihan metode pembayaran
2. **`payments/qris.blade.php`** - Halaman pembayaran QRIS dengan QR code
3. **`payments/success.blade.php`** - Halaman sukses pembayaran
4. **`payments/expired.blade.php`** - Halaman pembayaran kedaluwarsa

## Fitur yang Diimplementasi

### ✅ Sudah Selesai
- [x] Konfigurasi Midtrans untuk environment sandbox dan production
- [x] Model Payment dengan field lengkap untuk tracking
- [x] Migration payments table dengan index yang optimal
- [x] Service MidtransService untuk handle QRIS payment
- [x] Controller PaymentController untuk semua endpoint
- [x] Routes untuk payment flow lengkap
- [x] Views yang responsive dan user-friendly
- [x] Auto-refresh status pembayaran setiap 5 detik
- [x] Countdown timer untuk expiry payment
- [x] Webhook notification handling
- [x] CSRF exception untuk webhook
- [x] Relasi Order->Payment
- [x] Status management yang lengkap
- [x] Error handling dan logging

### 🔄 Dapat Dikembangkan Lebih Lanjut
- [ ] Implementasi Virtual Account payment
- [ ] Implementasi Bank Transfer
- [ ] Email notification setelah pembayaran berhasil
- [ ] PDF ticket generation
- [ ] Refund functionality
- [ ] Payment retry mechanism
- [ ] Admin panel untuk monitoring payment

## Testing

### 1. Test dengan Simulator Midtrans
Gunakan kredensial sandbox yang sudah dikonfigurasi untuk testing.

### 2. Test Payment Flow
1. Buat order baru
2. Pilih metode pembayaran QRIS
3. Scan QR code dengan aplikasi simulator
4. Cek auto-update status di halaman payment

### 3. Test Webhook
```bash
# Simulate webhook notification
curl -X POST http://localhost/api/midtrans/notification \
  -H "Content-Type: application/json" \
  -d '{
    "order_id": "your_external_id",
    "transaction_status": "settlement",
    "fraud_status": "accept",
    "payment_type": "qris"
  }'
```

## Troubleshooting

### 1. QR Code tidak muncul
- Cek koneksi internet
- Pastikan kredensial Midtrans benar
- Cek log Laravel untuk error details

### 2. Webhook tidak berfungsi
- Pastikan URL webhook accessible dari internet (untuk production)
- Cek apakah route di-exclude dari CSRF verification
- Cek log untuk error details

### 3. Payment stuck di pending
- Cek apakah webhook notification diterima
- Manually check payment status via API
- Cek log Midtrans untuk transaction details

## Security Notes

### Production Checklist
- [ ] Set `MIDTRANS_IS_PRODUCTION=true`
- [ ] Gunakan kredensial production Midtrans
- [ ] Setup HTTPS untuk webhook URL
- [ ] Implement rate limiting untuk webhook endpoint
- [ ] Setup monitoring dan alerting
- [ ] Regular backup database payments

### Credential Management
- Jangan commit kredensial ke repository
- Gunakan environment variables
- Rotate kredensial secara berkala
- Monitor akses yang mencurigakan

## Support

Untuk pertanyaan teknis:
- Dokumentasi Midtrans: https://docs.midtrans.com/
- Laravel Documentation: https://laravel.com/docs
- GitHub Issues untuk project ini

## Changelog

### v1.0.0 (2025-01-16)
- Initial implementation QRIS payment
- Basic webhook handling
- Complete payment flow UI
- Auto-refresh payment status
- Payment expiry handling
