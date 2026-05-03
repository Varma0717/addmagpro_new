<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountStorePurchases extends Model
{
    use HasFactory;
    public $table="discount_store_purchases";
    public $timestamps=false;
    public $primaryKey="purchase_id";
}
