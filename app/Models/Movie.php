<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Movie extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'synopsis', 
        'genre',
        'duration',
        'rating',
        'language',
        'poster_url',
        'trailer_url',
        'director',
        'cast',
        'release_date',
        'status',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'cast' => 'array',
        'release_date' => 'date',
        'is_active' => 'boolean',
        'duration' => 'integer',
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = [
        'release_date',
        'created_at',
        'updated_at',
    ];

    /**
     * Movie status constants
     */
    public const STATUS_COMING_SOON = 'coming_soon';
    public const STATUS_NOW_PLAYING = 'now_playing';
    public const STATUS_FINISHED = 'finished';

    /**
     * Get all available statuses
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_COMING_SOON => 'Coming Soon',
            self::STATUS_NOW_PLAYING => 'Now Playing',
            self::STATUS_FINISHED => 'Finished',
        ];
    }

    /**
     * Get all available ratings
     */
    public static function getRatings(): array
    {
        return [
            'SU' => 'SU - Semua Umur',
            '13+' => '13+ - Remaja 13 Tahun ke Atas',
            '17+' => '17+ - Dewasa 17 Tahun ke Atas',
            '21+' => '21+ - Dewasa 21 Tahun ke Atas',
        ];
    }

    /**
     * Get movie showtimes
     */
    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }

    /**
     * Scope to get active movies only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get movies by status
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDuration(): string
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        
        if ($hours > 0) {
            return $hours . 'j ' . $minutes . 'm';
        }
        
        return $minutes . 'm';
    }

    /**
     * Get status label with color class
     */
    public function getStatusBadge(): array
    {
        $badges = [
            self::STATUS_COMING_SOON => [
                'text' => 'Coming Soon',
                'class' => 'bg-blue-100 text-blue-800'
            ],
            self::STATUS_NOW_PLAYING => [
                'text' => 'Now Playing', 
                'class' => 'bg-green-100 text-green-800'
            ],
            self::STATUS_FINISHED => [
                'text' => 'Finished',
                'class' => 'bg-gray-100 text-gray-800'
            ],
        ];

        return $badges[$this->status] ?? $badges[self::STATUS_COMING_SOON];
    }

    /**
     * Get cast as comma separated string
     */
    public function getCastString(): string
    {
        if (is_array($this->cast)) {
            return implode(', ', $this->cast);
        }
        
        return $this->cast ?? '';
    }

    /**
     * Check if movie is currently playing
     */
    public function isNowPlaying(): bool
    {
        return $this->status === self::STATUS_NOW_PLAYING && $this->is_active;
    }

    /**
     * Check if movie is coming soon
     */
    public function isComingSoon(): bool
    {
        return $this->status === self::STATUS_COMING_SOON && $this->is_active;
    }
}
