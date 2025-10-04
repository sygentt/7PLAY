<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    use HasFactory;

    protected $table = 'user_points';

    protected $fillable = [
        'user_id',
        'total_points',
        'total_orders',
        'membership_level',
        'last_order_date',
    ];

    protected $casts = [
        'total_points' => 'integer',
        'total_orders' => 'integer',
        'last_order_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Update membership level based on total points
     */
    public function updateMembershipLevel(): void
    {
        $level = $this->calculateMembershipLevel($this->total_points);
        
        if ($this->membership_level !== $level) {
            $this->membership_level = $level;
            $this->save();
        }
    }

    /**
     * Calculate membership level based on points
     */
    public static function calculateMembershipLevel(int $points): string
    {
        if ($points >= 10000) {
            return 'platinum';
        } elseif ($points >= 5000) {
            return 'gold';
        } elseif ($points >= 2000) {
            return 'silver';
        } else {
            return 'bronze';
        }
    }

    /**
     * Get membership level name in Indonesian
     */
    public function getMembershipLevelNameAttribute(): string
    {
        return match($this->membership_level) {
            'platinum' => 'Platinum',
            'gold' => 'Gold',
            'silver' => 'Silver',
            'bronze' => 'Bronze',
            default => 'Bronze',
        };
    }

    /**
     * Get membership level color for UI
     */
    public function getMembershipLevelColorAttribute(): string
    {
        return match($this->membership_level) {
            'platinum' => 'text-purple-600',
            'gold' => 'text-yellow-600',
            'silver' => 'text-gray-600',
            'bronze' => 'text-orange-600',
            default => 'text-gray-600',
        };
    }
}


