<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'seat_id',
        'price',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Status constants
     */
    public const STATUS_BOOKED = 'booked';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Get order item's order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get order item's seat
     */
    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    /**
     * Get order item's showtime through order
     */
    public function showtime(): HasOneThrough
    {
        return $this->hasOneThrough(
            Showtime::class,
            Order::class,
            'id', // Foreign key on orders table
            'id', // Foreign key on showtimes table  
            'order_id', // Local key on order_items table
            'showtime_id' // Local key on orders table
        );
    }

    /**
     * Get formatted price
     */
    public function getFormattedPrice(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get seat label
     */
    public function getSeatLabel(): string
    {
        return $this->seat->row_label . $this->seat->seat_number;
    }
}
