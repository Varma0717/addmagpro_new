<?php

namespace App\Models\Admin_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBanner extends Model
{
    use HasFactory;
    public $table="events_banners";
    public $timestamps=false;
    public $primaryKey="event_banner_id";
}
