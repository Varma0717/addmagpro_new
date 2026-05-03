<?php

namespace App\Models\Admin_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    use HasFactory;
    public $primaryKey="bank_id";
    public $table="user_bank_details";
    public $timestamps=false;
}
