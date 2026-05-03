<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartproducts extends Model
{
    use HasFactory;
    protected $primaryKey = 'cart_id';
    public $table="cart_products";
    public $timestamps=false;
}
