# 7PLAY Admin Dashboard - Icon Library Documentation

## 📦 Icon Library Setup

Admin dashboard menggunakan **Blade Heroicons** untuk konsistensi dengan Tailwind CSS dan kemudahan penggunaan.

### Package Information
- **Package**: `blade-ui-kit/blade-heroicons`
- **Version**: 2.6.0
- **Icon Set**: Heroicons v2 (1000+ icons)
- **Styles**: Outline, Solid, Mini, Micro
- **Website**: https://heroicons.com/

### Installation Status
✅ Package sudah terinstall  
✅ Configuration sudah di-publish  
✅ SVG assets sudah tersedia  
✅ Custom components sudah dibuat  
✅ Constants sudah didefinisikan  

---

## 🎨 Icon Styles & Usage

### 1. Icon Styles Available

| Style | Prefix | Size | Usage |
|-------|--------|------|-------|
| **Outline** | `o-` | 24x24px | Sidebar navigation, default states |
| **Solid** | `s-` | 24x24px | Active states, primary buttons |
| **Mini** | `m-` | 20x20px | Small buttons, form controls |
| **Micro** | `c-` | 16x16px | Status indicators, very small UI |

### 2. Basic Usage

```blade
<!-- Direct component usage -->
<x-heroicon-o-home class="w-6 h-6"/>
<x-heroicon-s-home class="w-6 h-6 text-blue-600"/>
<x-heroicon-m-plus class="w-5 h-5"/>
<x-heroicon-c-check class="w-4 h-4"/>

<!-- Using @svg directive -->
@svg('heroicon-o-home', 'w-6 h-6 text-gray-500')
```

### 3. Custom Icon Component

Tersedia komponen kustom untuk kemudahan penggunaan:

```blade
<!-- Basic usage -->
<x-admin.icon name="home" />

<!-- With custom properties -->
<x-admin.icon name="users" type="solid" size="medium" color="primary" />

<!-- Available properties -->
{{-- 
name: Icon name (without prefix)
type: outline|solid|mini|micro (default: outline)
size: micro|small|default|medium|large|xl (default: default)
color: default|primary|success|danger|warning|muted (default: default)
--}}
```

---

## 🗂️ Icon Constants & Organization

### AdminIcons Constants Class

Semua icon names tersimpan dalam `App\Constants\AdminIcons` untuk kemudahan maintenance:

```php
use App\Constants\AdminIcons;

// Navigation icons
AdminIcons::DASHBOARD    // 'squares-2x2'
AdminIcons::MOVIES       // 'film'
AdminIcons::USERS        // 'users'

// Action icons  
AdminIcons::ADD          // 'plus'
AdminIcons::EDIT         // 'pencil-square'
AdminIcons::DELETE       // 'trash'

// Status icons
AdminIcons::SUCCESS      // 'check-circle'
AdminIcons::ERROR        // 'x-circle'
AdminIcons::WARNING      // 'exclamation-triangle'
```

### Helper Methods

```php
// Get icon by module
AdminIcons::getModuleIcon('movies')        // Returns 'film'
AdminIcons::getActionIcon('create')        // Returns 'plus'
AdminIcons::getStatusIcon('active')        // Returns 'check-badge'
```

---

## 📋 Admin Dashboard Icon Mapping

### Sidebar Navigation
```blade
Dashboard    → <x-heroicon-o-squares-2x2 class="w-5 h-5"/>
Cities       → <x-heroicon-o-building-office-2 class="w-5 h-5"/>
Cinemas      → <x-heroicon-o-building-storefront class="w-5 h-5"/>
Movies       → <x-heroicon-o-film class="w-5 h-5"/>
Showtimes    → <x-heroicon-o-calendar-days class="w-5 h-5"/>
Orders       → <x-heroicon-o-shopping-bag class="w-5 h-5"/>
Users        → <x-heroicon-o-users class="w-5 h-5"/>
Vouchers     → <x-heroicon-o-ticket class="w-5 h-5"/>
Reports      → <x-heroicon-o-chart-bar class="w-5 h-5"/>
```

### Action Buttons
```blade
Add New      → <x-heroicon-m-plus class="w-4 h-4"/>
Edit         → <x-heroicon-m-pencil-square class="w-4 h-4"/>
Delete       → <x-heroicon-m-trash class="w-4 h-4"/>
View         → <x-heroicon-m-eye class="w-4 h-4"/>
Search       → <x-heroicon-m-magnifying-glass class="w-4 h-4"/>
Filter       → <x-heroicon-m-funnel class="w-4 h-4"/>
Export       → <x-heroicon-m-arrow-down-tray class="w-4 h-4"/>
```

### Status Indicators
```blade
Active       → <x-heroicon-c-check-circle class="w-4 h-4 text-green-500"/>
Inactive     → <x-heroicon-c-x-circle class="w-4 h-4 text-gray-400"/>
Success      → <x-heroicon-c-check-circle class="w-4 h-4 text-green-500"/>
Error        → <x-heroicon-c-x-circle class="w-4 h-4 text-red-500"/>
Warning      → <x-heroicon-c-exclamation-triangle class="w-4 h-4 text-yellow-500"/>
```

---

## 🎨 Styling Guidelines

### Size Classes
```css
w-3 h-3    /* 12px - Micro indicators */
w-4 h-4    /* 16px - Small buttons, status */
w-5 h-5    /* 20px - Default size, sidebar */
w-6 h-6    /* 24px - Medium buttons */
w-8 h-8    /* 32px - Large elements */
w-10 h-10  /* 40px - Extra large */
```

### Color Classes
```css
text-gray-400    /* Inactive/disabled */
text-gray-700    /* Default state */
text-blue-600    /* Primary actions */
text-green-600   /* Success states */
text-red-600     /* Danger/delete */
text-yellow-600  /* Warning states */
```

### Example Implementations

#### Sidebar Menu Item
```blade
<a href="{{ route('admin.movies.index') }}" 
   class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 
          {{ request()->routeIs('admin.movies.*') ? 'bg-blue-50 text-blue-700' : '' }}">
   @if(request()->routeIs('admin.movies.*'))
      <x-heroicon-s-film class="w-5 h-5 mr-3"/>
   @else
      <x-heroicon-o-film class="w-5 h-5 mr-3"/>
   @endif
   Movies
</a>
```

#### Action Button
```blade
<button type="button" class="inline-flex items-center px-3 py-2 border border-transparent 
                           text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
   <x-heroicon-m-plus class="w-4 h-4 mr-2"/>
   Add Movie
</button>
```

#### Status Badge
```blade
@if($item->is_active)
   <span class="inline-flex items-center px-2 py-1 text-xs font-medium 
                bg-green-100 text-green-800 rounded-full">
      <x-heroicon-c-check-circle class="w-3 h-3 mr-1"/>
      Active
   </span>
@else
   <span class="inline-flex items-center px-2 py-1 text-xs font-medium 
                bg-gray-100 text-gray-800 rounded-full">
      <x-heroicon-c-x-circle class="w-3 h-3 mr-1"/>
      Inactive
   </span>
@endif
```

---

## 📁 File Structure

```
├── app/Constants/AdminIcons.php                    # Icon constants
├── resources/views/admin/components/
│   ├── icon.blade.php                             # Custom icon component
│   └── icon-guide.blade.php                       # Complete usage guide
├── config/blade-heroicons.php                     # Package configuration
├── public/vendor/blade-heroicons/                 # Published SVG assets
└── ADMIN_DASHBOARD_README.md                      # This documentation
```

---

## 🔧 Configuration

File konfigurasi: `config/blade-heroicons.php`

```php
return [
    /*
    |--------------------------------------------------------------------------
    | Default Classes & Attributes
    |--------------------------------------------------------------------------
    */
    'class' => 'fill-current',
    'attributes' => [
        // Custom attributes untuk semua icons
    ],
];
```

---

## 📝 Best Practices

1. **Konsistensi**: Selalu gunakan ukuran yang konsisten untuk konteks yang sama
2. **Semantik**: Pilih icon yang sesuai dengan fungsinya
3. **Accessibility**: Tambahkan aria-hidden="true" untuk decorative icons
4. **Performance**: Gunakan icon caching dengan `php artisan view:cache`
5. **Maintenance**: Update icon constants ketika menambah/mengubah icons

---

## 🚀 Quick Start

1. Lihat available icons di: https://heroicons.com/
2. Gunakan custom component: `<x-admin.icon name="home" />`
3. Atau gunakan langsung: `<x-heroicon-o-home class="w-5 h-5"/>`
4. Referensi constants: `AdminIcons::DASHBOARD`
5. Cek dokumentasi lengkap di: `resources/views/admin/components/icon-guide.blade.php`

---

*Dokumentasi ini dibuat untuk 7PLAY Admin Dashboard v1.0*
