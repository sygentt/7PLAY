{{-- 
ICON USAGE GUIDE FOR 7PLAY ADMIN DASHBOARD
===========================================

Panduan Lengkap Penggunaan Icons dengan Blade Heroicons
Package: blade-ui-kit/blade-heroicons
Website: https://heroicons.com/

1. STYLE ICONS YANG TERSEDIA:
   - Outline (o-): Thin stroke icons - ideal untuk navigasi utama
   - Solid (s-): Filled icons - ideal untuk buttons dan highlights  
   - Mini (m-): 20x20px icons - ideal untuk small buttons
   - Micro (c-): 16x16px icons - ideal untuk very small elements

2. PENGGUNAAN BASIC:

   Outline Icons (Recommended untuk sidebar menu):
   <x-heroicon-o-home class="w-6 h-6"/>
   <x-heroicon-o-chart-bar class="w-6 h-6"/>
   <x-heroicon-o-users class="w-6 h-6"/>

   Solid Icons (Recommended untuk active states):
   <x-heroicon-s-home class="w-6 h-6 text-blue-600"/>
   <x-heroicon-s-chart-bar class="w-6 h-6 text-blue-600"/>

   Mini Icons (Recommended untuk buttons):
   <x-heroicon-m-plus class="w-5 h-5"/>
   <x-heroicon-m-pencil class="w-5 h-5"/>

   Micro Icons (Recommended untuk status indicators):
   <x-heroicon-c-check class="w-4 h-4"/>
   <x-heroicon-c-x-mark class="w-4 h-4"/>

3. ICONS UNTUK ADMIN DASHBOARD MODULES:

   === SIDEBAR NAVIGATION ===
   Dashboard: heroicon-o-squares-2x2 atau heroicon-o-chart-pie
   Cities: heroicon-o-building-office-2 atau heroicon-o-map-pin
   Cinemas: heroicon-o-building-storefront atau heroicon-o-film
   Movies: heroicon-o-film atau heroicon-o-play-circle
   Showtimes: heroicon-o-calendar-days atau heroicon-o-clock
   Orders: heroicon-o-shopping-bag atau heroicon-o-document-text
   Users: heroicon-o-users atau heroicon-o-user-group
   Vouchers: heroicon-o-ticket atau heroicon-o-gift
   Reports: heroicon-o-chart-bar atau heroicon-o-presentation-chart-line
   Settings: heroicon-o-cog-6-tooth atau heroicon-o-wrench-screwdriver

   === ACTION BUTTONS ===
   Add/Create: heroicon-m-plus
   Edit: heroicon-m-pencil atau heroicon-m-pencil-square
   Delete: heroicon-m-trash atau heroicon-m-x-mark
   View: heroicon-m-eye atau heroicon-m-document-magnifying-glass
   Save: heroicon-m-check atau heroicon-m-check-circle
   Cancel: heroicon-m-x-mark atau heroicon-m-arrow-uturn-left
   Search: heroicon-m-magnifying-glass
   Filter: heroicon-m-funnel atau heroicon-m-adjustments-horizontal
   Export: heroicon-m-arrow-down-tray atau heroicon-m-document-arrow-down
   Import: heroicon-m-arrow-up-tray atau heroicon-m-document-arrow-up
   Refresh: heroicon-m-arrow-path

   === STATUS INDICATORS ===
   Success: heroicon-c-check-circle (text-green-500)
   Error: heroicon-c-x-circle (text-red-500)
   Warning: heroicon-c-exclamation-triangle (text-yellow-500)
   Info: heroicon-c-information-circle (text-blue-500)
   Active: heroicon-c-check-badge (text-green-500)
   Inactive: heroicon-c-x-mark (text-gray-400)

   === FORM ELEMENTS ===
   Email: heroicon-m-envelope
   Phone: heroicon-m-phone
   Password: heroicon-m-lock-closed
   Calendar: heroicon-m-calendar-days
   Location: heroicon-m-map-pin
   Image: heroicon-m-photo
   File: heroicon-m-document

4. CONTOH IMPLEMENTASI:

   Sidebar Menu Item:
   <a href="{{ route('admin.movies.index') }}" 
      class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.movies.*') ? 'bg-blue-50 text-blue-700' : '' }}">
      @if(request()->routeIs('admin.movies.*'))
         <x-heroicon-s-film class="w-5 h-5 mr-3"/>
      @else
         <x-heroicon-o-film class="w-5 h-5 mr-3"/>
      @endif
      Movies
   </a>

   Action Button:
   <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
      <x-heroicon-m-plus class="w-4 h-4 mr-2"/>
      Add Movie
   </button>

   Status Badge:
   @if($movie->is_active)
      <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
         <x-heroicon-c-check-circle class="w-3 h-3 mr-1"/>
         Active
      </span>
   @else
      <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
         <x-heroicon-c-x-circle class="w-3 h-3 mr-1"/>
         Inactive
      </span>
   @endif

5. ADVANCED USAGE:

   Using @svg directive:
   @svg('heroicon-o-home', 'w-6 h-6 text-gray-400', ['aria-hidden' => 'true'])

   Conditional icons:
   <x-heroicon-{{ $user->is_active ? 's' : 'o' }}-check-circle class="w-5 h-5 {{ $user->is_active ? 'text-green-500' : 'text-gray-400' }}"/>

   Dynamic icons:
   @php
      $statusIcons = [
         'pending' => 'heroicon-o-clock',
         'paid' => 'heroicon-s-check-circle', 
         'cancelled' => 'heroicon-s-x-circle'
      ];
   @endphp
   <x-dynamic-component :component="$statusIcons[$order->status]" class="w-5 h-5"/>

6. TAILWIND CLASSES UNTUK SIZING:
   w-3 h-3 (12px) - Micro icons
   w-4 h-4 (16px) - Small icons
   w-5 h-5 (20px) - Default icons
   w-6 h-6 (24px) - Medium icons
   w-8 h-8 (32px) - Large icons
   w-10 h-10 (40px) - Extra large icons

7. COLORS:
   text-gray-400 - Inactive/disabled
   text-gray-700 - Default
   text-blue-600 - Primary actions
   text-green-600 - Success states
   text-red-600 - Danger/delete actions
   text-yellow-600 - Warning states

Catatan: Selalu gunakan class w-[x] h-[x] yang sama untuk konsistensi visual
--}}
