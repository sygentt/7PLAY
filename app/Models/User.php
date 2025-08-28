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
        ];
    }

    /**
     * Get all orders for the user.
     * TODO: Uncomment when Order model is created
     */
    // public function orders(): HasMany
    // {
    //     return $this->hasMany(Order::class);
    // }

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
     * TODO: Uncomment when SeatReservations model is created
     */
    // public function seat_reservations(): HasMany
    // {
    //     return $this->hasMany(SeatReservations::class);
    // }

    /**
     * Scope for active users only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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
}
