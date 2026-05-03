<?php

namespace App\Http\Controllers\Admin\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor_Panel\Brand;
use App\Models\Service\BusinessListing;
use App\Models\Wallet\AdminWallet;
use App\Models\Service\ServiceUser;
use App\Models\Wallet\CommissionWallet;
use App\Models\Admin_Panel\Service;
use App\Models\Admin_Panel\Classified;
use App\Models\Admin_Panel\Store;

class AddBrand extends Controller
{
    public function add_brand(){
        return view('admin_pages.brand.add_brand');
    }

    public function new_brand_added(Request $req){
        $folderName = public_path('assets/vendor_assets/brand_images_admin/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('brand_image')) {
            $image = $req->file('brand_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $user = new Brand;
            $user->	vendor_id = 10;
            $user->brand_name	 = $req->brand_name;
            $user->ImageURL = 'assets/vendor_assets/brand_images_admin/' . $imageName; // Update the image path.
            $result = $user->save();

            if ($result) {
                toastr()->success('Brand Added Successfully!');
                return redirect('brand_list');
            } else {
                toastr()->error('Brand Adding Failed!');
                return redirect('brand_list');
            }
        } else {
            toastr()->error('Image Not Found!');
            return redirect('brand_list');
        }
    }

    public function brand_list(){
        $brand=Brand::paginate(20);
        return view('admin_pages.brand.brand_list',['brand_details'=>$brand]);
    }

    public function add_service(){
        return view('admin_pages.brand.add_service');
    }

    public function add_classified(){
        return view('admin_pages.brand.add_classified');
    }

    public function add_store(){
        return view('admin_pages.brand.add_store');
    }

    public function new_service_added(Request $req){
        $folderName = public_path('assets/vendor_assets/service_images_admin/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('service_image')) {
            $image = $req->file('service_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $user = new Service;
            $user->service_name	 = $req->service_name;
            $user->service_image = 'assets/vendor_assets/service_images_admin/' . $imageName; // Update the image path.
            $result = $user->save();

            if ($result) {
                toastr()->success('Service Added Successfully!');
                return redirect('service_list');
            } else {
                toastr()->error('Service Adding Failed!');
                return redirect('service_list');
            }
        } else {
            toastr()->error('Image Not Found!');
            return redirect('service_list');
        }
    }

    public function new_classified_added(Request $req){
        $folderName = public_path('assets/vendor_assets/classified_images_admin/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('service_image')) {
            $image = $req->file('service_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $user = new Classified;
            $user->classified_name = $req->service_name;
            $user->classified_image = 'assets/vendor_assets/classified_images_admin/' . $imageName; // Update the image path.
            $result = $user->save();

            if ($result) {
                toastr()->success('Classified Added Successfully!');
                return redirect('classified_list');
            } else {
                toastr()->error('Classified Adding Failed!');
                return redirect('classified_list');
            }
        } else {
            toastr()->error('Image Not Found!');
            return redirect('classified_list');
        }
    }
    public function new_store_added(Request $req){
        $folderName = public_path('assets/vendor_assets/store_images_admin/'); // Use $vendor_id[0] to get the ID as an integer.

        if ($req->hasFile('store_image')) {
            $image = $req->file('store_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $user = new Store;
            $user->StoreName	 = $req->store_name;
            $user->store_image = 'assets/vendor_assets/store_images_admin/' . $imageName; // Update the image path.
            $result = $user->save();

            if ($result) {
                toastr()->success('Store Added Successfully!');
                return redirect('add_store');
            } else {
                toastr()->error('Store Adding Failed!');
                return redirect('store_list');
            }
        } else {
            toastr()->error('Image Not Found!');
            return redirect('store_list');
        }
    }

    public function service_list(){
        $services=Service::paginate(20);
        return view('admin_pages.brand.service_list',compact('services'));
    }


    public function classified_list(){
        $services=Classified::paginate(20);
        return view('admin_pages.brand.classified_list',compact('services'));
    }


    public function store_list(){
        $stores=Store::paginate(20);
        return view('admin_pages.brand.store_list',compact('stores'));
    }

    public function service_update_admin($service_id){
        $service_info=Service::find($service_id);
        $service_img=$service_info->service_image;
        return view('admin_pages.brand.service_update',compact('service_info','service_img'));
    }


    public function classified_update_admin($service_id){
        $service_info=Classified::find($service_id);
        $service_img=$service_info->classified_image;
        return view('admin_pages.brand.classified_update',compact('service_info','service_img'));
    }


    public function store_update_admin($store_id){
        $store_info=Store::find($store_id);
        $store_img=$store_info->store_image;
        return view('admin_pages.brand.store_update',compact('store_info','store_img'));
    }
    
    public function store_delete_admin($store_id){
        $store_info=Store::find($store_id);
        $store_info->delete();
        return redirect()->route('store_list');
    }
    
    public function service_delete_admin($service_id){
        $service_info=Service::find($service_id);
        $service_info->delete();
        return redirect()->route('service_list');
    }
    
    public function classified_delete_admin($service_id){
        $service_info=Classified::find($service_id);
        $service_info->delete();
        return redirect()->route('classified_list');
    }


    public function service_update_admin_submit(Request $req){
        $service_id=$req->service_id;
        $folderName = public_path('assets/vendor_assets/service_images_admin/');
        if ($req->hasFile('service_image')) {
            $image = $req->file('service_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $service_info=Service::find($req->service_id);
            $service_info->service_name=$req->service_name;
            $service_info->service_image='assets/vendor_assets/service_images_admin/'  . $imageName;
            $service_info->save();
        }else{
            $imageName=$req->service_image;
            $service_info=Service::find($req->service_id);
            $service_info->service_name=$req->service_name;
            $service_info->service_image=$imageName;
            $service_info->save();
        }

        toastr()->success('Service Updated');
        return redirect()->route('service_list');
    }


    public function classified_update_admin_submit(Request $req){
        $service_id=$req->service_id;
        $folderName = public_path('assets/vendor_assets/classified_images_admin/');
        if ($req->hasFile('service_image')) {
            $image = $req->file('service_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $service_info=Classified::find($req->service_id);
            $service_info->classified_name=$req->service_name;
            $service_info->classified_image='assets/vendor_assets/classified_images_admin/'  . $imageName;
            $service_info->save();
        }else{
            $imageName=$req->service_image;
            $service_info=Service::find($req->service_id);
            $service_info->classified_name=$req->service_name;
            $service_info->classified_image=$imageName;
            $service_info->save();
        }

        toastr()->success('Classified Updated');
        return redirect()->route('classified_list');
    }

    public function store_update_admin_submit(Request $req){
        $store_id=$req->StoreID;
        $folderName = public_path('assets/vendor_assets/store_images_admin/');
        if ($req->hasFile('store_image')) {
            $image = $req->file('store_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $store_info=Store::find($req->StoreID);
            $store_info->StoreName=$req->store_name;
            $store_info->store_image='assets/vendor_assets/store_images_admin/'  . $imageName;
            $store_info->save();
        }else{
            $imageName=$req->store_image;
            $store_info=Store::find($req->StoreID);
            $store_info->StoreName=$req->store_name;
            $store_info->store_image=$imageName;
            $store_info->save();
        }

        toastr()->success('Store Updated');
        return redirect()->route('store_list');
    }

    public function brand_update_admin($brand_id){
        $brand_info=Brand::find($brand_id);
        $brand_img=$brand_info->ImageURL;
        return view('admin_pages.brand.brand_update',compact('brand_info','brand_img'));
    }

    public function brand_update_admin_submit(Request $req){
        $brand_id_id=$req->brand_id;
        $folderName = public_path('assets/vendor_assets/brand_images_admin/');
        if ($req->hasFile('brand_image')) {
            $image = $req->file('brand_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $brand_info=Brand::find($req->brand_id);
            $brand_info->brand_name=$req->brand_name;
            $brand_info->ImageURL='assets/vendor_assets/brand_images_admin/'  . $imageName;
            $brand_info->save();
        }else{
            $imageName=$req->brand_image;
            $brand_info=Brand::find($req->brand_id);
            $brand_info->brand_name=$req->brand_name;
            $brand_info->ImageURL=$imageName;
            $brand_info->save();
        }

        toastr()->success('Brand Updated');
        return redirect()->route('brand_list');
    }

    public function business_listing_status_update($user_id){
        $user_id=$user_id;
        $user_details=BusinessListing::where('service_user_id',$user_id)->first();
        // return $user_details;
        return view('admin_pages.brand.business_listing_update',compact('user_id','user_details'));
    }

    // public function business_listing_status_update_submit(Request $req){
    //     $total_amount=210;
    //     $percentage_completed=8;
    //     $commission_amount=0;
    //     $each_part_amount=210/20;
    //     $user_detail=ServiceUser::where('service_id',$req->user_id)->get();
    //     $referral_by=$user_detail[0]->referral_by;
    //     $referred_user=ServiceUser::where('referral_id',$referral_by)->get();
    //     $commission_user_wallet=new CommissionWallet();
    //     $commission_user_wallet->user_id=$referred_user[0]->service_id;
    //     $commission_user_wallet->balance=8*$each_part_amount;
    //     $total_amount=$total_amount-8*$each_part_amount;
    //     $commission_user_wallet->save();
    //     while($total_amount>0){
    //         $referred_user=ServiceUser::where('referral_id',$referred_user[0]->referral_by)->get();
    //         if($referred_user[0]->commission_percentage>8 && $referred_user[0]->referral_by!='admin'){
    //             $commission_percentage=$referred_user[0]->commission_percentage-$percentage_completed;
    //             $commission_amount=$commission_percentage*$each_part_amount;
    //             if($commission_amount>$total_amount){
    //                 $commission_amount=$total_amount;
    //             }
    //             $total_amount=$total_amount-$commission_amount;
    //         }else{
    //             $referred_user=ServiceUser::where('referral_id',$referred_user[0]->referral_by)->get();
    //             $commission_percentage=$referred_user[0]->commission_percentage-$percentage_completed;
    //             $commission_amount=$commission_percentage*$each_part_amount;
    //             if($commission_amount>$total_amount){
    //                 $commission_amount=$total_amount;
    //             }

    //             $total_amount=$total_amount-$commission_amount;
                
    //         }
    //         $commission_user_wallet=new CommissionWallet();
    //         $commission_user_wallet->user_id=$referred_user[0]->service_id;
    //         $commission_user_wallet->balance=$commission_amount;
    //         $commission_user_wallet->save();
    //     }
    //     $user_detail=BusinessListing::find($req->user_id);
    //     $user_detail->status=$req->status;
    //     $user_detail->save();
    //     toastr()->success('Status Updated');
    //     return redirect('/serviceusers');
    // }


    public function business_listing_status_update_submit(Request $req){
        
        $business_listing_user=BusinessListing::where('service_user_id',$req->user_id)->get();
        if($business_listing_user[0]->business_listing_type=='2'){
            return redirect()->route('classified_business_service',['user_id'=>$req->user_id]);
        }
        
        $back_2_back_commission=100;
        $charity_wallet=10;
        $monthly_pool_wallet=50;
        $company_wallet=640;
        $admin_wallet=new AdminWallet();
        $admin_wallet->back_two_back=$back_2_back_commission;
        $admin_wallet->charity=$charity_wallet;
        $admin_wallet->monthly_pool=$monthly_pool_wallet;
        $admin_wallet->company=$company_wallet;
        $admin_wallet->save();
        // return AdminWallet::all();
        $total_amount=200;
        $percentage_completed=8;
        $comparission_percentage=8;
        $commission_amount=0;
        $each_part_amount=200/20;
        $user_detail=ServiceUser::where('service_id',$req->user_id)->get();
        // return $user_detail;
        $referral_by=$user_detail[0]->referral_by;
        $admin_id=ServiceUser::where('referral_id','admin')->get();
        // return $admin_id[0]->service_id;
        if($referral_by==='admin'){
            $commission_user_wallet=new CommissionWallet();
                $commission_user_wallet->user_id=$admin_id[0]->service_id;
                $commission_user_wallet->balance=$total_amount;
                $commission_user_wallet->save();
                $total_amount=0;
                $user_detail=BusinessListing::find($req->user_id);
                // return $user_detail;
                $user_detail->status=$req->status;
                $user_detail->save();
                toastr()->success('Status Updated');
                return redirect('/serviceusers');
        }
        $referred_user=ServiceUser::where('referral_id',$referral_by)->get();
        $commission_user=CommissionWallet::where('user_id',$referred_user[0]->service_id)->first();
        if($commission_user){
            $commission_user->balance+=$referred_user[0]->commission_percentage*$each_part_amount;
            $commission_user->save();
        }else{
            $commission_user_wallet=new CommissionWallet();
            $commission_user_wallet->user_id=$referred_user[0]->service_id;
            $commission_user_wallet->balance=$referred_user[0]->commission_percentage*$each_part_amount;
            $comparission_percentage=$referred_user[0]->commission_percentage;
            $total_amount=$total_amount-$referred_user[0]->commission_percentage*$each_part_amount;
            $commission_user_wallet->save();
        }
        while($total_amount>0){
            $referred_user=ServiceUser::where('referral_id',$referred_user[0]->referral_by)->get();
            // return $referred_user;
            if($referred_user[0]->referral_by==='admin'){
                $commission_user_wallet=new CommissionWallet();
                $commission_user_wallet->user_id=$admin_id[0]->service_id;
                $commission_user_wallet->balance=$total_amount;
                $commission_user_wallet->save();
                $total_amount=0;
                $user_detail=BusinessListing::find($req->user_id);
                $user_detail->status=$req->status;
                $user_detail->save();
                toastr()->success('Status Updated');
                return redirect('/serviceusers');
            }
            while($referred_user[0]->commission_percentage<=$comparission_percentage){
                print_r("commission Percentage  is:".$referred_user[0]->commission_percentage);
                $referred_user=ServiceUser::where('referral_id',$referred_user[0]->referral_by)->get();
                
            }
            // $referred_user=ServiceUser::where('referral_id',$referred_user[0]->referral_by)->get();
            // return $referred_user;
            // return $referred_user[0]->commission_percentage;
            $commission_percentage=$referred_user[0]->commission_percentage-$comparission_percentage;
            $comparission_percentage=$comparission_percentage+$commission_percentage;
            $comparission_percentage=$referred_user[0]->commission_percentage;
            $commission_amount=$commission_percentage*$each_part_amount;
            if($commission_amount>$total_amount){
                $commission_amount=$total_amount;
            }
            $commission_user=CommissionWallet::where('user_id',$referred_user[0]->service_id)->first();
            if($commission_user){
                $commission_user->balance+=$referred_user[0]->commission_percentage*$each_part_amount;
                $commission_user->save();
            }else{
                $commission_user_wallet=new CommissionWallet();
                $commission_user_wallet->user_id=$referred_user[0]->service_id;
                $commission_user_wallet->balance=$commission_amount;
                $total_amount=$total_amount-$commission_amount;
                $commission_user_wallet->save();
            }
                // return "Not Greater".$referred_user[0]->referral_by;
        }
        $user_detail=BusinessListing::find($req->user_id);
        $user_detail->status=$req->status;
        $user_detail->save();
        toastr()->success('Status Updated');
        return redirect('/serviceusers');
    }

    public function status_update_id_active_submit(Request $req){
        $user_detail=BusinessListing::find($req->user_id);
        $user_detail->status=$req->status;
        $user_detail->save();
        toastr()->success('Status Updated');
        return redirect()->route('serviceusers');
    }


    public function classified_business_service($user_id){
        $user_id= session::get('service_user_id');
        $user_detail = ServiceUser::where('service_id', $user_id)->first();
        if (!$user_detail) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $referral_by = $user_detail->referral_by;
        if ($referral_by === 'admin') {
            $admin = ServiceUser::where('referral_id', 'admin')->first();
            if ($admin) {
                $admin->cumulative_gross += 100;
                $admin->save();
            }
        }
        $referred_user = ServiceUser::where('referral_id', $referral_by)->first();
        while ($referred_user && $referred_user->referral_id !== 'admin') {
            $referred_user->cumulative_gross += 100;
            $referred_user->save();
            $referred_user = ServiceUser::where('referral_id', $referred_user->referral_by)->first();
        }
        if ($referred_user && $referred_user->referral_by === 'admin') {
            $admin = ServiceUser::where('referral_id', 'admin')->first();
            if ($admin) {
                $admin->cumulative_gross += 100;
                $admin->save();
            }
        }
        $user_detail=BusinessListing::find($user_id);
        $user_detail->status='1';
        $user_detail->save();
        $admin_wallet=new AdminWallet();
        $admin_wallet->back_two_back=0;
        $admin_wallet->charity=0;
        $admin_wallet->monthly_pool=0;
        $admin_wallet->company=100;
        $admin_wallet->save();
        toastr()->success('Status Updated');
        return redirect('/serviceusers');
    }

    public function id_activation_update($user_id){
        $user_id=$user_id;
        $user_details=BusinessListing::where('service_user_id',$user_id)->first();
        return view('admin_pages.brand.id_activation_business_update',compact('user_id','user_details'));
    }
}
