{{-- Contoh penggunaan komponen Movie Carousel --}}

{{-- Film Sedang Tayang --}}
<x-ui.movie-carousel
    title="Sedang Tayang"
    subtitle="Film-film terbaru yang sedang tayang di bioskop"
    :movies="$now_playing ?? []"
    icon="play-circle"
    theme="cinema"
    type="now-playing"
    id="now-playing"
    button-text="Beli Tiket"
    button-link="/movies"
    :show-rating="true"
    :show-countdown="false"
    :autoplay-delay="5000"
/>

{{-- Film Akan Datang --}}
<x-ui.movie-carousel
    title="Akan Datang"
    subtitle="Film-film yang akan tayang segera di bioskop"
    :movies="$coming_soon ?? []"
    icon="calendar-days"
    theme="gold"
    type="coming-soon"
    id="coming-soon"
    button-text="Ingatkan Saya"
    button-link="/movies/coming-soon"
    :show-rating="false"
    :show-countdown="true"
    :autoplay-delay="6000"
/>

{{-- Film Populer --}}
<x-ui.movie-carousel
    title="Film Populer"
    subtitle="Film-film yang paling banyak ditonton"
    :movies="$popular_movies ?? []"
    icon="fire"
    theme="cinema"
    type="popular"
    id="popular-movies"
    button-text="Tonton Sekarang"
    button-link="/movies/popular"
    :show-rating="true"
    :show-countdown="false"
    :autoplay-delay="7000"
/>

{{-- Film Horror --}}
<x-ui.movie-carousel
    title="Film Horror"
    subtitle="Film-film horor terbaik untuk pengalaman mendebarkan"
    :movies="$horror_movies ?? []"
    icon="film"
    theme="gold"
    type="horror"
    id="horror-movies"
    button-text="Berani Nonton?"
    button-link="/movies/genre/horror"
    :show-rating="true"
    :show-countdown="false"
    :autoplay-delay="8000"
/>

{{-- 
CONTOH DATA YANG DIPERLUKAN:

1. Untuk Now Playing ($now_playing):
[
    [
        'id' => 1,
        'title' => 'Avengers: Endgame',
        'poster' => 'https://dummyimage.com/400x600/000/fff?text=Avengers',
        'genre' => 'Action, Adventure',
        'duration' => '181 menit',
        'rating' => '8.4',
        'description' => 'Setelah peristiwa Infinity War, para Avengers berkumpul untuk mengalahkan Thanos...'
    ],
    // ... data film lainnya
]

2. Untuk Coming Soon ($coming_soon):
[
    [
        'id' => 1,
        'title' => 'Spider-Man: No Way Home',
        'poster' => 'https://dummyimage.com/400x600/000/fff?text=Spiderman',
        'genre' => 'Action, Adventure',
        'duration' => '148 menit',
        'release_date' => '2024-03-15',
        'description' => 'Peter Parker menghadapi konsekuensi setelah identitasnya terbongkar...'
    ],
    // ... data film lainnya
]

FITUR UTAMA KOMPONEN:

✅ Menampilkan 4 item film di desktop secara konsisten
✅ Navigation dengan tombol prev/next dan pagination dots
✅ Autoplay dengan pause on hover
✅ Loop infinite untuk pengalaman user yang seamless
✅ Responsive untuk semua ukuran layar
✅ Customizable theme (cinema = biru, gold = emas)
✅ Support countdown timer untuk film coming soon
✅ Support rating display untuk film yang sudah tayang
✅ Placeholder image otomatis menggunakan dummyimage.com
✅ Smooth animations dan hover effects
✅ Dark mode support

CARA MENGGUNAKAN:

1. Include komponen di blade template:
   <x-ui.movie-carousel />

2. Pass data film melalui props:
   :movies="$your_movie_data"

3. Customize sesuai kebutuhan:
   - title: Judul section
   - subtitle: Subjudul section
   - theme: 'cinema' atau 'gold'
   - type: 'now-playing', 'coming-soon', dll
   - icon: 'play-circle', 'calendar-days', 'film', dll
   - button-text: Text tombol utama
   - show-rating: true/false untuk menampilkan rating
   - show-countdown: true/false untuk countdown timer
   - autoplay-delay: Delay autoplay dalam ms

--}}
