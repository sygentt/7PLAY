<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MovieController extends Controller
{
    /**
     * Display a listing of movies.
     */
    public function index(Request $request): View
    {
        $query = Movie::query()->withCount('showtimes');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('director', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%")
                  ->orWhere('language', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by genre
        if ($request->filled('genre')) {
            $query->where('genre', 'like', "%{$request->genre}%");
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
        $sortField = $request->get('sort', 'title');
        $sortDirection = $request->get('direction', 'asc');
        
        $allowedSorts = ['title', 'genre', 'duration', 'rating', 'release_date', 'status', 'created_at'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $movies = $query->paginate(12)->appends($request->all());

        // Get filter options
        $statuses = Movie::getStatuses();
        $ratings = Movie::getRatings();
        $genres = Movie::distinct()->pluck('genre')->filter()->sort();

        // Statistics
        $stats = [
            'total' => Movie::count(),
            'now_playing' => Movie::byStatus(Movie::STATUS_NOW_PLAYING)->count(),
            'coming_soon' => Movie::byStatus(Movie::STATUS_COMING_SOON)->count(),
            'finished' => Movie::byStatus(Movie::STATUS_FINISHED)->count(),
        ];

        return view('admin.movies.index', compact('movies', 'statuses', 'ratings', 'genres', 'stats'));
    }

    /**
     * Show the form for creating a new movie.
     */
    public function create(): View
    {
        $statuses = Movie::getStatuses();
        $ratings = Movie::getRatings();
        
        return view('admin.movies.create', compact('statuses', 'ratings'));
    }

    /**
     * Store a newly created movie in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'synopsis' => ['required', 'string'],
            'genre' => ['required', 'string', 'max:100'],
            'duration' => ['required', 'integer', 'min:1', 'max:300'],
            'rating' => ['required', 'string', Rule::in(array_keys(Movie::getRatings()))],
            'language' => ['required', 'string', 'max:50'],
            'director' => ['required', 'string', 'max:255'],
            'cast' => ['required', 'string'],
            'release_date' => ['required', 'date'],
            'status' => ['required', 'string', Rule::in(array_keys(Movie::getStatuses()))],
            'poster_url' => ['nullable', 'url'],
            'trailer_url' => ['nullable', 'url'],
            'is_active' => ['boolean'],
        ]);

        // Convert cast string to array
        $validated['cast'] = array_map('trim', explode(',', $validated['cast']));
        $validated['is_active'] = $request->has('is_active');

        $movie = Movie::create($validated);

        return redirect()
            ->route('admin.movies.index')
            ->with('success', "Film '{$movie->title}' berhasil ditambahkan.");
    }

    /**
     * Display the specified movie.
     */
    public function show(Movie $movie): View
    {
        $movie->load('showtimes.cinemaHall.cinema.city');
        
        return view('admin.movies.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified movie.
     */
    public function edit(Movie $movie): View
    {
        $statuses = Movie::getStatuses();
        $ratings = Movie::getRatings();
        
        return view('admin.movies.edit', compact('movie', 'statuses', 'ratings'));
    }

    /**
     * Update the specified movie in storage.
     */
    public function update(Request $request, Movie $movie): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'synopsis' => ['required', 'string'],
            'genre' => ['required', 'string', 'max:100'],
            'duration' => ['required', 'integer', 'min:1', 'max:300'],
            'rating' => ['required', 'string', Rule::in(array_keys(Movie::getRatings()))],
            'language' => ['required', 'string', 'max:50'],
            'director' => ['required', 'string', 'max:255'],
            'cast' => ['required', 'string'],
            'release_date' => ['required', 'date'],
            'status' => ['required', 'string', Rule::in(array_keys(Movie::getStatuses()))],
            'poster_url' => ['nullable', 'url'],
            'trailer_url' => ['nullable', 'url'],
            'is_active' => ['boolean'],
        ]);

        // Convert cast string to array
        $validated['cast'] = array_map('trim', explode(',', $validated['cast']));
        $validated['is_active'] = $request->has('is_active');

        $movie->update($validated);

        return redirect()
            ->route('admin.movies.index')
            ->with('success', "Film '{$movie->title}' berhasil diperbarui.");
    }

    /**
     * Remove the specified movie from storage.
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        // Check if movie has showtimes
        if ($movie->showtimes()->count() > 0) {
            return back()->with('error', "Tidak dapat menghapus film '{$movie->title}' karena masih memiliki jadwal tayang.");
        }

        $movieTitle = $movie->title;
        $movie->delete();

        return redirect()
            ->route('admin.movies.index')
            ->with('success', "Film '{$movieTitle}' berhasil dihapus.");
    }

    /**
     * Toggle movie active status
     */
    public function toggleStatus(Movie $movie): JsonResponse
    {
        $movie->update(['is_active' => !$movie->is_active]);
        
        $status = $movie->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return response()->json([
            'success' => true,
            'message' => "Film '{$movie->title}' berhasil {$status}.",
            'is_active' => $movie->is_active,
        ]);
    }

    /**
     * Get movies for AJAX requests
     */
    public function getMovies(Request $request): JsonResponse
    {
        $query = Movie::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        $movies = $query->active()
            ->select('id', 'title', 'genre', 'duration', 'rating', 'status')
            ->orderBy('title')
            ->get();

        return response()->json($movies);
    }
}
