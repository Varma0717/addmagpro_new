<?php

namespace App\Http\Controllers\Admin\Kyc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin_Panel\KycVerification;

class AcceptedKyc extends Controller
{
    public function accepted_kyc(){
        $accepted_kyc= KycVerification::where('kyc_status','Approved')->paginate(20);
        return view('admin_pages.kyc.acceptedkyc',['accepted_kyc'=>$accepted_kyc]);
    }
}
