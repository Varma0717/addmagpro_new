<?php

namespace App\Models\Admin_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GadgetGallery extends Model
{
    use HasFactory;
    public $primaryKey="gadget_gallery_id";
    public $table="gadget_gallery";
    public $timestamps=false;
}
