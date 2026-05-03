<?php

namespace App\Http\Controllers\Website_Policies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function privacy_policy(){
        return view('policies.privacy_policy');
    }

    public function terms_and_conditions(){
        return view('policies.terms_conditions');
    }

    public function refund_policy(){
        return view('policies.refund_policy');
    }

    public function shipping_policy(){
        return view('policies.shipping_policy');
    }

    public function contact_us(){
        return view('policies.contact_us');
    }
}
