<?php

namespace App\Models\Admin_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $primaryKey = 'service_id'; 
    public $table="services";
    public $timestamps=false;
}
