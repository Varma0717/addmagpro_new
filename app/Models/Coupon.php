<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'minimum_order_value',
        'max_usage',
        'max_usage_per_user',
        'usage_count',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
        'minimum_order_value' => 'decimal:2',
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->max_usage && $this->usage_count >= $this->max_usage) {
            return false;
        }

        if ($this->valid_from && now() < $this->valid_from) {
            return false;
        }

        if ($this->valid_until && now() > $this->valid_until) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $orderTotal): float|null
    {
        if (!$this->isValid()) {
            return 0;
        }

        if ($this->minimum_order_value && $orderTotal < $this->minimum_order_value) {
            return 0;
        }

        if ($this->discount_type === 'percent') {
            return ($orderTotal * $this->discount_value) / 100;
        }

        return $this->discount_value;
    }
}
