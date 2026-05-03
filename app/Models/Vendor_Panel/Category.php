<?php

namespace App\Models\Vendor_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $table="categories";
    public $timestamps=false;
}
