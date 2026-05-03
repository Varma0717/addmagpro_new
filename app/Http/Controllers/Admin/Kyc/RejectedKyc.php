<?php

namespace App\Http\Controllers\Admin\Kyc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin_Panel\KycVerification;

class RejectedKyc extends Controller
{
    public function rejected_kyc(){
        $rejected_kyc= KycVerification::where('kyc_status','Rejected')->paginate(20);
        return view('admin_pages.kyc.rejectedkyc',['rejected_kyc'=>$rejected_kyc]);
    }
}
