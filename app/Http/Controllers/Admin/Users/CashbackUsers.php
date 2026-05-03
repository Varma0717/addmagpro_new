<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin_Panel\CashBackUser;
use Illuminate\Support\Facades\DB;
use App\Models\Service\ServiceUser;
use App\Models\Wallet\CommissionWallet;

class CashbackUsers extends Controller
{
    public function cash_back_users(){
        $cash_back_users = DB::table('service_users')
            ->whereNotIn('service_id', function($q){ $q->select('service_user_id')->from('business_listing_users'); })
            ->whereNotIn('service_id', function($q){ $q->select('user_id')->from('customer_ordered_products'); })
            ->whereNotIn('service_id', function($q){ $q->select('user_id')->from('active_users'); })
            ->where('back_two_back_balance', 0)
            ->orderByDesc('joined_date')
            ->paginate(20);
        return view('admin_pages.users.cashbackusers',['cash_back_users'=>$cash_back_users]);

    }

    public function active_users()
    {
        $cash_back_users = DB::table('service_users')
            ->where(function($q) {
                $q->whereIn('service_id', function($q2){ $q2->select('service_user_id')->from('business_listing_users'); })
                  ->orWhereIn('service_id', function($q2){ $q2->select('user_id')->from('customer_ordered_products')->where('status', 'Delivered'); })
                  ->orWhereIn('service_id', function($q2){ $q2->select('user_id')->from('active_users'); })
                  ->orWhere('back_two_back_balance', '>', 0);
            })
            ->orderByDesc('joined_date')
            ->paginate(20);
        return view('admin_pages.users.activeusers', ['cash_back_users' => $cash_back_users]);
    }
    
    public function upgrade_user_percentage($user_id){
        $user_details=ServiceUser::where('service_id',$user_id)->get();
        $user_comission=CommissionWallet::where('user_id',$user_id)->first();
        if ($user_comission === null || $user_comission['balance'] === null) {
            $user_comission=0;
        }else{
            $user_comission=$user_comission['balance'];
        }
        return view('admin_pages.gallery.upgrade_user_percentage',compact('user_details','user_comission'));
    }

    public function upgrade_user_percentage_submit(Request $req){
        $user_details=ServiceUser::find($req->service_user_id);
        $user_details->commission_percentage=$req->percentage_level;
        $user_details->cumulative_gross=$req->cumulative_gross;
        $user_details->back_two_back_balance=$req->back_two_back_value;
        $user_details->save();
        $user_comission=CommissionWallet::where('user_id',$req->service_user_id)->first();
        if($req->user_commission==0){
            toastr()->success('User Level Upgraded!');
            return redirect()->route('active_users');
        }
        if($user_comission===null){
            $user_comission=new CommissionWallet();
            $user_comission->user_id=$req->service_user_id;
            $user_comission->balance=$req->user_commission;
            $user_comission->save();
            toastr()->success('User Level Upgraded!');
            return redirect()->route('active_users');
        }

        $user_comission['balance']+=$req->user_commission;
        $user_comission->save();
        toastr()->success('User Level Upgraded!');
        return redirect()->route('active_users');
    }
    
}
