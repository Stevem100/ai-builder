<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan',
        'status',
        'current_period_start',
        'current_period_end',
        'ai_tokens_used',
        'ai_tokens_limit',
    ];

    protected function casts(): array
    {
        return [
            'current_period_start' => 'datetime',
            'current_period_end' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPlanLabelAttribute(): string
    {
        return match ($this->plan) {
            'free' => 'Free',
            'pro' => 'Pro',
            'enterprise' => 'Enterprise',
            default => ucfirst($this->plan),
        };
    }

    public function getTokensRemainingAttribute(): int
    {
        return max(0, $this->ai_tokens_limit - $this->ai_tokens_used);
    }
}
