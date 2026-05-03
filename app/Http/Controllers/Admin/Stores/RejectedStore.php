<?php

namespace App\Http\Controllers\Admin\Stores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Admin_Panel\Store;

class RejectedStore extends Controller
{
    public function rejected_stores(){
        $approved_stores=Vendor::where('status','Rejected')->paginate(20);
        return view('admin_pages.stores.rejectedstore',['approved_stores'=>$approved_stores]);
    }
}
