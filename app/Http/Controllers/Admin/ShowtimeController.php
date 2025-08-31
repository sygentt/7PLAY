<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\City;
use App\Models\CinemaHall;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class ShowtimeController extends Controller
{
    /**
     * Display a listing of showtimes.
     */
    public function index(Request $request): View
    {
        $query = Showtime::query()
            ->with(['movie', 'cinemaHall.cinema.city']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('movie', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })->orWhereHas('cinemaHall.cinema', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter by movie
        if ($request->filled('movie_id')) {
            $query->byMovie($request->movie_id);
        }

        // Filter by cinema
        if ($request->filled('cinema_id')) {
            $query->byCinema($request->cinema_id);
        }

        // Filter by city
        if ($request->filled('city_id')) {
            $query->byCity($request->city_id);
        }

        // Filter by date
        if ($request->filled('show_date')) {
            $query->byDate($request->show_date);
        }

        // Filter by date range
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->byDate(Carbon::today());
                    break;
                case 'tomorrow':
                    $query->byDate(Carbon::tomorrow());
                    break;
                case 'this_week':
                    $query->whereBetween('show_date', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'past':
                    $query->past();
                    break;
            }
        }

        // Filter by active status
        if ($request->filled('active_status')) {
            if ($request->active_status === 'active') {
                $query->active();
            } elseif ($request->active_status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sort functionality
        $sortField = $request->get('sort', 'show_date');
        $sortDirection = $request->get('direction', 'asc');
        
        $allowedSorts = ['show_date', 'show_time', 'price', 'created_at'];
        if (in_array($sortField, $allowedSorts)) {
            if ($sortField === 'show_date') {
                $query->orderBy('show_date', $sortDirection)
                      ->orderBy('show_time', 'asc');
            } else {
                $query->orderBy($sortField, $sortDirection);
            }
        }

        $showtimes = $query->paginate(15)->appends($request->all());

        // Get filter options
        $movies = Movie::active()->orderBy('title')->get();
        $cities = City::active()->orderBy('name')->get();
        $cinemas = Cinema::active()->orderBy('name')->get();

        // Statistics
        $stats = [
            'total' => Showtime::count(),
            'today' => Showtime::byDate(Carbon::today())->count(),
            'upcoming' => Showtime::upcoming()->count(),
            'past' => Showtime::past()->count(),
        ];

        return view('admin.showtimes.index', compact('showtimes', 'movies', 'cities', 'cinemas', 'stats'));
    }

    /**
     * Show the form for creating a new showtime.
     */
    public function create(): View
    {
        $movies = Movie::active()->byStatus(Movie::STATUS_NOW_PLAYING)->orderBy('title')->get();
        $cities = City::active()->orderBy('name')->get();
        $cinemas = Cinema::active()->with('cinema_halls')->orderBy('name')->get();
        
        return view('admin.showtimes.create', compact('movies', 'cities', 'cinemas'));
    }

    /**
     * Store a newly created showtime in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'movie_id' => ['required', 'exists:movies,id'],
            'cinema_hall_id' => ['required', 'exists:cinema_halls,id'],
            'show_date' => ['required', 'date', 'after_or_equal:today'],
            'show_time' => ['required', 'date_format:H:i'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'is_active' => ['boolean'],
        ]);

        // Check for time conflicts
        $conflictingShowtime = Showtime::where('cinema_hall_id', $validated['cinema_hall_id'])
            ->where('show_date', $validated['show_date'])
            ->where('show_time', $validated['show_time'])
            ->first();

        if ($conflictingShowtime) {
            return back()
                ->withInput()
                ->withErrors(['show_time' => 'Sudah ada jadwal tayang pada waktu yang sama di studio ini.']);
        }

        $validated['is_active'] = $request->has('is_active');
        
        // Set available_seats from cinema hall
        $cinemaHall = CinemaHall::find($validated['cinema_hall_id']);
        $validated['available_seats'] = $cinemaHall->total_seats;

        $showtime = Showtime::create($validated);

        return redirect()
            ->route('admin.showtimes.index')
            ->with('success', "Jadwal tayang untuk film '{$showtime->movie->title}' berhasil ditambahkan.");
    }

    /**
     * Display the specified showtime.
     */
    public function show(Showtime $showtime): View
    {
        $showtime->load(['movie', 'cinemaHall.cinema.city', 'seatReservations']);
        
        return view('admin.showtimes.show', compact('showtime'));
    }

    /**
     * Show the form for editing the specified showtime.
     */
    public function edit(Showtime $showtime): View
    {
        $showtime->load(['movie', 'cinemaHall.cinema']);
        
        $movies = Movie::active()->orderBy('title')->get();
        $cities = City::active()->orderBy('name')->get();
        $cinemas = Cinema::active()->with('cinema_halls')->orderBy('name')->get();
        
        return view('admin.showtimes.edit', compact('showtime', 'movies', 'cities', 'cinemas'));
    }

    /**
     * Update the specified showtime in storage.
     */
    public function update(Request $request, Showtime $showtime): RedirectResponse
    {
        $validated = $request->validate([
            'movie_id' => ['required', 'exists:movies,id'],
            'cinema_hall_id' => ['required', 'exists:cinema_halls,id'],
            'show_date' => ['required', 'date', 'after_or_equal:today'],
            'show_time' => ['required', 'date_format:H:i'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'is_active' => ['boolean'],
        ]);

        // Check for time conflicts (excluding current showtime)
        $conflictingShowtime = Showtime::where('cinema_hall_id', $validated['cinema_hall_id'])
            ->where('show_date', $validated['show_date'])
            ->where('show_time', $validated['show_time'])
            ->where('id', '!=', $showtime->id)
            ->first();

        if ($conflictingShowtime) {
            return back()
                ->withInput()
                ->withErrors(['show_time' => 'Sudah ada jadwal tayang pada waktu yang sama di studio ini.']);
        }

        $validated['is_active'] = $request->has('is_active');

        $showtime->update($validated);

        return redirect()
            ->route('admin.showtimes.index')
            ->with('success', "Jadwal tayang untuk film '{$showtime->movie->title}' berhasil diperbarui.");
    }

    /**
     * Remove the specified showtime from storage.
     */
    public function destroy(Showtime $showtime): RedirectResponse
    {
        // Check if showtime has reservations
        if ($showtime->seatReservations()->count() > 0) {
            return back()->with('error', "Tidak dapat menghapus jadwal tayang karena sudah ada reservasi kursi.");
        }

        $movieTitle = $showtime->movie->title;
        $showtime->delete();

        return redirect()
            ->route('admin.showtimes.index')
            ->with('success', "Jadwal tayang untuk film '{$movieTitle}' berhasil dihapus.");
    }

    /**
     * Toggle showtime active status
     */
    public function toggleStatus(Showtime $showtime): JsonResponse
    {
        $showtime->update(['is_active' => !$showtime->is_active]);
        
        $status = $showtime->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return response()->json([
            'success' => true,
            'message' => "Jadwal tayang berhasil {$status}.",
            'is_active' => $showtime->is_active,
        ]);
    }

    /**
     * Get cinema halls by cinema for AJAX requests
     */
    public function getCinemaHallsByCinema(Request $request, Cinema $cinema): JsonResponse
    {
        $cinemaHalls = $cinema->cinema_halls()
            ->active()
            ->select('id', 'name', 'type', 'total_seats')
            ->orderBy('name')
            ->get();

        return response()->json($cinemaHalls);
    }

    /**
     * Get showtimes by movie for AJAX requests
     */
    public function getShowtimesByMovie(Request $request, Movie $movie): JsonResponse
    {
        $query = $movie->showtimes()
            ->with('cinemaHall.cinema.city')
            ->upcoming()
            ->active();

        if ($request->filled('city_id')) {
            $query->byCity($request->city_id);
        }

        if ($request->filled('cinema_id')) {
            $query->byCinema($request->cinema_id);
        }

        $showtimes = $query->orderBy('show_date')
            ->orderBy('show_time')
            ->get();

        return response()->json($showtimes);
    }
}
