<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CinemaHall extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cinema_id',
        'name',
        'total_seats',
        'rows',
        'seats_per_row',
        'type',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'total_seats' => 'integer',
        'rows' => 'integer',
        'seats_per_row' => 'integer',
    ];

    /**
     * Cinema hall type constants
     */
    public const TYPE_REGULAR = 'regular';
    public const TYPE_PREMIUM = 'premium';
    public const TYPE_IMAX = 'imax';
    public const TYPE_4DX = '4dx';

    /**
     * Get all available types
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_REGULAR => 'Regular',
            self::TYPE_PREMIUM => 'Premium',
            self::TYPE_IMAX => 'IMAX',
            self::TYPE_4DX => '4DX',
        ];
    }

    /**
     * Get cinema hall's cinema
     */
    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    /**
     * Get cinema hall's showtimes
     */
    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }

    /**
     * Get cinema hall's seats
     */
    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    /**
     * Scope to get active cinema halls only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get cinema halls by cinema
     */
    public function scopeByCinema($query, $cinemaId)
    {
        return $query->where('cinema_id', $cinemaId);
    }

    /**
     * Scope to get cinema halls by type
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get type label with icon
     */
    public function getTypeLabel(): array
    {
        $typeLabels = [
            self::TYPE_REGULAR => [
                'text' => 'Regular',
                'class' => 'bg-gray-100 text-gray-800'
            ],
            self::TYPE_PREMIUM => [
                'text' => 'Premium',
                'class' => 'bg-yellow-100 text-yellow-800'
            ],
            self::TYPE_IMAX => [
                'text' => 'IMAX',
                'class' => 'bg-purple-100 text-purple-800'
            ],
            self::TYPE_4DX => [
                'text' => '4DX',
                'class' => 'bg-blue-100 text-blue-800'
            ],
        ];

        return $typeLabels[$this->type] ?? $typeLabels[self::TYPE_REGULAR];
    }

    /**
     * Get full name with cinema
     */
    public function getFullName(): string
    {
        return $this->cinema->name . ' - ' . $this->name;
    }

    /**
     * Check if cinema hall is active
     */
    public function isActive(): bool
    {
        return $this->is_active && $this->cinema->is_active;
    }
}
