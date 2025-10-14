<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class MovieSeeder extends Seeder
{
    /**
     * 🎛️ KONFIGURASI SEEDER - Bisa diubah sesuai kebutuhan
     */
    private array $config = [
        'total_movies' => 30,
        'now_playing_count' => 12,
        'coming_soon_count' => 10,
        'finished_count' => 8,
        'use_real_posters' => false, // false untuk dummy images
        'include_indonesian_movies' => true,
        'min_duration' => 90, // menit
        'max_duration' => 180, // menit
    ];

    /**
     * Template data untuk generate random movies
     */
    private array $movieTemplates = [
        'action' => [
            'titles' => [
                'Thunder Strike', 'Steel Vengeance', 'Fire Storm', 'Iron Fist', 'Shadow Hunter',
                'Blade Runner', 'Night Warrior', 'Storm Force', 'Steel Legion', 'Fire Phoenix',
                'Dark Justice', 'Crimson Blade', 'Lightning Strike', 'Metal Storm', 'War Machine'
            ],
            'genres' => ['Action', 'Action, Adventure', 'Action, Thriller', 'Action, Sci-Fi'],
            'keywords' => ['explosive', 'thrilling', 'intense', 'adrenaline-pumping', 'epic', 'spectacular']
        ],
        'comedy' => [
            'titles' => [
                'Laugh Out Loud', 'Crazy Times', 'Funny Business', 'Comedy Central', 'Happy Days',
                'Good Vibes', 'Smile More', 'Joy Ride', 'Fun House', 'Giggles Galore',
                'Silly Times', 'Comic Relief', 'Happy Hour', 'Fun Zone', 'Chuckles'
            ],
            'genres' => ['Comedy', 'Comedy, Romance', 'Comedy, Family', 'Comedy, Adventure'],
            'keywords' => ['hilarious', 'heartwarming', 'entertaining', 'feel-good', 'lighthearted', 'amusing']
        ],
        'drama' => [
            'titles' => [
                'Heart Strings', 'Life Journey', 'Emotional Depths', 'Soul Search', 'True Stories',
                'Human Touch', 'Deep Waters', 'Life Lessons', 'Touching Hearts', 'Real Life',
                'Broken Dreams', 'Hope Rising', 'Silent Tears', 'Inner Strength', 'Life Changes'
            ],
            'genres' => ['Drama', 'Drama, Romance', 'Drama, Family', 'Biography, Drama'],
            'keywords' => ['emotional', 'touching', 'powerful', 'inspiring', 'profound', 'moving']
        ],
        'horror' => [
            'titles' => [
                'Dark Shadows', 'Night Terror', 'Haunted House', 'Evil Spirits', 'Nightmare',
                'Ghost Town', 'Fear Factor', 'Dark Woods', 'Scary Tales', 'Horror Night',
                'Blood Moon', 'Dead Zone', 'Silent Scream', 'Cursed Land', 'Evil Rising'
            ],
            'genres' => ['Horror', 'Horror, Thriller', 'Horror, Mystery', 'Supernatural, Horror'],
            'keywords' => ['terrifying', 'spine-chilling', 'frightening', 'suspenseful', 'eerie', 'disturbing']
        ],
        'scifi' => [
            'titles' => [
                'Future World', 'Space Odyssey', 'Cyber City', 'Robot Wars', 'Time Travel',
                'Galaxy Quest', 'Tech Revolution', 'Virtual Reality', 'Star Journey', 'AI Rising',
                'Quantum Leap', 'Digital Dreams', 'Space Colony', 'Cyber Wars', 'Alien Contact'
            ],
            'genres' => ['Sci-Fi', 'Sci-Fi, Action', 'Sci-Fi, Adventure', 'Sci-Fi, Thriller'],
            'keywords' => ['futuristic', 'innovative', 'mind-bending', 'technological', 'visionary', 'advanced']
        ]
    ];

    private array $indonesianMovies = [
        ['title' => 'Laskar Pelangi', 'genre' => 'Drama, Family'],
        ['title' => 'Ada Apa Dengan Cinta', 'genre' => 'Romance, Drama'],
        ['title' => 'Pengabdi Setan', 'genre' => 'Horror, Thriller'],
        ['title' => 'Dilan 1990', 'genre' => 'Romance, Drama'],
        ['title' => 'KKN di Desa Penari', 'genre' => 'Horror, Thriller'],
        ['title' => 'Miracle in Cell No. 7', 'genre' => 'Drama, Family'],
        ['title' => 'Habibie & Ainun', 'genre' => 'Biography, Romance'],
        ['title' => 'Warkop DKI', 'genre' => 'Comedy, Action'],
        ['title' => 'Surat Kecil untuk Tuhan', 'genre' => 'Drama, Family'],
        ['title' => 'Tenggelamnya Kapal Van Der Wijck', 'genre' => 'Drama, Romance'],
        ['title' => 'Ayat-Ayat Cinta', 'genre' => 'Romance, Drama'],
        ['title' => 'Danur', 'genre' => 'Horror, Thriller']
    ];

    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $this->command->info('🎬 Generating random movies...');
        $this->command->info("📋 Configuration:");
        $this->command->info("   • Total Movies: {$this->config['total_movies']}");
        $this->command->info("   • Now Playing: {$this->config['now_playing_count']}");
        $this->command->info("   • Coming Soon: {$this->config['coming_soon_count']}");
        $this->command->info("   • Finished: {$this->config['finished_count']}");
        $this->command->info("   • Indonesian Movies: " . ($this->config['include_indonesian_movies'] ? 'Yes' : 'No'));
        $this->command->info('');

        $faker = Faker::create('id_ID');
        $movies = [];

        // Generate Now Playing movies
        $this->command->info('🎭 Generating Now Playing movies...');
        for ($i = 0; $i < $this->config['now_playing_count']; $i++) {
            $movies[] = $this->generateRandomMovie($faker, Movie::STATUS_NOW_PLAYING);
        }

        // Generate Coming Soon movies
        $this->command->info('🗓️ Generating Coming Soon movies...');
        for ($i = 0; $i < $this->config['coming_soon_count']; $i++) {
            $movies[] = $this->generateRandomMovie($faker, Movie::STATUS_COMING_SOON);
        }

        // Generate Finished movies
        $this->command->info('📚 Generating Finished movies...');
        for ($i = 0; $i < $this->config['finished_count']; $i++) {
            $movies[] = $this->generateRandomMovie($faker, Movie::STATUS_FINISHED);
        }

        // Sisanya random status
        $remaining = $this->config['total_movies'] - count($movies);
        if ($remaining > 0) {
            $this->command->info("🎲 Generating {$remaining} additional movies with random status...");
            $statuses = [Movie::STATUS_NOW_PLAYING, Movie::STATUS_COMING_SOON, Movie::STATUS_FINISHED];
            
            for ($i = 0; $i < $remaining; $i++) {
                $randomStatus = $faker->randomElement($statuses);
                $movies[] = $this->generateRandomMovie($faker, $randomStatus);
            }
        }

        // Shuffle untuk random order
        shuffle($movies);

        // Save to database
        $this->command->info('💾 Saving to database...');
        foreach ($movies as $movieData) {
            Movie::create($movieData);
        }

        $this->command->info('✅ Movies seeded successfully! Added ' . count($movies) . ' random movies.');
        
        // Show statistics
        $this->showStatistics();
    }

    /**
     * Generate random movie data
     */
    private function generateRandomMovie($faker, string $status): array
    {
        // Pilih kategori film secara random
        $categories = array_keys($this->movieTemplates);
        $category = $faker->randomElement($categories);
        $template = $this->movieTemplates[$category];

        // Buat judul unik
        $baseTitle = $faker->randomElement($template['titles']);
        $uniqueModifier = $faker->randomElement(['', ' ' . $faker->numberBetween(2, 9), ' Returns', ' Legacy', ' Reborn', ' Rising', ' Chronicles']);
        $title = $baseTitle . $uniqueModifier;

        // Genre
        $genre = $faker->randomElement($template['genres']);

        // Synopsis dengan keyword yang sesuai kategori
        $keyword = $faker->randomElement($template['keywords']);
        $synopsis = $this->generateSynopsis($faker, $keyword, $title);

        // Duration
        $duration = $faker->numberBetween($this->config['min_duration'], $this->config['max_duration']);

        // Release date berdasarkan status
        $releaseDate = $this->generateReleaseDate($faker, $status);

        // Rating
        $ratings = ['SU', '13+', '17+', '21+'];
        $rating = $faker->randomElement($ratings);

        // Language (mix Indonesian dan English)
        $language = $this->config['include_indonesian_movies'] && $faker->boolean(30) ? 'Indonesia' : 'English';

        // Jika Indonesian, gunakan template Indonesian
        if ($language === 'Indonesia' && $faker->boolean(60)) {
            $indonesianMovie = $faker->randomElement($this->indonesianMovies);
            $title = $indonesianMovie['title'] . ' ' . $faker->numberBetween(2, 5);
            $genre = $indonesianMovie['genre'];
        }

        // Cast (nama-nama random)
        $cast = $this->generateCast($faker, $language);

        // Director
        $director = $language === 'Indonesia' ? 
            $faker->randomElement(['Joko Anwar', 'Hanung Bramantyo', 'Awi Suryadi', 'Riri Riza', 'Ernest Prakasa', 'Timo Tjahjanto', 'Angga Dwimas Sasongko']) :
            $faker->name;

        // Poster URL
        $posterUrl = $this->generatePosterUrl($faker, $title);

        // Trailer URL (dummy YouTube links)
        $trailerUrl = 'https://www.youtube.com/watch?v=' . $faker->regexify('[A-Za-z0-9]{11}');

        return [
            'title' => $title,
            'synopsis' => $synopsis,
            'genre' => $genre,
            'duration' => $duration,
            'rating' => $rating,
            'language' => $language,
            'director' => $director,
            'cast' => $cast,
            'release_date' => $releaseDate,
            'status' => $status,
            'poster_url' => $posterUrl,
            'trailer_url' => $trailerUrl,
            'is_active' => true,
        ];
    }

    /**
     * Generate synopsis
     */
    private function generateSynopsis($faker, string $keyword, string $title): string
    {
        $templates = [
            "When {character} discovers {plot_device}, they must {action} to save {stakes}. This {keyword} adventure will {outcome}.",
            "In a world where {setting}, {character} faces {challenge}. A {keyword} story of {theme} and {emotion}.",
            "{character} must {action} when {problem} threatens {stakes}. This {keyword} tale explores {theme}.",
            "After {event}, {character} embarks on a {keyword} journey to {goal}. But {obstacle} stands in their way.",
            "The story of {character} who {action} in order to {goal}. A {keyword} narrative about {theme}.",
            "{character} finds themselves in {situation} where they must {action}. This {keyword} film follows their {theme}."
        ];

        $template = $faker->randomElement($templates);
        
        return str_replace([
            '{character}', '{plot_device}', '{action}', '{stakes}', '{keyword}', '{outcome}',
            '{setting}', '{challenge}', '{theme}', '{emotion}', '{problem}', '{event}',
            '{goal}', '{obstacle}', '{situation}'
        ], [
            $faker->randomElement(['a young hero', 'a brave warrior', 'an unlikely protagonist', 'a determined fighter', 'a skilled detective', 'a troubled soul']),
            $faker->randomElement(['a hidden secret', 'an ancient artifact', 'a mysterious power', 'a dangerous truth', 'a lost treasure', 'a forbidden knowledge']),
            $faker->randomElement(['fight against evil', 'overcome obstacles', 'face their fears', 'unite their allies', 'confront the past', 'embrace their destiny']),
            $faker->randomElement(['the world', 'their family', 'humanity', 'their homeland', 'innocent lives', 'everything they love']),
            $keyword,
            $faker->randomElement(['change everything', 'test their limits', 'reveal hidden truths', 'forge new alliances', 'transform their world', 'redefine their purpose']),
            $faker->randomElement(['magic exists', 'technology rules', 'anything is possible', 'danger lurks', 'dreams come true', 'hope survives']),
            $faker->randomElement(['an impossible choice', 'a deadly enemy', 'overwhelming odds', 'inner demons', 'unexpected betrayal', 'moral dilemmas']),
            $faker->randomElement(['courage', 'friendship', 'love', 'sacrifice', 'redemption', 'survival', 'justice', 'family']),
            $faker->randomElement(['hope', 'determination', 'loss', 'discovery', 'triumph', 'despair', 'joy']),
            $faker->randomElement(['evil forces', 'a terrible curse', 'an ancient enemy', 'corruption', 'natural disaster', 'alien invasion']),
            $faker->randomElement(['a tragic accident', 'a shocking revelation', 'a betrayal', 'a catastrophe', 'a mysterious disappearance', 'an unexpected encounter']),
            $faker->randomElement(['restore peace', 'find the truth', 'save their loved ones', 'fulfill their destiny', 'uncover secrets', 'prevent disaster']),
            $faker->randomElement(['powerful enemies', 'personal doubts', 'impossible odds', 'past mistakes', 'time running out', 'competing interests']),
            $faker->randomElement(['a dangerous situation', 'an extraordinary circumstance', 'a life-changing moment', 'a critical juncture', 'a mysterious place'])
        ], $template);
    }

    /**
     * Generate release date based on status
     * 
     * Note: For COMING_SOON movies, tickets will be available 3 days after release_date
     * Example: If release_date is Oct 19, tickets can be sold starting Oct 22
     */
    private function generateReleaseDate($faker, string $status): Carbon
    {
        switch ($status) {
            case Movie::STATUS_NOW_PLAYING:
                // Already released, 1-60 days ago
                return Carbon::now()->subDays($faker->numberBetween(1, 60));
            case Movie::STATUS_COMING_SOON:
                // Will be released 7-90 days from now
                // Tickets will be available starting from (release_date + 3 days)
                return Carbon::now()->addDays($faker->numberBetween(7, 90));
            case Movie::STATUS_FINISHED:
                // Finished showing, released 90-365 days ago
                return Carbon::now()->subDays($faker->numberBetween(90, 365));
            default:
                return Carbon::now();
        }
    }

    /**
     * Generate cast array
     */
    private function generateCast($faker, string $language): array
    {
        $castCount = $faker->numberBetween(3, 6);
        $cast = [];

        if ($language === 'Indonesia') {
            $indonesianActors = [
                'Iko Uwais', 'Tara Basro', 'Reza Rahadian', 'Dian Sastrowardoyo',
                'Vino G Bastian', 'Chelsea Islan', 'Nicholas Saputra', 'Marsha Timothy',
                'Ringgo Agus Rahman', 'Acha Septriasa', 'Chicco Jerikho', 'Pevita Pearce',
                'Luna Maya', 'Joe Taslim', 'Putri Marino', 'Morgan Oey', 'Cinta Laura'
            ];
            
            for ($i = 0; $i < $castCount; $i++) {
                $cast[] = $faker->randomElement($indonesianActors);
            }
        } else {
            for ($i = 0; $i < $castCount; $i++) {
                $cast[] = $faker->name;
            }
        }

        return array_unique($cast);
    }

    /**
     * Generate poster URL
     */
    private function generatePosterUrl($faker, string $title): string
    {
        if ($this->config['use_real_posters']) {
            // Gunakan service poster film real (placeholder TMDB style)
            $movieId = $faker->numberBetween(100000, 999999);
            return "https://image.tmdb.org/t/p/w500/{$movieId}.jpg";
        } else {
            // Gunakan dummyimage.com dengan judul film
            $text = urlencode(substr($title, 0, 20));
            $bgColor = str_replace('#', '', $faker->hexColor);
            $textColor = 'ffffff';
            return "https://dummyimage.com/500x750/{$bgColor}/{$textColor}?text={$text}";
        }
    }

    /**
     * Show statistics setelah seeding
     */
    private function showStatistics(): void
    {
        $nowPlaying = Movie::byStatus(Movie::STATUS_NOW_PLAYING)->count();
        $comingSoon = Movie::byStatus(Movie::STATUS_COMING_SOON)->count();
        $finished = Movie::byStatus(Movie::STATUS_FINISHED)->count();
        $total = Movie::count();
        $indonesian = Movie::where('language', 'Indonesia')->count();
        $english = Movie::where('language', 'English')->count();

        $this->command->info('');
        $this->command->info('📊 Movie Statistics:');
        $this->command->info("┌─────────────────┬───────┐");
        $this->command->info("│ Status          │ Count │");
        $this->command->info("├─────────────────┼───────┤");
        $this->command->info(sprintf("│ Now Playing     │ %-5s │", $nowPlaying));
        $this->command->info(sprintf("│ Coming Soon     │ %-5s │", $comingSoon));
        $this->command->info(sprintf("│ Finished        │ %-5s │", $finished));
        $this->command->info("├─────────────────┼───────┤");
        $this->command->info(sprintf("│ TOTAL           │ %-5s │", $total));
        $this->command->info("└─────────────────┴───────┘");
        
        $this->command->info('');
        $this->command->info('🌍 Language Distribution:');
        $this->command->info("┌─────────────────┬───────┐");
        $this->command->info(sprintf("│ Indonesian      │ %-5s │", $indonesian));
        $this->command->info(sprintf("│ English         │ %-5s │", $english));
        $this->command->info("└─────────────────┴───────┘");
        $this->command->info('');

        // Show sample movies
        $samples = Movie::inRandomOrder()->take(5)->get(['title', 'genre', 'status', 'language']);
        $this->command->info('🎬 Sample Generated Movies:');
        foreach ($samples as $movie) {
            $flag = $movie->language === 'Indonesia' ? '🇮🇩' : '🇺🇸';
            $this->command->info("   {$flag} {$movie->title} ({$movie->genre}) - {$movie->status}");
        }
        $this->command->info('');
        $this->command->info('🎉 Random movie generation completed successfully!');
    }
}