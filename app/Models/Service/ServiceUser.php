<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ServiceUser extends Model
{
    use HasFactory, HasApiTokens;
    protected $primaryKey = 'service_id';
    public $table = "service_users";
    public $timestamps = false;
}
