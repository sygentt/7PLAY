<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use App\Models\Cinema;
// use App\Models\Order;
// use App\Models\Movie;
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
        $total_orders = 0; // Order::count() - will be updated when Order model is created
        $total_movies = 0; // Movie::count() - will be updated when Movie model is created
        
        // Recent orders (will be implemented when Order model is created)
        $recent_orders = [];
        
        // Revenue stats (will be implemented when Order model is created)
        $today_revenue = 0;
        $monthly_revenue = 0;
        
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
        return response()->json([
            'total_users' => User::count(),
            'total_cities' => City::count(),
            'total_cinemas' => Cinema::count(),
            'active_cinemas' => Cinema::active()->count(),
            'total_orders' => 0, // Order::count(),
            'total_movies' => 0, // Movie::count(),
            'today_revenue' => 0, // Order::whereDate('created_at', today())->sum('total_amount'),
            'monthly_revenue' => 0, // Order::whereMonth('created_at', now()->month)->sum('total_amount'),
        ]);
    }
}
