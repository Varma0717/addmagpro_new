<?php

namespace App\Models\Admin_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorWithdrawRequest extends Model
{
    use HasFactory;
    public $primaryKey="request_id";
    public $table="vendor_withdraw_requests";
    public $timestamps=false;
}
