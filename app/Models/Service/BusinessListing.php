<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessListing extends Model
{
    use HasFactory;
    public $table="business_listing_users";
    protected $primaryKey="service_user_id";
    public $timestamps=false;
}
