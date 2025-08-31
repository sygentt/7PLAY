<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Showtime;
use App\Models\Seat;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create some regular users first if they don't exist
        $users = User::where('is_admin', false)->get();
        
        if ($users->count() < 10) {
            for ($i = 0; $i < 10; $i++) {
                User::create([
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'password' => bcrypt('password'),
                    'phone' => fake()->phoneNumber(),
                    'is_admin' => false,
                ]);
            }
            $users = User::where('is_admin', false)->get();
        }

        $showtimes = Showtime::with(['cinemaHall.cinema', 'movie'])->get();
        
        if ($showtimes->isEmpty()) {
            $this->command->warn('⚠️ No showtimes found. Please run ShowtimeSeeder first.');
            return;
        }

        $statuses = ['pending', 'paid', 'confirmed', 'cancelled'];
        $paymentMethods = ['midtrans', 'qris', 'bank_transfer', 'wallet'];
        $orderCount = 0;

        // Generate orders for the last 90 days
        for ($day = 90; $day >= 0; $day--) {
            $date = Carbon::now()->subDays($day);
            
            // Random number of orders per day (0-15)
            $dailyOrders = rand(0, 15);
            
            for ($i = 0; $i < $dailyOrders; $i++) {
                $user = $users->random();
                $showtime = $showtimes->random();
                
                // Determine status based on date
                if ($date->isAfter(Carbon::now()->subDays(7))) {
                    // Recent orders - mix of all statuses
                    $status = $statuses[array_rand($statuses)];
                } elseif ($date->isAfter(Carbon::now()->subDays(30))) {
                    // Medium old orders - mostly confirmed/cancelled
                    $status = rand(0, 10) < 8 ? ($date->isPast() ? 'confirmed' : 'paid') : 'cancelled';
                } else {
                    // Old orders - mostly confirmed
                    $status = rand(0, 10) < 9 ? 'confirmed' : 'cancelled';
                }

                // Random number of tickets (1-4)
                $ticketCount = rand(1, 4);
                
                // Get available seats for this showtime
                $availableSeats = Seat::where('cinema_hall_id', $showtime->cinema_hall_id)
                    ->active()
                    ->inRandomOrder()
                    ->take($ticketCount)
                    ->get();
                
                if ($availableSeats->count() < $ticketCount) {
                    continue; // Skip if not enough seats
                }

                // Calculate pricing
                $basePrice = $showtime->price;
                $subtotal = $basePrice * $ticketCount;
                
                // Random discount (0-20%)
                $discountPercentage = rand(0, 20);
                $discountAmount = $subtotal * ($discountPercentage / 100);
                $totalAmount = $subtotal - $discountAmount;

                // Points
                $pointsUsed = rand(0, 1000);
                $pointsEarned = (int) ($totalAmount / 10000); // 1 point per 10k spending

                $order = Order::create([
                    'order_number' => Order::generateOrderNumber(),
                    'user_id' => $user->id,
                    'showtime_id' => $showtime->id,
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'total_amount' => $totalAmount,
                    'points_used' => $pointsUsed,
                    'points_earned' => $pointsEarned,
                    'status' => $status,
                    'payment_method' => in_array($status, ['paid', 'confirmed']) ? $paymentMethods[array_rand($paymentMethods)] : null,
                    'payment_reference' => in_array($status, ['paid', 'confirmed']) ? 'PAY-' . strtoupper(substr(md5(uniqid()), 0, 10)) : null,
                    'payment_date' => in_array($status, ['paid', 'confirmed']) ? $date->addHours(rand(0, 2))->addMinutes(rand(0, 59)) : null,
                    'expiry_date' => $status === 'pending' ? $date->addHours(2) : null,
                    'qr_code' => in_array($status, ['confirmed']) ? 'QR-' . strtoupper(substr(md5(uniqid()), 0, 12)) : null,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);

                // Create order items for each seat
                foreach ($availableSeats as $seat) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'seat_id' => $seat->id,
                        'price' => $basePrice,
                        'status' => $status === 'cancelled' ? 'cancelled' : 'booked',
                    ]);
                }

                $orderCount++;
            }
        }

        $this->command->info("✅ Orders seeded successfully! Added {$orderCount} orders with order items.");
        
        // Display statistics
        $stats = [
            'Total Orders' => Order::count(),
            'Pending' => Order::where('status', 'pending')->count(),
            'Paid' => Order::where('status', 'paid')->count(),
            'Confirmed' => Order::where('status', 'confirmed')->count(),
            'Cancelled' => Order::where('status', 'cancelled')->count(),
            'Total Revenue' => 'Rp ' . number_format(Order::where('status', 'confirmed')->sum('total_amount'), 0, ',', '.'),
        ];

        foreach ($stats as $label => $value) {
            $this->command->info("   {$label}: {$value}");
        }
    }
}
