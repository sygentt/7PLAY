<?php

namespace Database\Seeders;

use App\Models\CinemaHall;
use App\Models\Cinema;
use Illuminate\Database\Seeder;

class CinemaHallSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $cinemas = Cinema::all();

        $hallTypes = ['regular', 'premium', 'imax', '4dx'];
        $hallNames = ['Studio 1', 'Studio 2', 'Studio 3', 'Studio 4', 'Studio 5', 'Studio 6'];

        foreach ($cinemas as $cinema) {
            // Each cinema gets 3-6 halls
            $hallCount = rand(3, 6);
            
            for ($i = 1; $i <= $hallCount; $i++) {
                $type = $hallTypes[array_rand($hallTypes)];
                
                // Different seating capacity based on type
                $seatingConfig = match($type) {
                    'regular' => ['rows' => rand(8, 12), 'seats_per_row' => rand(12, 16)],
                    'premium' => ['rows' => rand(6, 8), 'seats_per_row' => rand(10, 14)],
                    'imax' => ['rows' => rand(12, 16), 'seats_per_row' => rand(16, 20)],
                    '4dx' => ['rows' => rand(6, 8), 'seats_per_row' => rand(8, 12)],
                    default => ['rows' => rand(8, 12), 'seats_per_row' => rand(12, 16)]
                };

                $totalSeats = $seatingConfig['rows'] * $seatingConfig['seats_per_row'];

                CinemaHall::create([
                    'cinema_id' => $cinema->id,
                    'name' => $hallNames[$i - 1] ?? "Studio $i",
                    'total_seats' => $totalSeats,
                    'rows' => $seatingConfig['rows'],
                    'seats_per_row' => $seatingConfig['seats_per_row'],
                    'type' => $type,
                    'is_active' => rand(0, 10) > 1, // 90% chance of being active
                ]);
            }
        }

        $this->command->info('✅ Cinema halls seeded successfully! Added halls for ' . $cinemas->count() . ' cinemas.');
    }
}
