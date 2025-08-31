<?php

namespace Database\Seeders;

use App\Models\Showtime;
use App\Models\Movie;
use App\Models\CinemaHall;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ShowtimeSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $movies = Movie::active()->get();
        $cinemaHalls = CinemaHall::active()->with('cinema.city')->get();

        if ($movies->isEmpty() || $cinemaHalls->isEmpty()) {
            $this->command->warn('⚠️ No active movies or cinema halls found. Please run MovieSeeder and CinemaHallSeeder first.');
            return;
        }

        $timeSlots = [
            '10:00', '12:30', '15:00', '17:30', '20:00', '22:30'
        ];

        $basePrices = [
            'regular' => [35000, 40000, 45000],
            'premium' => [50000, 60000, 70000],
            'imax' => [70000, 80000, 90000],
            '4dx' => [80000, 100000, 120000],
        ];

        // Generate showtimes for next 30 days
        for ($day = 0; $day < 30; $day++) {
            $date = Carbon::now()->addDays($day);
            
            // Skip past dates
            if ($date->isPast() && !$date->isToday()) {
                continue;
            }

            foreach ($cinemaHalls as $hall) {
                // Each hall gets 2-4 showtimes per day
                $dailyShowtimes = rand(2, 4);
                $selectedTimeSlots = array_rand($timeSlots, $dailyShowtimes);
                
                if (!is_array($selectedTimeSlots)) {
                    $selectedTimeSlots = [$selectedTimeSlots];
                }

                foreach ($selectedTimeSlots as $timeIndex) {
                    $time = $timeSlots[$timeIndex];
                    
                    // Skip past times for today
                    if ($date->isToday() && Carbon::createFromFormat('H:i', $time)->isPast()) {
                        continue;
                    }

                    // Random movie for this showtime
                    $movie = $movies->random();
                    
                    // Base price based on hall type
                    $basePrice = $basePrices[$hall->type][array_rand($basePrices[$hall->type])];
                    
                    // Weekend premium (Friday-Sunday)
                    if (in_array($date->dayOfWeek, [5, 6, 0])) {
                        $basePrice += 10000;
                    }
                    
                    // Evening premium (after 18:00)
                    if (Carbon::createFromFormat('H:i', $time)->hour >= 18) {
                        $basePrice += 5000;
                    }

                    Showtime::create([
                        'movie_id' => $movie->id,
                        'cinema_hall_id' => $hall->id,
                        'show_date' => $date->format('Y-m-d'),
                        'show_time' => $time,
                        'price' => $basePrice,
                        'available_seats' => $hall->total_seats,
                        'is_active' => rand(0, 10) > 1, // 90% chance of being active
                    ]);
                }
            }
        }

        $totalShowtimes = Showtime::count();
        $this->command->info("✅ Showtimes seeded successfully! Added {$totalShowtimes} showtimes for the next 30 days.");
    }
}
