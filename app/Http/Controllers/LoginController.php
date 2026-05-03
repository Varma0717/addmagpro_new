<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Service\ServiceUser;

class LoginController extends Controller
{
    public function login(){
        return view('login');
    }

    public function sign_up($referal = null){
        if($referal){
            $referal_check=ServiceUser::where('referral_id',$referal)->get();
            if($referal_check->count() > 0){
                $referral_by= $referal;
            }else{
                return redirect('vendor_register');
            }
            
        }else{
            $referral_by="admin";
        }
        
        return view('vendor_pages.vendor_register',compact('referral_by'));
    }

    public function login_submit(Request $req){
        $user=Vendor::where('vendor_email',$req->email)->first();
        if($user){
            $data=password_verify($req->password,$user->password);
        }
        if($user and $data){
            $req->session()->put('vendor_id',$user->vendor_id);
            $req->session()->put('vendor_name',$user->vendor_name);
            $req->session()->put('profile_image',$user->profile_image);
            $req->session()->put('vendor_number',$user->vendor_phone);
            toastr()->success('Vendor Login Successfully!');
            // dd(session()->all());
            return redirect('vendor_dashboard');
        }
        toastr()->error('Vendor Login Failed!');
        return redirect('login');
    }
}
