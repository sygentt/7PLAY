<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\City;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data nyata dari database
        $nowPlayingModels = Movie::query()
            ->active()
            ->byStatus(Movie::STATUS_NOW_PLAYING)
            ->latest('release_date')
            ->take(20)
            ->get();

        $comingSoonModels = Movie::query()
            ->active()
            ->byStatus(Movie::STATUS_COMING_SOON)
            ->oldest('release_date')
            ->take(20)
            ->get();

        $citiesModels = City::query()->active()->orderBy('name')->get(['id', 'name']);

        // Helper untuk placeholder gambar
        $posterPlaceholder = function (string $title): string {
            $text = urlencode(Str::limit($title ?: 'Poster', 30, '…'));
            return "https://dummyimage.com/500x750/e5e7eb/374151.jpg&text={$text}";
        };
        $bannerPlaceholder = function (string $title): string {
            $text = urlencode(Str::limit($title ?: 'Banner', 30, '…'));
            return "https://dummyimage.com/1600x600/e5e7eb/374151.jpg&text={$text}";
        };

        // Petakan ke struktur yang digunakan komponen Blade saat ini (array associative)
        $now_playing = $nowPlayingModels->map(function (Movie $movie) use ($posterPlaceholder, $bannerPlaceholder) {
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'poster' => $movie->poster_url ?: $posterPlaceholder($movie->title),
                'banner' => $movie->poster_url ?: $bannerPlaceholder($movie->title),
                'genre' => $movie->genre,
                // Komponen memakai angka rating 1-10; tabel menyimpan klasifikasi usia.
                // Jika hanya punya klasifikasi usia, sembunyikan badge rating dengan null.
                'rating' => null,
                'duration' => $movie->getFormattedDuration(),
                'release_date' => optional($movie->release_date)->toDateString(),
                'description' => Str::limit($movie->synopsis, 180),
                'trailer_url' => $movie->trailer_url,
            ];
        })->values()->all();

        $coming_soon = $comingSoonModels->map(function (Movie $movie) use ($posterPlaceholder, $bannerPlaceholder) {
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'poster' => $movie->poster_url ?: $posterPlaceholder($movie->title),
                'banner' => $movie->poster_url ?: $bannerPlaceholder($movie->title),
                'genre' => $movie->genre,
                'rating' => null,
                'duration' => $movie->getFormattedDuration(),
                'release_date' => optional($movie->release_date)->toDateString(),
                'description' => Str::limit($movie->synopsis, 180),
                'trailer_url' => $movie->trailer_url,
            ];
        })->values()->all();

        // Featured diambil dari now playing (maks 3)
        $featured_movies = array_slice($now_playing, 0, 3);

        // Kota aktif
        $cities = $citiesModels->map(fn ($c) => ['id' => $c->id, 'name' => $c->name])->values()->all();

        return view('home', compact('now_playing', 'coming_soon', 'featured_movies', 'cities'));
    }
}