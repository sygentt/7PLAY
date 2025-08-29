@extends('layouts.public')

@section('title', config('app.name', '7PLAY') . ' - Platform Pemesanan Tiket Bioskop Terpercaya')

@section('description', 'Platform pemesanan tiket bioskop online terpercaya di Indonesia. Booking tiket film favorit Anda dengan mudah dan aman.')

@section('content')
    <!-- Banner Carousel -->
    @include('components.home.banner', ['featured_movies' => $featured_movies])
    
    <!-- Now Playing Section -->
    @include('components.home.now-playing', ['now_playing' => $now_playing])
    
    <!-- Coming Soon Section -->
    @include('components.home.coming-soon', ['coming_soon' => $coming_soon])
@endsection
