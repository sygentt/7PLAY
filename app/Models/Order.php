<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_number',
        'user_id',
        'showtime_id', 
        'voucher_id',
        'subtotal',
        'discount_amount',
        'total_amount',
        'points_earned',
        'points_used',
        'status',
        'payment_method',
        'payment_reference',
        'payment_data',
        'qr_code',
        'payment_date',
        'expiry_date',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2', 
        'total_amount' => 'decimal:2',
        'points_earned' => 'integer',
        'points_used' => 'integer',
        'payment_data' => 'array',
        'payment_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    /**
     * Order status constants
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Get all available statuses
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pending Payment',
            self::STATUS_PAID => 'Paid',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    /**
     * Get order's user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get order's showtime
     */
    public function showtime(): BelongsTo
    {
        return $this->belongsTo(Showtime::class);
    }

    /**
     * Get order's voucher
     * TODO: Uncomment when Voucher model is created
     */
    // public function voucher(): BelongsTo
    // {
    //     return $this->belongsTo(Voucher::class);
    // }

    /**
     * Get order items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get order payments
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get latest payment
     */
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latest();
    }

    /**
     * Scope to filter by status
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get pending orders
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope to get paid orders
     */
    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    /**
     * Scope to get confirmed orders
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    /**
     * Scope to get cancelled orders
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    /**
     * Scope to get orders by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get orders by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Get status badge with color class
     */
    public function getStatusBadge(): array
    {
        $badges = [
            self::STATUS_PENDING => [
                'text' => 'Pending Payment',
                'class' => 'bg-yellow-100 text-yellow-800'
            ],
            self::STATUS_PAID => [
                'text' => 'Paid',
                'class' => 'bg-blue-100 text-blue-800'
            ],
            self::STATUS_CONFIRMED => [
                'text' => 'Confirmed',
                'class' => 'bg-green-100 text-green-800'
            ],
            self::STATUS_CANCELLED => [
                'text' => 'Cancelled',
                'class' => 'bg-red-100 text-red-800'
            ],
        ];

        return $badges[$this->status] ?? $badges[self::STATUS_PENDING];
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotal(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Get formatted subtotal
     */
    public function getFormattedSubtotal(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Get formatted discount amount
     */
    public function getFormattedDiscount(): string
    {
        return 'Rp ' . number_format($this->discount_amount, 0, ',', '.');
    }

    /**
     * Check if order is expired
     */
    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast() && $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PAID]) && !$this->showtime->hasPassed();
    }

    /**
     * Check if order can be confirmed
     */
    public function canBeConfirmed(): bool
    {
        return $this->status === self::STATUS_PAID && !$this->showtime->hasPassed();
    }

    /**
     * Get seat numbers as string
     */
    public function getSeatNumbers(): string
    {
        return $this->orderItems->map(function ($item) {
            return $item->seat->row_label . $item->seat->seat_number;
        })->join(', ');
    }

    /**
     * Get total tickets count
     */
    public function getTicketCount(): int
    {
        return $this->orderItems->count();
    }

    /**
     * Generate order number
     */
    public static function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        return '7PLAY' . $date . $random;
    }

    /**
     * Boot method to generate order number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
        });
    }
}
