<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service\BusinessListing;
use App\Models\Admin_Panel\ServiceUser;

class ServiceUsers extends Controller
{
    public function service_users(){
        $service_users=BusinessListing::where('status','0')->paginate(20);
        // return $service_users;
        return view('admin_pages.users.serviceusers',compact('service_users'));
    }
}
