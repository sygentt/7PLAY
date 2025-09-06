<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class SeatReservation extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'showtime_id',
        'seat_id',
        'reserved_at',
        'expires_at',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'reserved_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Status constants
     */
    public const STATUS_RESERVED = 'reserved';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_CONFIRMED = 'confirmed';

    /**
     * Get reservation's user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get reservation's showtime
     */
    public function showtime(): BelongsTo
    {
        return $this->belongsTo(Showtime::class);
    }

    /**
     * Get reservation's seat
     */
    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    /**
     * Scope to get active reservations
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_RESERVED)
                    ->where('expires_at', '>', now());
    }

    /**
     * Scope to get expired reservations
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now())
                    ->where('status', self::STATUS_RESERVED);
    }

    /**
     * Check if reservation is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast() && $this->status === self::STATUS_RESERVED;
    }

    /**
     * Create reservation with default expiry time
     */
    public static function createReservation($userId, $showtimeId, $seatId, $minutes = null): self
    {
        $ttl = $minutes ?? (int) config('booking.ttl_minutes', 10);
        return self::create([
            'user_id' => $userId,
            'showtime_id' => $showtimeId,
            'seat_id' => $seatId,
            'reserved_at' => now(),
            'expires_at' => now()->addMinutes($ttl),
            'status' => self::STATUS_RESERVED,
        ]);
    }

    /**
     * Extend reservation expiry time
     */
    public function extend($minutes = null): bool
    {
        if ($this->status === self::STATUS_RESERVED) {
            $ttl = $minutes ?? (int) config('booking.ttl_minutes', 10);
            $this->update(['expires_at' => now()->addMinutes($ttl)]);
            return true;
        }
        return false;
    }

    /**
     * Mark reservation as confirmed
     */
    public function confirm(): bool
    {
        if ($this->status === self::STATUS_RESERVED) {
            $this->update(['status' => self::STATUS_CONFIRMED]);
            return true;
        }
        return false;
    }

    /**
     * Boot method to handle expired reservations
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-expire reservations when queried
        static::addGlobalScope('auto_expire', function ($builder) {
            // This will be handled by a scheduled job instead
            // to avoid performance issues on every query
        });
    }
}
