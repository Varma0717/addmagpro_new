<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveUser extends Model
{
    use HasFactory;
    protected $primaryKey = 'active_id';
    public $table="active_users";
    public $timestamps=false;
}