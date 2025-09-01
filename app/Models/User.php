<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'birth_date',
        'gender',
        'avatar',
        'is_active',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date' => 'date',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get all orders for the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the user's point account.
     * TODO: Uncomment when UserPoints model is created
     */
    // public function user_points(): HasOne
    // {
    //     return $this->hasOne(UserPoints::class);
    // }

    /**
     * Get the user's preferences.
     * TODO: Uncomment when UserPreferences model is created
     */
    // public function preferences(): HasOne
    // {
    //     return $this->hasOne(UserPreferences::class);
    // }

    /**
     * Get all vouchers owned by the user.
     * TODO: Uncomment when UserVouchers model is created
     */
    // public function vouchers(): HasMany
    // {
    //     return $this->hasMany(UserVouchers::class);
    // }

    /**
     * Get all point transactions for the user.
     * TODO: Uncomment when PointTransactions model is created
     */
    // public function point_transactions(): HasMany
    // {
    //     return $this->hasMany(PointTransactions::class);
    // }

    /**
     * Get all seat reservations made by the user.
     */
    public function seatReservations(): HasMany
    {
        return $this->hasMany(SeatReservation::class);
    }

    /**
     * Get all favorite movies for the user.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(UserFavorite::class);
    }

    /**
     * Get all favorite movies directly.
     */
    public function favoriteMovies(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'user_favorites');
    }

    /**
     * Check if user has favorited a movie.
     */
    public function hasFavorited(int $movieId): bool
    {
        return $this->favorites()->where('movie_id', $movieId)->exists();
    }

    /**
     * Get all notifications for the user.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    /**
     * Scope for active users only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for admin users only.
     */
    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }

    /**
     * Scope for customer users only.
     */
    public function scopeCustomers($query)
    {
        return $query->where('is_admin', false);
    }

    /**
     * Scope for search functionality.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    /**
     * Get user's current membership level.
     * TODO: Update when UserPoints model is created
     */
    public function getMembershipLevelAttribute(): string
    {
        // return $this->user_points?->membership_level ?? 'bronze';
        return 'bronze'; // Default for now
    }

    /**
     * Get user's total points.
     * TODO: Update when UserPoints model is created
     */
    public function getTotalPointsAttribute(): int
    {
        // return $this->user_points?->total_points ?? 0;
        return 0; // Default for now
    }

    /**
     * Check if user has sufficient points.
     * TODO: Update when UserPoints model is created
     */
    public function hasSufficientPoints(int $required_points): bool
    {
        return $this->total_points >= $required_points;
    }

    /**
     * Get user's avatar URL or default
     */
    public function getAvatarUrl(): string
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get formatted birth date
     */
    public function getFormattedBirthDate(): string
    {
        return $this->birth_date ? $this->birth_date->format('d F Y') : '-';
    }

    /**
     * Get user age
     */
    public function getAge(): ?int
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    /**
     * Get user's total spent amount
     */
    public function getTotalSpent(): float
    {
        return $this->orders()
            ->whereIn('status', [Order::STATUS_CONFIRMED, Order::STATUS_PAID])
            ->sum('total_amount');
    }

    /**
     * Get user's total orders count
     */
    public function getTotalOrders(): int
    {
        return $this->orders()->count();
    }

    /**
     * Get user's status badge
     */
    public function getStatusBadge(): array
    {
        if (!$this->is_active) {
            return [
                'text' => 'Inactive',
                'class' => 'bg-red-100 text-red-800'
            ];
        }

        if ($this->is_admin) {
            return [
                'text' => 'Admin',
                'class' => 'bg-purple-100 text-purple-800'
            ];
        }

        return [
            'text' => 'Customer',
            'class' => 'bg-green-100 text-green-800'
        ];
    }

    /**
     * Get user's role
     */
    public function getRole(): string
    {
        return $this->is_admin ? 'Admin' : 'Customer';
    }

    /**
     * Get user's favorite movie genre based on order history
     */
    public function getFavoriteGenre(): ?string
    {
        $genres = $this->orders()
            ->confirmed()
            ->with('showtime.movie')
            ->get()
            ->pluck('showtime.movie.genre')
            ->filter()
            ->countBy()
            ->sortDesc();

        return $genres->keys()->first();
    }
}
