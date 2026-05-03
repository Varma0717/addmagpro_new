<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin_Panel\Franchise;
use App\Models\Admin;

class AllFranchise extends Controller
{
    public function index(){
        $all_franchise=Franchise::paginate(20);
        return view('admin_pages.allfranchise',['all_franchise'=>$all_franchise]);
    }

    public function active_franchise(){
        $active_franchise=Franchise::where('franchise_status',1)->paginate(20);
        return view('admin_pages.activefranchise',['active_franchise'=>$active_franchise]);

    }

    public function inactive_franchise(){
        $inactive_franchise=Franchise::where('franchise_status',0)->paginate(20);
        return view('admin_pages.inactivefranchise',['inactive_franchise'=>$inactive_franchise]);
    }
}
