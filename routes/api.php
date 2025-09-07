<?php

use App\Http\Controllers\Api\ShowtimeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Showtime;
use App\Models\SeatReservation;
use App\Models\Order;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public APIs
Route::get('/movies', function () {
    return Movie::active()->select('id','title','genre','rating','duration','poster_url')->paginate(20);
});

Route::get('/cinemas', function () {
    return Cinema::active()->with('city:id,name')->select('id','name','city_id')->paginate(50);
});

Route::get('/movies/{movie}/showtimes', function (Movie $movie) {
    $showtimes = Showtime::where('movie_id', $movie->id)
        ->active()
        ->upcoming()
        ->with(['cinemaHall.cinema.city'])
        ->orderBy('show_date')
        ->orderBy('show_time')
        ->get();

    return [
        'movie' => $movie->only(['id', 'title']),
        'showtimes' => $showtimes,
    ];
});

Route::get('/seats/availability/{showtime}', function (Showtime $showtime) {
    $reserved = SeatReservation::query()
        ->where('showtime_id', $showtime->id)
        ->where('status', 'reserved')
        ->where('expires_at', '>', now())
        ->pluck('seat_id');
    $confirmed = \App\Models\OrderItem::whereHas('order', function($q) use ($showtime) {
            $q->completed()->where('showtime_id', $showtime->id);
        })
        ->pluck('seat_id');
    return [
        'showtime_id' => $showtime->id,
        'unavailable_seat_ids' => $reserved->merge($confirmed)->unique()->values(),
    ];
});

Route::get('/orders/{order}/status', function (Order $order) {
    return [
        'order_id' => $order->id,
        'status' => $order->status,
        'is_completed' => in_array($order->status, [Order::STATUS_PAID, Order::STATUS_CONFIRMED], true),
    ];
})->middleware('auth:sanctum');

// Public API routes
Route::get('/showtimes/{showtime}', [ShowtimeController::class, 'show']);
