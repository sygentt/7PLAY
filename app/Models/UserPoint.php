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
}


