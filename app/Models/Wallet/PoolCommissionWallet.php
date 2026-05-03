<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoolCommissionWallet extends Model
{
    use HasFactory;
    protected $primaryKey = 'wallet_id';
    public $table="pool_commision_wallet";
    public $timestamps=false;
}
