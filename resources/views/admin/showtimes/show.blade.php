@extends('admin.layouts.app')

@section('title', 'Detail Showtime')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <x-heroicon-m-home class="mr-2 h-4 w-4"/>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="h-4 w-4 text-gray-400"/>
                        <a href="{{ route('admin.showtimes.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Showtimes</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="h-4 w-4 text-gray-400"/>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $showtime->movie->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Showtime</h1>
                <p class="mt-1 text-sm text-gray-600">Informasi lengkap jadwal tayang {{ $showtime->movie->title }}</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('admin.showtimes.edit', $showtime) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <x-heroicon-m-pencil class="mr-2 h-4 w-4"/>
                    Edit Showtime
                </a>
                <a href="{{ route('admin.showtimes.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <x-heroicon-m-arrow-left class="mr-2 h-4 w-4"/>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Showtime Info -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-6">
                        <div class="flex items-center">
                            @if($showtime->movie->poster_url)
                                <img class="h-32 w-24 rounded-lg object-cover shadow-md" 
                                     src="{{ $showtime->movie->poster_url }}" 
                                     alt="{{ $showtime->movie->title }}">
                            @else
                                <div class="h-32 w-24 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <x-heroicon-m-film class="h-8 w-8 text-gray-400"/>
                                </div>
                            @endif
                            <div class="ml-6 flex-1">
                                <h2 class="text-2xl font-bold text-gray-900">{{ $showtime->movie->title }}</h2>
                                <p class="text-sm text-gray-500 mb-2">{{ $showtime->movie->genre }} • {{ $showtime->movie->duration }} menit • {{ $showtime->movie->rating }}</p>
                                
                                <div class="flex items-center space-x-4 text-sm">
                                    <div class="flex items-center text-gray-600">
                                        <x-heroicon-m-calendar class="h-4 w-4 mr-1"/>
                                        {{ $showtime->getFormattedDate() }}
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <x-heroicon-m-clock class="h-4 w-4 mr-1"/>
                                        {{ $showtime->getFormattedTime() }}
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <x-heroicon-m-currency-dollar class="h-4 w-4 mr-1"/>
                                        {{ $showtime->getFormattedPrice() }}
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center space-x-3">
                                    @if($showtime->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <x-heroicon-m-check-circle class="mr-1 h-3 w-3"/>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <x-heroicon-m-x-circle class="mr-1 h-3 w-3"/>
                                            Inactive
                                        </span>
                                    @endif

                                    @php $bookingStatus = $showtime->getBookingStatus(); @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bookingStatus['class'] }}">
                                        {{ $bookingStatus['text'] }}
                                    </span>

                                    @if($showtime->hasPassed())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <x-heroicon-m-clock class="mr-1 h-3 w-3"/>
                                            Past Show
                                        </span>
                                    @elseif($showtime->isToday())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <x-heroicon-m-calendar class="mr-1 h-3 w-3"/>
                                            Today
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 px-6 py-4">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Cinema</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $showtime->cinemaHall->cinema->brand }} {{ $showtime->cinemaHall->cinema->name }}
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Studio</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $showtime->cinemaHall->name }}
                                    <span class="text-xs text-gray-500">({{ $showtime->cinemaHall->type }})</span>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Location</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $showtime->cinemaHall->cinema->city->name }}, {{ $showtime->cinemaHall->cinema->city->province }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $showtime->cinemaHall->cinema->address }}</dd>
                            </div>

                            @if($showtime->cinemaHall->cinema->phone)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $showtime->cinemaHall->cinema->phone }}</dd>
                            </div>
                            @endif

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $showtime->created_at->format('d M Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Movie Synopsis -->
                @if($showtime->movie->synopsis)
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Synopsis</h3>
                    </div>
                    <div class="px-6 py-4">
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $showtime->movie->synopsis }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Seat Statistics -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Seat Information</h3>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total Seats</span>
                            <span class="text-sm font-medium text-gray-900">{{ $showtime->cinemaHall->total_seats }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Occupied</span>
                            <span class="text-sm font-medium text-red-600">{{ $showtime->getOccupiedSeatsCount() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Available</span>
                            <span class="text-sm font-medium text-green-600">{{ $showtime->getAvailableSeatsCount() }}</span>
                        </div>
                        <div class="pt-2 border-t">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600">Occupancy Rate</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ round(($showtime->getOccupiedSeatsCount() / $showtime->cinemaHall->total_seats) * 100, 1) }}%
                                </span>
                            </div>
                            <div class="mt-2 bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" 
                                     style="width: {{ ($showtime->getOccupiedSeatsCount() / $showtime->cinemaHall->total_seats) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Information -->
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Revenue Information</h3>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Ticket Price</span>
                            <span class="text-sm font-medium text-gray-900">{{ $showtime->getFormattedPrice() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Tickets Sold</span>
                            <span class="text-sm font-medium text-gray-900">{{ $showtime->getOccupiedSeatsCount() }}</span>
                        </div>
                        <div class="pt-2 border-t">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600">Current Revenue</span>
                                <span class="text-sm font-medium text-green-600">
                                    Rp {{ number_format($showtime->price * $showtime->getOccupiedSeatsCount(), 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span class="text-xs text-gray-500">Potential Revenue</span>
                                <span class="text-xs text-gray-500">
                                    Rp {{ number_format($showtime->price * $showtime->cinemaHall->total_seats, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <a href="{{ route('admin.showtimes.edit', $showtime) }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <x-heroicon-m-pencil class="mr-2 h-4 w-4"/>
                            Edit Showtime
                        </a>
                        
                        <a href="{{ route('admin.movies.show', $showtime->movie) }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <x-heroicon-m-film class="mr-2 h-4 w-4"/>
                            View Movie
                        </a>

                        <a href="{{ route('admin.cinemas.show', $showtime->cinemaHall->cinema) }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <x-heroicon-m-building-office class="mr-2 h-4 w-4"/>
                            View Cinema
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


