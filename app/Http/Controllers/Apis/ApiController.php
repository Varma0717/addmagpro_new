<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Vendor_Panel\Products;
use Illuminate\Support\Facades\DB;
use App\Models\Service\Cartproducts;
use App\Models\CustomerOrderedProducts;
use App\Models\Vendor_Panel\Category;

use Carbon\Carbon;

class ApiController extends Controller
{
    
    public function login(){
        return ServiceUser::all();
    }
    
    public function register(Request $req)
    {
        $customMessages = [
            'member_name.required' => 'The Member Name is required.',
            'mobile_no.required' => 'The Mobile Number is required.',
            'password.required' => 'The Password is required.',
            'location.required' => 'The Location is required.',
            'mobile_no.unique' => 'The Mobile Number is already registered.',
            'mobile_no.size' => 'The Mobile Number must be 10 digits.',
        ];
    
        $validator = Validator::make($req->all(), [
            'member_name' => 'required|min:5',
            'mobile_no' => 'required|size:10|unique:service_users,member_phone',
            'password' => 'required',
            'location' => 'required'
        ], $customMessages);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'status' => 'Failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        $service_user = new ServiceUser();
        $service_user->member_name = $req->member_name;
        $service_user->member_phone = $req->mobile_no;
        $service_user->password = Hash::make($req->password);
        $service_user->open_password = $req->password;
        $service_user->location = $req->location;
        $service_user->joined_date = Carbon::now();
        $service_user->cumulative_gross = '0';
        $service_user->referral_id = $req->mobile_no;
        $service_user->referral_by = '9346234899'; // Default referral_by value
        $service_user->save();
    
        return response()->json([
            'message' => 'User registered successfully',
            'status' => 'Success',
            'user' => $service_user
        ], 201);
    }
    
    public function user_login(Request $req)
    {
        $customMessages = [
            'member_phone.required' => 'The Mobile Number is required.',
            'password.required' => 'The Password is required.',
            'member_phone.size' => 'The Mobile Number must be 10 digits.',
        ];
    
        // Validate the request
        $validator = Validator::make($req->all(), [
            'member_phone' => 'required|size:10',
            'password' => 'required',
        ], $customMessages);
    
        // Handle validation errors
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'status' => 'Failed',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Check if the user exists
        $user = ServiceUser::where('member_phone', $req->member_phone)->first();
    
        if (!$user) {
            return response()->json([
                'message' => 'Invalid Mobile Number',
                'status' => 'Failed',
            ], 404);
        }
    
        // Verify the password
        if (!password_verify($req->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials',
                'status' => 'Failed',
            ], 401);
        }
    
        // Save user session
        // $req->session()->put('service_user_name', $user->member_name);
        // $req->session()->put('service_user_id', $user->service_id);
        
        return response()->json([
            'message' => 'User logged in successfully',
            'status' => 'Success',
            'data' => [
                'user_name' => $user->member_name,
                'user_id' => $user->service_id,
            ],
        ], 200);
    }
    
    public function category_list(){
        $vendor_categories=Category::where('Vendor_id','37')->get();
        return response()->json([
            'message' => 'Vendor Product Categories',
            'status' => 'Success',
            'data' => [
                'categories' => $vendor_categories,
            ],
        ], 200);
    }
    
    public function products_list(Request $req){
        $validator = Validator::make($req->all(), [
            'category_id' => 'required|integer|exists:categories,id', // Make sure it exists in the categories table
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'status' => 'Failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        $products_based_on_category=Products::where('category_id',$req->category_id)->get();
        return response()->json([
            'message' => 'Vendor Products List',
            'status' => 'Success',
            'data' => [
                'products_list' => $products_based_on_category,
            ],
        ], 200);
        
    }
    
    public function add_to_cart(Request $req){
        $cart=new Cartproducts;
        $existing_cart_product = Cartproducts::where('product_id', $req->product_id)
        ->where('service_user_id', $req->user_id)
        ->first();
        if ($existing_cart_product) {
            return response()->json([
                'message' => 'Product Already in Cart',
                'status' => 'Fail',
            ], 404);
        }
        $cart->service_user_id=$req->user_id;
        $cart->product_id=$req->product_id;
        $cart->quantity=$req->quantity;
        $cart->save();
        return response()->json([
            'message' => 'Product Added to Cart',
            'status' => 'Success',
            'data' => [
                'cart_id' => $cart['cart_id'],
            ],
        ], 200);
    }
    
    public function view_cart(Request $req){
        $cart_products=DB::table('cart_products')
        ->select('*')
        ->join('products_list','cart_products.product_id','=','products_list.product_id')
        ->where('service_user_id','=',$req->user_id)
        ->get();
        return response()->json([
            'message' => 'Customer Cart Items',
            'status' => 'Success',
            'data' => [
                'cart_products' => $cart_products,
            ],
        ], 200);
        
    }
    
    public function order_products(Request $req){
        $customMessages = [
            'user_id.required' => 'The User ID is required.',
            'first_name.required' => 'The First Name is required.',
            'first_name.min' => 'The First Name must be at least 2 characters.',
            'location.required' => 'The Location is required.',
            'email.required' => 'The Email is required.',
            'email.email' => 'The Email must be a valid email address.',
            'mobile_no.required' => 'The Mobile Number is required.',
            'mobile_no.unique' => 'The Mobile Number is already registered.',
            'mobile_no.size' => 'The Mobile Number must be exactly 10 digits.',
            'address.required' => 'The Address is required.',
            'zip_code.required' => 'The ZIP Code is required.',
            'zip_code.numeric' => 'The ZIP Code must be a number.',
            'city_name.required' => 'The City is required.',
            'country_name.required' => 'The State/Country is required.',
            'totalAmount.required' => 'The Total Amount is required.',
            'totalAmount.numeric' => 'The Total Amount must be a number.',
        ];
    
        $validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'first_name' => 'required|min:2',
            'location' => 'required',
            'email' => 'required|email',
            'mobile_no' => 'required|size:10|unique:service_users,member_phone',
            'address' => 'required',
            'zip_code' => 'required|numeric',
            'city_name' => 'required',
            'country_name' => 'required',
            'totalAmount' => 'required|numeric',
        ], $customMessages);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'status' => 'Failed',
                'errors' => $validator->errors()
            ], 422);
        }
        $unique_id = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $ordered_products=DB::table('products_list')
            ->select('products_list.product_id', 'products_list.product_name', 'products_list.purchase_price','products_list.unit_price','cart_products.quantity')
            ->join('cart_products','products_list.product_id','=','cart_products.product_id')
            ->where('cart_products.service_user_id','=',$req->user_id)
            ->get();
        $customered_ordered_details=new CustomerOrderedProducts();
        $customered_ordered_details->user_id=$req->user_id;
        $customered_ordered_details->first_name=$req->first_name;
        $customered_ordered_details->location=$req->location;
        $customered_ordered_details->email=$req->email;
        $customered_ordered_details->mobile_no=$req->mobile_no;
        $customered_ordered_details->address=$req->address;
        $customered_ordered_details->zip_code=$req->zip_code;
        $customered_ordered_details->city=$req->city_name;
        $customered_ordered_details->state=$req->country_name;
        $customered_ordered_details->total_amount=$req->totalAmount;
        $customered_ordered_details->oredered_products=$ordered_products;
        $customered_ordered_details->unique_id=$unique_id;
        $customered_ordered_details->save();
        return response()->json([
            'message' => 'Order Placed',
            'status' => 'Success',
            'data' => [
                'cart_products' => $customered_ordered_details,
            ],
        ], 200);
    }


}
