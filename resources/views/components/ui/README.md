# Movie Carousel Component

Komponen carousel yang dapat digunakan kembali untuk menampilkan daftar film dengan navigasi dan fitur-fitur interaktif.

## Fitur Utama

✅ **Tampilan 4 Item**: Menampilkan 4 film secara konsisten di desktop  
✅ **Navigasi Lengkap**: Tombol prev/next dan pagination dots  
✅ **Autoplay**: Dengan pause on hover untuk pengalaman user yang baik  
✅ **Loop Infinite**: Scroll tanpa batas untuk semua film  
✅ **Responsive**: Adaptif untuk semua ukuran layar  
✅ **Customizable Theme**: Dua tema (cinema = biru, gold = emas)  
✅ **Countdown Timer**: Untuk film yang akan datang  
✅ **Rating Display**: Untuk film yang sedang tayang  
✅ **Placeholder Images**: Otomatis menggunakan dummyimage.com  
✅ **Smooth Animations**: Efek hover dan transisi yang halus  
✅ **Dark Mode**: Dukungan penuh untuk dark mode  

## Cara Penggunaan

### Basic Usage

```blade
<x-ui.movie-carousel
    title="Sedang Tayang"
    subtitle="Film-film terbaru yang sedang tayang di bioskop"
    :movies="$now_playing"
    theme="cinema"
    type="now-playing"
/>
```

### Advanced Usage

```blade
<x-ui.movie-carousel
    title="Akan Datang"
    subtitle="Film-film yang akan tayang segera di bioskop"
    :movies="$coming_soon"
    icon="calendar-days"
    theme="gold"
    type="coming-soon"
    id="coming-soon-carousel"
    button-text="Ingatkan Saya"
    button-link="/movies/coming-soon"
    :show-rating="false"
    :show-countdown="true"
    :autoplay-delay="6000"
/>
```

## Props

| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `title` | string | '' | Judul section carousel |
| `subtitle` | string | '' | Subjudul section carousel |
| `movies` | array | [] | Array data film |
| `icon` | string | 'play-circle' | Icon header (play-circle, calendar-days, clock, film) |
| `theme` | string | 'cinema' | Tema warna (cinema, gold) |
| `type` | string | 'now-playing' | Tipe carousel (now-playing, coming-soon, popular, dll) |
| `id` | string | auto-generated | ID unik untuk carousel |
| `buttonText` | string | 'Beli Tiket' | Text tombol utama |
| `buttonLink` | string | '#' | Link tombol "Lihat Semua" |
| `showRating` | boolean | true | Tampilkan rating film |
| `showCountdown` | boolean | false | Tampilkan countdown timer |
| `autoplayDelay` | integer | 5000 | Delay autoplay dalam milidetik |

## Format Data Film

### Untuk Film Sedang Tayang

```php
$now_playing = [
    [
        'id' => 1,
        'title' => 'Avengers: Endgame',
        'poster' => 'https://example.com/poster.jpg',
        'genre' => 'Action, Adventure, Drama',
        'duration' => '181 menit',
        'rating' => '8.4',
        'description' => 'Deskripsi film...'
    ],
    // ... film lainnya
];
```

### Untuk Film Akan Datang

```php
$coming_soon = [
    [
        'id' => 1,
        'title' => 'Spider-Man: No Way Home',
        'poster' => 'https://example.com/poster.jpg',
        'genre' => 'Action, Adventure',
        'duration' => '148 menit',
        'release_date' => '2024-03-15',
        'description' => 'Deskripsi film...'
    ],
    // ... film lainnya
];
```

## Responsive Breakpoints

| Ukuran Layar | Slides per View | Spacing |
|--------------|-----------------|---------|
| Mobile (< 480px) | 1.2 | 16px |
| Small Mobile (480px+) | 1.5 | 20px |
| Tablet (640px+) | 2 | 24px |
| Large Tablet (768px+) | 2.5 | 24px |
| Desktop (1024px+) | **4** | 32px |
| Large Desktop (1280px+) | **4** | 32px |
| XL Desktop (1536px+) | **4** | 32px |

## Themes

### Cinema Theme (Biru)
- Background: Putih/Abu gelap
- Accent: Biru cinema
- Untuk: Film sedang tayang, populer

### Gold Theme (Emas)  
- Background: Abu terang/Abu gelap
- Accent: Emas/Gold
- Untuk: Film akan datang, premium

## Contoh Implementasi

```blade
{{-- resources/views/home.blade.php --}}

{{-- Film Sedang Tayang --}}
<x-ui.movie-carousel
    title="Sedang Tayang"
    subtitle="Film-film terbaru yang sedang tayang di bioskop"
    :movies="$now_playing"
    icon="play-circle"
    theme="cinema"
    type="now-playing"
    button-text="Beli Tiket"
    :show-rating="true"
/>

{{-- Film Akan Datang --}}
<x-ui.movie-carousel
    title="Akan Datang"
    subtitle="Film-film yang akan tayang segera di bioskop"
    :movies="$coming_soon"
    icon="calendar-days"
    theme="gold"
    type="coming-soon"
    button-text="Ingatkan Saya"
    :show-countdown="true"
/>
```

## Requirements

- Laravel 11/12
- Tailwind CSS
- Heroicons (blade-heroicons)
- Swiper.js

## Browser Support

- Chrome 60+
- Firefox 60+
- Safari 12+
- Edge 79+

## Performance

- **Lazy Loading**: Images dimuat saat diperlukan
- **Optimized Animations**: GPU-accelerated transforms
- **Efficient DOM**: Minimal DOM manipulation
- **Memory Friendly**: Cleanup otomatis untuk timers

## Customization

### Custom Styling

```css
/* Override default styles */
.your-carousel-id-swiper .swiper-slide {
    /* Custom slide styles */
}

.your-carousel-id-swiper-pagination .swiper-pagination-bullet {
    /* Custom pagination styles */
}
```

### Custom JavaScript

```javascript
// Access swiper instance
document.addEventListener('DOMContentLoaded', function() {
    const swiper = document.querySelector('.your-carousel-id-swiper').swiper;
    
    // Custom event handlers
    swiper.on('slideChange', function() {
        console.log('Slide changed');
    });
});
```
