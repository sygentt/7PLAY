<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Data dummy untuk film yang sedang tayang
        $now_playing = [
            [
                'id' => 1,
                'title' => 'Avengers: Endgame',
                'poster' => 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg',
                'banner' => 'https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/7RyHsO4yDXtBv1zUU3mTpHeQ0d5.jpg',
                'genre' => 'Action, Adventure, Drama',
                'rating' => 8.4,
                'duration' => '181 min',
                'release_date' => '2019-04-26',
                'description' => 'After the devastating events of Avengers: Infinity War, the universe is in ruins due to the efforts of the Mad Titan, Thanos.'
            ],
            [
                'id' => 2,
                'title' => 'Spider-Man: No Way Home',
                'poster' => 'https://image.tmdb.org/t/p/w500/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg',
                'banner' => 'https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/14QbnygCuTO0vl7CAFmPf1fgZfV.jpg',
                'genre' => 'Action, Adventure, Sci-Fi',
                'rating' => 8.2,
                'duration' => '148 min',
                'release_date' => '2021-12-17',
                'description' => 'With Spider-Man\'s identity now revealed, Peter asks Doctor Strange for help.'
            ],
            [
                'id' => 3,
                'title' => 'The Batman',
                'poster' => 'https://image.tmdb.org/t/p/w500/b0PlSFdDwbyK0cf5RxwDpaOJQvQ.jpg',
                'banner' => 'https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/b0PlSFdDwbyK0cf5RxwDpaOJQvQ.jpg',
                'genre' => 'Action, Crime, Drama',
                'rating' => 7.8,
                'duration' => '176 min',
                'release_date' => '2022-03-04',
                'description' => 'When the Riddler, a sadistic serial killer, begins murdering key political figures in Gotham.'
            ],
            [
                'id' => 4,
                'title' => 'Top Gun: Maverick',
                'poster' => 'https://image.tmdb.org/t/p/w500/62HCnUTziyWcpDaBO2i1DX17ljH.jpg',
                'banner' => 'https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/odJ4hx6g6vBt4lBWKFD1tI8WS4x.jpg',
                'genre' => 'Action, Drama',
                'rating' => 8.3,
                'duration' => '130 min',
                'release_date' => '2022-05-27',
                'description' => 'After thirty years, Maverick is still pushing the envelope as a top naval aviator.'
            ],
            [
                'id' => 5,
                'title' => 'Avatar: The Way of Water',
                'poster' => 'https://image.tmdb.org/t/p/w500/t6HIqrRAclMCA60NsSmeqe9RmNV.jpg',
                'banner' => 'https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg',
                'genre' => 'Sci-Fi, Adventure, Action',
                'rating' => 7.6,
                'duration' => '192 min',
                'release_date' => '2022-12-16',
                'description' => 'Jake Sully lives with his newfound family formed on the planet of Pandora.'
            ]
        ];

        // Data dummy untuk film yang akan tayang
        $coming_soon = [
            [
                'id' => 6,
                'title' => 'Guardians of the Galaxy Vol. 3',
                'poster' => 'https://image.tmdb.org/t/p/w500/r2J02Z2OpNTctfOSN1Ydgii51I3.jpg',
                'banner' => 'https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/5YZbUmjbMa3ClvSW1Wj3D6XGolb.jpg',
                'genre' => 'Action, Adventure, Comedy',
                'rating' => null,
                'duration' => '150 min',
                'release_date' => '2025-11-15',
                'description' => 'Peter Quill, still reeling from the loss of Gamora, must rally his team around him.'
            ],
            [
                'id' => 7,
                'title' => 'John Wick: Chapter 4',
                'poster' => 'https://image.tmdb.org/t/p/w500/vZloFAK7NmvMGKE7VkF5UHaz0I.jpg',
                'banner' => 'https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/h7dZpJDORYs5c56dydbrLFkEXpE.jpg',
                'genre' => 'Action, Thriller, Crime',
                'rating' => null,
                'duration' => '169 min',
                'release_date' => '2025-12-05',
                'description' => 'John Wick uncovers a path to defeating The High Table.'
            ],
            [
                'id' => 8,
                'title' => 'Fast X',
                'poster' => 'https://image.tmdb.org/t/p/w500/fiVW06jE7z9YnO4trhaMEdclSiC.jpg',
                'banner' => 'https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/4XddcRDtnNjYmLRMYpbrhFxsbuq.jpg',
                'genre' => 'Action, Crime, Thriller',
                'rating' => null,
                'duration' => '141 min',
                'release_date' => '2025-12-25',
                'description' => 'Dom Toretto and his family are targeted by the vengeful son of drug kingpin Hernan Reyes.'
            ],
            [
                'id' => 9,
                'title' => 'Indiana Jones 5',
                'poster' => 'https://image.tmdb.org/t/p/w500/Af4bXE63pVsb2FtbW8uYIyPBadD.jpg',
                'banner' => 'https://image.tmdb.org/t/p/w1920_and_h800_multi_faces/3GrRgt6CiLIUXUtoktcv1g2iwT5.jpg',
                'genre' => 'Action, Adventure',
                'rating' => null,
                'duration' => '154 min',
                'release_date' => '2026-01-18',
                'description' => 'Experience the return of the legendary hero with an all-new adventure.'
            ]
        ];

        // Data untuk banner utama (3 film pilihan)
        $featured_movies = array_slice($now_playing, 0, 3);

        // Data dummy untuk lokasi bioskop
        $cities = [
            ['id' => 1, 'name' => 'Jakarta'],
            ['id' => 2, 'name' => 'Bandung'],
            ['id' => 3, 'name' => 'Surabaya'],
            ['id' => 4, 'name' => 'Medan'],
            ['id' => 5, 'name' => 'Yogyakarta'],
            ['id' => 6, 'name' => 'Semarang'],
        ];

        return view('home', compact('now_playing', 'coming_soon', 'featured_movies', 'cities'));
    }
}