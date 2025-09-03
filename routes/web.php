<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\BookingController;
// use App\Http\Controllers\OrderController;
// use App\Http\Controllers\PointController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes - No Authentication Required
|--------------------------------------------------------------------------
*/

// Homepage - Movie listings, cinema info
Route::get('/', [HomeController::class, 'index'])->name('home');

// Movie browsing (public)
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Debug/Test routes (remove in production)
Route::get('/test-modal', function () {
    $current_page = 'test';
    return view('test-modal', compact('current_page'));
})->name('test.modal');

// Cinema and showtime info (public)
// Route::get('/cinemas', [CinemaController::class, 'index'])->name('cinemas.index');
// Route::get('/cinemas/{cinema}', [CinemaController::class, 'show'])->name('cinemas.show');

/*
|--------------------------------------------------------------------------
| Guest Routes - For Non-Authenticated Users
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login required notice for booking
    Route::get('/login-required', function () {
        return view('auth.login-required');
    })->name('login.required');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

// Redirect legacy dashboard URL to home for backward compatibility
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated & Verified Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Booking System
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/select-seats/{showtime}', [BookingController::class, 'selectSeats'])->name('select-seats');
        Route::post('/reserve-seats', [BookingController::class, 'reserveSeats'])->name('reserve-seats');
        Route::get('/checkout/{order}', [BookingController::class, 'checkout'])->name('checkout');
        Route::get('/checkout/{order}/vouchers', [BookingController::class, 'listVouchers'])->name('checkout.vouchers');
        Route::post('/checkout/{order}/apply-voucher', [BookingController::class, 'applyVoucher'])->name('checkout.apply-voucher');
    });
    
    // Order Management
    // Route::prefix('orders')->name('orders.')->group(function () {
    //     Route::get('/', [OrderController::class, 'index'])->name('index');
    //     Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    //     Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    //     Route::get('/{order}/ticket', [OrderController::class, 'ticket'])->name('ticket');
    // });
    
    // Points & Loyalty
    // Route::prefix('points')->name('points.')->group(function () {
    //     Route::get('/', [PointController::class, 'index'])->name('index');
    //     Route::get('/history', [PointController::class, 'history'])->name('history');
    //     Route::post('/redeem', [PointController::class, 'redeem'])->name('redeem');
    // });
    
    // Vouchers
    // Route::prefix('vouchers')->name('vouchers.')->group(function () {
    //     Route::get('/', [VoucherController::class, 'index'])->name('index');
    //     Route::post('/claim/{voucher}', [VoucherController::class, 'claim'])->name('claim');
    // });

    // Points & Vouchers
    Route::prefix('points')->name('points.')->group(function () {
        Route::get('/', [\App\Http\Controllers\PointsController::class, 'index'])->name('index');
        Route::post('/redeem/{voucher}', [\App\Http\Controllers\PointsController::class, 'redeem'])->name('redeem');
    });

    // Profile related routes  
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');
        
        Route::get('/tickets', [App\Http\Controllers\TicketController::class, 'index'])->name('tickets');
        
        Route::get('/orders-history', [App\Http\Controllers\OrderHistoryController::class, 'index'])->name('orders-history');
        Route::get('/orders/{order}', [App\Http\Controllers\OrderHistoryController::class, 'show'])->name('orders.show');
        
        Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites');
        
        Route::get('/settings', function () {
            return view('profile.settings');
        })->name('settings');
    });

    // Favorites API routes
    Route::prefix('favorites')->middleware('auth')->group(function () {
        Route::post('/', [App\Http\Controllers\FavoriteController::class, 'store'])->name('favorites.store');
        Route::delete('/{movieId}', [App\Http\Controllers\FavoriteController::class, 'destroy'])->name('favorites.destroy');
        Route::post('/toggle', [App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');
    });

    // Notifications API routes
    Route::prefix('notifications')->middleware('auth')->group(function () {
        Route::post('/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::post('/{notification}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::get('/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    });
});

// Test route untuk settings
Route::get('/profile/settings', function () {
    return view('profile.settings');
})->name('profile.settings')->middleware(['auth', 'verified']);

/*
|--------------------------------------------------------------------------
| Active Users Only Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'active_user'])->group(function () {
    // Routes yang memerlukan user aktif
    // Route untuk transaksi, booking, dll
});

/*
|--------------------------------------------------------------------------
| Admin Routes (will be implemented later)
|--------------------------------------------------------------------------
*/

// Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin panel routes
// });

require __DIR__.'/auth.php';
