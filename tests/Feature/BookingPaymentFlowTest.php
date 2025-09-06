<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\City;
use App\Models\Cinema;
use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Seat;
use App\Models\Order;
use App\Models\UserVoucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingPaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_end_to_end_booking_to_checkin_minimal(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $city = City::create(['name' => 'Jakarta', 'is_active' => true]);
        $cinema = Cinema::create(['name' => '7PLAY Mall', 'city_id' => $city->id, 'is_active' => true]);
        $hall = CinemaHall::create(['cinema_id' => $cinema->id, 'name' => 'Hall 1', 'total_seats' => 10, 'is_active' => true]);
        $movie = Movie::create(['title' => 'Demo Movie', 'duration' => 120, 'genre' => 'Action', 'rating' => 'R13', 'is_active' => true]);
        $showtime = Showtime::create([
            'movie_id' => $movie->id,
            'cinema_hall_id' => $hall->id,
            'show_date' => now()->toDateString(),
            'show_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
            'price' => 50000,
            'available_seats' => 10,
            'is_active' => true,
        ]);
        // Buat beberapa kursi
        for ($i = 1; $i <= 5; $i++) {
            Seat::create(['cinema_hall_id' => $hall->id, 'row_label' => 'A', 'seat_number' => $i, 'type' => 'regular']);
        }

        // Reservasi kursi via endpoint
        $this->actingAs($user);
        $seatIds = [Seat::where('cinema_hall_id', $hall->id)->value('id')];
        $resp = $this->postJson(route('booking.reserve-seats'), [
            'showtime_id' => $showtime->id,
            'seat_ids' => $seatIds,
        ]);
        $resp->assertStatus(200)->assertJson(['success' => true]);
        $orderId = $resp['order_id'];
        $order = Order::findOrFail($orderId);

        // Terapkan voucher (opsional): skip jika tidak ada
        // Simulasikan pembayaran sukses (langsung set status & payment_date)
        $order->update(['status' => Order::STATUS_PAID, 'payment_date' => now()]);

        // Generate QR dan lakukan check-in
        $token = $order->generateQrToken();
        $checkin = $this->postJson('/admin/checkin', ['token' => $token]);
        $checkin->assertStatus(200)->assertJson(['success' => true]);
    }
}


