<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class City extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'province', 
        'code',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the cinemas for the city.
     */
    public function cinemas(): HasMany
    {
        return $this->hasMany(Cinema::class);
    }

    /**
     * Get active cinemas for the city.
     */
    public function active_cinemas(): HasMany
    {
        return $this->hasMany(Cinema::class)->where('is_active', true);
    }

    /**
     * Scope a query to only include active cities.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to search cities by name or province.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('province', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        });
    }

    /**
     * Get the total number of cinemas in this city.
     */
    public function getCinemasCountAttribute(): int
    {
        return $this->cinemas()->count();
    }

    /**
     * Get the total number of active cinemas in this city.
     */
    public function getActiveCinemasCountAttribute(): int
    {
        return $this->active_cinemas()->count();
    }

    /**
     * Get the display name for the city (Name, Province).
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name}, {$this->province}";
    }
}
