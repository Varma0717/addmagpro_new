<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWallet extends Model
{
    use HasFactory;
    public $table="product_wallet";
    public $timestamps=false;
    public $primaryKey="wallet_id";
}
