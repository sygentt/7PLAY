<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Showtime extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'movie_id',
        'cinema_hall_id',
        'show_date',
        'show_time',
        'price',
        'available_seats',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'show_date' => 'date',
        'show_time' => 'datetime:H:i',
        'price' => 'decimal:2',
        'available_seats' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = [
        'show_date',
        'show_time',
        'created_at',
        'updated_at',
    ];

    /**
     * Get showtime's movie
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Get showtime's cinema hall
     */
    public function cinemaHall(): BelongsTo
    {
        return $this->belongsTo(CinemaHall::class);
    }

    /**
     * Get showtime's seat reservations
     */
    public function seatReservations(): HasMany
    {
        return $this->hasMany(SeatReservation::class);
    }

    /**
     * Scope to get active showtimes only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get showtimes by movie
     */
    public function scopeByMovie($query, $movieId)
    {
        return $query->where('movie_id', $movieId);
    }

    /**
     * Scope to get showtimes by cinema hall
     */
    public function scopeByCinemaHall($query, $cinemaHallId)
    {
        return $query->where('cinema_hall_id', $cinemaHallId);
    }

    /**
     * Scope to get showtimes by cinema
     */
    public function scopeByCinema($query, $cinemaId)
    {
        return $query->whereHas('cinemaHall', function ($q) use ($cinemaId) {
            $q->where('cinema_id', $cinemaId);
        });
    }

    /**
     * Scope to get showtimes by city
     */
    public function scopeByCity($query, $cityId)
    {
        return $query->whereHas('cinemaHall.cinema', function ($q) use ($cityId) {
            $q->where('city_id', $cityId);
        });
    }

    /**
     * Scope to get showtimes by date
     */
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('show_date', $date);
    }

    /**
     * Scope to get showtimes from today
     */
    public function scopeUpcoming($query)
    {
        return $query->whereDate('show_date', '>=', Carbon::today());
    }

    /**
     * Scope to get showtimes that have started
     */
    public function scopePast($query)
    {
        return $query->where(function ($q) {
            $q->whereDate('show_date', '<', Carbon::today())
              ->orWhere(function ($subQuery) {
                  $subQuery->whereDate('show_date', Carbon::today())
                           ->whereTime('show_time', '<', Carbon::now()->format('H:i'));
              });
        });
    }

    /**
     * Get formatted show date and time
     */
    public function getFormattedDateTime(): string
    {
        return $this->show_date->format('d M Y') . ' ' . $this->show_time->format('H:i');
    }

    /**
     * Get formatted show date
     */
    public function getFormattedDate(): string
    {
        return $this->show_date->format('d F Y');
    }

    /**
     * Get formatted show time
     */
    public function getFormattedTime(): string
    {
        return $this->show_time->format('H:i');
    }

    /**
     * Get formatted price
     */
    public function getFormattedPrice(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Check if showtime has passed
     */
    public function hasPassed(): bool
    {
        $showDateTime = $this->show_date->copy()->setTimeFromTimeString($this->show_time->format('H:i:s'));
        return $showDateTime->isPast();
    }

    /**
     * Check if showtime is today
     */
    public function isToday(): bool
    {
        return $this->show_date->isToday();
    }

    /**
     * Check if showtime is upcoming (not started)
     */
    public function isUpcoming(): bool
    {
        return !$this->hasPassed();
    }

    /**
     * Get occupied seats count
     */
    public function getOccupiedSeatsCount(): int
    {
        return $this->seatReservations()->count();
    }

    /**
     * Get available seats count
     */
    public function getAvailableSeatsCount(): int
    {
        return $this->cinemaHall->total_seats - $this->getOccupiedSeatsCount();
    }

    /**
     * Check if showtime is fully booked
     */
    public function isFullyBooked(): bool
    {
        return $this->getAvailableSeatsCount() <= 0;
    }

    /**
     * Get booking status with color class
     */
    public function getBookingStatus(): array
    {
        $availableSeats = $this->getAvailableSeatsCount();
        $totalSeats = $this->cinemaHall->total_seats;
        $percentage = ($availableSeats / $totalSeats) * 100;

        if ($percentage <= 0) {
            return [
                'text' => 'Sold Out',
                'class' => 'bg-red-100 text-red-800'
            ];
        } elseif ($percentage <= 10) {
            return [
                'text' => 'Almost Full',
                'class' => 'bg-orange-100 text-orange-800'
            ];
        } elseif ($percentage <= 50) {
            return [
                'text' => 'Filling Fast',
                'class' => 'bg-yellow-100 text-yellow-800'
            ];
        } else {
            return [
                'text' => 'Available',
                'class' => 'bg-green-100 text-green-800'
            ];
        }
    }
}
