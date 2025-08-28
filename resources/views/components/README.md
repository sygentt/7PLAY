# Struktur Komponen 7PLAY

Dokumentasi struktur komponen yang telah diorganisir untuk memudahkan maintenance dan pengembangan.

## 📁 Struktur Folder

### 🏠 `/home/` - Komponen Halaman Beranda
Komponen-komponen yang khusus digunakan untuk halaman beranda (homepage).

- **`header.blade.php`** - Header navigation dengan logo, menu, search, dan auth buttons
- **`banner.blade.php`** - Banner carousel utama dengan Swiper.js
- **`now-playing.blade.php`** - Section film yang sedang tayang
- **`coming-soon.blade.php`** - Section film yang akan datang dengan countdown
- **`footer.blade.php`** - Footer dengan copyright, links, dan social media

### 🎨 `/ui/` - Komponen UI Umum
Komponen-komponen UI yang dapat digunakan di berbagai halaman.

- **`application-logo.blade.php`** - Logo aplikasi dengan styling
- **`modal.blade.php`** - Modal dialog component
- **`auth-session-status.blade.php`** - Status session autentikasi
- **`dark-mode-toggle.blade.php`** - Toggle dark/light mode

### 📝 `/form/` - Komponen Form
Komponen-komponen yang berkaitan dengan form dan input.

- **`primary-button.blade.php`** - Tombol primary dengan styling
- **`secondary-button.blade.php`** - Tombol secondary dengan styling
- **`danger-button.blade.php`** - Tombol danger/delete dengan styling
- **`text-input.blade.php`** - Input text dengan styling
- **`input-label.blade.php`** - Label untuk input
- **`input-error.blade.php`** - Error message untuk input

### 🧭 `/navigation/` - Komponen Navigasi
Komponen-komponen yang berkaitan dengan navigasi.

- **`nav-link.blade.php`** - Link navigasi dengan styling
- **`responsive-nav-link.blade.php`** - Link navigasi responsive
- **`dropdown.blade.php`** - Dropdown menu component
- **`dropdown-link.blade.php`** - Link dalam dropdown

### 🏗️ `/layout/` - Komponen Layout
Komponen-komponen yang berkaitan dengan layout dan struktur halaman.

*(Folder ini siap untuk komponen layout masa depan)*

## 🔧 Cara Penggunaan

### Include Komponen Home
```php
@include('components.home.header', ['cities' => $cities])
@include('components.home.banner', ['featured_movies' => $featured_movies])
@include('components.home.now-playing', ['now_playing' => $now_playing])
@include('components.home.coming-soon', ['coming_soon' => $coming_soon])
@include('components.home.footer')
```

### Include Komponen UI
```php
@include('components.ui.application-logo')
@include('components.ui.modal')
@include('components.ui.dark-mode-toggle')
```

### Include Komponen Form
```php
@include('components.form.primary-button')
@include('components.form.text-input')
@include('components.form.input-label')
```

### Include Komponen Navigation
```php
@include('components.navigation.nav-link')
@include('components.navigation.dropdown')
```

## 📋 Best Practices

1. **Naming Convention**: Gunakan kebab-case untuk nama file
2. **Folder Organization**: Kelompokkan komponen berdasarkan fungsinya
3. **Reusability**: Komponen di folder `/ui/`, `/form/`, dan `/navigation/` harus reusable
4. **Specific Components**: Komponen yang spesifik untuk halaman tertentu masuk ke folder halaman tersebut
5. **Documentation**: Update README ini ketika menambah komponen baru

## 🚀 Pengembangan Selanjutnya

- Tambahkan komponen untuk halaman lain (auth, dashboard, dll.)
- Buat komponen layout yang lebih kompleks
- Tambahkan komponen untuk fitur-fitur baru
- Implementasi sistem design tokens untuk konsistensi
