<?php

namespace App\Models\Admin_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsBanner extends Model
{
    use HasFactory;
    public $table="ads_banners";
    public $timestamps=false;
    public $primaryKey="ads_banner_id";
}
