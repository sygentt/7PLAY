<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_purchase',
        'max_discount',
        'usage_limit',
        'used_count',
        'points_required',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'points_required' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

    public function isAvailable(): bool
    {
        if (!$this->is_active) return false;
        $now = now();
        if ($this->valid_from && $now->lt($this->valid_from)) return false;
        if ($this->valid_until && $now->gt($this->valid_until)) return false;
        if (!is_null($this->usage_limit) && $this->used_count >= $this->usage_limit) return false;
        return true;
    }
}


