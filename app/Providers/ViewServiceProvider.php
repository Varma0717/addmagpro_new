<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Service\ServiceUser;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $serviceUserId = Session::get('service_user_id');
            if ($serviceUserId) {
                $serviceUsers = ServiceUser::where('service_id', $serviceUserId)->first();
                $view->with('service_users_detail_info', $serviceUsers);

                // Global cart & wishlist counts for header badge
                $cart_count = DB::table('cart_products')
                    ->where('service_user_id', $serviceUserId)
                    ->count();
                $wishlist_count = DB::table('wishlist_products')
                    ->where('service_user_id', $serviceUserId)
                    ->count();
                $view->with('cart_count', $cart_count);
                $view->with('wishlist_count', $wishlist_count);

                // Global cart items for header offcanvas sidebar
                $cart_header_items = DB::table('cart_products')
                    ->select(
                        'cart_products.*',
                        'products_list.product_name',
                        'products_list.product_images',
                        'products_list.unit_price'
                    )
                    ->join('products_list', 'cart_products.product_id', '=', 'products_list.product_id')
                    ->where('cart_products.service_user_id', $serviceUserId)
                    ->get();
                $view->with('cart_header_items', $cart_header_items);
            } else {
                $view->with('service_users_detail_info', null);
                $view->with('cart_count', 0);
                $view->with('wishlist_count', 0);
                $view->with('cart_header_items', collect());
            }
        });
    }
}
