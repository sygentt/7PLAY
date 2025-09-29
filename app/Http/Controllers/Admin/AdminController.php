<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Order;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard(): View
    {
        // Get basic stats for dashboard
        $total_users = User::count();
        $total_cities = City::count();
        $total_cinemas = Cinema::count();
        $active_cinemas = Cinema::active()->count();

        $total_orders = Order::count();
        $total_movies = Movie::count();
        $active_showtimes = Showtime::active()->upcoming()->count();
        $today_bookings = Order::completed()
            ->whereDate('created_at', today())
            ->count();
        $new_users_this_month = User::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();

        // Recent orders
        $recent_orders = Order::with(['user', 'showtime.movie'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Revenue stats
        $today_revenue = Order::completed()
            ->whereDate('created_at', today())
            ->sum('total_amount');
        $monthly_revenue = Order::completed()
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total_amount');

        // Recent cities and cinemas
        $recent_cities = City::latest()->take(5)->get();
        $recent_cinemas = Cinema::with('city')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'total_users',
            'total_cities',
            'total_cinemas',
            'active_cinemas',
            'total_orders',
            'total_movies',
            'active_showtimes',
            'today_bookings',
            'new_users_this_month',
            'recent_orders',
            'recent_cities',
            'recent_cinemas',
            'today_revenue',
            'monthly_revenue'
        ));
    }
    
    /**
     * Get dashboard statistics for AJAX requests.
     */
    public function getDashboardStats(): JsonResponse
    {
        $total_orders = Order::count();
        $total_movies = Movie::count();
        $today_revenue = Order::completed()->whereDate('created_at', today())->sum('total_amount');
        $monthly_revenue = Order::completed()->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('total_amount');
        $active_showtimes = Showtime::active()->upcoming()->count();
        $today_bookings = Order::completed()
            ->whereDate('created_at', today())
            ->count();
        $new_users_this_month = User::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();

        return response()->json([
            'total_users' => User::count(),
            'total_cities' => City::count(),
            'total_cinemas' => Cinema::count(),
            'active_cinemas' => Cinema::active()->count(),
            'total_orders' => $total_orders,
            'total_movies' => $total_movies,
            'active_showtimes' => $active_showtimes,
            'today_bookings' => $today_bookings,
            'new_users_this_month' => $new_users_this_month,
            'today_revenue' => (float) $today_revenue,
            'monthly_revenue' => (float) $monthly_revenue,
        ]);
    }
}
