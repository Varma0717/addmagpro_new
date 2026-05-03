<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Vendor_Panel\Category;
use App\Models\Vendor_Panel\Brand;
use App\Models\Vendor_Panel\VendorBanner;
use App\Models\Vendor_Panel\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    public function vendor_register_submit(Request $req){
        $customMessages = [
            'vendor_name.required' => 'The Vendor Name  is required.',
            'vendor_number.required' => 'The Vendor Number is required.',
            'vendor_number.size' => 'The Vendor Number must be 10 digits .',
            'vendor_email.required' => 'The Vendor Email  is required.',
            'vendor_email.unique' => 'The Vendor Email  is Already registered.',
            'bussiness_name.required' => 'The Business Name  is required.',
            'bussiness_type.required' => 'The Business Type  is required.',
            'vendor_address.required' => 'The Business Address  is required.',
            'vendor_location.required' => 'The Business Location  is required.',
            'vendor_password.required' => 'The Password is required.',
            // 'pan_number.unique' => 'Pan Number Already registered.',
            'pan_number.size' => 'The Pan Number Must be 10 digits.',
            'pan_number.required' => 'The Pan Number is required.',
            'commission_percentage.required' => 'The commission Percentage is required.',
            'bank_name.required' => 'The Bank Name is required.',
            'account_num.required' => 'The Account Number is required.',
            'ifsc.required' => 'The IFSC is required.',
            // 'gst_number.unique' => 'GST Number Already registered.',
            'gst_number.required' => 'The GST Number is required.'
        ];
    
        $req->validate([
            'vendor_name' => 'required|min:5',
            'vendor_number' => 'required|size:10',
            'vendor_email' => 'required|unique',
            'vendor_email' => 'required|email|unique:vendors,vendor_email',
            'bussiness_name' => 'required',
            'bussiness_type' => 'required',
            'vendor_address' => 'required',
            'vendor_location' => 'required',
            'vendor_password' => 'required|min:5',
            'pan_number' => 'required|size:10',
            // 'pan_number' => 'required|size:10|unique:vendors,pancard_number',
            'account_num' => 'required',
            'bank_name' => 'required',
            'commission_percentage' => 'required',
            'ifsc' => 'required',
            'gst_number' => 'required',
            // 'gst_number' => 'required|unique:vendors,gst_number',
        ], $customMessages);
        $random_num=Str::random(10);
        $vendor=new Vendor();
        $vendor->vendor_name=$req->vendor_name;
        $vendor->vendor_phone=$req->vendor_number;
        $vendor->vendor_email=$req->vendor_email;
        $vendor->password=Hash::make($req->vendor_password);
        $vendor->open_password=$req->vendor_password;
        $vendor->business_name=$req->bussiness_name;
        $vendor->business_type=$req->bussiness_type;
        $vendor->business_address=$req->vendor_address;
        $vendor->business_location=$req->vendor_location;
        $vendor->pancard_number=$req->pan_number;
        $vendor->commission_percentage=$req->commission_percentage;
        $vendor->bank_name=$req->bank_name;
        $vendor->account_number=$req->account_num;
        $vendor->ifsc=$req->ifsc;
        $vendor->gst_number=$req->gst_number;
        $vendor->reference_id=$req->vendor_number;
        $vendor->reference_by=$req->referral_by;
        $vendor->save();
        $last_vendor = DB::table('vendors')
                    ->select('vendor_id')
                    ->orderBy('vendor_id', 'desc')
                    ->first();
        $last_vendor=(string) $last_vendor->vendor_id;
        // Vendor Banner Adding
        $new_vendor_id=$last_vendor;
        $vendor_banner=new VendorBanner();
        $vendor_banner->vendor_id=$new_vendor_id;
        // $vendor_banner->ImageURL='assets/vendor_assets/images/user.png';
        $vendor_banner->ImageURL='assets/vendor_assets/vendor_banner/6656f46a71a68.vendor_banner_common.jpg';
        $vendor_banner->save();
        $profile_image_session='assets/vendor_assets/images/user.png';
        $req->session()->put('vendor_id',$last_vendor);
        $req->session()->put('profile_image',$profile_image_session);
        $req->session()->put('vendor_name',$req->vendor_name);
        $req->session()->put('vendor_number',$req->vendor_number);
        toastr()->success('Vendor Registeration Successfully!');
        return redirect('vendor_dashboard');
    }

    public function vendor_dashboard(Request $req){
        $vendor_id= session::get('vendor_id');
        $products_count=Products::where('vendor_id',$vendor_id)->count();
        return view('vendor_pages.vendor_dashboard',compact('products_count'));
    }

    public function logout(){
        if(Session()->has('vendor_name')){
            session()->pull('vendor_name');
            session()->pull('vendor_number');
        }
        return redirect('login');   
    }

    public function vendor_new_category(Request $req){
        return view('vendor_pages.new_category');
    }

    public function vendor_category_list(Request $req){
        $vendor_id=Session::get('vendor_id');
        $category_details=Category::where('Vendor_id',$vendor_id)->get();
        return view('vendor_pages.category_list',['category_details'=>$category_details]);
    }

    public function vendor_new_brand(Request $req){
        return view('vendor_pages.new_brand');
    }

    public function vendor_brand_list(Request $req){
        $vendor_id=Session::get('vendor_id');
        $brand_details=Brand::where('vendor_id',$vendor_id)->get();
        return view('vendor_pages.brand_list',['brand_details'=>$brand_details]);
    }


    public function add_new_brand(Request $req){
        $vendor_id = Session::get('vendor_id');

        $folderName = public_path('assets/vendor_assets/brand_images/' . $vendor_id); // Use $vendor_id[0] to get the ID as an integer.
        if (!file_exists($folderName)) {
            mkdir($folderName, 0777, true); // Create the folder with full permissions (0777).
        }

        if ($req->hasFile('brand_image')) {
            $image = $req->file('brand_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $user = new Brand;
            $user->	vendor_id = $vendor_id;
            $user->	brand_name = $req->brand_name;
            $user->ImageURL = 'assets/vendor_assets/brand_images/' . $vendor_id . '/' . $imageName; // Update the image path.
            $result = $user->save();

            if ($result) {
                toastr()->success('Brand Added Successfully!');
                return redirect('vendor_brand_list');
            } else {
                toastr()->error('Brand Adding Failed!');
                return redirect('vendor_brand_list');
            }
        } else {
            toastr()->error('Image Not Found!');
            return redirect('vendor_brand_list');
        }
    }

    public function vendor_order_list(Request $req){
        $vendor_id= session::get('vendor_id');
        $vendor_products=Vendor::where('vendor_id',$vendor_id)->get();
        $customer_ordered_products=Products::where('vendor_id',$vendor_id)->get();
        return view('vendor_pages.orders_list',compact('customer_ordered_products'));
    }

    public function products_list(){
        $vendor_id=Session('vendor_id');
        $product_list=Products::where('vendor_id',$vendor_id)->get();
        // return $product_list;
        return view('vendor_pages.products_list',compact('product_list'));
    }

    public function vendor_category_update($category_id){
        // $category_details=Category::where('id',$id)->get();
        // return view('vendor_pages.category_update',['category_details'=>$category_details]);
        // return view('vendor_pages.category_update');
        $category_info=Category::find($category_id);
        $category_img=$category_info->ImageURL;
        return view('vendor_pages.category_update',compact('category_info','category_img'));
    }

    public function vendor_banner_update($vendor_id){
        $category_info=VendorBanner::find($vendor_id);
        $category_img=$category_info->ImageURL;
        return view('vendor_pages.vendor_banner_update',compact('category_info','category_img'));
    }

    public function vendor_cate_up(){
        return view('vendor_pages.category_update');
    }

    public function vendor_category_delete($id){
        $category=Category::find($id);
        $category->delete();
        toastr()->success('Category Deleted Successfully!');
        return redirect('vendor_category_list');
    }

    public function vendor_brand_update($id){
        $brand_info=Brand::find($id);
        $brand_img=$brand_info->ImageURL;
        return view('vendor_pages.brand_update',compact('brand_info','brand_img'));
    }

    public function vendor_brand_update_submit(Request $req){
        $vendor_id=$req->brand_id;
        $folderName = public_path('assets/vendor_assets/brand_images/' . $vendor_id);
        if ($req->hasFile('brand_image')) {
            $image = $req->file('brand_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $brand_info=Brand::find($req->brand_id);
            $brand_info->brand_name=$req->brand_name;
            $brand_info->ImageURL='assets/vendor_assets/brand_images/' . $vendor_id . '/' . $imageName;
            $brand_info->save();
        }else{
            $imageName=$req->brand_image;
            $brand_info=Brand::find($req->brand_id);
            $brand_info->brand_name=$req->brand_name;
            $brand_info->ImageURL=$imageName;
            $brand_info->save();
        }

        toastr()->success('Brand Updated');
        return redirect()->route('vendor_brand_list');
    }

    public function vendor_category_update_submit(Request $req){
        $category_id=$req->category_id;
        $folderName = public_path('assets/vendor_assets/category_images/' . $category_id);
        if ($req->hasFile('category_image')) {
            $image = $req->file('category_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $category_info=Category::find($req->category_id);
            $category_info->CategoryName=$req->category_name;
            $category_info->ImageURL='assets/vendor_assets/category_images/' . $category_id . '/' . $imageName;
            $category_info->save();
        }else{
            $imageName=$req->category_image;
            $category_info=Category::find($req->category_id);
            $category_info->CategoryName=$req->category_name;
            $category_info->ImageURL=$imageName;
            $category_info->save();
        }

        toastr()->success('Category Updated');
        return redirect()->route('vendor_category_list');
    }

    public function vendor_banner_update_modify(Request $req){
        // return $req->input();
        $category_id=$req->category_id;
        $folderName = public_path('assets/vendor_assets/vendor_banner/');
        if ($req->hasFile('category_image')) {
            $image = $req->file('category_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $category_info=VendorBanner::find($req->category_id);
            // return $category_info;
            $category_info->ImageURL='assets/vendor_assets/vendor_banner/' . $imageName;
            $category_info->save();
        }else{
            $imageName=$req->category_image;
            $category_info=VendorBanner::find($req->category_id);
            $category_info->ImageURL=$imageName;
            $category_info->save();
        }

        toastr()->success('Vendor Banner Updated');
        return redirect()->route('vendor_banner');
    }

    public function vendor_brand_delete($brand_id){
        $brand=Brand::find($brand_id);
        $brand->delete();
        toastr()->success('Brand Deleted Successfully!');
        return redirect('vendor_brand_list');
    }
    
    public function vendor_settings(){
        $vendor_id=Session('vendor_id');
        $vendor_details=Vendor::where('vendor_id',$vendor_id)->get();
        return view('vendor_pages.settings',['vendor_details'=>$vendor_details]);
    }

    public function vendor_settings_update(Request $req){
        $lastEmployee=Session('vendor_id');
        $vendor_demo=Vendor::find($lastEmployee);
        $req->session()->put('vendor_name',$req->vendor_name);
        $folderName = public_path('assets/vendor_assets/profile_images/' . $lastEmployee); // Use $lastEmployee[0] to get the ID as an integer.
        if (!file_exists($folderName)) {
            mkdir($folderName, 0777, true); // Create the folder with full permissions (0777).
        }

        if ($req->hasFile('imageInput')) {
            $image = $req->file('imageInput');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $vendor_demo->	vendor_name = $req->vendor_name;
            $vendor_demo->	vendor_phone = $req->phone_number;
            $vendor_demo->	vendor_email =  $vendor_demo->vendor_email;
            $vendor_demo->	password = $vendor_demo->password;
            $vendor_demo->	business_name = $req->business_name;
            $vendor_demo->	business_type = $req->business_type;
            $vendor_demo->	reference_id = $vendor_demo->reference_id;
            $vendor_demo->	status = $vendor_demo->status;
            $vendor_demo->business_address	 = $req->vendor_address;
            $vendor_demo->profile_image = 'assets/vendor_assets/profile_images/' . $lastEmployee . '/' . $imageName;
            $profile_img='assets/vendor_assets/profile_images/' . $lastEmployee . '/' . $imageName;
            $req->session()->put('profile_image',$profile_img);
            $result = $vendor_demo->save();

            if ($result) {
                toastr()->success('Vendor Details Updated!');
                return redirect('/vendor_dashboard');
            } else {
                toastr()->error('Vendor Update Failed!');
                return redirect('/vendor_dashboard');
            }
        } else {
            $vendor_demo->	vendor_name = $req->vendor_name;
            $vendor_demo->	vendor_phone = $req->phone_number;
            $vendor_demo->	vendor_email =  $vendor_demo->vendor_email;
            $vendor_demo->	password = $vendor_demo->password;
            $vendor_demo->	business_name = $req->business_name;
            $vendor_demo->	business_type = $req->business_type;
            $vendor_demo->	reference_id = $vendor_demo->reference_id;
            $vendor_demo->	status = $vendor_demo->status;
            $vendor_demo->business_address	 = $req->vendor_address;
            $vendor_demo->profile_image = $vendor_demo->profile_image;
            $result = $vendor_demo->save();
            if ($result) {
                toastr()->success('Vendor Details Updated!');
                return redirect('/vendor_dashboard');
            } 
        }
    }

    public function vendor_profile(){
        $lastEmployee=Session('vendor_id');
        $vendor_demo=Vendor::find($lastEmployee);
        return view('vendor_pages.profile',['vendor_details'=>$vendor_demo]);
    }

    public function new_product(){
        $vendor_id=Session('vendor_id');
        $category_details=Category::where('vendor_id',$vendor_id)->get();
        $brand_details=Brand::where('vendor_id',$vendor_id)->get();
        if(count($brand_details)==0){
            toastr()->error('Add Brand Before Adding Products!');
            return redirect()->route('vendor_new_brand');
        };
        if(count($category_details)==0){
            toastr()->error('Add Category Before Adding Products!');
            return redirect()->route('vendor_new_category');
        };
        return view('vendor_pages.new_product',compact('category_details','brand_details'));
    }

    public function new_product_submit(Request $req){
        $vendor_id=Session('vendor_id');
        $folderName = public_path('assets/vendor_assets/product_lists/' . $vendor_id); 
        if (!file_exists($folderName)) {
            mkdir($folderName, 0777, true); 
        }

        if ($req->hasFile('product_thumbnail')) {
            $image = $req->file('product_thumbnail');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $product_list=new Products;
            $product_list->product_name=$req->product_name;
            $product_list->product_description=$req->product_description;
            $product_list->vendor_id=$vendor_id;
            $product_list->category_id=$req->category;
            $product_list->brand_id=$req->brand;
            $product_list->item_code=$req->item_code;
            $product_list->unit_price=$req->unit_price;
            $product_list->purchase_price=$req->purchase_price;
            $product_list->product_images='assets/vendor_assets/product_lists/' . $vendor_id . '/' . $imageName;
            $product_list->save();

            if ($product_list) {
                toastr()->success('Product Added Successfully!');
                return redirect('products_list_vendor');
            } else {
                toastr()->error('Product Adding Failed!');
                return redirect('products_list_vendor');
            }
        }else{
            toastr()->error('Image Not Failed!');
            return redirect('products_list_vendor');
        }
    }

    public function product_delete($id){
        $product=Products::find($id);
        $product->delete();
        toastr()->success('Product Deleted Successfully!');
        return redirect('products_list_vendor');
    }

    public function product_update($id){
        $product=Products::find($id);
        $categories=Category::where('Vendor_id',$product->vendor_id)->get();
        $brands=Brand::where('vendor_id',$product->vendor_id)->get();
        $category=Category::where('id',$product->category_id)->get();
        $brand=Brand::where('id',$product->brand_id)->get();
        // return $brand;
        return view('vendor_pages.product_update',compact('product','category','brand','categories','brands'));
    }

    public function product_update_submit(Request $req){
        $vendor_id=$req->vendor_id;
        $folderName = public_path('assets/vendor_assets/product_lists/' . $vendor_id);
        $product_info=Products::find($req->product_id);
        $product_info->product_name=$req->product_name;
        $product_info->product_description=$req->product_description;
        $product_info->category_id=$req->category;
        $product_info->brand_id=$req->brand;
        $product_info->item_code=$req->item_code;
        $product_info->purchase_price=$req->purchase_price;
        $product_info->unit_price=$req->unit_price;
        if ($req->hasFile('product_thumbnail')) {
            $image = $req->file('product_thumbnail');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $product_info->product_images='assets/vendor_assets/product_lists/' . $vendor_id . '/' . $imageName;
        }
        $product_info->save();
        toastr()->success('Product Updated');
        return redirect()->route('products_list_vendors');
    }

    public function change_password(Request $req){
        $vendor=Vendor::find($req->vendor_id);
        $vendor->password=Hash::make($req->new_password);
        $vendor->save();
        toastr()->success('Password Updated');
        return redirect()->route('vendor_profile');
    }

    public function vendor_banner(){
        $vendor_id=Session::get('vendor_id');
        $vendor_banner=VendorBanner::where('vendor_id',$vendor_id)->get();
        return view('vendor_pages.vendor_banner',['category_details'=>$vendor_banner]);
    }
}
