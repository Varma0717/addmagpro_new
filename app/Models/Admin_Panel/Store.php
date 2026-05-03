<?php

namespace App\Models\Admin_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $primaryKey = 'StoreID'; 
    public $table="stores";
    public $timestamps=false;
}
