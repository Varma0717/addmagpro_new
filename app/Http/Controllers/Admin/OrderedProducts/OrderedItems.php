<?php

namespace App\Http\Controllers\Admin\OrderedProducts;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrderedProducts;
use Illuminate\Http\Request;

class OrderedItems extends Controller
{
    public function delivered_products(){
        $ordered_products=CustomerOrderedProducts::where('status','Delivered')->paginate(20);
        // return $ordered_products;
        return view('admin_pages.ordered_products.ordered_products',compact('ordered_products'));
    }

    public function shipping_products(){
        $ordered_products=CustomerOrderedProducts::where('status','Shipping')->paginate(20);
        // return $ordered_products;
        return view('admin_pages.ordered_products.ordered_products',compact('ordered_products'));
    }

    public function packaging_products(){
        $ordered_products=CustomerOrderedProducts::where('status','Packing')->paginate(20);
        // return $ordered_products;
        return view('admin_pages.ordered_products.ordered_products',compact('ordered_products'));
    }
}
