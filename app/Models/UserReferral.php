<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReferral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referred_user_id',
        'status',
        'referrer_bonus',
        'referred_bonus',
        'referrer_bonus_claimed',
        'referred_bonus_claimed',
        'notes',
        'bonus_credited_at',
    ];

    protected $casts = [
        'referrer_bonus' => 'decimal:2',
        'referred_bonus' => 'decimal:2',
        'referrer_bonus_claimed' => 'boolean',
        'referred_bonus_claimed' => 'boolean',
        'bonus_credited_at' => 'datetime',
    ];

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referredUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
}
