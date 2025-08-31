<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CinemaController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\ShowtimeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
// use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\ReportController;
// use App\Http\Controllers\Admin\CinemaHallController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. All these routes are prefixed with
| /admin and require authentication with admin role.
|
*/

// Admin Dashboard
Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Cities Management
Route::resource('cities', CityController::class)->names([
    'index' => 'admin.cities.index',
    'create' => 'admin.cities.create', 
    'store' => 'admin.cities.store',
    'show' => 'admin.cities.show',
    'edit' => 'admin.cities.edit',
    'update' => 'admin.cities.update',
    'destroy' => 'admin.cities.destroy',
]);
Route::patch('cities/{city}/toggle-status', [CityController::class, 'toggleStatus'])->name('admin.cities.toggle-status');

// Cinemas Management  
Route::resource('cinemas', CinemaController::class)->names([
    'index' => 'admin.cinemas.index',
    'create' => 'admin.cinemas.create',
    'store' => 'admin.cinemas.store', 
    'show' => 'admin.cinemas.show',
    'edit' => 'admin.cinemas.edit',
    'update' => 'admin.cinemas.update',
    'destroy' => 'admin.cinemas.destroy',
]);
Route::patch('cinemas/{cinema}/toggle-status', [CinemaController::class, 'toggleStatus'])->name('admin.cinemas.toggle-status');

// Movies Management
Route::resource('movies', MovieController::class)->names([
    'index' => 'admin.movies.index',
    'create' => 'admin.movies.create',
    'store' => 'admin.movies.store',
    'show' => 'admin.movies.show',
    'edit' => 'admin.movies.edit',
    'update' => 'admin.movies.update',
    'destroy' => 'admin.movies.destroy',
]);
Route::patch('movies/{movie}/toggle-status', [MovieController::class, 'toggleStatus'])->name('admin.movies.toggle-status');

// Showtimes Management
Route::resource('showtimes', ShowtimeController::class)->names([
    'index' => 'admin.showtimes.index',
    'create' => 'admin.showtimes.create',
    'store' => 'admin.showtimes.store',
    'show' => 'admin.showtimes.show',
    'edit' => 'admin.showtimes.edit',
    'update' => 'admin.showtimes.update',
    'destroy' => 'admin.showtimes.destroy',
]);
Route::patch('showtimes/{showtime}/toggle-status', [ShowtimeController::class, 'toggleStatus'])->name('admin.showtimes.toggle-status');
Route::get('api/cities/{city}/cinemas', [CityController::class, 'getCinemasByCity'])->name('admin.api.cities.cinemas');
Route::get('api/cinemas/{cinema}/halls', [ShowtimeController::class, 'getCinemaHallsByCinema'])->name('admin.api.cinemas.halls');

// Orders Management
Route::resource('orders', OrderController::class)->except(['create', 'store', 'edit', 'update'])->names([
    'index' => 'admin.orders.index',
    'show' => 'admin.orders.show',
    'destroy' => 'admin.orders.destroy',
]);
Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');

// Users Management
Route::resource('users', UserController::class)->names([
    'index' => 'admin.users.index',
    'create' => 'admin.users.create',
    'store' => 'admin.users.store',
    'show' => 'admin.users.show',
    'edit' => 'admin.users.edit',
    'update' => 'admin.users.update',
    'destroy' => 'admin.users.destroy',
]);
Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
Route::patch('users/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('admin.users.verify-email');
Route::patch('users/{user}/unverify-email', [UserController::class, 'unverifyEmail'])->name('admin.users.unverify-email');
Route::patch('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('admin.users.reset-password');

// Reports & Analytics
Route::prefix('reports')->name('admin.reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
    Route::get('/movies', [ReportController::class, 'movies'])->name('movies');
    Route::get('/users', [ReportController::class, 'users'])->name('users');
    Route::get('/chart-data', [ReportController::class, 'getChartData'])->name('chart-data');
});
