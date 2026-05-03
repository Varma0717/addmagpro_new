<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrderedProducts extends Model
{
    use HasFactory;
    public $table="customer_ordered_products";
    public $timestamps=false;
}
