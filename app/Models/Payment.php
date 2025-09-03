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

    /**
     * Get payment issuer/provider information
     */
    public function getIssuerInfo(): array
    {
        $issuers = [
            'gopay' => [
                'name' => 'GoPay',
                'issuer' => 'Gojek',
                'logo' => '💰'
            ],
            'dana' => [
                'name' => 'DANA',
                'issuer' => 'DANA',
                'logo' => '💳'
            ],
            'ovo' => [
                'name' => 'OVO',
                'issuer' => 'OVO',
                'logo' => '🟣'
            ],
            'shopeepay' => [
                'name' => 'ShopeePay',
                'issuer' => 'Shopee',
                'logo' => '🛒'
            ],
            'linkaja' => [
                'name' => 'LinkAja',
                'issuer' => 'Telkomsel',
                'logo' => '📱'
            ],
            'bca_va' => [
                'name' => 'BCA Virtual Account',
                'issuer' => 'Bank BCA',
                'logo' => '🏦'
            ],
            'bni_va' => [
                'name' => 'BNI Virtual Account',
                'issuer' => 'Bank BNI',
                'logo' => '🏦'
            ],
            'bri_va' => [
                'name' => 'BRI Virtual Account',
                'issuer' => 'Bank BRI',
                'logo' => '🏦'
            ],
            'mandiri_va' => [
                'name' => 'Mandiri Virtual Account',
                'issuer' => 'Bank Mandiri',
                'logo' => '🏦'
            ],
            'permata_va' => [
                'name' => 'Permata Virtual Account',
                'issuer' => 'Bank Permata',
                'logo' => '🏦'
            ],
            'qris' => [
                'name' => 'QRIS',
                'issuer' => 'Bank Indonesia',
                'logo' => '📱'
            ],
            'credit_card' => [
                'name' => 'Kartu Kredit',
                'issuer' => 'Bank Penerbit',
                'logo' => '💳'
            ],
            'bank_transfer' => [
                'name' => 'Transfer Bank',
                'issuer' => 'Bank',
                'logo' => '🏦'
            ]
        ];

        return $issuers[$this->payment_method] ?? [
            'name' => ucfirst(str_replace('_', ' ', $this->payment_method ?? 'Unknown')),
            'issuer' => 'Unknown',
            'logo' => '💳'
        ];
    }

    /**
     * Get formatted payment method name
     */
    public function getFormattedPaymentMethodAttribute(): string
    {
        $issuerInfo = $this->getIssuerInfo();
        return $issuerInfo['name'];
    }

    /**
     * Get payment issuer name
     */
    public function getIssuerAttribute(): string
    {
        $issuerInfo = $this->getIssuerInfo();
        return $issuerInfo['issuer'];
    }
}