<?php

namespace App\Models\Admin_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCouponCode extends Model
{
    use HasFactory;
    public $primaryKey="coupon_id";
    public $table="user_coupon_codes";
    public $timestamps=false;
}
