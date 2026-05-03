<?php

namespace App\Http\Controllers\Admin\Withdrawals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin_Panel\WithdrawalRequest;
use App\Models\Admin_Panel\VendorWithdrawRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Service\ServiceUser;

class PendingWithdrawal extends Controller
{
    public function pending_withdrawal(){
        $pending_withdrawals = DB::table('user_bank_details as ubd')
            ->join('withdrawalrequests as wdr', 'ubd.user_id', '=', 'wdr.UserID')
            ->where('wdr.status', 'pending')
            ->paginate(20);
        return view('admin_pages.withdrawal.pendingwithdrawal', compact('pending_withdrawals'));
    }
    
    public function vendor_pending_withdrawal(){
        $pending_withdrawals = DB::table('user_bank_details as ubd')
            ->join('vendor_withdraw_requests as wdr', 'ubd.user_id', '=', 'wdr.user_id')
            ->where('wdr.status', 'pending')
            ->paginate(20);
        return view('admin_pages.withdrawal.vendor_pendingwithdrawal', compact('pending_withdrawals'));
    }

    public function update_withdrawal_request($user_id){
        $update_user_withdrawal_status=DB::select('SELECT * FROM `user_bank_details` as ubd INNER JOIN withdrawalrequests as wdr on ubd.user_id=wdr.UserID WHERE wdr.RequestID=?',[$user_id]);
        // return $update_user_withdrawal_status;
        return view('admin_pages.withdrawal.update_withdrawal_request',compact('update_user_withdrawal_status'));
    }
    
    public function update_vendor_withdrawal_request($user_id){
        $update_user_withdrawal_status=DB::select('SELECT * FROM `user_bank_details` as ubd INNER JOIN vendor_withdraw_requests as wdr on ubd.user_id=wdr.user_id WHERE wdr.request_id=?',[$user_id]);
        
        return $update_user_withdrawal_status;
    }

    public function update_user_withdrawal_status(Request $req){
        $update_withdrawal_request=WithdrawalRequest::find($req->request_id);
        // return $req->input();
        // return $update_withdrawal_request;
        if($req->status==1){
            $update_withdrawal_request->Status='approved';
        }else{
            $update_withdrawal_request->Status='rejected';
        }
        $update_withdrawal_request->CompletionDate=now();
        $update_withdrawal_request->save();
        return redirect()->route('pending_withdrawal');
    }


}
