<?php

namespace App\Models\Vendor_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public $table="brands";
    public $timestamps=false;
}
