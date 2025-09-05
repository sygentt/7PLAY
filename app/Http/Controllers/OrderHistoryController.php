<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderHistoryController extends Controller
{
    /**
     * Display user's order history.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        
        // Get all user orders with pagination
        $orders = $user->orders()
            ->with(['orderItems.showtime' => function ($query) {
                $query->with(['movie', 'cinemaHall.cinema']);
            }, 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('profile.orders-history', compact('orders'));
    }

    /**
     * Display the specified order detail.
     */
    public function show(Request $request, Order $order): View
    {
        $user = $request->user();
        
        // Ensure user can only view their own orders
        if ($order->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
        
        // Load order with all related data
        $order->load([
            'orderItems.seat',
            'orderItems.showtime' => function ($query) {
                $query->with(['movie', 'cinemaHall.cinema.city']);
            },
            'payment',
            'user'
        ]);

        return view('profile.order-detail', compact('order'));
    }
}
