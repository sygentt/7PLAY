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

                    // Get eligible movies for this date
                    $eligibleMovies = $this->getEligibleMoviesForDate($movies, $date);
                    
                    if ($eligibleMovies->isEmpty()) {
                        continue;
                    }

                    // Random movie for this showtime from eligible movies
                    $movie = $eligibleMovies->random();
                    
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
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Ensure every eligible movie has at least one showtime per day for the next 7 days
        for ($day = 0; $day < 7; $day++) {
            $date = Carbon::now()->addDays($day);
            
            // Get eligible movies for this date
            $eligibleMovies = $this->getEligibleMoviesForDate($movies, $date);

            foreach ($eligibleMovies as $movie) {
                $existsForDate = Showtime::where('movie_id', $movie->id)
                    ->whereDate('show_date', $date->format('Y-m-d'))
                    ->exists();

                if ($existsForDate) {
                    continue;
                }

                // Pick a random hall
                $hall = $cinemaHalls->random();

                // Choose an available time slot (avoid past times for today)
                $candidateSlots = $timeSlots;
                if ($date->isToday()) {
                    $candidateSlots = array_values(array_filter($timeSlots, function ($slot) {
                        return !Carbon::createFromFormat('H:i', $slot)->isPast();
                    }));
                    if (empty($candidateSlots)) {
                        continue; // no valid slot left for today
                    }
                }
                $time = $candidateSlots[array_rand($candidateSlots)];

                // Avoid collision in the same hall at the same time
                $collision = Showtime::where('cinema_hall_id', $hall->id)
                    ->whereDate('show_date', $date->format('Y-m-d'))
                    ->where('show_time', $time)
                    ->exists();
                if ($collision) {
                    foreach ($timeSlots as $slotTry) {
                        if ($date->isToday() && Carbon::createFromFormat('H:i', $slotTry)->isPast()) {
                            continue;
                        }
                        $collision = Showtime::where('cinema_hall_id', $hall->id)
                            ->whereDate('show_date', $date->format('Y-m-d'))
                            ->where('show_time', $slotTry)
                            ->exists();
                        if (! $collision) {
                            $time = $slotTry;
                            break;
                        }
                    }
                }

                // Compute price similar to the main loop
                $basePrice = $basePrices[$hall->type][array_rand($basePrices[$hall->type])];
                if (in_array($date->dayOfWeek, [5, 6, 0])) {
                    $basePrice += 10000; // weekend premium
                }
                if (Carbon::createFromFormat('H:i', $time)->hour >= 18) {
                    $basePrice += 5000; // evening premium
                }

                Showtime::create([
                    'movie_id' => $movie->id,
                    'cinema_hall_id' => $hall->id,
                    'show_date' => $date->format('Y-m-d'),
                    'show_time' => $time,
                    'price' => $basePrice,
                    'available_seats' => $hall->total_seats,
                    'is_active' => true,
                ]);
            }
        }

        $totalShowtimes = Showtime::count();
        $this->command->info("✅ Showtimes seeded successfully! Added {$totalShowtimes} showtimes for the next 30 days.");
        $this->showShowtimeStatistics();
    }

    /**
     * Get eligible movies for a specific date
     * Coming soon movies can only have showtimes starting 3 days after release date
     */
    private function getEligibleMoviesForDate($movies, Carbon $date)
    {
        return $movies->filter(function ($movie) use ($date) {
            // If movie is coming soon, check if date is at least 3 days after release date
            if ($movie->status === Movie::STATUS_COMING_SOON) {
                $releaseDate = Carbon::parse($movie->release_date);
                $ticketSaleDate = $releaseDate->copy()->addDays(3);
                
                // Ticket can only be sold starting from release_date + 3 days
                return $date->greaterThanOrEqualTo($ticketSaleDate);
            }
            
            // For now playing and finished movies, always eligible
            return true;
        });
    }

    /**
     * Show showtime statistics after seeding
     */
    private function showShowtimeStatistics(): void
    {
        $nowPlayingShowtimes = Showtime::whereHas('movie', function ($query) {
            $query->where('status', Movie::STATUS_NOW_PLAYING);
        })->count();

        $comingSoonShowtimes = Showtime::whereHas('movie', function ($query) {
            $query->where('status', Movie::STATUS_COMING_SOON);
        })->count();

        $this->command->info('');
        $this->command->info('📊 Showtime Statistics:');
        $this->command->info('┌─────────────────────┬───────┐');
        $this->command->info('│ Category            │ Count │');
        $this->command->info('├─────────────────────┼───────┤');
        $this->command->info(sprintf('│ Now Playing Shows   │ %-5s │', $nowPlayingShowtimes));
        $this->command->info(sprintf('│ Coming Soon Shows   │ %-5s │', $comingSoonShowtimes));
        $this->command->info('└─────────────────────┴───────┘');
        $this->command->info('');
        $this->command->info('📅 Note: Coming Soon movie tickets are available 3 days after release date');
        $this->command->info('');
    }
}
