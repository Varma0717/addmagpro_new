<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders_list';

    protected $fillable = [
        'user_id',
        'first_name',
        'email',
        'mobile_no',
        'address',
        'zip_code',
        'city',
        'state',
        'oredered_products',
        'total_amount',
        'status',
        'confirmation_status',
        'location',
        'unique_id',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'ordered_date' => 'datetime',
        'confirmation_status' => 'int',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
