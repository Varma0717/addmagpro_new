<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacktwoBackWallet extends Model
{
    use HasFactory;
    protected $primaryKey="wallet_id";
    public $table="backtwoback_wallet";
    public $timestamps=false;
}
