<?php

namespace App\Models\Vendor_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';
    public $table="products_list";
    public $timestamps=false;
}
