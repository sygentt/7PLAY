<?php

namespace Database\Seeders;

use App\Models\Seat;
use App\Models\CinemaHall;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $cinemaHalls = CinemaHall::all();

        foreach ($cinemaHalls as $hall) {
            $rowLabels = range('A', chr(ord('A') + $hall->rows - 1));
            
            foreach ($rowLabels as $rowLabel) {
                for ($seatNumber = 1; $seatNumber <= $hall->seats_per_row; $seatNumber++) {
                    // Determine seat type based on position and hall type
                    $seatType = 'regular';
                    
                    if ($hall->type === 'premium') {
                        // Premium halls have more premium seats
                        if (in_array($rowLabel, ['C', 'D', 'E']) && $seatNumber >= 4 && $seatNumber <= ($hall->seats_per_row - 3)) {
                            $seatType = 'premium';
                        }
                    } elseif ($hall->type === 'regular') {
                        // Regular halls have fewer premium seats
                        if (in_array($rowLabel, ['D', 'E']) && $seatNumber >= 6 && $seatNumber <= ($hall->seats_per_row - 5)) {
                            $seatType = 'premium';
                        }
                    }
                    
                    // Add wheelchair accessible seats (first row, ends)
                    if ($rowLabel === 'A' && ($seatNumber <= 2 || $seatNumber >= ($hall->seats_per_row - 1))) {
                        $seatType = 'wheelchair';
                    }

                    Seat::create([
                        'cinema_hall_id' => $hall->id,
                        'row_label' => $rowLabel,
                        'seat_number' => $seatNumber,
                        'type' => $seatType,
                        'is_active' => rand(0, 20) > 0, // 95% chance of being active
                    ]);
                }
            }
        }

        $totalSeats = Seat::count();
        $this->command->info("✅ Seats seeded successfully! Added {$totalSeats} seats across all cinema halls.");
    }
}
