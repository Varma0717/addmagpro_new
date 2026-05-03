<?php

namespace App\Models\Vendor_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountVendor extends Model
{
    use HasFactory;
    protected $primaryKey = 'vendor_id';
    public $table="discount_vendors";
    public $timestamps=false;
}
