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
        $query = Movie::active()->with(['showtimes']);
        
        // Filter by status (now_playing or coming_soon)
        if ($request->status) {
            $query->byStatus($request->status);
        } else {
            // Default to now_playing if no status specified
            $query->byStatus('now_playing');
        }
        
        // Search filter
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%")
                  ->orWhere('director', 'like', "%{$search}%")
                  ->orWhere('synopsis', 'like', "%{$search}%");
            });
        }
        
        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('release_date', 'asc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'rating':
                $query->orderByDesc('rating')->orderBy('title', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('release_date', 'desc');
                break;
        }
        
        // Add secondary sorting for consistency
        if ($sort !== 'title') {
            $query->orderBy('title', 'asc');
        }
        
        $movies = $query->paginate(12)->withQueryString();
        $favoriteIds = [];
        if ($request->user()) {
            $favoriteIds = $request->user()->favorites()->pluck('movie_id')->toArray();
        }
        
        // Pass current page info for navigation
        $current_page = 'movies';
        
        return view('movies.index', compact('movies', 'current_page', 'favoriteIds'));
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
                ->filter(function ($showtime) use ($date) {
                    return optional($showtime->show_date)->isSameDay($date);
                })
                ->isNotEmpty();

            // Hanya tampilkan tanggal yang memiliki showtime
            if (! $hasShowtimes) {
                continue;
            }
                
            $availableDates->push([
                'date' => $date->copy(),
                'formatted_day' => ucfirst($date->locale(app()->getLocale())->translatedFormat('D')),
                'formatted_date' => $date->format('d'),
                'has_showtimes' => true,
                'is_today' => $date->isToday(),
            ]);
        }

        // Get selected date from request or default to today
        $selectedDate = $request->date ? Carbon::parse($request->date) : Carbon::today();

        // Optional filters from request
        $brandFilter = $request->string('brand')->trim()->toString();
        $searchQuery = $request->string('q')->trim()->toString();
        
        // Filter showtimes by selected date
        $showtimesByDate = $movie->showtimes
            ->filter(function ($showtime) use ($selectedDate) {
                return optional($showtime->show_date)->isSameDay($selectedDate);
            });

        // Group showtimes by cinema
        $showtimesByCinema = $showtimesByDate->groupBy(function ($showtime) {
            return $showtime->cinemaHall->cinema->id;
        });

        // Get unique cinemas that have showtimes for this movie, with optional brand/search filters
        $cinemas = Cinema::query()
        ->whereHas('cinema_halls.showtimes', function ($query) use ($movie, $selectedDate) {
            $query->where('movie_id', $movie->id)
                  ->whereDate('show_date', $selectedDate)
                  ->active()
                  ->upcoming();
        })
        ->when($brandFilter !== '', function ($q) use ($brandFilter) {
            $q->where('brand', $brandFilter);
        })
        ->when($searchQuery !== '', function ($q) use ($searchQuery) {
            $q->where('name', 'like', "%{$searchQuery}%");
        })
        ->with(['city', 'cinema_halls.showtimes' => function ($query) use ($movie, $selectedDate) {
            $query->where('movie_id', $movie->id)
                  ->whereDate('show_date', $selectedDate)
                  ->active()
                  ->upcoming()
                  ->orderBy('show_time');
        }])
        ->get();

        $isFavorited = $request->user() ? $request->user()->hasFavorited($movie->id) : false;

        return view('movies.show', compact(
            'movie', 
            'availableDates', 
            'selectedDate', 
            'cinemas',
            'showtimesByCinema',
            'isFavorited'
        ));
    }
}
