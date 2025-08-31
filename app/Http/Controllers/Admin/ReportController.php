<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Cinema;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{
    /**
     * Display the main reports dashboard.
     */
    public function index(Request $request): View
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth());
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth());

        // Key Performance Indicators
        $kpis = [
            'total_revenue' => Order::confirmed()
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->sum('total_amount'),
            
            'total_orders' => Order::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            
            'total_tickets' => Order::confirmed()
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->withCount('orderItems')
                ->get()
                ->sum('order_items_count'),
            
            'avg_order_value' => Order::confirmed()
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->avg('total_amount') ?? 0,
            
            'new_users' => User::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            
            'active_movies' => Movie::active()->byStatus(Movie::STATUS_NOW_PLAYING)->count(),
            
            'conversion_rate' => $this->getConversionRate($dateFrom, $dateTo),
            
            'customer_retention' => $this->getCustomerRetentionRate($dateFrom, $dateTo),
        ];

        // Growth metrics (compared to previous period)
        $previousPeriodStart = Carbon::parse($dateFrom)->subDays(Carbon::parse($dateFrom)->diffInDays($dateTo) + 1);
        $previousPeriodEnd = Carbon::parse($dateFrom)->subDay();

        $growth = [
            'revenue_growth' => $this->calculateGrowth(
                Order::confirmed()->whereBetween('created_at', [$dateFrom, $dateTo])->sum('total_amount'),
                Order::confirmed()->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->sum('total_amount')
            ),
            'orders_growth' => $this->calculateGrowth(
                Order::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
                Order::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count()
            ),
            'users_growth' => $this->calculateGrowth(
                User::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
                User::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count()
            ),
        ];

        // Quick insights
        $insights = [
            'top_movie' => $this->getTopMovie($dateFrom, $dateTo),
            'top_cinema' => $this->getTopCinema($dateFrom, $dateTo),
            'peak_day' => $this->getPeakDay($dateFrom, $dateTo),
            'busiest_time' => $this->getBusiestTime($dateFrom, $dateTo),
        ];

        return view('admin.reports.index', compact('kpis', 'growth', 'insights', 'dateFrom', 'dateTo'));
    }

    /**
     * Sales and revenue reports.
     */
    public function sales(Request $request): View
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth());
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth());

        // Daily revenue trend
        $dailyRevenue = Order::confirmed()
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Revenue by payment method
        $paymentMethodRevenue = Order::confirmed()
            ->selectRaw('payment_method, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->whereNotNull('payment_method')
            ->groupBy('payment_method')
            ->orderByDesc('revenue')
            ->get();

        // Revenue by city
        $cityRevenue = Order::confirmed()
            ->join('showtimes', 'orders.showtime_id', '=', 'showtimes.id')
            ->join('cinema_halls', 'showtimes.cinema_hall_id', '=', 'cinema_halls.id')
            ->join('cinemas', 'cinema_halls.cinema_id', '=', 'cinemas.id')
            ->join('cities', 'cinemas.city_id', '=', 'cities.id')
            ->selectRaw('cities.name as city, SUM(orders.total_amount) as revenue, COUNT(orders.id) as orders')
            ->whereBetween('orders.created_at', [$dateFrom, $dateTo])
            ->groupBy('cities.id', 'cities.name')
            ->orderByDesc('revenue')
            ->get();

        // Revenue by cinema
        $cinemaRevenue = Order::confirmed()
            ->join('showtimes', 'orders.showtime_id', '=', 'showtimes.id')
            ->join('cinema_halls', 'showtimes.cinema_hall_id', '=', 'cinema_halls.id')
            ->join('cinemas', 'cinema_halls.cinema_id', '=', 'cinemas.id')
            ->selectRaw('cinemas.name as cinema, SUM(orders.total_amount) as revenue, COUNT(orders.id) as orders')
            ->whereBetween('orders.created_at', [$dateFrom, $dateTo])
            ->groupBy('cinemas.id', 'cinemas.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        return view('admin.reports.sales', compact('dailyRevenue', 'paymentMethodRevenue', 'cityRevenue', 'cinemaRevenue', 'dateFrom', 'dateTo'));
    }

    /**
     * Movie performance reports.
     */
    public function movies(Request $request): View
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth());
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth());

        // Top performing movies
        $topMovies = Order::confirmed()
            ->join('showtimes', 'orders.showtime_id', '=', 'showtimes.id')
            ->join('movies', 'showtimes.movie_id', '=', 'movies.id')
            ->selectRaw('movies.title, movies.genre, movies.rating, SUM(orders.total_amount) as revenue, COUNT(orders.id) as tickets_sold, AVG(orders.total_amount) as avg_ticket_price')
            ->whereBetween('orders.created_at', [$dateFrom, $dateTo])
            ->groupBy('movies.id', 'movies.title', 'movies.genre', 'movies.rating')
            ->orderByDesc('revenue')
            ->limit(20)
            ->get();

        // Movie performance by genre
        $genrePerformance = Order::confirmed()
            ->join('showtimes', 'orders.showtime_id', '=', 'showtimes.id')
            ->join('movies', 'showtimes.movie_id', '=', 'movies.id')
            ->selectRaw('movies.genre, SUM(orders.total_amount) as revenue, COUNT(orders.id) as tickets_sold')
            ->whereBetween('orders.created_at', [$dateFrom, $dateTo])
            ->whereNotNull('movies.genre')
            ->groupBy('movies.genre')
            ->orderByDesc('revenue')
            ->get();

        // Movie ratings performance
        $ratingPerformance = Order::confirmed()
            ->join('showtimes', 'orders.showtime_id', '=', 'showtimes.id')
            ->join('movies', 'showtimes.movie_id', '=', 'movies.id')
            ->selectRaw('movies.rating, SUM(orders.total_amount) as revenue, COUNT(orders.id) as tickets_sold')
            ->whereBetween('orders.created_at', [$dateFrom, $dateTo])
            ->groupBy('movies.rating')
            ->orderByDesc('revenue')
            ->get();

        // Showtime utilization
        $showtimeUtilization = Showtime::with(['movie', 'cinemaHall.cinema'])
            ->withCount(['orderItems' => function ($query) use ($dateFrom, $dateTo) {
                $query->whereHas('order', function ($q) use ($dateFrom, $dateTo) {
                    $q->confirmed()->whereBetween('created_at', [$dateFrom, $dateTo]);
                });
            }])
            ->whereBetween('show_date', [$dateFrom, $dateTo])
            ->get()
            ->map(function ($showtime) {
                $utilization = ($showtime->order_items_count / $showtime->cinemaHall->total_seats) * 100;
                return [
                    'movie' => $showtime->movie->title,
                    'cinema' => $showtime->cinemaHall->cinema->name,
                    'show_date' => $showtime->show_date->format('d M Y'),
                    'show_time' => $showtime->show_time->format('H:i'),
                    'total_seats' => $showtime->cinemaHall->total_seats,
                    'sold_seats' => $showtime->order_items_count,
                    'utilization' => round($utilization, 1),
                ];
            })
            ->sortByDesc('utilization')
            ->take(20)
            ->values();

        return view('admin.reports.movies', compact('topMovies', 'genrePerformance', 'ratingPerformance', 'showtimeUtilization', 'dateFrom', 'dateTo'));
    }

    /**
     * User analytics reports.
     */
    public function users(Request $request): View
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth());
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth());

        // User registration trend
        $userGrowth = User::selectRaw('DATE(created_at) as date, COUNT(*) as new_users')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top customers by spending
        $topCustomers = User::withSum(['orders as total_spent' => function ($q) use ($dateFrom, $dateTo) {
                $q->confirmed()->whereBetween('created_at', [$dateFrom, $dateTo]);
            }], 'total_amount')
            ->withCount(['orders as total_orders' => function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            }])
            ->having('total_spent', '>', 0)
            ->orderByDesc('total_spent')
            ->limit(20)
            ->get();

        // User demographics
        $demographics = [
            'gender' => User::selectRaw('gender, COUNT(*) as count')
                ->whereNotNull('gender')
                ->groupBy('gender')
                ->get(),
            'age_groups' => $this->getUserAgeGroups(),
            'cities' => $this->getTopUserCities($dateFrom, $dateTo),
        ];

        // Customer behavior
        $behavior = [
            'avg_orders_per_user' => Order::whereBetween('created_at', [$dateFrom, $dateTo])->count() / (User::count() ?: 1),
            'repeat_customers' => $this->getRepeatCustomers($dateFrom, $dateTo),
            'customer_lifetime_value' => $this->getCustomerLifetimeValue(),
        ];

        return view('admin.reports.users', compact('userGrowth', 'topCustomers', 'demographics', 'behavior', 'dateFrom', 'dateTo'));
    }

    /**
     * Get chart data for AJAX requests.
     */
    public function getChartData(Request $request): JsonResponse
    {
        $type = $request->input('type');
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth());
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth());

        switch ($type) {
            case 'revenue_trend':
                return response()->json($this->getRevenueTrend($dateFrom, $dateTo));
                
            case 'order_status':
                return response()->json($this->getOrderStatusChart($dateFrom, $dateTo));
                
            case 'movie_genre':
                return response()->json($this->getMovieGenreChart($dateFrom, $dateTo));
                
            case 'payment_methods':
                return response()->json($this->getPaymentMethodChart($dateFrom, $dateTo));
                
            case 'hourly_sales':
                return response()->json($this->getHourlySalesChart($dateFrom, $dateTo));
                
            default:
                return response()->json(['error' => 'Invalid chart type'], 400);
        }
    }

    /**
     * Export reports to CSV/PDF.
     */
    public function export(Request $request, string $type)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth());
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth());

        switch ($type) {
            case 'sales':
                return $this->exportSalesReport($dateFrom, $dateTo);
            case 'movies':
                return $this->exportMoviesReport($dateFrom, $dateTo);
            case 'users':
                return $this->exportUsersReport($dateFrom, $dateTo);
            default:
                return redirect()->back()->with('error', 'Invalid export type.');
        }
    }

    // Helper methods for calculations and data processing
    
    private function getConversionRate($dateFrom, $dateTo): float
    {
        $totalVisitors = User::whereBetween('created_at', [$dateFrom, $dateTo])->count();
        $totalOrders = Order::confirmed()->whereBetween('created_at', [$dateFrom, $dateTo])->distinct('user_id')->count();
        
        return $totalVisitors > 0 ? ($totalOrders / $totalVisitors) * 100 : 0;
    }

    private function getCustomerRetentionRate($dateFrom, $dateTo): float
    {
        $previousPeriodStart = Carbon::parse($dateFrom)->subMonth();
        $previousPeriodEnd = Carbon::parse($dateFrom)->subDay();
        
        $previousCustomers = Order::confirmed()
            ->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])
            ->distinct('user_id')
            ->pluck('user_id');
            
        $currentCustomers = Order::confirmed()
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->distinct('user_id')
            ->pluck('user_id');
            
        $retainedCustomers = $previousCustomers->intersect($currentCustomers)->count();
        
        return $previousCustomers->count() > 0 ? ($retainedCustomers / $previousCustomers->count()) * 100 : 0;
    }

    private function calculateGrowth($current, $previous): array
    {
        if ($previous == 0) {
            return ['percentage' => $current > 0 ? 100 : 0, 'trend' => $current > 0 ? 'up' : 'neutral'];
        }
        
        $percentage = (($current - $previous) / $previous) * 100;
        return [
            'percentage' => round(abs($percentage), 1),
            'trend' => $percentage > 0 ? 'up' : ($percentage < 0 ? 'down' : 'neutral')
        ];
    }

    private function getTopMovie($dateFrom, $dateTo): ?array
    {
        $topMovie = Order::where('orders.status', 'confirmed')
            ->join('showtimes', 'orders.showtime_id', '=', 'showtimes.id')
            ->join('movies', 'showtimes.movie_id', '=', 'movies.id')
            ->selectRaw('movies.title, SUM(orders.total_amount) as revenue')
            ->whereBetween('orders.created_at', [$dateFrom, $dateTo])
            ->groupBy('movies.id', 'movies.title')
            ->orderByDesc('revenue')
            ->first();

        return $topMovie ? [
            'title' => $topMovie->title,
            'revenue' => $topMovie->revenue
        ] : null;
    }

    private function getTopCinema($dateFrom, $dateTo): ?array
    {
        $topCinema = Order::confirmed()
            ->join('showtimes', 'orders.showtime_id', '=', 'showtimes.id')
            ->join('cinema_halls', 'showtimes.cinema_hall_id', '=', 'cinema_halls.id')
            ->join('cinemas', 'cinema_halls.cinema_id', '=', 'cinemas.id')
            ->selectRaw('cinemas.name, SUM(orders.total_amount) as revenue')
            ->whereBetween('orders.created_at', [$dateFrom, $dateTo])
            ->groupBy('cinemas.id', 'cinemas.name')
            ->orderByDesc('revenue')
            ->first();

        return $topCinema ? [
            'name' => $topCinema->name,
            'revenue' => $topCinema->revenue
        ] : null;
    }

    private function getPeakDay($dateFrom, $dateTo): ?array
    {
        $peakDay = Order::confirmed()
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('date')
            ->orderByDesc('revenue')
            ->first();

        return $peakDay ? [
            'date' => Carbon::parse($peakDay->date)->format('d M Y'),
            'revenue' => $peakDay->revenue
        ] : null;
    }

    private function getBusiestTime($dateFrom, $dateTo): ?array
    {
        $busiestTime = Order::confirmed()
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as orders')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('hour')
            ->orderByDesc('orders')
            ->first();

        return $busiestTime ? [
            'hour' => $busiestTime->hour . ':00',
            'orders' => $busiestTime->orders
        ] : null;
    }

    private function getRevenueTrend($dateFrom, $dateTo): array
    {
        return Order::confirmed()
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'revenue' => (float) $item->revenue
                ];
            })
            ->toArray();
    }

    private function getOrderStatusChart($dateFrom, $dateTo): array
    {
        return Order::selectRaw('status, COUNT(*) as count')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                return [
                    'status' => ucfirst($item->status),
                    'count' => $item->count
                ];
            })
            ->toArray();
    }

    private function getMovieGenreChart($dateFrom, $dateTo): array
    {
        return Order::confirmed()
            ->join('showtimes', 'orders.showtime_id', '=', 'showtimes.id')
            ->join('movies', 'showtimes.movie_id', '=', 'movies.id')
            ->selectRaw('movies.genre, SUM(orders.total_amount) as revenue')
            ->whereBetween('orders.created_at', [$dateFrom, $dateTo])
            ->whereNotNull('movies.genre')
            ->groupBy('movies.genre')
            ->get()
            ->map(function ($item) {
                return [
                    'genre' => $item->genre,
                    'revenue' => (float) $item->revenue
                ];
            })
            ->toArray();
    }

    private function getPaymentMethodChart($dateFrom, $dateTo): array
    {
        return Order::confirmed()
            ->selectRaw('payment_method, COUNT(*) as count, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->whereNotNull('payment_method')
            ->groupBy('payment_method')
            ->get()
            ->map(function ($item) {
                return [
                    'method' => ucfirst(str_replace('_', ' ', $item->payment_method)),
                    'count' => $item->count,
                    'revenue' => (float) $item->revenue
                ];
            })
            ->toArray();
    }

    private function getHourlySalesChart($dateFrom, $dateTo): array
    {
        return Order::confirmed()
            ->selectRaw('HOUR(created_at) as hour, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->map(function ($item) {
                return [
                    'hour' => $item->hour . ':00',
                    'revenue' => (float) $item->revenue
                ];
            })
            ->toArray();
    }

    private function getUserAgeGroups(): array
    {
        $users = User::whereNotNull('birth_date')->get();
        $ageGroups = ['18-25' => 0, '26-35' => 0, '36-45' => 0, '46-55' => 0, '55+' => 0];
        
        foreach ($users as $user) {
            $age = $user->getAge();
            if ($age <= 25) $ageGroups['18-25']++;
            elseif ($age <= 35) $ageGroups['26-35']++;
            elseif ($age <= 45) $ageGroups['36-45']++;
            elseif ($age <= 55) $ageGroups['46-55']++;
            else $ageGroups['55+']++;
        }
        
        return $ageGroups;
    }

    private function getTopUserCities($dateFrom, $dateTo): array
    {
        return Order::whereBetween('created_at', [$dateFrom, $dateTo])
            ->join('showtimes', 'orders.showtime_id', '=', 'showtimes.id')
            ->join('cinema_halls', 'showtimes.cinema_hall_id', '=', 'cinema_halls.id')
            ->join('cinemas', 'cinema_halls.cinema_id', '=', 'cinemas.id')
            ->join('cities', 'cinemas.city_id', '=', 'cities.id')
            ->selectRaw('cities.name as city, COUNT(DISTINCT orders.user_id) as users')
            ->groupBy('cities.id', 'cities.name')
            ->orderByDesc('users')
            ->limit(10)
            ->get()
            ->toArray();
    }

    private function getRepeatCustomers($dateFrom, $dateTo): int
    {
        return Order::whereBetween('created_at', [$dateFrom, $dateTo])
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();
    }

    private function getCustomerLifetimeValue(): float
    {
        return User::withSum(['orders as total_spent' => function ($q) {
                $q->confirmed();
            }], 'total_amount')
            ->avg('total_spent') ?? 0;
    }

    private function exportSalesReport($dateFrom, $dateTo)
    {
        // Implementation for CSV export
        $filename = 'sales_report_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        // Return CSV response with sales data
        return response()->stream(function() use ($dateFrom, $dateTo) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date', 'Revenue', 'Orders', 'Tickets Sold', 'Avg Order Value']);
            
            $data = Order::confirmed()
                ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders, SUM((SELECT COUNT(*) FROM order_items WHERE order_items.order_id = orders.id)) as tickets')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            
            foreach ($data as $row) {
                fputcsv($handle, [
                    $row->date,
                    $row->revenue,
                    $row->orders,
                    $row->tickets,
                    $row->orders > 0 ? round($row->revenue / $row->orders, 2) : 0
                ]);
            }
            
            fclose($handle);
        }, 200, $headers);
    }

    private function exportMoviesReport($dateFrom, $dateTo)
    {
        // Similar implementation for movies report
        return $this->exportSalesReport($dateFrom, $dateTo); // Placeholder
    }

    private function exportUsersReport($dateFrom, $dateTo)
    {
        // Similar implementation for users report
        return $this->exportSalesReport($dateFrom, $dateTo); // Placeholder
    }
}
