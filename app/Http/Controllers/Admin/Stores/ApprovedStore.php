<?php

namespace App\Http\Controllers\Admin\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Admin_Panel\Store;

class ApprovedStore extends Controller
{
    public function approved_stores(){
        $approved_stores=Vendor::where('status','Approved')->paginate(20);
        return view('admin_pages.stores.approvedstore',['approved_stores'=>$approved_stores]);
    }
}
