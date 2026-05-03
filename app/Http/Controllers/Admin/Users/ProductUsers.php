<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin_Panel\ProductUser;

class ProductUsers extends Controller
{
    public function product_users(){
        $product_users=ProductUser::paginate(20);
        return view('admin_pages.users.productusers',['product_users'=>$product_users]);
    }
}
