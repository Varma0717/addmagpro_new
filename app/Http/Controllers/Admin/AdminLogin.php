<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Wallet\CommissionWallet;
use App\Models\Wallet\AdminWallet;
use App\Models\Wallet\BacktwoBackWallet;
use App\Models\Service\BusinessListing;
use App\Models\Admin_Panel\PinSystem;
use App\Models\Admin_Panel\Classified;
use App\Models\CustomerOrderedProducts;
use App\Models\Service\ServiceUser;
use App\Models\Admin;
use App\Models\ActiveUser;
use App\Models\Wallet\ProductWallet;
use App\Models\Wallet\PoolCommissionWallet;
use Illuminate\Support\Facades\Hash;

class AdminLogin extends Controller
{

    public function change_password()
    {
        $service_users =  ServiceUser::all();
        foreach ($service_users as $service_user) {
            $mobil_number = $service_user['member_phone'];
            $update_password = ServiceUser::find($service_user['service_id']);
            $update_password->password = Hash::make($mobil_number);
            $update_password->save();
        }
        return "All Completed";
    }

    public function loginpage()
    {
        return view('admin_pages.login');
    }

    public function login_submit(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = Admin::where('email', $req->email)->first();

        $isValidPassword = false;
        if ($user) {
            $isValidPassword = Hash::check($req->password, $user->password) || $req->password === $user->password;
        }

        if ($user && $isValidPassword) {
            $req->session()->regenerate();
            $req->session()->put('admin_username', $user->username);
            $req->session()->put('admin_id', $user->id);
            toastr()->success('Admin Login Successfully!');
            return redirect()->route('home');
        }

        toastr()->error('Invalid Login Details!');
        return redirect()->route('adminlogin');
    }

    public function logout()
    {
        if (Session()->has('admin_username')) {
            // session()->pull('admin_username');
            Session::flush();
        }
        return redirect('adminlogin');
    }

    public function admin_dashboard()
    {
        // $active_users = DB::select('SELECT * FROM service_users WHERE service_id IN (SELECT service_user_id FROM business_listing_users) OR service_id IN (SELECT user_id FROM customer_ordered_products) OR back_two_back_balance > 0');
        $active_users = DB::select("
        SELECT *
        FROM service_users
        WHERE service_id IN (
            SELECT service_user_id
            FROM business_listing_users
        )
        OR service_id IN (
            SELECT user_id
            FROM customer_ordered_products
            WHERE confirmation_status = '1'
        )
        OR service_id IN (
            SELECT user_id
            FROM active_users
        )
        OR back_two_back_balance > 0 ORDER BY created_at DESC
    ");
        $active_users_count = count($active_users);
        $service_users_turn_over = BusinessListing::where('business_listing_type', '1')
            ->orWhere('business_listing_type', '0')
            ->count() * 1000;
        $classified_users_turn_over = count(Classified::all()) * 100;
        // return $service_users_turn_over;
        $products_purchase_turn_over = CustomerOrderedProducts::sum('total_amount');
        $back2back_outstanding = ServiceUser::sum('back_two_back_balance');
        $total_turn_over = $products_purchase_turn_over + $service_users_turn_over + 988000;
        $active_users = ServiceUser::all()->count();
        $admin_id = ServiceUser::where('referral_id', 'admin')->get();
        // return $admin_id[0]->service_id;
        // $admin_commission = CommissionWallet::where('user_id', $admin_id[0]->service_id)
        // ->selectRaw('SUM(balance) as total_balance')
        // ->first();
        $admin_commission = CommissionWallet::sum('balance');
        $admin_wallet = AdminWallet::selectRaw('SUM(back_two_back) as backtwoback, SUM(charity) as charity, SUM(monthly_pool) as monthly_pool, SUM(company) as comapany')
            ->first();
        // if($admin_wallet->charity==''){
        //     return $admin_wallet;
        // }
        // return $admin_wallet;
        return view('admin_pages.index', compact('admin_wallet', 'active_users_count', 'back2back_outstanding', 'total_turn_over', 'admin_commission', 'active_users'));
    }

    public function backtwoback_settle()
    {
        return view('admin_pages.backtwoback_settle');
    }


    public function pool_amount_settle()
    {
        return view('admin_pages.pool_amount_settle');
    }


    public function backtwoback_amount_settle()
    {
        $admin_wallet = AdminWallet::selectRaw('SUM(back_two_back) as backtwoback, SUM(charity) as charity, SUM(monthly_pool) as monthly_pool, SUM(company) as comapany')
            ->first();
        $backtwoback_money = $admin_wallet['backtwoback'];
        if ($backtwoback_money <= 0) {
            toastr()->error('No Money in Back 2 Backet Wallet!');
            return redirect()->route('home');
        }
        $backtwoback_money_each_part = $backtwoback_money / 100;
        $eligible_back2back_users = ServiceUser::where('back_two_back_balance', '>', 500)->get();
        $back2back_users = ServiceUser::where('back_two_back_balance', '>', 500)->selectRaw('SUM(back_two_back_balance) as users_backtwoback')->get();
        $back2back_total_money = $back2back_users[0]['users_backtwoback'] / 1000;
        $users_part_to_split = $backtwoback_money_each_part / $back2back_total_money;
        $users_part_to_split_formatted = number_format($users_part_to_split, 3);
        // return $eligible_back2back_users;
        $total_money_distributed = 0;
        foreach ($eligible_back2back_users as $back2back_user) {
            $back2back_user_part = $back2back_user['back_two_back_balance'] / 10;
            $user_back2back_income = $back2back_user_part * $users_part_to_split_formatted;
            $backtwoback_income_user = BacktwoBackWallet::where('user_id', $back2back_user->service_id)->first();
            if ($backtwoback_income_user) {
                $backtwoback_income_user->balance += $user_back2back_income;
                $backtwoback_income_user->save();
            } else {
                $back2back_wallet = new BacktwoBackWallet();
                $back2back_wallet->user_id = $back2back_user->service_id;
                $back2back_wallet->balance = $user_back2back_income;
                $back2back_wallet->save();
            }

            $total_money_distributed = $total_money_distributed + $user_back2back_income;
        }
        // AdminWallet::query()->delete();
        AdminWallet::query()->update(['back_two_back' => 0]);
        toastr()->success('Back 2 Back Money Settled!');
        return redirect()->route('home');
    }

    public function pool_amount_settle_activate()
    {
        $admin_wallet = AdminWallet::selectRaw('SUM(back_two_back) as backtwoback, SUM(charity) as charity, SUM(monthly_pool) as monthly_pool, SUM(company) as comapany')
            ->first();
        $pool_commission_amount = $admin_wallet['monthly_pool'];
        if ($pool_commission_amount <= 0) {
            toastr()->error('Pool Comission Amount is not Sufficient!');
            return redirect()->route('home');
        }
        $pool_commission_users_count = ServiceUser::where('commission_percentage', '>', 15)->count();
        $pool_comission_users = ServiceUser::where('commission_percentage', '>', 15)->get();
        $pool_comission_amount_each_user = $pool_commission_amount / $pool_commission_users_count;
        foreach ($pool_comission_users as $pool_comission_user) {
            $user = PoolCommissionWallet::where('user_id', $pool_comission_user['service_id'])->first();
            if ($user) {
                $user->balance += $pool_comission_amount_each_user;
                $user->save();
            } else {
                $new_user = new PoolCommissionWallet();
                $new_user->user_id = $pool_comission_user['service_id'];
                $new_user->balance = $pool_comission_amount_each_user;
                $new_user->save();
            }
        }
        AdminWallet::query()->update(['monthly_pool' => 0]);
        toastr()->success('Pool Comission Amount Settled!');
        return redirect()->route('home');
    }

    public function admin_id_activation()
    {
        $service_users = BusinessListing::where('status', '0')->get();
        $stores_business_listing_data = DB::select("SELECT * FROM `business_listing_users` as blu INNER JOIN stores as str on str.StoreID=blu.profession WHERE blu.business_listing_type='1' and blu.status='0'");
        $services_business_listing_data = DB::select("SELECT * FROM `business_listing_users` as blu INNER JOIN services as str on str.service_id=blu.profession WHERE blu.business_listing_type='0' and blu.status='0'");

        // return $business_listing_users;
        return view('admin_pages.id_activation', compact('service_users', 'services_business_listing_data', 'stores_business_listing_data'));
    }

    public function pin_system()
    {
        return view('admin_pages.pin_system');
    }

    public function pin_system_activation(Request $req)
    {
        $user_details = ServiceUser::where('member_phone', $req->user_mobile)->get();
        if ($user_details->isEmpty()) {
            toastr()->error('No User With this Number!');
            return redirect()->route('pin_system');
        }
        $pin_system_user = PinSystem::where('user_id', $user_details[0]->service_id)->first();
        if ($pin_system_user) {
            $pin_system_user['total_pins'] += $req->pins_count;
            $pin_system_user->save();
            toastr()->success('Pins added successfully!');
            return redirect()->route('pin_system');
        }
        $pin_system = new PinSystem();
        $pin_system->user_id = $user_details[0]->service_id;
        $pin_system->total_pins = $req->pins_count;
        $pin_system->save();
        toastr()->success($req->pins_count . " Pins Assigned to " . $user_details[0]->member_name . " Successfully");
        return redirect()->route('pin_system');
    }

    public function activate_id_in_products(Request $req)
    {
        $user_details = ServiceUser::where('member_phone', $req->user_mobile)->get();
        $active_users = 0;
        if (!$user_details->isEmpty()) {
            $active_users = ActiveUser::where('user_id', $user_details[0]->service_id)->count();
        }
        if ($user_details->isEmpty()) {
            toastr()->error('No User With this Number!');
            return redirect()->route('admin_id_activation');
        }
        if ($active_users > 0) {
            toastr()->error('Already User Is Active!');
            return redirect()->route('admin_id_activation');
        } else {
            $new_active_user = new ActiveUser();
            $new_active_user->user_id = $user_details[0]->service_id;
            $new_active_user->user_name = $user_details[0]->member_name;
            $new_active_user->save();
            toastr()->success('User Activated!');
            return redirect()->route('admin_id_activation');
        };
    }

    public function product_wallet_convertion()
    {
        $back2back_income_users = DB::select('SELECT * FROM `backtwoback_wallet` as backwallet  INNER JOIN service_users as seu ON backwallet.user_id=seu.service_id');
        // return $back2back_income_users[0]->member_name;
        return view('admin_pages.product_wallet_conversion', compact('back2back_income_users'));
    }

    public function back2back_to_product_wallet($user_id)
    {
        $back2back_income = BacktwoBackWallet::where('user_id', $user_id)->first();
        $product_wallet = ProductWallet::where('user_id', $user_id)->first();
        if ($product_wallet) {
            $product_wallet->balance += $back2back_income['balance'];
            $product_wallet->save();
        } else {
            $new_user_product_wallet = new ProductWallet();
            $new_user_product_wallet->user_id = $back2back_income['user_id'];
            $new_user_product_wallet->balance = $back2back_income['balance'];
            $new_user_product_wallet->save();
        }
        $back2back_income->balance = 0;
        $back2back_income->save();
        toastr()->success('Back2Back Converted to Product Wallet');
        return redirect()->route('product_wallet_convertion');
    }
}
