<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovieController extends Controller
{
    /**
     * Display a listing of movies
     */
    public function index(Request $request)
    {
        $movies = Movie::active()
            ->with(['showtimes'])
            ->when($request->status, function ($query, $status) {
                return $query->byStatus($status);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                            ->orWhere('genre', 'like', "%{$search}%")
                            ->orWhere('director', 'like', "%{$search}%");
            })
            ->orderBy('release_date', 'desc')
            ->paginate(12);

        return view('movies.index', compact('movies'));
    }

    /**
     * Display the specified movie with detailed information
     */
    public function show(Movie $movie, Request $request)
    {
        // Load movie with necessary relationships
        $movie->load([
            'showtimes' => function ($query) {
                $query->active()
                      ->upcoming()
                      ->with(['cinemaHall.cinema.city'])
                      ->orderBy('show_date')
                      ->orderBy('show_time');
            }
        ]);

        // Get available dates for the movie showtimes (next 7 days)
        $availableDates = collect();
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(6);
        
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $hasShowtimes = $movie->showtimes
                ->where('show_date', $date->format('Y-m-d'))
                ->isNotEmpty();
                
            $availableDates->push([
                'date' => $date->copy(),
                'formatted_day' => $date->format('D'),
                'formatted_date' => $date->format('d'),
                'has_showtimes' => $hasShowtimes,
                'is_today' => $date->isToday(),
            ]);
        }

        // Get selected date from request or default to today
        $selectedDate = $request->date ? Carbon::parse($request->date) : Carbon::today();
        
        // Filter showtimes by selected date
        $showtimesByDate = $movie->showtimes
            ->where('show_date', $selectedDate->format('Y-m-d'));

        // Group showtimes by cinema
        $showtimesByCinema = $showtimesByDate->groupBy(function ($showtime) {
            return $showtime->cinemaHall->cinema->id;
        });

        // Get unique cinemas that have showtimes for this movie
        $cinemas = Cinema::whereHas('cinema_halls.showtimes', function ($query) use ($movie, $selectedDate) {
            $query->where('movie_id', $movie->id)
                  ->whereDate('show_date', $selectedDate)
                  ->active()
                  ->upcoming();
        })
        ->with(['city', 'cinema_halls.showtimes' => function ($query) use ($movie, $selectedDate) {
            $query->where('movie_id', $movie->id)
                  ->whereDate('show_date', $selectedDate)
                  ->active()
                  ->upcoming()
                  ->orderBy('show_time');
        }])
        ->get();

        return view('movies.show', compact(
            'movie', 
            'availableDates', 
            'selectedDate', 
            'cinemas',
            'showtimesByCinema'
        ));
    }
}
