<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';
    protected $primaryKey = 'district_id'; // or 'id' depending on table structure
    public $timestamps = false;

    protected $fillable = [
        'state_id',
        'district_name',
    ];
}
