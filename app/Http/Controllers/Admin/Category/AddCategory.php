<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Vendor_Panel\Category;

class AddCategory extends Controller
{
    public function add_category(){
        return view('admin_pages.category.add_category');
    }

    
    public function new_category_added(Request $req){

        $folderName = public_path('assets/vendor_assets/category_images_admin/'); // Use $vendor_id[0] to get the ID as an integer.
        $vendor_id=Session::get('vendor_id');
        if ($req->hasFile('category_image')) {
            $image = $req->file('category_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $user = new Category;
            $user->	Vendor_id = $vendor_id;
            $user->CategoryName	 = $req->category_name;
            $user->ImageURL = 'assets/vendor_assets/category_images_admin/' . $imageName; // Update the image path.
            $result = $user->save();

            if ($result) {
                toastr()->success('Category Added Successfully!');
                return redirect('vendor_category_list');
            } else {
                toastr()->error('Category Adding Failed!');
                return redirect('vendor_category_list');
            }
        } else {
            toastr()->error('Image Not Found!');
            return redirect('vendor_category_list');
        }
    }

    public function category_list(){
        $category=Category::paginate(20);
        return view('admin_pages.category.category_list',['category_details'=>$category]);
    }

    public function category_update_admin($category_id){
        $category_info=Category::find($category_id);
        $category_img=$category_info->ImageURL;
        return view('admin_pages.category.category_update',compact('category_info','category_img'));
    }

    public function category_update_admin_submit(Request $req){
        $category_id=$req->category_id;
        $folderName = public_path('assets/vendor_assets/category_images_admin/');
        if ($req->hasFile('category_image')) {
            $image = $req->file('category_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $category_info=Category::find($req->category_id);
            $category_info->CategoryName=$req->category_name;
            $category_info->ImageURL='assets/vendor_assets/category_images_admin/'  . $imageName;
            $category_info->save();
        }else{
            $imageName=$req->category_image;
            $category_info=Category::find($req->category_id);
            $category_info->CategoryName=$req->category_name;
            $category_info->ImageURL=$imageName;
            $category_info->save();
        }

        toastr()->success('Category Updated');
        return redirect()->route('category_list');
    }

}
