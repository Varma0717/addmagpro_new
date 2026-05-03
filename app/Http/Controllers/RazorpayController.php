<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Razorpay\Api\Api;
use App\Models\Service\BusinessListing;
use App\Models\Admin_Panel\UserCouponCode;
use App\Models\Service\ServiceUser;
use App\Models\Admin_Panel\BankDetails;
use Illuminate\Support\Facades\Session;
use App\Models\State;

class RazorpayController extends Controller
{

    public function payment(){
        return view('payment_gateway');
    }

    // public function razorpay(Request $request){
    //     // return $request->service_user_id;
    //     // dd($request->all());
    //     if(isset($request->razorpay_payment_id) && $request->razorpay_payment_id!=''){
    //         $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    //         $payment=$api->payment->fetch($request->razorpay_payment_id);
    //         $response=$payment->capture(array('amount'=>$payment->amount));
    //         $payment=new Payment();
    //         $payment->payment_id=$response['id'];
    //         $payment->product_name=$response['notes']['product_name'];
    //         $payment->quantity=$response['notes']['quantity'];
    //         $payment->amount=$response['amount']/100;
    //         $payment->currency=$response['currency'];
    //         $payment->customer_name=$response['notes']['customer_name'];
    //         $payment->customer_email=$response['notes']['customer_email'];
    //         $payment->payment_status=$response['status'];
    //         $payment->payment_method='RazorPay';
    //         $payment->save();
    //         return redirect()->route('success');
    //     }else{
    //         return redirect()->route('cancel');
    //     }

    // }
    
    public function discount_products_razorpay(Request $req){
        $user_id= session::get('service_user_id');
        if(isset($req->razorpay_payment_id) && $req->razorpay_payment_id!=''){
            $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
            $payment=$api->payment->fetch($req->razorpay_payment_id);
            $response=$payment->capture(array('amount'=>$payment->amount));
            $purchase_detail=new DiscountStorePurchases();
            $purchase_detail->vendor_id=$req->vendor_id;
            $purchase_detail->customer_id=$user_id;
            $purchase_detail->store_name=$req->store_name;
            $purchase_detail->purchase_amount=$req->purchase_amount;
            $purchase_detail->discount_margin=$req->discount_margin;
            $purchase_detail->total_amount=$req->total_amount;
            $purchase_detail->vendor_commision=$req->purchase_amount-($req->purchase_amount*$req->discount_margin_offered)/100;
            $purchase_detail->save();
            $vendor_detail=DiscountVendor::find($req->vendor_id);
            $discount_amount=($req->purchase_amount*$vendor_detail['discount_margin'])/100;
            $withdraw_amount=$req->purchase_amount-$discount_amount;
            $vendor_detail['withdrawal_amount']+=$withdraw_amount;
            $vendor_detail->save();
            toastr()->success('Discount Product Amount Paid');
            return redirect()->route('welcome_page');
        }else{
            toastr()->error('Discount Products Purchase Failed');
            return redirect()->route('welcome_page');
        }
    }




    public function razorpay(Request $req){
        $user_id= session::get('service_user_id');
        if($req->business_type=='2'){
            $gross_amount=100;
        }else{
            $gross_amount=1000;
        }
        $coupon_used = UserCouponCode::where('coupon_code', $req->coupon_code)->first();

        if ($coupon_used) {
            $coupon_used->status = 'Expired';
            $coupon_used->save();
        }

        //  Start Cummulative Gross adding to tree
        
        $total_amount=$gross_amount;
        $user_detail = ServiceUser::where('service_id', $user_id)->first();
        if (!$user_detail) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user_detail->cumulative_gross += $total_amount;
        $user_detail->save();
        if($user_detail->cumulative_gross>7999 && $user_detail->cumulative_gross<20001){
            $user_detail->commission_percentage=10;
        }elseif($user_detail->cumulative_gross>20000 && $user_detail->cumulative_gross<40001){
            $user_detail->commission_percentage=12;
        }elseif($user_detail->cumulative_gross>40000 && $user_detail->cumulative_gross<120001){
            $user_detail->commission_percentage=14;
        }elseif($user_detail->cumulative_gross>120000 && $user_detail->cumulative_gross<200001){
            $user_detail->commission_percentage=16;
        }elseif($user_detail->cumulative_gross>200000 && $user_detail->cumulative_gross<400001){
            $user_detail->commission_percentage=18;
        }elseif($user_detail->cumulative_gross>400000){
            $user_detail->commission_percentage=20;
        }else{
            $user_detail->commission_percentage=8;
        }
        $user_detail->save();
        $referral_by = $user_detail->referral_by;
        if ($referral_by === 'admin') {
            $admin = ServiceUser::where('referral_id', 'admin')->first();
            if ($admin) {
                $admin->cumulative_gross += $total_amount;
                $admin->save();
            }
        }else{
            $referred_user = ServiceUser::where('referral_id', $referral_by)->first();
            while ($referred_user && $referred_user->member_name !== 'Admin') {
                $referred_user->cumulative_gross += $total_amount;
                $referred_user->save();
                if($referred_user->cumulative_gross>7999 && $referred_user->cumulative_gross<20001){
                    $referred_user->commission_percentage=10;
                }elseif($referred_user->cumulative_gross>20000 && $referred_user->cumulative_gross<40001){
                    $referred_user->commission_percentage=12;
                }elseif($referred_user->cumulative_gross>40000 && $referred_user->cumulative_gross<120001){
                    $referred_user->commission_percentage=14;
                }elseif($referred_user->cumulative_gross>120000 && $referred_user->cumulative_gross<200001){
                    $referred_user->commission_percentage=16;
                }elseif($referred_user->cumulative_gross>200000 && $referred_user->cumulative_gross<400001){
                    $referred_user->commission_percentage=18;
                }elseif($referred_user->cumulative_gross>400000){
                    $referred_user->commission_percentage=20;
                }else{
                    $referred_user->commission_percentage=8;
                }
                $referred_user->save();
                $referred_user = ServiceUser::where('referral_id', $referred_user->referral_by)->first();
            }
            if ($referred_user && $referred_user->member_name === 'Admin') {
                $admin = ServiceUser::where('referral_id', 'admin')->first();
                if ($admin) {
                    $admin->cumulative_gross += $total_amount;
                    $admin->save();
                }
            }    
        }

        // End Cummulative Gross adding to tree
        $state_name=State::where('state_id',$req->state)->first();
        $service_state_name= $state_name['state_name'];
        $folderName = public_path('assets/business_listing_images/');       
        if ($req->hasFile('service_image')) {
            $image = $req->file('service_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $imageName='assets/business_listing_images/' . $imageName;
        }else{
            $imageName='assets/images/img2.jpg';
        }
        if(isset($req->razorpay_payment_id) && $req->razorpay_payment_id!=''){
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            $payment=$api->payment->fetch($req->razorpay_payment_id);
            $response=$payment->capture(array('amount'=>$payment->amount));
            $business_listing_users=new BusinessListing();
            $business_listing_users->member_name=$req->name;
            $business_listing_users->service_user_id=$req->service_user_id;
            $business_listing_users->member_phone=$req->mobile;
            $business_listing_users->coupon_code=$req->coupon_code;
            $business_listing_users->business_image = $imageName;
            $business_listing_users->password=$req->password;
            $business_listing_users->pan_number=$req->pannumber;
            $business_listing_users->address=$req->address;
            $business_listing_users->state=$service_state_name;
            $business_listing_users->district=$req->district;
            $business_listing_users->location=$req->location;
            $business_listing_users->pincode=$req->pincode;
            $business_listing_users->profession=$req->profession;
            $business_listing_users->bank_name=$req->bankname;
            $business_listing_users->cumulative_gross=$req->cumulative_gross;
            $business_listing_users->commission_percentage=$req->commission_percentage;
            $business_listing_users->referral_id=$req->referral_id;
            $business_listing_users->referral_by=$req->referral_by;
            $business_listing_users->account_number=$req->accountnumber;
            $business_listing_users->currency=$response['currency'];
            $business_listing_users->payment_method='RazorPay';
            $business_listing_users->payment_status=$response['status'];
            $business_listing_users->business_listing_type=$req->business_type;
            $business_listing_users->description=$req->description;
            $business_listing_users->save();
            // $bank_details=new BankDetails();
            // $bank_details->user_id=$req->service_user_id;
            // $bank_details->pancard_number=$req->pannumber;
            // $bank_details->user_name=$req->name;
            // $bank_details->bank_name=$req->bankname;
            // $bank_details->account_number=$req->accountnumber;
            // $bank_details->ifsc=$req->ifsccode;
            // $bank_details->save();
            toastr()->success('Business Listing Added!Wait For Admin Approval');
            return redirect('/welcome_page');
        }else{
            return redirect()->route('cancel');
        }
    }

    public function success(){
        return "Payment Successfull!";
    }

    public function cancel(){
        return "Payment Failed!";
    }
}
