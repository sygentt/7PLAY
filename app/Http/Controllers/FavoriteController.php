<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\UserFavorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    /**
     * Display a listing of user's favorite movies.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $favorites = $user->favoriteMovies()
            ->with(['showtimes' => function ($query) {
                $query->where('show_time', '>=', now())
                      ->orderBy('show_time')
                      ->take(3);
            }])
            ->orderBy('user_favorites.created_at', 'desc')
            ->paginate(12);

        return view('profile.favorites', compact('favorites'));
    }

    /**
     * Add a movie to user's favorites.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id'
        ]);

        $user = $request->user();
        $movieId = $request->movie_id;

        // Check if already favorited
        if ($user->hasFavorited($movieId)) {
            return response()->json([
                'success' => false,
                'message' => 'Film sudah ada di daftar favorit Anda.'
            ], 409);
        }

        $favorite = UserFavorite::create([
            'user_id' => $user->id,
            'movie_id' => $movieId
        ]);

        $movie = Movie::find($movieId);

        return response()->json([
            'success' => true,
            'message' => "Film \"{$movie->title}\" berhasil ditambahkan ke favorit!",
            'favorited' => true
        ]);
    }

    /**
     * Remove a movie from user's favorites.
     */
    public function destroy(Request $request, int $movieId): JsonResponse
    {
        $user = $request->user();
        
        $favorite = UserFavorite::where('user_id', $user->id)
                                ->where('movie_id', $movieId)
                                ->first();

        if (!$favorite) {
            return response()->json([
                'success' => false,
                'message' => 'Film tidak ditemukan di daftar favorit Anda.'
            ], 404);
        }

        $movie = Movie::find($movieId);
        $favorite->delete();

        return response()->json([
            'success' => true,
            'message' => "Film \"{$movie->title}\" berhasil dihapus dari favorit!",
            'favorited' => false
        ]);
    }

    /**
     * Toggle favorite status for a movie.
     */
    public function toggle(Request $request): JsonResponse
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id'
        ]);

        $user = $request->user();
        $movieId = $request->movie_id;

        $favorite = UserFavorite::where('user_id', $user->id)
                                ->where('movie_id', $movieId)
                                ->first();

        $movie = Movie::find($movieId);

        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            
            return response()->json([
                'success' => true,
                'message' => "Film \"{$movie->title}\" dihapus dari favorit!",
                'favorited' => false
            ]);
        } else {
            // Add to favorites
            UserFavorite::create([
                'user_id' => $user->id,
                'movie_id' => $movieId
            ]);

            return response()->json([
                'success' => true,
                'message' => "Film \"{$movie->title}\" ditambahkan ke favorit!",
                'favorited' => true
            ]);
        }
    }
}
