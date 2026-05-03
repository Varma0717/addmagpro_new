<?php

namespace App\Models\Admin_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreImage extends Model
{
    use HasFactory;
    public $primaryKey="store_id";
    public $table="speciality_store_images";
    public $timestamps=false;
}
