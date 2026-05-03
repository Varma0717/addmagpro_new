<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionWallet extends Model
{
    use HasFactory;
    protected $primaryKey = 'wallet_id';
    public $table="commission_wallet";
    public $timestamps=false;
}
