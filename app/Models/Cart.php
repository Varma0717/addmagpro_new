<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'total',
        'coupon_code',
    ];

    protected $casts = [
        'subtotal' => 'float',
        'discount_amount' => 'float',
        'tax_amount' => 'float',
        'total' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function recalculateTotal(): void
    {
        $subtotal = (float)($this->items()->sum('subtotal') ?? 0);
        $this->subtotal = $subtotal;
        $this->tax_amount = $subtotal * 0.05; // 5% tax
        $this->total = $subtotal + ($subtotal * 0.05) - ((float)($this->discount_amount ?? 0));
        $this->save();
    }
}
