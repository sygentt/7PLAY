<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $movies = [
            [
                'title' => 'Avatar: The Way of Water',
                'synopsis' => 'Set more than a decade after the events of the first film, Avatar: The Way of Water begins to tell the story of the Sully family, the trouble that follows them, the lengths they go to keep each other safe, the battles they fight to stay alive, and the tragedies they endure.',
                'genre' => 'Action, Adventure, Sci-Fi',
                'duration' => 192,
                'rating' => '13+',
                'language' => 'English',
                'director' => 'James Cameron',
                'cast' => ['Sam Worthington', 'Zoe Saldana', 'Sigourney Weaver', 'Kate Winslet'],
                'release_date' => Carbon::now()->subDays(30),
                'status' => Movie::STATUS_NOW_PLAYING,
                'poster_url' => 'https://image.tmdb.org/t/p/w500/t6HIqrRAclMCA60NsSmeqe9RmNV.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=a8Gx8wiNbs8',
                'is_active' => true,
            ],
            [
                'title' => 'Top Gun: Maverick',
                'synopsis' => 'After thirty years, Maverick is still pushing the envelope as a top naval aviator, but must confront ghosts of his past when he leads TOP GUN\'s elite graduates on a mission that demands the ultimate sacrifice from those chosen to fly it.',
                'genre' => 'Action, Drama',
                'duration' => 131,
                'rating' => '13+',
                'language' => 'English',
                'director' => 'Joseph Kosinski',
                'cast' => ['Tom Cruise', 'Miles Teller', 'Jennifer Connelly', 'Jon Hamm'],
                'release_date' => Carbon::now()->subDays(45),
                'status' => Movie::STATUS_NOW_PLAYING,
                'poster_url' => 'https://image.tmdb.org/t/p/w500/62HCnUTziyWcpDaBO2i1DX17ljH.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=qSqVVswa420',
                'is_active' => true,
            ],
            [
                'title' => 'Spider-Man: No Way Home',
                'synopsis' => 'Peter Parker seeks help from Doctor Strange to make everyone forget his secret identity as Spider-Man. When the spell goes wrong, it brings enemies from other dimensions.',
                'genre' => 'Action, Adventure, Sci-Fi',
                'duration' => 148,
                'rating' => '13+',
                'language' => 'English',
                'director' => 'Jon Watts',
                'cast' => ['Tom Holland', 'Zendaya', 'Benedict Cumberbatch', 'Willem Dafoe'],
                'release_date' => Carbon::now()->subDays(90),
                'status' => Movie::STATUS_FINISHED,
                'poster_url' => 'https://image.tmdb.org/t/p/w500/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=JfVOs4VSpmA',
                'is_active' => true,
            ],
            [
                'title' => 'Dune',
                'synopsis' => 'Paul Atreides leads nomadic tribes in a rebellion against the evil Harkonnen empire for control of the desert planet Arrakis.',
                'genre' => 'Adventure, Drama, Sci-Fi',
                'duration' => 155,
                'rating' => '13+',
                'language' => 'English',
                'director' => 'Denis Villeneuve',
                'cast' => ['Timothée Chalamet', 'Rebecca Ferguson', 'Oscar Isaac', 'Josh Brolin'],
                'release_date' => Carbon::now()->subDays(60),
                'status' => Movie::STATUS_FINISHED,
                'poster_url' => 'https://image.tmdb.org/t/p/w500/d5NXSklXo0qyIYkgV94XAgMIckC.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=8g18jFHCLXk',
                'is_active' => true,
            ],
            [
                'title' => 'Fast X',
                'synopsis' => 'Dom Toretto and his family are targeted by the vengeful son of drug kingpin Hernan Reyes.',
                'genre' => 'Action, Crime, Thriller',
                'duration' => 141,
                'rating' => '17+',
                'language' => 'English',
                'director' => 'Louis Leterrier',
                'cast' => ['Vin Diesel', 'Michelle Rodriguez', 'Tyrese Gibson', 'Ludacris'],
                'release_date' => Carbon::now()->addDays(15),
                'status' => Movie::STATUS_COMING_SOON,
                'poster_url' => 'https://image.tmdb.org/t/p/w500/fiVW06jE7z9YnO4trhaMEdclSiC.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=aOb15GVFZn0',
                'is_active' => true,
            ],
            [
                'title' => 'John Wick: Chapter 4',
                'synopsis' => 'John Wick uncovers a path to defeating The High Table. But before he can earn his freedom, Wick must face off against a new enemy with powerful alliances across the globe.',
                'genre' => 'Action, Crime, Thriller',
                'duration' => 169,
                'rating' => '17+',
                'language' => 'English',
                'director' => 'Chad Stahelski',
                'cast' => ['Keanu Reeves', 'Laurence Fishburne', 'Ian McShane', 'Lance Reddick'],
                'release_date' => Carbon::now()->addDays(7),
                'status' => Movie::STATUS_COMING_SOON,
                'poster_url' => 'https://image.tmdb.org/t/p/w500/vZloFAK7NmvMGKE7VkF5UHaz0I.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=qEVUtrk8_B4',
                'is_active' => true,
            ],
            [
                'title' => 'KKN di Desa Penari',
                'synopsis' => 'Lima mahasiswa melakukan program KKN di desa terpencil dan mengalami teror dari makhluk supernatural yang menghantui desa tersebut.',
                'genre' => 'Horror, Thriller',
                'duration' => 110,
                'rating' => '17+',
                'language' => 'Indonesia',
                'director' => 'Awi Suryadi',
                'cast' => ['Tissa Biani', 'Adinda Thomas', 'Achmad Megantara', 'Calvin Jeremy'],
                'release_date' => Carbon::now()->subDays(20),
                'status' => Movie::STATUS_NOW_PLAYING,
                'poster_url' => 'https://image.tmdb.org/t/p/w500/7BkNwGpzVqVTyVKYJRfLJPwZo3N.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=yNWLvGMPiPo',
                'is_active' => true,
            ],
            [
                'title' => 'Pengabdi Setan 2: Communion',
                'synopsis' => 'Keluarga Suwono pindah ke apartemen untuk menghindar dari teror roh jahat, namun roh tersebut tetap mengikuti mereka.',
                'genre' => 'Horror, Mystery',
                'duration' => 119,
                'rating' => '17+',
                'language' => 'Indonesia',
                'director' => 'Joko Anwar',
                'cast' => ['Tara Basro', 'Bront Palarae', 'Endy Arfian', 'Nasar Anuz'],
                'release_date' => Carbon::now()->subDays(180),
                'status' => Movie::STATUS_FINISHED,
                'poster_url' => 'https://image.tmdb.org/t/p/w500/6yRMyWwjuhKg6IU66uiZIGhaSqM.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=eRV8yRJYB6w',
                'is_active' => true,
            ],
            [
                'title' => 'Miracle in Cell No. 7',
                'synopsis' => 'Seorang ayah dengan keterbatasan mental dipenjara atas tuduhan pembunuhan. Di penjara, dia mendapat bantuan dari sesama tahanan untuk bertemu putrinya.',
                'genre' => 'Drama, Family',
                'duration' => 105,
                'rating' => 'SU',
                'language' => 'Indonesia',
                'director' => 'Hanung Bramantyo',
                'cast' => ['Vino G Bastian', 'Graciella Abigail', 'Indro', 'Tora Sudiro'],
                'release_date' => Carbon::now()->subDays(100),
                'status' => Movie::STATUS_FINISHED,
                'poster_url' => 'https://image.tmdb.org/t/p/w500/bOth4QmNyEkalwahfPCfiXjNh4H.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=JIzg8TQ-f2k',
                'is_active' => true,
            ],
            [
                'title' => 'Transformer: Rise of the Beasts',
                'synopsis' => 'The Autobots team up with the Maximals to save Earth from the Terrorcons and Predacons in this new chapter of the Transformers saga.',
                'genre' => 'Action, Adventure, Sci-Fi',
                'duration' => 127,
                'rating' => '13+',
                'language' => 'English',
                'director' => 'Steven Caple Jr.',
                'cast' => ['Anthony Ramos', 'Dominique Fishback', 'Luna Lauren Velez', 'Peter Cullen'],
                'release_date' => Carbon::now()->addDays(30),
                'status' => Movie::STATUS_COMING_SOON,
                'poster_url' => 'https://image.tmdb.org/t/p/w500/gPbM0MK8CP8A174rmUwGsADNYKD.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=itnqEauWQZM',
                'is_active' => true,
            ],
        ];

        foreach ($movies as $movieData) {
            Movie::create($movieData);
        }

        $this->command->info('✅ Movies seeded successfully! Added ' . count($movies) . ' movies.');
    }
}
