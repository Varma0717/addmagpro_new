<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceUser extends Model
{
    use HasFactory;
    protected $primaryKey = 'service_id';
    public $table="service_users";
    public $timestamps=false;

}
