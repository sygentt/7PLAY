<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    public function getIsBroadcastAttribute(): bool
    {
        $data = $this->data;
        return is_array($data) && ($data['audience'] ?? null) === 'all';
    }

    public function getBatchKeyAttribute(): ?string
    {
        $data = $this->data;
        return is_array($data) ? ($data['batch_key'] ?? null) : null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function markAsRead(): bool
    {
        return $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function getIconAttribute(): string
    {
        return match($this->type) {
            'order' => 'ticket',
            'movie' => 'film',
            'system' => 'cog-6-tooth',
            'promo' => 'gift',
            default => 'bell',
        };
    }

    public function getColorClassAttribute(): string
    {
        return match($this->type) {
            'order' => 'text-blue-600 dark:text-blue-400',
            'movie' => 'text-purple-600 dark:text-purple-400',
            'system' => 'text-gray-600 dark:text-gray-400',
            'promo' => 'text-yellow-600 dark:text-yellow-400',
            default => 'text-gray-600 dark:text-gray-400',
        };
    }
}
