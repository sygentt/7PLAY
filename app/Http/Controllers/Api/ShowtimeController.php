<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use Illuminate\Http\JsonResponse;

class ShowtimeController extends Controller
{
    /**
     * Get showtime details for API
     */
    public function show(Showtime $showtime): JsonResponse
    {
        try {
            // Load necessary relationships
            $showtime->load([
                'movie:id,title,poster_url,duration,genre,rating',
                'cinemaHall.cinema.city:id,name',
                'cinemaHall:id,cinema_id,name,total_seats'
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $showtime->id,
                    'movie' => [
                        'id' => $showtime->movie->id,
                        'title' => $showtime->movie->title,
                        'poster' => $showtime->movie->poster_url,
                        'duration' => $showtime->movie->duration,
                        'genre' => $showtime->movie->genre,
                        'rating' => $showtime->movie->rating,
                    ],
                    'cinema' => [
                        'id' => $showtime->cinemaHall->cinema->id,
                        'name' => $showtime->cinemaHall->cinema->name,
                        'full_name' => $showtime->cinemaHall->cinema->full_name,
                        'brand' => $showtime->cinemaHall->cinema->brand,
                        'address' => $showtime->cinemaHall->cinema->address,
                        'city' => $showtime->cinemaHall->cinema->city->name ?? 'Unknown',
                    ],
                    'cinema_hall' => [
                        'id' => $showtime->cinemaHall->id,
                        'name' => $showtime->cinemaHall->name,
                        'total_seats' => $showtime->cinemaHall->total_seats,
                    ],
                    'show_date' => $showtime->show_date?->format('Y-m-d'),
                    'show_time' => $showtime->show_time?->format('H:i'),
                    'price' => $showtime->price,
                    'formatted_price' => $showtime->getFormattedPrice(),
                    'formatted_time' => $showtime->getFormattedTime(),
                    'formatted_date' => $showtime->show_date?->format('d F Y'),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Showtime not found or data incomplete',
                'error' => app()->environment('local') ? $e->getMessage() : null,
            ], 404);
        }
    }
}
