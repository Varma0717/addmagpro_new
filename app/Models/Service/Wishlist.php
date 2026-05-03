<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $primaryKey="wishlist_id";   
    public $timestamps=false;
    public $table="wishlist_products";
}
