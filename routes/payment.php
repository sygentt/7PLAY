<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
|
| Routes untuk handling pembayaran dengan Midtrans QRIS
|
*/

Route::middleware(['auth'])->group(function () {
    
    // Halaman pilihan metode pembayaran
    Route::get('/payment/methods/{order}', [PaymentController::class, 'showPaymentMethods'])
        ->name('payment.methods');

    // QRIS Payment Routes
    Route::prefix('payment/qris')->name('payment.qris.')->group(function () {
        
        // Buat pembayaran QRIS
        Route::post('/create/{order}', [PaymentController::class, 'createQrisPayment'])
            ->name('create');
        
        // Tampilkan halaman pembayaran QRIS
        Route::get('/{payment}', [PaymentController::class, 'showQrisPayment'])
            ->name('show');
        
        // Cek status pembayaran (AJAX)
        Route::get('/{payment}/status', [PaymentController::class, 'checkPaymentStatus'])
            ->name('status');
        
        // Batalkan pembayaran
        Route::post('/{payment}/cancel', [PaymentController::class, 'cancelPayment'])
            ->name('cancel');
    });

    // Short URL for showing payment page (same experience as checkout + QR modal)
    Route::get('/pay/{payment}', [PaymentController::class, 'showQrisPayment'])->name('pay.show');

    // Halaman sukses pembayaran
    Route::get('/payment/success/{payment}', [PaymentController::class, 'paymentSuccess'])
        ->name('payment.success');
});

// Webhook notification dari Midtrans (tidak perlu auth)
Route::post('/api/midtrans/notification', [PaymentController::class, 'handleNotification'])
    ->name('midtrans.notification');
