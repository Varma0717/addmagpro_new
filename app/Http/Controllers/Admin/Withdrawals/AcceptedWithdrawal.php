<?php

namespace App\Http\Controllers\Admin\Withdrawals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin_Panel\WithdrawalRequest;

class AcceptedWithdrawal extends Controller
{
    public function accepted_withdrawal(){
        $approved_withdrawals = DB::table('user_bank_details as ubd')
            ->join('withdrawalrequests as wdr', 'ubd.user_id', '=', 'wdr.UserID')
            ->where('wdr.status', 'approved')
            ->paginate(20);
        return view('admin_pages.withdrawal.acceptedwithdrawal', compact('approved_withdrawals'));
    }
}