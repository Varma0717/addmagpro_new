<?php

namespace App\Models\Admin_Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;
    public $primaryKey="RequestID";
    public $table="withdrawalrequests";
    public $timestamps=false;
}
