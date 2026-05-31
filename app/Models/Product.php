<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products_list';
    protected $primaryKey = 'product_id';
    public $incrementing = false;

    protected $fillable = [
        'product_name',
        'product_description',
        'vendor_id',
        'category_id',
        'brand_id',
        'item_code',
        'unit_price',
        'purchase_price',
        'product_images',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'purchase_price' => 'decimal:2',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Get all images for this product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    /**
     * Get all reviews for this product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'product_id');
    }

    /**
     * Get the product images (legacy: stored in product_images column as path)
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->product_images;
    }

    /**
     * Get the cart items for this product.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'product_id', 'product_id');
    }

    /**
     * Get the order items for this product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'product_id');
    }

    /**
     * Query Scopes (legacy schema doesn't have these columns, so they're no-ops)
     */
    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query;
    }

    public function scopeFeatured(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query;
    }

    public function scopeInStock(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query;
    }
}
