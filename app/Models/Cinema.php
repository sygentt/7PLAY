<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Cinema extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'city_id',
        'name',
        'brand',
        'address',
        'phone',
        'latitude',
        'longitude',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean',
    ];

    /**
     * Get the city that owns the cinema.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the cinema halls for the cinema.
     */
    public function cinema_halls(): HasMany
    {
        return $this->hasMany(CinemaHall::class);
    }

    /**
     * Get active cinema halls for the cinema.
     */
    public function active_cinema_halls(): HasMany
    {
        return $this->hasMany(CinemaHall::class)->where('is_active', true);
    }

    /**
     * Scope a query to only include active cinemas.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to search cinemas by name, brand, or address.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to filter cinemas by city.
     */
    public function scopeByCity(Builder $query, int $cityId): Builder
    {
        return $query->where('city_id', $cityId);
    }

    /**
     * Scope a query to filter cinemas by brand.
     */
    public function scopeByBrand(Builder $query, string $brand): Builder
    {
        return $query->where('brand', $brand);
    }

    /**
     * Get the total number of cinema halls in this cinema.
     */
    public function getCinemaHallsCountAttribute(): int
    {
        return $this->cinema_halls()->count();
    }

    /**
     * Get the total number of active cinema halls in this cinema.
     */
    public function getActiveCinemaHallsCountAttribute(): int
    {
        return $this->active_cinema_halls()->count();
    }

    /**
     * Get the full address display for the cinema.
     */
    public function getFullAddressAttribute(): string
    {
        return "{$this->address}, {$this->city->name}, {$this->city->province}";
    }

    /**
     * Get the display name with brand for the cinema.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->brand} {$this->name}";
    }

    /**
     * Check if cinema has coordinate data.
     */
    public function hasCoordinates(): bool
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }

    /**
     * Get available brands for dropdown.
     */
    public static function getAvailableBrands(): array
    {
        return [
            'XXI' => 'Cinema XXI',
            'CGV' => 'CGV Cinemas',
            'Cinepolis' => 'Cinépolis',
            'Platinum' => 'Platinum Cineplex',
            'New Star' => 'New Star Cineplex',
            'Hollywood' => 'Hollywood Theater',
            'Other' => 'Lainnya',
        ];
    }
}
