<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminWallet extends Model
{
    use HasFactory;
    public $table="admin_wallets";
    public $timestamps=false;

}
