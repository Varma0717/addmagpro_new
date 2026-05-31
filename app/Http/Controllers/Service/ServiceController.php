<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Service\ServiceUser;
use App\Models\Service\Cartproducts;
use App\Models\Admin_Panel\Service;
use App\Models\Admin_Panel\BankDetails;
use App\Models\Admin_Panel\HomeHeading;
use App\Models\Admin_Panel\Banner;
use App\Models\Service\Wishlist;
use Carbon\Carbon;
use Razorpay\Api\Api;
use App\Models\Service\BusinessListing;
use App\Models\Wallet\AdminWallet;
use Illuminate\Support\Facades\Session;
use App\Models\Wallet\ProductWallet;
use App\Models\CustomerOrderedProducts;
use Illuminate\Support\Facades\Hash;
use App\Models\Vendor_Panel\Products;
use App\Models\Vendor_Panel\VendorBanner;
use App\Models\Wallet\CommissionWallet;
use App\Models\Admin_Panel\UserCouponCode;
use App\Models\Vendor_Panel\Category;
use App\Models\Vendor_Panel\Brand;
use App\Models\Vendor_Panel\DiscountVendor;
use App\Models\Admin_Panel\GadgetGallery;
use App\Models\Wallet\BacktwoBackWallet;
use App\Models\Wallet\PoolCommissionWallet;
use App\Models\Admin_Panel\Gallery;
use App\Models\Admin_Panel\VendorWithdrawRequest;
use App\Models\Admin_Panel\Store;
use App\Models\Admin_Panel\AdsBanner;
use App\Models\Admin_Panel\Classified;
use App\Models\Admin_Panel\EventBanner;
use App\Models\DiscountStorePurchases;
use App\Models\Admin_Panel\PinSystem;
use App\Models\Admin_Panel\StoreImage;
use App\Models\ActiveUser;
use App\Models\Vendor;
use App\Models\State;
use App\Models\District;
use App\Models\Admin_Panel\WithdrawalRequest;

class ServiceController extends Controller
{
    public $user_cart_products;

    public function service_user_registration($referal = null)
    {
        if ($referal) {
            $referal_check = ServiceUser::where('referral_id', $referal)->get();

            if ($referal_check->count() > 0) {
                $referal_name = $referal_check[0]->member_name;
                $referral_by = $referal;
            } else {
                return redirect('service_user_registration');
            }
        } else {
            $referral_by = "admin";
            $referal_name = "admin";
        }

        return view('service_users.register', compact('referral_by', 'referal_name'));
    }

    public function service_registration_submit(Request $req)
    {
        $customMessages = [
            'member_name.required' => 'The Member Name  is required.',
            'mobile_no.required' => 'The Mobile Number is required.',
            'password.required' => 'The Password is required.',
            'location.required' => 'The Location is required.',
            'mobile_no.unique' => 'The Mobile Number is Already Registered.',
            'mobile_no.size' => 'The Mobile Number Must be 10 digits.',
        ];

        $req->validate([
            'member_name' => 'required|min:5',
            'mobile_no' => 'required|size:10|unique:service_users,member_phone',
            'password' => 'required',
            'location' => 'required'
        ], $customMessages);
        // return $req->input();
        $service_user = new ServiceUser();
        $service_user->member_name = $req->member_name;
        $service_user->member_phone = $req->mobile_no;
        $service_user->password = Hash::make($req->password);
        $service_user->open_password = $req->password;
        $service_user->location = $req->location;
        $service_user->joined_date = Carbon::now();
        $service_user->cumulative_gross = '0';
        $service_user->referral_id = $req->mobile_no;
        $service_user->referral_by = $req->referral_by;
        $service_user->save();
        toastr()->success('Registration Successfully!');
        return redirect('index');
    }

    public function welcome_page()
    {
        $cashback_products = Products::where('purchase_price', '>', 3000)->get();
        $discount_products = Products::where('purchase_price', '<', 3000)->get();
        $vendors_cashback_products = [];
        $vendors_discount_products = [];
        $discount_vendor_banners = DiscountVendor::all();
        foreach ($cashback_products as $cashback_product) {
            $vendor_id = $cashback_product->vendor_id;
            if (!isset($vendors_cashback_products[$vendor_id])) {
                $vendors_cashback_products[$vendor_id] = $cashback_product;
            }
        }

        foreach ($discount_products as $discount_product) {
            $vendor_id = $discount_product->vendor_id;
            if (!isset($vendors_discount_products[$vendor_id])) {
                $vendors_discount_products[$vendor_id] = $discount_product;
            }
        }
        // return $vendors_cashback_products;
        $user_id = session::get('service_user_id');
        $user_details = ServiceUser::where('service_id', $user_id)->first();

        if ($user_details) {
            $user_name = $user_details->member_name;
        } else {
            $user_name = "Guest"; // fallback
        }

        $headings = HomeHeading::all();
        $vendor_banners = VendorBanner::all();
        // return $vendor_banners;
        $total_joinings = ServiceUser::all()->count();
        $visitor_users = DB::select('SELECT * FROM service_users WHERE service_id NOT IN (SELECT service_user_id FROM business_listing_users) AND service_id NOT IN (SELECT user_id FROM customer_ordered_products) AND back_two_back_balance = 0 ORDER BY created_at DESC');
        $visitor_users_count = 30000 + 777 + count($visitor_users);
        $active_users = DB::select("SELECT *
        FROM service_users
        WHERE service_id IN (
            SELECT service_user_id
            FROM business_listing_users
        )
        OR service_id IN (
            SELECT user_id
            FROM customer_ordered_products
            WHERE confirmation_status = '1'
        )
        OR service_id IN (
            SELECT user_id
            FROM active_users
        )
        OR back_two_back_balance > 0 ORDER BY created_at DESC");
        $active_users_count = 1000 + count($active_users);
        $ads_gallery = AdsBanner::all();
        $gadget_gallery = GadgetGallery::take(10)->get();
        $gadget_gallery_mini = GadgetGallery::skip(10)->take(4)->get();
        $store_gallery = StoreImage::take(10)->get();
        $store_gallery_mini = StoreImage::skip(10)->take(4)->get();
        // return $gadget_gallery_mini;
        $service_user_id_for_cart = Session::get('service_user_id');
        $banner1 = Banner::where('banner_name', 'banner1')->get();
        $banner2 = Banner::where('banner_name', 'banner2')->get();
        $banner3 = Banner::where('banner_name', 'banner3')->get();
        $banner4 = Banner::where('banner_name', 'banner4')->get();
        $main_slider_banner = Banner::where('type', 'MainSlider')->get();
        // return $main_slider_banner[0]->banner_image;
        $allSessionData = Session::all();
        $products = Products::take(20)->get();
        $service = Service::take(4)->get();
        $store = Store::take(4)->get();
        // return $store;
        $latest_products = Products::latest()->take(7)->get();
        $categories = Category::all();
        $cart_products = DB::table('cart_products')
            ->select('*')
            ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id_for_cart)
            ->get();
        // return $cart_products;
        $cart_count = count($cart_products);
        $this->user_cart_products = $cart_products;
        $gallery_details = Gallery::take(6)->get();
        $event_banners = EventBanner::all();
        return view('service_users.welcome', compact('products', 'discount_vendor_banners', 'vendors_cashback_products', 'user_details', 'vendors_discount_products', 'user_name', 'headings', 'store', 'vendor_banners', 'visitor_users_count', 'active_users_count', 'ads_gallery', 'store_gallery', 'store_gallery_mini', 'gadget_gallery_mini', 'gadget_gallery', 'service', 'latest_products', 'categories', 'cart_products', 'cart_count', 'banner1', 'banner2', 'banner3', 'banner4', 'main_slider_banner', 'total_joinings', 'gallery_details', 'event_banners'));
    }

    public function index_page()
    {
        $service_user_id_for_cart = Session::get('service_user_id');
        $allSessionData = Session::all();
        $products = Products::take(20)->get();
        $service = Service::take(4)->get();
        $latest_products = Products::latest()->take(7)->get();
        $categories = Category::all();
        $cart_products = DB::table('cart_products')
            ->select('*')
            ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id_for_cart)
            ->get();
        $cart_count = count($cart_products);
        $this->user_cart_products = $cart_products;
        return view('service_users.index_page', compact('products', 'service', 'latest_products', 'categories', 'cart_products', 'cart_count'));
    }

    public function service_user_logout()
    {
        if (Session()->has('service_user_name')) {
            // session()->pull('service_user_name');
            Session::flush();
        }
        return redirect('index');
    }

    public function discount_vendor_detail($vendor_id)
    {
        $vendor_detail = DiscountVendor::where('vendor_id', $vendor_id)->first();
        // return $vendor_detail;
        return view('service_users.discount_vendor_full_view', compact('vendor_detail'));
    }

    public function vendor_discount_products_shop($vendor_id)
    {
        $discount_vendor_details = DiscountVendor::where('vendor_id', $vendor_id)->get();
        // return $discount_vendor_details;
        return view('service_users.vendor_discount_products_shop', compact('discount_vendor_details'));
    }

    public function customer_payments()
    {
        $user_id = Session::get('service_user_id');
        $user_detail = ServiceUser::where('service_id', $user_id)->first();
        $discount_vendor = DiscountVendor::where('member_phone', $user_detail['member_phone'])->first();
        if ($discount_vendor) {
            $customer_transactions = DB::table('discount_store_purchases')
                ->select('*')
                ->join('service_users', 'discount_store_purchases.customer_id', '=', 'service_users.service_id')
                ->where('vendor_id', '=', 3)
                ->orderBy('discount_store_purchases.created_at', 'asc')
                ->get();
            // return $customer_transactions;
            return view('service_users.customer_payments', compact('customer_transactions'));
        } else {
            toastr()->error('Regsiter Your Store');
            return redirect('add_your_shop');
        }
    }

    public function discount_shop_orders()
    {
        $user_id = Session::get('service_user_id');
        $my_discount_purchases = DiscountStorePurchases::where('customer_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();
        // return $my_discount_purchases;
        return view('service_users.discount_shop_orders', compact('my_discount_purchases'));
    }

    public function products_list()
    {
        $service_user_id_for_cart = Session::get('service_user_id');
        $vendor_categories = Category::where('Vendor_id', '37')->get();
        // return $vendor_categories;
        $categories = Category::all();
        $brands = Brand::all();
        // return $categories;
        $products = Products::all();
        $cart_products = DB::table('cart_products')
            ->select('*')
            ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id_for_cart)
            ->get();
        $cart_count = count($cart_products);
        return view('service_users.products_list', compact('products', 'vendor_categories', 'cart_products', 'cart_count', 'categories', 'brands'));
    }

    public function products_list_vendor($vendor_id)
    {
        // return $vendor_id;
        $service_user_id_for_cart = Session::get('service_user_id');
        $vendor_categories = Category::where('Vendor_id', $vendor_id)->get();
        // return $vendor_categories;
        $categories = Category::all();
        $brands = Brand::all();
        // return $categories;
        $products = Products::all();
        $cart_products = DB::table('cart_products')
            ->select('*')
            ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id_for_cart)
            ->get();
        $cart_count = count($cart_products);
        return view('service_users.products_list', compact('products', 'vendor_categories', 'cart_products', 'cart_count', 'categories', 'brands'));
    }


    public function add_your_shop()
    {
        $user_id = session::get('service_user_id');
        $user_details = ServiceUser::where('service_id', $user_id)->get();
        // return $user_details;
        return view('service_users.add_the_shop', compact('user_details'));
    }

    public function user_search_products(Request $req)
    {
        $searchTerm = $req->input('query');
        $service_user_id_for_cart = Session::get('service_user_id');
        $cart_products = DB::table('cart_products')
            ->select('*')
            ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id_for_cart)
            ->get();
        $products = Products::all();
        $cart_count = count($cart_products);
        if ($searchTerm == '') {
            return redirect()->back();
        }
        $products_based_on_category = Products::where('product_name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('product_description', 'LIKE', "%{$searchTerm}%")
            ->get();
        return view('service_users.products_grid_view', compact('products_based_on_category', 'cart_count', 'cart_products'));
        // return view('search_results', compact('products', 'searchTerm'));
    }

    public function products_grid_view($category_id)
    {
        // return $category_id;
        $products_based_on_category = Products::where('category_id', $category_id)->get();
        // return $products_based_on_category;
        $service_user_id_for_cart = Session::get('service_user_id');
        $cart_products = DB::table('cart_products')
            ->select('*')
            ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id_for_cart)
            ->get();
        $products = Products::all();
        // return $products;
        $cart_count = count($cart_products);
        return view('service_users.products_grid_view', compact('cart_products', 'cart_count', 'products', 'products_based_on_category'));
    }

    public function shop_registeration(Request $req)
    {
        $user_id = session::get('service_user_id');
        $folderName = public_path('assets/vendor_assets/discount_vendor_banners/'); // Use $vendor_id[0] to get the ID as an integer.
        if ($req->hasFile('category_image')) {
            $image = $req->file('category_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);

            $discount_vendor = new DiscountVendor();
            $discount_vendor->user_id = $user_id;
            $discount_vendor->member_name = $req->owner_name;
            $discount_vendor->member_phone = $req->mobile;
            $discount_vendor->shop_name = $req->shop_name;
            $discount_vendor->gst_number = $req->gst_number;
            $discount_vendor->shop_description = $req->shop_description;
            $discount_vendor->address = $req->address;
            $discount_vendor->banner_image = 'assets/vendor_assets/discount_vendor_banners/' . $imageName;
            $discount_vendor->location = $req->location;
            $discount_vendor->state = $req->state;
            $discount_vendor->district = $req->district;
            $discount_vendor->pincode = $req->pincode;
            $discount_vendor->bank_name = $req->bankname;
            $discount_vendor->account_name = $req->accountnumber;
            $discount_vendor->ifsc_code = $req->ifsccode;
            $discount_vendor->discount_margin = $req->margin;
            $discount_vendor->save();
            toastr()->success('Discount Vendor Registration Completed!Wait For Approval');
            return redirect()->route('welcome_page');
        } else {
            toastr()->error('Image Not Found!');
            return redirect('add_your_shop');
        }
    }

    public function product_detail($vendor_id, $category_id)
    {
        $service_user_id_for_cart = Session::get('service_user_id');
        $products_based_on_category = Products::where('vendor_id', $vendor_id)->where('category_id', $category_id)->get();
        $cart_products = DB::table('cart_products')
            ->select('*')
            ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id_for_cart)
            ->get();
        $cart_count = count($cart_products);
        return view('service_users.products_grid_view', compact('products_based_on_category', 'cart_products', 'cart_count'));
    }

    public function services_list()
    {
        $user_id = Session::get('service_user_id');
        $service_used_count = BusinessListing::where('service_user_id', $user_id)->count();
        $services = Service::orderBy('service_name')->get();
        $user_id = Session::get('service_user_id');
        $service_used_count = BusinessListing::where('service_user_id', $user_id)->count();
        $stores = Store::orderBy('StoreName')->get();
        return view('service_users.services_list', compact('services', 'service_used_count', 'stores', 'service_used_count'));
    }

    public function classifieds_list()
    {
        $classifieds = Classified::orderBy('classified_name')->get();
        // return $classifieds;
        return view('service_users.classified_list', compact('classifieds'));
    }


    public function user_stores_list()
    {
        $user_id = Session::get('service_user_id');
        $service_used_count = BusinessListing::where('service_user_id', $user_id)->count();
        $stores = Store::orderBy('StoreName')->get();
        // return $stores;
        return view('service_users.stores_list', compact('stores', 'service_used_count'));
    }

    public function adding_service()
    {
        $states = State::all();
        $districts = District::all();
        $user_id = session::get('service_user_id');
        $user_details = ServiceUser::where('service_id', $user_id)->get();
        $service_used_count = BusinessListing::where('service_user_id', $user_id)->count();
        if ($service_used_count > 0) {
            return redirect()->route('services_list');
        }
        // return $user_details;
        $services_details = Service::select('service_name', 'service_id')->get();
        $business_type = 0;
        return view(
            'service_users.adding_service',
            compact('user_details', 'states', 'districts', 'services_details', 'business_type')
        );
    }

    public function adding_classified()
    {
        $states = State::all();
        $districts = District::all();
        $user_id = session::get('service_user_id');
        $user_details = ServiceUser::where('service_id', $user_id)->get();
        // return $user_details;
        $services_details = Classified::select('classified_name', 'id')->get();
        // return $services_details;
        $business_type = 0;
        return view('service_users.adding_classified', compact('user_details', 'states', 'districts', 'services_details', 'business_type'));
    }

    public function adding_store()
    {
        $states = State::all();
        $districts = District::all();
        $user_id = session::get('service_user_id');
        $user_details = ServiceUser::where('service_id', $user_id)->get();
        $service_used_count = BusinessListing::where('service_user_id', $user_id)->count();
        if ($service_used_count > 0) {
            return redirect()->route('user_stores_list');
        }
        $services_details = Store::select('StoreName', 'StoreID')->get();
        $business_type = 1;
        return view('service_users.adding_store', compact('user_details', 'states', 'districts', 'services_details', 'business_type'));
    }

    public function service_fullview($service_id)
    {
        $service_id = $service_id;
        $service_users = DB::table('business_listing_users')
            ->select('*')
            ->join('services', 'services.service_id', '=', 'business_listing_users.profession')
            ->where('business_listing_users.profession', '=', $service_id)
            ->where('business_listing_users.status', '=', '1')
            ->where('business_listing_users.business_listing_type', '=', 0)
            ->get();
        // return $service_users;
        return view('service_users.services_fullview', compact('service_users'));
    }

    public function service_user_detail_view($user_id)
    {
        $service_id = $user_id;
        $service_users = BusinessListing::where('user_id', $service_id)->get();
        // return $service_users;
        return view('service_users.service_user_detail_view', compact('service_users'));
    }


    public function classified_fullview($service_id)
    {
        $service_id = $service_id;
        $service_users = DB::table('business_listing_users')
            ->select('*')
            ->join('classifieds', 'classifieds.id', '=', 'business_listing_users.profession')
            ->where('business_listing_users.profession', '=', $service_id)
            ->where('business_listing_users.status', '=', '1')
            ->where('business_listing_users.business_listing_type', '=', 2)
            ->get();
        return view('service_users.classifieds_fullview', compact('service_users'));
    }


    public function store_fullview($store_id)
    {
        $store_id = $store_id;
        // return $store_id;
        $service_users = DB::table('business_listing_users')
            ->select('*')
            ->join('stores', 'business_listing_users.profession', '=', 'stores.StoreID')
            ->where('business_listing_users.status', '=', '1')
            ->where('business_listing_users.profession', '=', $store_id)
            ->where('business_listing_users.business_listing_type', '=', 1)
            ->get();
        // return $service_users;
        return view('service_users.stores_fullview', compact('service_users'));
    }

    public function top_category_products_list($category_id)
    {
        $service_user_id_for_cart = Session::get('service_user_id');
        $products = Products::where('category_id', $category_id)->get();
        $items_found = count($products);
        $cart_products = DB::table('cart_products')
            ->select('*')
            ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id_for_cart)
            ->get();
        $cart_count = count($cart_products);
        return view('service_users.top_category_products', compact('products', 'items_found', 'cart_products', 'cart_count'));
    }

    public function popular_discounts_products()
    {
        $service_user_id_for_cart = Session::get('service_user_id');
        $products = Products::all();
        $cart_products = DB::table('cart_products')
            ->select('*')
            ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id_for_cart)
            ->get();
        $cart_count = count($cart_products);
        return view('service_users.popular_discount_products', compact('products', 'cart_products', 'cart_count'));
    }

    public function add_to_cart($product_id, $quantity)
    {
        $service_user_id = Session::get('service_user_id');

        $newProduct = Products::where('product_id', $product_id)->first();

        if (!$newProduct) {
            toastr()->error('Product not found');
            return redirect()->back();
        }

        $existing_cart_product = Cartproducts::where('product_id', $product_id)
            ->where('service_user_id', $service_user_id)
            ->first();

        if ($existing_cart_product) {
            toastr()->error('Product Already Added to Cart!');
            return redirect()->back();
        }

        $oldCartItem = Cartproducts::where('service_user_id', $service_user_id)->first();

        if ($oldCartItem) {
            $oldProduct = Products::where('product_id', $oldCartItem->product_id)->first();

            if ($oldProduct && $oldProduct->vendor_id != $newProduct->vendor_id) {
                Cartproducts::where('service_user_id', $service_user_id)->delete();
                toastr()->error('Old Vendor Cart Items are Removed');
            }
        }

        $cart = new Cartproducts;
        $existing_cart_product = Cartproducts::where('product_id', $product_id)
            ->where('service_user_id', $service_user_id)
            ->first();
        if ($existing_cart_product) {
            toastr()->error('Product Already Added to Cart!');
            return redirect()->back();
        }
        $cart->service_user_id = $service_user_id;
        $cart->product_id = $product_id;
        $cart->quantity = $quantity;
        $cart->save();
        toastr()->success('Product Added to Cart');
        return redirect()->back();
    }


    public function add_to_wishlist($product_id)
    {
        $service_user_id = Session::get('service_user_id');
        $product_id = $product_id;
        $wishlist = new Wishlist;
        $existing_cart_product = Wishlist::where('product_id', $product_id)
            ->where('service_user_id', $service_user_id)
            ->first();
        if ($existing_cart_product) {
            toastr()->error('Product Already In Wishlist!');
            return redirect('/products_list');
        }
        $wishlist->service_user_id = $service_user_id;
        $wishlist->product_id = $product_id;
        $wishlist->save();
        toastr()->success('Product Added To Wishlist');
        return redirect()->route('welcome_page');
    }


    public function vendors_full_view()
    {
        $vendor_banners = DB::table('vendor_banners')
            ->select('*')
            ->join('vendors', 'vendor_banners.vendor_id', '=', 'vendors.vendor_id')
            ->get();
        // return $vendor_banners;
        $service_user_id_for_cart = Session::get('service_user_id');
        $cart_products = DB::table('cart_products')
            ->select('*')
            ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id_for_cart)
            ->get();
        $cart_count = count($cart_products);
        return view('service_users.vendors_full_view', compact('vendor_banners', 'cart_products', 'cart_count'));
    }


    public function remove_item_cart($product_id)
    {
        $cart_item = Cartproducts::where('product_id', $product_id)->first();
        $cart_item->delete();
        session()->flash('success', 'Item Removed from Cart');
        // toastr()->success('Item Removed from Cart');
        return redirect('/welcome_page');
    }

    public function remove_item_wishlist($product_id)
    {
        $cart_item = Wishlist::where('product_id', $product_id)->first();
        $cart_item->delete();
        toastr()->success('Item Removed from Wishlist');
        return redirect('/welcome_page');
    }

    public function wishlist()
    {
        $service_user_id = session::get('service_user_id');
        $cart_products = DB::table('cart_products')
            ->select('*')
            ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id)
            ->get();
        $cart_count = count($cart_products);
        $wishlist_products = DB::table('wishlist_products')
            ->select('*')
            ->join('products_list', 'wishlist_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id)
            ->get();
        $wishlist_count = count($wishlist_products);
        $cart_count = count($cart_products);
        return view('service_users.wishlist', compact('cart_products', 'wishlist_products', 'wishlist_count', 'cart_count'));
    }

    public function business_service_listing(Request $req)
    {
        // return $req->input();
        $folderName = public_path('assets/business_listing_images/');
        if ($req->hasFile('service_image')) {
            $image = $req->file('service_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $imageName = 'assets/business_listing_images/' . $imageName;
        } else {
            $imageName = 'assets/images/img2.jpg';
        }
        $business_listing_users = new BusinessListing();
        $business_listing_users->member_name = $req->name;
        $business_listing_users->service_user_id = $req->service_user_id;
        $business_listing_users->member_phone = $req->mobile;
        $business_listing_users->business_image = $imageName;
        $business_listing_users->password = $req->password;
        $business_listing_users->pan_number = $req->pannumber;
        $business_listing_users->address = $req->address;
        $business_listing_users->state = $req->state;
        $business_listing_users->district = $req->district;
        $business_listing_users->pincode = $req->pincode;
        $business_listing_users->profession = $req->proffession;
        $business_listing_users->bank_name = $req->bankname;
        $business_listing_users->cumulative_gross = $req->cumulative_gross;
        $business_listing_users->commission_percentage = $req->commission_percentage;
        $business_listing_users->referral_id = $req->referral_id;
        $business_listing_users->referral_by = $req->referral_by;
        $business_listing_users->account_number = $req->accountnumber;
        $business_listing_users->business_listing_type = $req->business_type;
        $business_listing_users->save();
        toastr()->success('Business Listing Added!Wait For Admin Approval');
        return redirect('/welcome_page');
    }

    public function billing_details_form()
    {
        $totalPurchasePrice = 0;
        $user_id = Session::get('service_user_id');
        $bank_details = BankDetails::where('user_id', $user_id)->first();
        $cart_items = Cartproducts::where('service_user_id', $user_id)->count();
        $ordered_products = DB::table('products_list')
            ->select('products_list.product_id', 'products_list.product_name', 'products_list.purchase_price', 'products_list.unit_price', 'cart_products.quantity')
            ->join('cart_products', 'products_list.product_id', '=', 'cart_products.product_id')
            ->where('cart_products.service_user_id', '=', $user_id)
            ->get();
        foreach ($ordered_products as $product) {
            $totalPurchasePrice += $product->purchase_price * $product->quantity;
        }
        if ($totalPurchasePrice < 499) {
            toastr()->error('Minimum purchase amount is ₹500!');
            return redirect()->route('welcome_page');
        }
        if ($cart_items <= 0) {
            toastr()->error('No Products In Cart!');
            return redirect()->route('welcome_page');
        }
        $user_details = ServiceUser::where('service_id', $user_id)->first();
        // return $user_details;
        return view('service_users.billing_details', compact('user_details', 'bank_details'));
    }

    public function billing_details_form_submit(Request $req)
    {
        $user_id = session::get('service_user_id');
        $wallet_money = 0;
        $cart_items = Cartproducts::where('service_user_id', $user_id)->get();
        $product_id = $cart_items[0]->product_id;
        $product_details = Products::where('product_id', $product_id)->get();
        $products_vendor_id = $product_details[0]->vendor_id;
        $backtwoback_income = BacktwoBackWallet::where('user_id', $user_id)->first();
        //Addupto wallet balance Start
        $user_commission = CommissionWallet::where('user_id', $user_id)
            ->selectRaw('SUM(balance) as total_balance')
            ->first();
        $pool_comission_wallet = PoolCommissionWallet::where('user_id', $user_id)
            ->selectRaw('SUM(balance) as pool_balance')
            ->first();
        $pool_comission_amount = $pool_comission_wallet->pool_balance ?? 0;
        $my_commission = $user_commission->total_balance + $pool_comission_amount;
        //Addupto wallet balance End

        // return $backtwoback_income->balance;
        if ($backtwoback_income) {
            $wallet_money = $backtwoback_income->balance + $my_commission;
        } else {
            $wallet_money = $my_commission;
        }

        $bank_details = BankDetails::where('user_id', $user_id)->get();
        if ($bank_details->isEmpty()) {
            $bank_details = new BankDetails();
            $bank_details->user_id = $user_id;
            $bank_details->pancard_number = $req->pan_number;
            $bank_details->user_name = $req->account_holder_name;
            $bank_details->bank_name = $req->bank_name;
            $bank_details->account_number = $req->account_number;
            $bank_details->ifsc = $req->ifsc;
            $bank_details->save();
        }
        $unique_id = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

        $ordered_products = DB::table('products_list')
            ->select('products_list.product_id', 'products_list.product_name', 'products_list.purchase_price', 'products_list.unit_price', 'cart_products.quantity')
            ->join('cart_products', 'products_list.product_id', '=', 'cart_products.product_id')
            ->where('cart_products.service_user_id', '=', $user_id)
            ->get();
        $totalPurchasePrice = 0;
        $totalUnitPrice = 0;
        // return $ordered_products;
        foreach ($ordered_products as $product) {
            $totalPurchasePrice += $product->purchase_price * $product->quantity;
        }

        foreach ($ordered_products as $product) {
            $totalUnitPrice += $product->unit_price * $product->quantity;
        }
        if ($totalPurchasePrice < 3000) {
            // $deliveryCharges=round(($totalPurchasePrice*18)/100);
            $deliveryCharges = 100;
        } else {
            $deliveryCharges = 100;
        }
        $totalDiscount = $totalUnitPrice - $totalPurchasePrice;
        // $deliveryCharges=100;
        $totalAmount = $deliveryCharges + $totalPurchasePrice;
        // return $totalPurchasePrice;
        // return $totalUnitPrice;
        $customered_ordered_details = new CustomerOrderedProducts();
        $customered_ordered_details->user_id = $user_id;
        $customered_ordered_details->first_name = $req->first_name;
        $customered_ordered_details->location = $req->location;
        $customered_ordered_details->email = $req->email;
        $customered_ordered_details->mobile_no = $req->mobile_no;
        $customered_ordered_details->address = $req->address;
        $customered_ordered_details->zip_code = $req->zip_code;
        $customered_ordered_details->city = $req->city_name;
        $customered_ordered_details->state = $req->country_name;
        $customered_ordered_details->total_amount = $totalAmount;
        $customered_ordered_details->oredered_products = $ordered_products;
        $customered_ordered_details->unique_id = $unique_id;
        $customered_ordered_details->save();
        // toastr()->success('Product Ordered Successfully!');
        return view('service_users.ordered_summary', compact('ordered_products', 'products_vendor_id', 'wallet_money', 'unique_id', 'totalUnitPrice', 'totalPurchasePrice', 'totalDiscount', 'deliveryCharges', 'totalAmount'));
    }

    public function latest_products_view()
    {
        $service_user_id_for_cart = Session::get('service_user_id');
        $cart_products = DB::table('cart_products')
            ->select('*')
            ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
            ->where('service_user_id', '=', $service_user_id_for_cart)
            ->get();
        $products = Products::all();
        // return $products;
        $cart_count = count($cart_products);
        $products_based_on_category = Products::latest()->take(10)->get();
        return view('service_users.products_grid_view', compact('products_based_on_category', 'cart_products', 'cart_count'));
    }

    public function ordered_cofirmation_status(Request $req)
    {
        // return $req->input();
        $user_id = session::get('service_user_id');
        $total_amount = $req->total_amount - 100;
        $user_detail = ServiceUser::where('service_id', $user_id)->first();
        $user_commission_percentage_level = $user_detail['commission_percentage'];
        $old_orders_count = CustomerOrderedProducts::where('user_id', $user_id)
            ->where('confirmation_status', 1)->count();
        if (!$user_detail) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user_detail->cumulative_gross += $total_amount;
        $user_detail->save();
        if ($user_detail->cumulative_gross > 7999 && $user_detail->cumulative_gross < 20001) {
            $user_detail->commission_percentage = 10;
        } elseif ($user_detail->cumulative_gross > 20000 && $user_detail->cumulative_gross < 40001) {
            $user_detail->commission_percentage = 12;
        } elseif ($user_detail->cumulative_gross > 40000 && $user_detail->cumulative_gross < 120001) {
            $user_detail->commission_percentage = 14;
        } elseif ($user_detail->cumulative_gross > 120000 && $user_detail->cumulative_gross < 200001) {
            $user_detail->commission_percentage = 16;
        } elseif ($user_detail->cumulative_gross > 200000 && $user_detail->cumulative_gross < 400001) {
            $user_detail->commission_percentage = 18;
        } elseif ($user_detail->cumulative_gross > 400000) {
            $user_detail->commission_percentage = 20;
        } else {
            $user_detail->commission_percentage = 8;
        }
        $user_detail->save();
        $referral_by = $user_detail->referral_by;
        if ($referral_by === 'admin') {
            $admin = ServiceUser::where('referral_id', 'admin')->first();
            if ($admin) {
                $admin->cumulative_gross += $total_amount;
                $admin->save();
            }
        }
        $referred_user = ServiceUser::where('referral_id', $referral_by)->first();
        while ($referred_user && $referred_user->member_name !== 'Admin') {
            $referred_user->cumulative_gross += $total_amount;
            $referred_user->save();
            if ($referred_user->cumulative_gross > 7999 && $referred_user->cumulative_gross < 20001) {
                $referred_user->commission_percentage = 10;
            } elseif ($referred_user->cumulative_gross > 20000 && $referred_user->cumulative_gross < 40001) {
                $referred_user->commission_percentage = 12;
            } elseif ($referred_user->cumulative_gross > 40000 && $referred_user->cumulative_gross < 120001) {
                $referred_user->commission_percentage = 14;
            } elseif ($referred_user->cumulative_gross > 120000 && $referred_user->cumulative_gross < 200001) {
                $referred_user->commission_percentage = 16;
            } elseif ($referred_user->cumulative_gross > 200000 && $referred_user->cumulative_gross < 400001) {
                $referred_user->commission_percentage = 18;
            } elseif ($referred_user->cumulative_gross > 400000) {
                $referred_user->commission_percentage = 20;
            } else {
                $referred_user->commission_percentage = 8;
            }
            $referred_user->save();
            $referred_user = ServiceUser::where('referral_id', $referred_user->referral_by)->first();
        }
        if ($referred_user && $referred_user->member_name === 'Admin') {
            $admin = ServiceUser::where('referral_id', 'admin')->first();
            if ($admin) {
                $admin->cumulative_gross += $total_amount;
                $admin->save();
            }
        }
        if (isset($req->razorpay_payment_id) && $req->razorpay_payment_id != '') {
            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );
            $payment = $api->payment->fetch($req->razorpay_payment_id);
            $response = $payment->capture(array('amount' => $payment->amount));
            $user_id = Session::get('service_user_id');
            $product_vendor = Vendor::find($req->vendor_id);
            $admin_percentage = ($total_amount * $product_vendor->commission_percentage) / 100;
            $admin_percentage_gained = ($total_amount * 40) / 100;
            $admin_percentage_split = $admin_percentage_gained / 40;
            $company_percentage = $admin_percentage - $admin_percentage_split;
            $back_two_bacK_percentage = $admin_percentage_split * 15;
            $customer_referal_percentage = $admin_percentage_split * 20;
            // return "Back_tobackper-".$back_two_bacK_percentage."-"."Customer_referal".$customer_referal_percentage;
            if ($old_orders_count > 0) {
                $self_purchase_income = $admin_percentage_split * $user_commission_percentage_level;
            } else {
                $self_purchase_income = 0;
            }

            //Self Purchase Income Start
            $self_purchase_user = CommissionWallet::where('user_id', $user_id)->first();
            if ($self_purchase_user) {
                $self_purchase_user->purchase_income += $self_purchase_income;
                $self_purchase_user->save();
            } else {
                $self_purchase_user_wallet = new CommissionWallet();
                $self_purchase_user_wallet->user_id = $user_id;
                $self_purchase_user_wallet->purchase_income = $self_purchase_income;
                $self_purchase_user_wallet->save();
            }

            //Self Purchase Income End

            $monthly_pool_percentage = $admin_percentage_split * 2;
            $charity_percentage = 0;
            $company_percentage = $company_percentage + ($admin_percentage_split * 4);
            $product_vendor_comission_percentage = $admin_percentage_split - $admin_percentage;
            $product_vendor->vendor_wallet = $product_vendor->vendor_wallet + $product_vendor_comission_percentage;
            $product_vendor->save();
            $admin_wallet = new AdminWallet();
            $admin_wallet->back_two_back = $back_two_bacK_percentage;
            $admin_wallet->charity = $charity_percentage;
            $admin_wallet->monthly_pool = $monthly_pool_percentage;
            $admin_wallet->company = $company_percentage;
            $admin_wallet->save();
            $unique_id = $req->unique_id;
            $total_amount = $customer_referal_percentage;
            $percentage_completed = 8;
            $comparission_percentage = 8;
            $commission_amount = 0;
            $each_part_amount = $customer_referal_percentage / 20;
            $user_detail = ServiceUser::where('service_id', $user_id)->get();
            $referral_by = $user_detail[0]->referral_by;
            $admin_id = ServiceUser::where('referral_id', 'admin')->get();
            if ($referral_by === 'admin') {
                $commission_user_wallet = new CommissionWallet();
                $commission_user_wallet->user_id = $admin_id[0]->service_id;
                $commission_user_wallet->balance = $total_amount;
                $commission_user_wallet->save();
                $total_amount = 0;
                $user_id = session::get('service_user_id');
                $active_user = ActiveUser::where('user_id', $user_id)->get();
                if ($active_user->isEmpty()) {
                    $service_user = ServiceUser::where('service_id', $user_id)->get();
                    $new_active_user = new ActiveUser();
                    $new_active_user->user_id = $user_id;
                    $new_active_user->user_name = $service_user[0]->member_name;
                    $new_active_user->save();
                }
                $delete_all_cart_items = DB::delete('DELETE FROM cart_products WHERE service_user_id = ?', [$user_id]);
                $confirmation_status_change = DB::update('UPDATE customer_ordered_products SET confirmation_status = 1 WHERE unique_id = ?', [$unique_id]);
                toastr()->success('Ordered Placed!');
                return $this->wallet_amount_subtract($req);
            }
            $referred_user = ServiceUser::where('referral_id', $referral_by)->get();
            $commission_user = CommissionWallet::where('user_id', $referred_user[0]->service_id)->first();
            if ($commission_user) {
                // return "referral_by-"."-".$referral_by."-commission_percentage-"."-".$referred_user[0]->commission_percentage."-eachpart_amount-"."-".$each_part_amount;
                $commission_user->balance += $referred_user[0]->commission_percentage * $each_part_amount;
                $commission_user->save();
            } else {
                $commission_user_wallet = new CommissionWallet();
                $commission_user_wallet->user_id = $referred_user[0]->service_id;
                $commission_user_wallet->balance = $referred_user[0]->commission_percentage * $each_part_amount;
                $commission_user_wallet->save();
            }

            $comparission_percentage = $referred_user[0]->commission_percentage;
            $total_amount = $total_amount - $referred_user[0]->commission_percentage * $each_part_amount;
            while ($total_amount > 0) {
                $referred_user = ServiceUser::where('referral_id', $referred_user[0]->referral_by)->get();
                if ($referred_user[0]->referral_by === 'admin') {
                    $commission_user_wallet = new CommissionWallet();
                    $commission_user_wallet->user_id = $admin_id[0]->service_id;
                    $commission_user_wallet->balance = $total_amount;
                    $commission_user_wallet->save();
                    $total_amount = 0;
                    $user_id = session::get('service_user_id');
                    $active_user = ActiveUser::where('user_id', $user_id)->get();
                    if ($active_user->isEmpty()) {
                        $service_user = ServiceUser::where('service_id', $user_id)->get();
                        $new_active_user = new ActiveUser();
                        $new_active_user->user_id = $user_id;
                        $new_active_user->user_name = $service_user[0]->member_name;
                        $new_active_user->save();
                    }
                    $delete_all_cart_items = DB::delete('DELETE FROM cart_products WHERE service_user_id = ?', [$user_id]);
                    $confirmation_status_change = DB::update('UPDATE customer_ordered_products SET confirmation_status = 1 WHERE unique_id = ?', [$unique_id]);
                    toastr()->success('Ordered Placed!');
                    return $this->wallet_amount_subtract($req);
                }
                while ($referred_user[0]->commission_percentage <= $comparission_percentage) {
                    $referred_user = ServiceUser::where('referral_id', $referred_user[0]->referral_by)->get();
                }
                $commission_percentage = $referred_user[0]->commission_percentage - $comparission_percentage;
                $comparission_percentage = $comparission_percentage + $commission_percentage;
                $comparission_percentage = $referred_user[0]->commission_percentage;
                $commission_amount = $commission_percentage * $each_part_amount;
                if ($commission_amount > $total_amount) {
                    $commission_amount = $total_amount;
                }
                $commission_user = CommissionWallet::where('user_id', $referred_user[0]->service_id)->first();
                if ($commission_user) {
                    $commission_user->balance += $commission_amount;
                    $commission_user->save();
                } else {
                    $commission_user_wallet = new CommissionWallet();
                    $commission_user_wallet->user_id = $referred_user[0]->service_id;
                    $commission_user_wallet->balance = $commission_amount;
                    $commission_user_wallet->save();
                }
                $total_amount = $total_amount - $commission_amount;
            }
            // add return
            $user_id = session::get('service_user_id');
            $active_user = ActiveUser::where('user_id', $user_id)->get();
            if ($active_user->isEmpty()) {
                $service_user = ServiceUser::where('service_id', $user_id)->get();
                $new_active_user = new ActiveUser();
                $new_active_user->user_id = $user_id;
                $new_active_user->user_name = $service_user[0]->member_name;
                $new_active_user->save();
            }
            $delete_all_cart_items = DB::delete('DELETE FROM cart_products WHERE service_user_id = ?', [$user_id]);
            $confirmation_status_change = DB::update('UPDATE customer_ordered_products SET confirmation_status = 1 WHERE unique_id = ?', [$unique_id]);
        }
        return $this->wallet_amount_subtract($req);
    }

    public function wallet_amount_subtract(Request $req)
    {
        $user_id = session::get('service_user_id');


        // Back2Back Amount limit Adding Start
        $total_amount = $req->total_amount - 100;
        if ($total_amount > 2999) {
            $user_data = ServiceUser::where('service_id', $user_id)->first();
            $user_data->back_two_back_balance += $total_amount;
            $user_data->save();
        }
        // Back2Back Amount limit Adding End

        if ($req->wallet_amount != null) {
            // Start --Removing Withdraw Amount From Wallets
            $withdrawal_amount = $req->wallet_amount;
            $user_backtwo_back_amount = BacktwoBackWallet::where('user_id', $user_id)->first();
            $user_commission_amount = CommissionWallet::where('user_id', $user_id)->first();
            $pool_comission_wallet = PoolCommissionWallet::where('user_id', $user_id)->first();
            if ($user_commission_amount && $user_commission_amount['balance'] > 0) {
                if ($user_commission_amount['balance'] < $withdrawal_amount) {
                    $withdrawal_amount = $withdrawal_amount - $user_commission_amount['balance'];
                    $user_commission_amount['balance'] = 0;
                    $user_commission_amount->save();
                } else {
                    $user_commission_amount['balance'] -= $withdrawal_amount;
                    $user_commission_amount->save();
                    toastr()->success('Ordered Placed!');
                    return redirect()->route('welcome_page');
                }
            }
            if ($user_commission_amount && $user_commission_amount['purchase_income'] > 0) {
                if ($user_commission_amount['purchase_income'] < $withdrawal_amount) {
                    $withdrawal_amount = $withdrawal_amount - $user_commission_amount['purchase_income'];
                    $user_commission_amount['purchase_income'] = 0;
                    $user_commission_amount->save();
                } else {
                    $user_commission_amount['purchase_income'] -= $withdrawal_amount;
                    $user_commission_amount->save();
                    toastr()->success('Withdrawal Request Sent!');
                    return redirect()->route('welcome_page');
                }
            }
            if ($pool_comission_wallet && $pool_comission_wallet['balance'] > 0) {
                if ($pool_comission_wallet['balance'] < $withdrawal_amount) {
                    $withdrawal_amount = $withdrawal_amount - $pool_comission_wallet['balance'];
                    $pool_comission_wallet['balance'] = 0;
                    $pool_comission_wallet->save();
                } else {
                    $remaining_amount = $pool_comission_wallet['balance'] - $withdrawal_amount;
                    $pool_comission_wallet['balance'] -= $remaining_amount;
                    $pool_comission_wallet->save();
                    toastr()->success('Withdrawal Request Sent!');
                    return redirect()->route('welcome_page');
                }
            }
            if ($user_backtwo_back_amount && $user_backtwo_back_amount['balance'] > 0) {
                if ($user_backtwo_back_amount['balance'] < $withdrawal_amount) {
                    $withdrawal_amount = $withdrawal_amount - $user_backtwo_back_amount['balance'];
                    $user_backtwo_back_amount['balance'] = 0;
                    $user_backtwo_back_amount->save();
                } else {
                    $user_backtwo_back_amount['balance'] -= $withdrawal_amount;
                    $user_backtwo_back_amount->save();
                    toastr()->success('Ordered Placed!');
                    return redirect()->route('welcome_page');
                }
            }
            // End --Removing Withdraw Amount From Wallets
        }
        return redirect('/welcome_page');
    }


    public function order_summary_details($ordered_products)
    {
        $data = session('data');
        return $data;
        return view('service_users.ordered_summary');
    }

    public function landing_page()
    {
        return view('service_users.login');
    }


    public function landing_page_submit(Request $req)
    {
        $user = ServiceUser::where('member_phone', $req->mobile_no)->first();
        $data = false;
        if ($user) {
            $data = password_verify($req->password, $user->password);
        }
        if ($user and $data) {
            $req->session()->put('service_user_name', $user->member_name);
            $req->session()->put('service_user_id', $user->service_id);
            toastr()->success('User Login Success!');
            return redirect()->route('welcome_page');
        }
        toastr()->error('User Login Failed!');
        return redirect()->route('landingpage');
    }

    public function user_dashboard()
    {
        $user_id = Session::get('service_user_id');
        $user_details = ServiceUser::where('service_id', $user_id)->first();
        $discount_vendor_count = DiscountVendor::where('member_phone', $user_details['member_phone'])->count();
        $backtwoback_income = BacktwoBackWallet::where('user_id', $user_id)->get();
        $back_two_back_value = ServiceUser::where('service_id', $user_id)->get();
        $back_two_back_balance_value = $back_two_back_value[0]->back_two_back_balance;
        $user_commission = CommissionWallet::where('user_id', $user_id)
            ->selectRaw('SUM(balance) as total_balance')
            ->selectRaw('SUM(purchase_income) as purchase_income')
            ->first();
        $pool_comission_wallet = PoolCommissionWallet::where('user_id', $user_id)
            ->selectRaw('SUM(balance) as pool_balance')
            ->first();
        $pool_comission_amount = $pool_comission_wallet->pool_balance ?? 0;
        $my_commission = $user_commission->total_balance + $user_commission->purchase_income;
        // return $user_commission;
        $user_details = ServiceUser::where('service_id', $user_id)->get();
        if ($backtwoback_income->isEmpty()) {
            $cummulative_value = $my_commission + $pool_comission_amount;
        } else {
            $cummulative_value = $backtwoback_income[0]->balance + $my_commission + $pool_comission_amount;
        }

        return view('service_users.user_dashboard', compact('my_commission', 'user_commission', 'discount_vendor_count', 'user_details', 'back_two_back_balance_value', 'backtwoback_income', 'cummulative_value'));
    }

    public function generate_coupon()
    {
        $user_id = session::get('service_user_id');
        $pin_user = PinSystem::where('user_id', $user_id)->first();
        $user_generated_coupons = UserCouponCode::all();
        if (!$pin_user) {
            toastr()->error('Coupon System Not Yet Activated!');
            return redirect()->route('user_dashboard');
        }
        return view('service_users.generate_coupon', compact('pin_user', 'user_generated_coupons'));
    }

    public function validateCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');

        // Validate the coupon code
        $isValid = UserCouponCode::where('coupon_code', $couponCode)->where('status', 'Active')->exists();

        if ($isValid) {
            return response()->json(['valid' => true]);
        } else {
            return response()->json(['valid' => false]);
        }
    }

    public function new_generate_coupon(Request $req)
    {
        $user_id = session::get('service_user_id');
        $user_pins = PinSystem::where('user_id', $user_id)->first();
        if ($user_pins['total_pins'] < 1050) {
            toastr()->error('Coupon Points Are Not Enough!');
            return redirect()->route('generate_coupon');
        }
        $coupon_existence_count = UserCouponCode::where('coupon_code', $req->coupon_code)->count();
        if ($coupon_existence_count > 0) {
            toastr()->error('Coupon Already Exist!Try New');
            return redirect()->route('generate_coupon');
        }
        $user_coupons = new UserCouponCode();
        $user_coupons->user_id = $user_id;
        $user_coupons->coupon_code = $req->coupon_code;
        $user_coupons->save();
        $user_pins['total_pins'] -= 1050;
        $user_pins->save();
        toastr()->success('Coupon Generated!');
        return redirect()->route('generate_coupon');
    }

    public function withdraw_amount()
    {
        $user_id = Session::get('service_user_id');

        $backtwoback_income = BacktwoBackWallet::where('user_id', $user_id)->get();
        $back_two_back_value = ServiceUser::where('service_id', $user_id)->get();
        $back_two_back_balance_value = $back_two_back_value[0]->back_two_back_balance ?? 0;

        $user_commission = CommissionWallet::where('user_id', $user_id)
            ->selectRaw('SUM(balance) as total_balance, SUM(purchase_income) as purchase_income')
            ->first();

        $pool_comission_wallet = PoolCommissionWallet::where('user_id', $user_id)
            ->selectRaw('SUM(balance) as pool_balance')
            ->first();

        $pool_comission_amount = $pool_comission_wallet->pool_balance ?? 0;
        $my_commission = ($user_commission->total_balance ?? 0) + ($user_commission->purchase_income ?? 0);

        if ($backtwoback_income->isEmpty()) {
            $withdraw_amount = $my_commission + $pool_comission_amount;
        } else {
            $withdraw_amount = $backtwoback_income[0]->balance + $my_commission + $pool_comission_amount;
        }

        $bank_details = BankDetails::where('user_id', $user_id)->first();

        return view('service_users.withdraw_amount', compact('withdraw_amount', 'bank_details'));
    }


    public function storeWithdrawRequest(Request $request)
    {
        $request->validate([
            'bankname' => 'required|string|max:255',
            'accountnumber' => 'required|string|max:255',
            'ifsc' => 'required|string|max:20',
        ]);

        $user_id = Session::get('service_user_id');

        // 💾 Save or update bank details
        BankDetails::updateOrCreate(
            ['user_id' => $user_id],
            [
                'bank_name' => $request->bankname,
                'account_number' => $request->accountnumber,
                'ifsc' => $request->ifsc
            ]
        );

        // 📝 Optionally store withdrawal request to a withdrawal_requests table
        // Example (optional):
        // WithdrawalRequest::create([
        //     'user_id' => $user_id,
        //     'amount' => $request->withdraw_amount,
        //     'status' => 'pending'
        // ]);

        return redirect()->back()->with('success', 'Withdrawal request submitted successfully. Bank details saved.');
    }

    public function vendor_withdrawal_request(Request $request)
    {
        $user_id = Session::get('service_user_id');
        $user_bank_details = BankDetails::where('user_id', $user_id)->count();
        if ($user_bank_details == 0) {
            toastr()->error('Update Bank Details In Profile!');
            return redirect()->route('account_profile');
        }
        $user_detail = ServiceUser::where('service_id', $user_id)->first();
        //Decresing Account From Vendor Wallet Start
        $vendor_detail = DiscountVendor::where('member_phone', $user_detail['member_phone'])->first();
        // return $vendor_detail;
        $old_withdraw_request = VendorWithdrawRequest::where('vendor_id', $vendor_detail['vendor_id'])
            ->orderByDesc('created_at')
            ->first();
        if ($old_withdraw_request['status'] == 'pending') {
            toastr()->error('Wait Untill Previous Withdrawal Request Settlement!');
            return redirect('welcome_page');
        }

        $vendor_detail['withdrawal_amount'] -= $request->withdraw_amount;
        $vendor_detail->save();

        //Decresing Account From Vendor Wallet End
        $new_vendor_withdraw_request = new VendorWithdrawRequest();
        $new_vendor_withdraw_request->vendor_id = $vendor_detail['vendor_id'];
        $new_vendor_withdraw_request->user_id = $user_id;
        $new_vendor_withdraw_request->vendor_name = $vendor_detail['member_name'];
        $new_vendor_withdraw_request->mobile_number = $vendor_detail['member_phone'];
        $new_vendor_withdraw_request->withdraw_amount = $request->withdraw_amount;
        $new_vendor_withdraw_request->status = 'pending';
        $new_vendor_withdraw_request->save();
        toastr()->success('Withdrawal Request Sent!');
        return redirect('welcome_page');
    }

    public function vendor_withdraw_amount()
    {
        $user_id = Session::get('service_user_id');
        $user_details = ServiceUser::where('service_id', $user_id)->first();
        $vendor_details = DiscountVendor::where('member_phone', $user_details['member_phone'])->first();
        $vendor_sellings = DiscountStorePurchases::where('vendor_id', $vendor_details['vendor_id'])
            ->sum('purchase_amount');
        // return $vendor_details['withdrawal_amount'];
        $withdraw_amount = $vendor_details['withdrawal_amount'];
        return view('service_users.vendor_withdraw_amount', compact('withdraw_amount'));
    }

    public function user_withdraw_request(Request $request)
    {
        $user_id = session::get('service_user_id');
        $user_bank_details = BankDetails::where('user_id', $user_id)->count();
        if ($user_bank_details > 0) {
            $withdrawalrequests = new WithdrawalRequest();
            $withdrawalrequests->UserID = $user_id;
            $withdrawalrequests->Amount = $request->withdraw_amount;
            $withdrawalrequests->RequestDate = now();
            $withdrawalrequests->Status = 'Pending';
            $withdrawalrequests->save();
            // Start --Removing Withdraw Amount From Wallets
            $withdrawal_amount = $request->withdraw_amount;
            $user_backtwo_back_amount = BacktwoBackWallet::where('user_id', $user_id)->first();
            $user_commission_amount = CommissionWallet::where('user_id', $user_id)->first();
            $pool_comission_wallet = PoolCommissionWallet::where('user_id', $user_id)->first();
            if ($user_backtwo_back_amount && $user_backtwo_back_amount['balance'] > 0) {
                if ($user_backtwo_back_amount['balance'] < $withdrawal_amount) {
                    $withdrawal_amount = $withdrawal_amount - $user_backtwo_back_amount['balance'];
                    $user_backtwo_back_amount['balance'] = 0;
                    $user_backtwo_back_amount->save();
                } else {
                    $user_backtwo_back_amount['balance'] -= $withdrawal_amount;
                    $user_backtwo_back_amount->save();
                    toastr()->success('Withdrawal Request Sent!');
                    return redirect()->route('welcome_page');
                }
            }
            if ($user_commission_amount && $user_commission_amount['balance'] > 0) {
                if ($user_commission_amount['balance'] < $withdrawal_amount) {
                    $withdrawal_amount = $withdrawal_amount - $user_commission_amount['balance'];
                    $user_commission_amount['balance'] = 0;
                    $user_commission_amount->save();
                } else {
                    $user_commission_amount['balance'] -= $withdrawal_amount;
                    $user_commission_amount->save();
                    toastr()->success('Withdrawal Request Sent!');
                    return redirect()->route('welcome_page');
                }
            }
            if ($user_commission_amount && $user_commission_amount['purchase_income'] > 0) {
                if ($user_commission_amount['purchase_income'] < $withdrawal_amount) {
                    $withdrawal_amount = $withdrawal_amount - $user_commission_amount['purchase_income'];
                    $user_commission_amount['purchase_income'] = 0;
                    $user_commission_amount->save();
                } else {
                    $user_commission_amount['purchase_income'] -= $withdrawal_amount;
                    $user_commission_amount->save();
                    toastr()->success('Withdrawal Request Sent!');
                    return redirect()->route('welcome_page');
                }
            }
            if ($pool_comission_wallet && $pool_comission_wallet['balance'] > 0) {
                if ($pool_comission_wallet['balance'] < $withdrawal_amount) {
                    $withdrawal_amount = $withdrawal_amount - $pool_comission_wallet['balance'];
                    $pool_comission_wallet['balance'] = 0;
                    $pool_comission_wallet->save();
                } else {
                    $remaining_amount = $pool_comission_wallet['balance'] - $withdrawal_amount;
                    $pool_comission_wallet['balance'] -= $remaining_amount;
                    $pool_comission_wallet->save();
                    toastr()->success('Withdrawal Request Sent!');
                    return redirect()->route('welcome_page');
                }
            }
            toastr()->success('Withdrawal Request Sent!');
            return redirect()->route('welcome_page');
            // End --Removing Withdraw Amount From Wallets
            // DB::update('UPDATE commission_wallet SET balance = balance - ? WHERE user_id = ?', [$request->withdraw_amount, $user_id]);
            // toastr()->success('Withdrawal Request Sent!');
            // return redirect()->route('welcome_page');
        } else {
            toastr()->error('Update Bank Details In Profile!');
            return redirect()->route('account_profile');
        }
    }

    public function my_commission()
    {
        $user_id = Session::get('service_user_id');
        // return $user_id;
        $user_commission = CommissionWallet::where('user_id', $user_id)
            ->selectRaw('SUM(balance) as total_balance')
            ->selectRaw('SUM(purchase_income) as purchase_income')
            ->first();
        $pool_comission_amount = PoolCommissionWallet::where('user_id', $user_id)->first();
        $product_comission_amount = ProductWallet::where('user_id', $user_id)->first();
        // return $user_commission['total_balance'];
        return view('service_users.my_commission', compact('user_commission', 'pool_comission_amount', 'product_comission_amount'));
    }

    public function id_activation()
    {
        return view('service_users.id_activation');
    }

    public function account_orders()
    {
        $service_user_id = session::get('service_user_id');
        $customer_ordered_products = CustomerOrderedProducts::where('user_id', $service_user_id)->get();
        // return $customer_ordered_products;
        return view('service_users.account_orders', compact('customer_ordered_products'));
    }

    public function account_profile()
    {
        $service_user_id = session::get('service_user_id');
        $user_info = ServiceUser::where('service_id', $service_user_id)->get();
        $user_bank_details = BankDetails::where('user_id', $service_user_id)->get();
        // if($user_bank_details->isEmpty()){
        //     return "Empty";
        // }else{
        //     return "NOT Empty";
        // };
        return view('service_users.account_profile', compact('user_info', 'user_bank_details'));
    }

    public function edit_user_profile()
    {
        $service_user_id = session::get('service_user_id');
        $user_info = ServiceUser::where('service_id', $service_user_id)->get();
        // return $user_info;
        $user_bank_details = BankDetails::where('user_id', $service_user_id)->get();
        return view('service_users.edit_account_profile', compact('user_info', 'user_bank_details'));
    }

    public function edit_user_profile_submit(Request $req)
    {
        // return $req->input();
        $update_user_details = ServiceUser::find($req->user_id);
        $update_user_details->member_name = $req->name;
        $update_user_details->location = $req->location;
        $update_user_details->address = $req->address;
        $update_user_details->password = Hash::make($req->password);
        $update_user_details->open_password = $req->password;
        $update_user_details->city = $req->city;
        $update_user_details->pincode = $req->pincode;
        $update_user_details->state = $req->state;
        // start updating profile
        $folderName = public_path('assets/user_assets/images/');
        if ($req->hasFile('category_image')) {
            $image = $req->file('category_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalName();
            $image->move($folderName, $imageName);
            $update_user_details->user_profile_pic = 'assets/user_assets/images/' . $imageName;
        }
        // end updating profile
        $update_user_details->save();
        if ($req->bank_new_enter == '1') {
            $user_bank_details = new BankDetails;
            $user_bank_details->user_id = $req->user_id;
            $user_bank_details->user_name = $req->name;
            $user_bank_details->pancard_number = $req->pan_number;
            $user_bank_details->bank_name = $req->bank_name;
            $user_bank_details->account_number = $req->account_num;
            $user_bank_details->ifsc = $req->ifsc;
            $user_bank_details->save();
        }
        return redirect()->route('account_profile');
    }

    // public function team_details(){
    //     $login_user_id=Session::get('service_user_id');
    //     $login_user=ServiceUser::where('service_id',$login_user_id)->first();
    //     // return $login_user;
    //     $referal_id=$login_user['referral_id'];
    //     $referred_users=ServiceUser::where('referral_by',$referal_id)->get();
    //     // return $referred_users;
    //     $count=0;
    //     $referred_users_count=$referred_users->count();
    //     // return $referred_users_count;
    //     $referral_ids_array = [];
    //     if($referred_users_count>0){
    //         foreach($referred_users as $referred_user){
    //             $id= $referred_user->referral_id;
    //             $referral_ids_array[] = $id;
    //         }
    //         // return $referral_ids_array;
    //         // return ServiceUser::where('referral_by',$referred_users['referral_id'])->get();
    //     }
    //     return view('service_users.team_details',compact('referred_users'));
    // }

    public function team_details()
    {
        $login_user_id = Session::get('service_user_id');
        $login_user = ServiceUser::where('service_id', $login_user_id)->first();
        $referral_id = $login_user->referral_id;
        $referred_users_by_login_person = ServiceUser::where('referral_by', $referral_id)->get();
        // return $referred_users_by_login_person;
        $referral_ids_array = $this->getReferralUserIds($referral_id);

        $chain_users = []; // Initialize an empty array to store fetched users

        foreach ($referral_ids_array as $referral_ids) {
            $users = ServiceUser::where('referral_id', $referral_ids)->get();

            $chain_users = array_merge($chain_users, $users->toArray());
        }

        return view('service_users.team_details', compact('chain_users', 'referred_users_by_login_person'));;
    }


    protected function getReferralUserIds($referral_id)
    {
        $referral_ids_array = [];

        $referred_users = ServiceUser::where('referral_by', $referral_id)->get();

        if ($referred_users->isNotEmpty()) {
            foreach ($referred_users as $referred_user) {
                $referral_ids_array[] = $referred_user->referral_id;

                // Recursively fetch referral users of this referred user
                $nested_referral_ids = $this->getReferralUserIds($referred_user->referral_id);

                if (!empty($nested_referral_ids)) {
                    $referral_ids_array = array_merge($referral_ids_array, $nested_referral_ids);
                }
            }
        }

        return $referral_ids_array;
        // return $referred_users;
    }

    public function user_wallet()
    {
        $user_id = Session::get('service_user_id');
        $user_back_two_back_amount = BacktwoBackWallet::where('user_id', $user_id)->sum('balance');
        $user_commission_amount = CommissionWallet::where('user_id', $user_id)->sum('balance');
        $user_pool_commission_amount = PoolCommissionWallet::where('user_id', $user_id)->sum('balance');
        return view('service_users.user_wallet', compact('user_back_two_back_amount', 'user_commission_amount', 'user_pool_commission_amount'));
    }

    public function wallet_topup()
    {
        $user_id = Session::get('service_user_id');
        if (!$user_id) {
            return redirect()->route('service_user_login');
        }

        // Get service user and generate Sanctum token for API authentication
        $user = ServiceUser::find($user_id);
        if (!$user) {
            return redirect()->route('service_user_login');
        }

        // Generate a Sanctum token for API access
        $token = $user->createToken('wallet-topup')->plainTextToken;

        $min_topup = config('wallet.min_topup', 100);
        $max_topup = config('wallet.max_topup', 100000);
        return view('service_users.wallet_topup', compact('min_topup', 'max_topup', 'token'));
    }

    public function filter_products(Request $req)
    {
        return $req->input();
    }
}
