<?php

namespace App\Http\Controllers\Admin\Kyc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin_Panel\KycVerification;

class PendingKyc extends Controller
{
    public function pending_kyc(){
        $pending_kyc= KycVerification::where('kyc_status','Pending')->paginate(20);
        return view('admin_pages.kyc.pendingkyc',['pending_kyc'=>$pending_kyc]);
    }
}
