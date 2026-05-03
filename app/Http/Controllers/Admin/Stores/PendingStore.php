<?php

namespace App\Http\Controllers\Admin\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin_Panel\Store;
use App\Models\Vendor;
use App\Models\Vendor_Panel\DiscountVendor;
use App\Models\Admin;

class PendingStore extends Controller
{
    public function pending_stores(){
        $approved_stores=Vendor::where('status','Pending')->paginate(20);
        return view('admin_pages.stores.pendingstore',['approved_stores'=>$approved_stores]);
    }

    public function discount_vendors(){
        $discount_vendors=DiscountVendor::paginate(20);
        // return $discount_vendors;
        return view('admin_pages.stores.discount_vendors',compact('discount_vendors'));
    }

    public function update_status($vendor_id){
        return view('admin_pages.stores.updatestatus',['vendor_id'=>$vendor_id]);
    }

    public function updated_new_one(Request $req){
        $vendor_info=Vendor::find($req->vendor_id);
        $vendor_info->status=$req->status;
        $vendor_info->save();
        toastr()->success('Vendor Status Updated!');
        return redirect()->route('pendingstores');
    }

    public function admin_profile(){
        $admin=Admin::all();
        return view('admin_pages.admin_profile',compact('admin'));
    }
}
