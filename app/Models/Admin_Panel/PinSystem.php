<?php

namespace App\Models\Admin_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinSystem extends Model
{
    use HasFactory;
    public $primaryKey="pin_system_id";
    public $table="pin_system";
    public $timestamps=false;
}
