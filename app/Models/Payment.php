<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'external_id',
        'reference_no',
        'merchant_id',
        'amount',
        'currency',
        'payment_method',
        'payment_type',
        'qr_code_url',
        'deep_link_url',
        'status',
        'fraud_status',
        'transaction_time',
        'settlement_time',
        'expiry_time',
        'customer_details',
        'item_details',
        'metadata',
        'raw_response',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'customer_details' => 'array',
        'item_details' => 'array',
        'metadata' => 'array',
        'raw_response' => 'array',
        'transaction_time' => 'datetime',
        'settlement_time' => 'datetime',
        'expiry_time' => 'datetime',
    ];

    /**
     * Relasi ke Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Scope untuk payment yang berhasil
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'settlement');
    }

    /**
     * Scope untuk payment pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk payment yang gagal
     */
    public function scopeFailed($query)
    {
        return $query->whereIn('status', ['deny', 'cancel', 'expire', 'failure']);
    }

    /**
     * Check apakah payment berhasil
     */
    public function isPaid(): bool
    {
        return $this->status === 'settlement';
    }

    /**
     * Check apakah payment masih pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check apakah payment gagal
     */
    public function isFailed(): bool
    {
        return in_array($this->status, ['deny', 'cancel', 'expire', 'failure']);
    }

    /**
     * Format amount untuk display
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}