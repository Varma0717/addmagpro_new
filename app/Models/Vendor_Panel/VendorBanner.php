<?php

namespace App\Models\Vendor_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBanner extends Model
{
    use HasFactory;
    protected $primaryKey = 'vendor_id';
    public $table="vendor_banners";
    public $timestamps=false;
}
