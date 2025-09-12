<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Showtime extends Model
{
    /**
     * Daftar atribut yang boleh diisi mass-assignment.
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
     * Konversi tipe untuk atribut tertentu.
     */
    protected $casts = [
        'show_date' => 'date',
        'show_time' => 'datetime:H:i',
        'price' => 'decimal:2',
        'available_seats' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Atribut yang diperlakukan sebagai tanggal.
     */
    protected $dates = [
        'show_date',
        'show_time',
        'created_at',
        'updated_at',
    ];

    /**
     * Relasi ke film.
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Relasi ke studio/bioskop (cinema hall).
     */
    public function cinemaHall(): BelongsTo
    {
        return $this->belongsTo(CinemaHall::class);
    }

    /**
     * Relasi ke reservasi kursi untuk jadwal ini.
     */
    public function seatReservations(): HasMany
    {
        return $this->hasMany(SeatReservation::class);
    }

    /**
     * Scope: hanya jadwal yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: filter berdasarkan film.
     */
    public function scopeByMovie($query, $movieId)
    {
        return $query->where('movie_id', $movieId);
    }

    /**
     * Scope: filter berdasarkan studio/bioskop (cinema hall).
     */
    public function scopeByCinemaHall($query, $cinemaHallId)
    {
        return $query->where('cinema_hall_id', $cinemaHallId);
    }

    /**
     * Scope: filter berdasarkan bioskop.
     */
    public function scopeByCinema($query, $cinemaId)
    {
        return $query->whereHas('cinemaHall', function ($q) use ($cinemaId) {
            $q->where('cinema_id', $cinemaId);
        });
    }

    /**
     * Scope: filter berdasarkan kota.
     */
    public function scopeByCity($query, $cityId)
    {
        return $query->whereHas('cinemaHall.cinema', function ($q) use ($cityId) {
            $q->where('city_id', $cityId);
        });
    }

    /**
     * Scope: filter berdasarkan tanggal pemutaran.
     */
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('show_date', $date);
    }

    /**
     * Scope: jadwal dari hari ini dan seterusnya.
     */
    public function scopeUpcoming($query)
    {
        return $query->where(function ($q) {
            $q->whereDate('show_date', '>', Carbon::today())
              ->orWhere(function ($subQuery) {
                  $subQuery->whereDate('show_date', Carbon::today())
                           ->whereTime('show_time', '>=', Carbon::now()->format('H:i'));
              });
        });
    }

    /**
     * Scope: jadwal yang sudah dimulai/terlewat.
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
     * Format gabungan tanggal dan jam pemutaran.
     */
    public function getFormattedDateTime(): string
    {
        return $this->show_date->format('d M Y') . ' ' . $this->show_time->format('H:i');
    }

    /**
     * Format tanggal pemutaran.
     */
    public function getFormattedDate(): string
    {
        return $this->show_date->format('d F Y');
    }

    /**
     * Format jam pemutaran.
     */
    public function getFormattedTime(): string
    {
        return $this->show_time->format('H:i');
    }

    /**
     * Format harga dalam rupiah.
     */
    public function getFormattedPrice(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Periksa apakah jadwal sudah lewat.
     */
    public function hasPassed(): bool
    {
        $showDateTime = $this->show_date->copy()->setTimeFromTimeString($this->show_time->format('H:i:s'));
        return $showDateTime->isPast();
    }

    /**
     * Periksa apakah jadwal adalah hari ini.
     */
    public function isToday(): bool
    {
        return $this->show_date->isToday();
    }

    /**
     * Periksa apakah jadwal masih akan datang.
     */
    public function isUpcoming(): bool
    {
        return !$this->hasPassed();
    }

    /**
     * Jumlah kursi yang sudah terisi.
     */
    public function getOccupiedSeatsCount(): int
    {
        return $this->seatReservations()->count();
    }

    /**
     * Jumlah kursi yang masih tersedia.
     */
    public function getAvailableSeatsCount(): int
    {
        return $this->cinemaHall->total_seats - $this->getOccupiedSeatsCount();
    }

    /**
     * Periksa apakah jadwal sudah penuh.
     */
    public function isFullyBooked(): bool
    {
        return $this->getAvailableSeatsCount() <= 0;
    }

    /**
     * Status ketersediaan kursi beserta kelas warna.
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
