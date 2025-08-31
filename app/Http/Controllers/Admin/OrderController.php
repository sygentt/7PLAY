<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request): View
    {
        $query = Order::query()
            ->with(['user', 'showtime.movie', 'showtime.cinemaHall.cinema.city', 'orderItems'])
            ->withCount('orderItems');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('showtime.movie', function ($movieQuery) use ($search) {
                      $movieQuery->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

        // Filter by movie
        if ($request->filled('movie_id')) {
            $query->whereHas('showtime', function ($q) use ($request) {
                $q->where('movie_id', $request->movie_id);
            });
        }

        // Filter by city
        if ($request->filled('city_id')) {
            $query->whereHas('showtime.cinemaHall.cinema', function ($q) use ($request) {
                $q->where('city_id', $request->city_id);
            });
        }

        // Filter by cinema
        if ($request->filled('cinema_id')) {
            $query->whereHas('showtime.cinemaHall', function ($q) use ($request) {
                $q->where('cinema_id', $request->cinema_id);
            });
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Quick date filters
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfMonth(),
                        Carbon::now()->endOfMonth()
                    ]);
                    break;
                case 'last_month':
                    $query->whereBetween('created_at', [
                        Carbon::now()->subMonth()->startOfMonth(),
                        Carbon::now()->subMonth()->endOfMonth()
                    ]);
                    break;
            }
        }

        // Sort functionality
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        $allowedSorts = ['created_at', 'order_number', 'total_amount', 'status', 'payment_date'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $orders = $query->paginate(15)->appends($request->all());

        // Get filter options
        $statuses = Order::getStatuses();
        $movies = Movie::active()->orderBy('title')->get();
        $cities = City::active()->orderBy('name')->get();
        $cinemas = Cinema::active()->orderBy('name')->get();
        $paymentMethods = ['midtrans', 'qris', 'bank_transfer', 'wallet'];

        // Statistics
        $stats = [
            'total' => Order::count(),
            'pending' => Order::pending()->count(),
            'paid' => Order::paid()->count(),
            'confirmed' => Order::confirmed()->count(),
            'cancelled' => Order::cancelled()->count(),
            'today_revenue' => Order::confirmed()->whereDate('created_at', Carbon::today())->sum('total_amount'),
            'month_revenue' => Order::confirmed()->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])->sum('total_amount'),
        ];

        return view('admin.orders.index', compact(
            'orders', 'statuses', 'movies', 'cities', 'cinemas', 'paymentMethods', 'stats'
        ));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): View
    {
        $order->load([
            'user',
            'showtime.movie',
            'showtime.cinemaHall.cinema.city',
            'orderItems.seat',
            'voucher'
        ]);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', array_keys(Order::getStatuses()))],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Business logic for status changes
        if ($oldStatus === Order::STATUS_CANCELLED) {
            return back()->with('error', 'Tidak dapat mengubah status order yang sudah dibatalkan.');
        }

        if ($newStatus === Order::STATUS_CONFIRMED && $oldStatus !== Order::STATUS_PAID) {
            return back()->with('error', 'Order hanya bisa dikonfirmasi jika sudah dibayar.');
        }

        if ($newStatus === Order::STATUS_PAID && $oldStatus !== Order::STATUS_PENDING) {
            return back()->with('error', 'Status paid hanya berlaku untuk order pending.');
        }

        // Handle status-specific updates
        $updateData = ['status' => $newStatus];
        
        if ($newStatus === Order::STATUS_PAID && !$order->payment_date) {
            $updateData['payment_date'] = now();
        }

        if ($newStatus === Order::STATUS_CANCELLED) {
            // Cancel seat reservations
            $order->orderItems()->update(['status' => 'cancelled']);
        }

        $order->update($updateData);

        $statusText = Order::getStatuses()[$newStatus];
        
        return back()->with('success', "Status order berhasil diubah menjadi '{$statusText}'.");
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order): RedirectResponse
    {
        // Only allow deletion of cancelled orders or very old orders
        if ($order->status !== Order::STATUS_CANCELLED && $order->created_at->gt(Carbon::now()->subDays(30))) {
            return back()->with('error', 'Hanya order yang dibatalkan atau order lama (>30 hari) yang dapat dihapus.');
        }

        $orderNumber = $order->order_number;
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', "Order '{$orderNumber}' berhasil dihapus.");
    }

    /**
     * Get order statistics for AJAX requests
     */
    public function getStats(Request $request): JsonResponse
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth());
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth());

        $stats = [
            'total_orders' => Order::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'total_revenue' => Order::confirmed()->whereBetween('created_at', [$dateFrom, $dateTo])->sum('total_amount'),
            'avg_order_value' => Order::confirmed()->whereBetween('created_at', [$dateFrom, $dateTo])->avg('total_amount'),
            'total_tickets' => Order::confirmed()->whereBetween('created_at', [$dateFrom, $dateTo])->withCount('orderItems')->get()->sum('order_items_count'),
            'status_breakdown' => Order::whereBetween('created_at', [$dateFrom, $dateTo])
                ->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),
            'payment_method_breakdown' => Order::confirmed()->whereBetween('created_at', [$dateFrom, $dateTo])
                ->selectRaw('payment_method, count(*) as count')
                ->groupBy('payment_method')
                ->pluck('count', 'payment_method'),
            'daily_revenue' => Order::confirmed()
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('revenue', 'date'),
        ];

        return response()->json($stats);
    }

    /**
     * Export orders to CSV
     */
    public function export(Request $request)
    {
        $query = Order::query()
            ->with(['user', 'showtime.movie', 'showtime.cinemaHall.cinema.city', 'orderItems'])
            ->withCount('orderItems');

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $filename = 'orders_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'Order Number',
                'Customer Name',
                'Customer Email', 
                'Movie Title',
                'Cinema',
                'Show Date',
                'Show Time',
                'Seats',
                'Tickets',
                'Total Amount',
                'Status',
                'Payment Method',
                'Order Date',
            ]);

            // CSV Data
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->user->name,
                    $order->user->email,
                    $order->showtime->movie->title,
                    $order->showtime->cinemaHall->cinema->name,
                    $order->showtime->show_date->format('d M Y'),
                    $order->showtime->show_time->format('H:i'),
                    $order->getSeatNumbers(),
                    $order->getTicketCount(),
                    $order->total_amount,
                    Order::getStatuses()[$order->status],
                    $order->payment_method,
                    $order->created_at->format('d M Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
