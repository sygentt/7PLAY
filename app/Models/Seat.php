<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cinema_hall_id',
        'row_label',
        'seat_number',
        'type',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'seat_number' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Seat type constants
     */
    public const TYPE_REGULAR = 'regular';
    public const TYPE_PREMIUM = 'premium';
    public const TYPE_WHEELCHAIR = 'wheelchair';

    /**
     * Get all available types
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_REGULAR => 'Regular',
            self::TYPE_PREMIUM => 'Premium',
            self::TYPE_WHEELCHAIR => 'Wheelchair Accessible',
        ];
    }

    /**
     * Get seat's cinema hall
     */
    public function cinemaHall(): BelongsTo
    {
        return $this->belongsTo(CinemaHall::class);
    }

    /**
     * Get seat's order items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get seat's reservations
     */
    public function seatReservations(): HasMany
    {
        return $this->hasMany(SeatReservation::class);
    }

    /**
     * Scope to get active seats only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get seats by cinema hall
     */
    public function scopeByCinemaHall($query, $cinemaHallId)
    {
        return $query->where('cinema_hall_id', $cinemaHallId);
    }

    /**
     * Scope to get seats by type
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get seat label
     */
    public function getLabel(): string
    {
        return $this->row_label . $this->seat_number;
    }

    /**
     * Check if seat is available for specific showtime
     */
    public function isAvailableForShowtime($showtimeId): bool
    {
        // Check if seat is booked for this showtime
        $isBooked = OrderItem::whereHas('order', function ($query) use ($showtimeId) {
            $query->where('showtime_id', $showtimeId)
                  ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_CONFIRMED]);
        })->where('seat_id', $this->id)->exists();

        // Check if seat is currently reserved for this showtime  
        $isReserved = SeatReservation::where('seat_id', $this->id)
            ->where('showtime_id', $showtimeId)
            ->where('status', SeatReservation::STATUS_RESERVED)
            ->where('expires_at', '>', now())
            ->exists();

        return !$isBooked && !$isReserved && $this->is_active;
    }
}
