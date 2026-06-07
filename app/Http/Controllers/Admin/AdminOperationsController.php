<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin_Panel\Service;
use App\Models\Admin_Panel\Store;
use App\Models\Product;
use App\Models\UserWalletTransaction;
use App\Models\Vendor;
use App\Models\Vendor_Panel\Brand;
use App\Models\Vendor_Panel\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminOperationsController extends Controller
{
    public function index(): View
    {
        $data = [
            'categoryCount' => Category::count(),
            'serviceCount' => Service::count(),
            'storeCount' => Store::count(),
            'vendorCount' => Vendor::count(),
            'productCount' => Product::count(),
            'pendingVendorCount' => Vendor::where('status', 'Pending')->count(),
            'pendingWithdrawCount' => $this->pendingWithdrawCount(),
        ];

        return view('admin_pages.operations.index', $data);
    }

    public function categories(): View
    {
        return view('admin_pages.operations.categories', [
            'categories' => Category::orderByDesc('id')->paginate(20),
        ]);
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:1000',
        ]);

        $category = new Category();
        $category->Vendor_id = 0;
        $category->CategoryName = $request->name;
        $category->ImageURL = $request->image_url;
        $category->save();

        toastr()->success('Category created successfully.');
        return redirect()->route('admin_ops_categories');
    }

    public function updateCategory(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:1000',
        ]);

        $category = Category::findOrFail($id);
        $category->CategoryName = $request->name;
        $category->ImageURL = $request->image_url;
        $category->save();

        toastr()->success('Category updated successfully.');
        return redirect()->route('admin_ops_categories');
    }

    public function deleteCategory(int $id): RedirectResponse
    {
        Category::where('id', $id)->delete();
        toastr()->success('Category deleted successfully.');
        return redirect()->route('admin_ops_categories');
    }

    public function services(): View
    {
        return view('admin_pages.operations.services', [
            'services' => Service::orderByDesc('service_id')->paginate(20),
        ]);
    }

    public function storeService(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:1000',
        ]);

        $service = new Service();
        $service->service_name = $request->name;
        $service->service_image = $request->image_url;
        $service->save();

        toastr()->success('Service created successfully.');
        return redirect()->route('admin_ops_services');
    }

    public function updateService(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:1000',
        ]);

        $service = Service::findOrFail($id);
        $service->service_name = $request->name;
        $service->service_image = $request->image_url;
        $service->save();

        toastr()->success('Service updated successfully.');
        return redirect()->route('admin_ops_services');
    }

    public function deleteService(int $id): RedirectResponse
    {
        Service::where('service_id', $id)->delete();
        toastr()->success('Service deleted successfully.');
        return redirect()->route('admin_ops_services');
    }

    public function stores(): View
    {
        return view('admin_pages.operations.stores', [
            'stores' => Store::orderByDesc('StoreID')->paginate(20),
        ]);
    }

    public function storeStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:1000',
        ]);

        $store = new Store();
        $store->StoreName = $request->name;
        $store->store_image = $request->image_url;
        $store->save();

        toastr()->success('Store created successfully.');
        return redirect()->route('admin_ops_stores');
    }

    public function updateStore(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:1000',
        ]);

        $store = Store::findOrFail($id);
        $store->StoreName = $request->name;
        $store->store_image = $request->image_url;
        $store->save();

        toastr()->success('Store updated successfully.');
        return redirect()->route('admin_ops_stores');
    }

    public function deleteStore(int $id): RedirectResponse
    {
        Store::where('StoreID', $id)->delete();
        toastr()->success('Store deleted successfully.');
        return redirect()->route('admin_ops_stores');
    }

    public function vendors(): View
    {
        return view('admin_pages.operations.vendors', [
            'vendors' => Vendor::orderByDesc('vendor_id')->paginate(20),
        ]);
    }

    public function storeVendor(Request $request): RedirectResponse
    {
        $rules = [
            'vendor_name' => 'required|string|max:255',
            'vendor_phone' => 'required|string|max:20',
            'vendor_email' => 'nullable|email|max:255',
            'business_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:100',
            'business_address' => 'nullable|string|max:1000',
            'status' => ['required', Rule::in(['Pending', 'Approved', 'Rejected'])],
        ];

        $request->validate($rules);

        $vendor = new Vendor();
        $vendor->vendor_name = $request->vendor_name;
        $vendor->vendor_phone = $request->vendor_phone;
        $vendor->vendor_email = $request->vendor_email;
        $vendor->business_name = $request->business_name;
        $vendor->business_type = $request->business_type;
        $vendor->business_address = $request->business_address;
        $vendor->status = $request->status;
        $vendor->save();

        toastr()->success('Vendor created successfully.');
        return redirect()->route('admin_ops_vendors');
    }

    public function updateVendor(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'vendor_name' => 'required|string|max:255',
            'vendor_phone' => 'required|string|max:20',
            'vendor_email' => 'nullable|email|max:255',
            'business_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:100',
            'business_address' => 'nullable|string|max:1000',
            'status' => ['required', Rule::in(['Pending', 'Approved', 'Rejected'])],
        ]);

        $vendor = Vendor::findOrFail($id);
        $vendor->vendor_name = $request->vendor_name;
        $vendor->vendor_phone = $request->vendor_phone;
        $vendor->vendor_email = $request->vendor_email;
        $vendor->business_name = $request->business_name;
        $vendor->business_type = $request->business_type;
        $vendor->business_address = $request->business_address;
        $vendor->status = $request->status;
        $vendor->save();

        toastr()->success('Vendor updated successfully.');
        return redirect()->route('admin_ops_vendors');
    }

    public function products(): View
    {
        return view('admin_pages.operations.products', [
            'products' => Product::orderByDesc('product_id')->paginate(20),
            'categories' => Category::orderBy('CategoryName')->get(),
            'vendors' => Vendor::orderBy('vendor_name')->get(),
            'brands' => Brand::orderBy('brand_name')->get(),
        ]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string|max:2000',
            'category_id' => 'required|integer',
            'vendor_id' => 'required|integer',
            'brand_id' => 'nullable|integer',
            'item_code' => 'nullable|string|max:120',
            'unit_price' => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'product_images' => 'nullable|string|max:1000',
        ]);

        $nextId = ((int) Product::max('product_id')) + 1;

        $product = new Product();
        $product->product_id = $nextId;
        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->category_id = $request->category_id;
        $product->vendor_id = $request->vendor_id;
        $product->brand_id = $request->brand_id;
        $product->item_code = $request->item_code;
        $product->unit_price = $request->unit_price;
        $product->purchase_price = $request->purchase_price ?? $request->unit_price;
        $product->product_images = $request->product_images;
        $product->save();

        toastr()->success('Product created successfully.');
        return redirect()->route('admin_ops_products');
    }

    public function updateProduct(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string|max:2000',
            'category_id' => 'required|integer',
            'vendor_id' => 'required|integer',
            'brand_id' => 'nullable|integer',
            'item_code' => 'nullable|string|max:120',
            'unit_price' => 'required|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'product_images' => 'nullable|string|max:1000',
        ]);

        $product = Product::where('product_id', $id)->firstOrFail();
        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->category_id = $request->category_id;
        $product->vendor_id = $request->vendor_id;
        $product->brand_id = $request->brand_id;
        $product->item_code = $request->item_code;
        $product->unit_price = $request->unit_price;
        $product->purchase_price = $request->purchase_price ?? $request->unit_price;
        $product->product_images = $request->product_images;
        $product->save();

        toastr()->success('Product updated successfully.');
        return redirect()->route('admin_ops_products');
    }

    public function deleteProduct(int $id): RedirectResponse
    {
        Product::where('product_id', $id)->delete();
        toastr()->success('Product deleted successfully.');
        return redirect()->route('admin_ops_products');
    }

    public function wallet(): View
    {
        $walletBalance = Schema::hasTable('users') && Schema::hasColumn('users', 'wallet_balance')
            ? (float) DB::table('users')->sum('wallet_balance')
            : 0;

        $summary = [
            'walletBalance' => $walletBalance,
            'totalTransactions' => UserWalletTransaction::count(),
            'pendingWithdrawals' => UserWalletTransaction::where('transaction_type', 'withdraw_request')
                ->where('status', 'pending')
                ->count(),
            'completedWithdrawals' => UserWalletTransaction::where('transaction_type', 'withdraw_request')
                ->where('status', 'completed')
                ->count(),
            'creditVolume' => (float) UserWalletTransaction::where('type', 'credit')->sum('amount'),
            'debitVolume' => (float) UserWalletTransaction::where('type', 'debit')->sum('amount'),
        ];

        $transactions = UserWalletTransaction::with('user:id,name,phone,email')
            ->latest('id')
            ->paginate(30);

        $topWalletUsers = collect();
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'wallet_balance')) {
            $topWalletUsers = DB::table('users')
                ->select(['id', 'name', 'phone', 'email', 'wallet_balance'])
                ->orderByDesc('wallet_balance')
                ->limit(8)
                ->get();
        }

        $pendingWithdrawals = UserWalletTransaction::with('user:id,name,phone,email')
            ->where('transaction_type', 'withdraw_request')
            ->where('status', 'pending')
            ->latest('id')
            ->limit(8)
            ->get();

        return view('admin_pages.operations.wallet', [
            'summary' => $summary,
            'transactions' => $transactions,
            'topWalletUsers' => $topWalletUsers,
            'pendingWithdrawals' => $pendingWithdrawals,
        ]);
    }

    public function updateWalletTransactionStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'completed', 'failed'])],
        ]);

        $transaction = UserWalletTransaction::findOrFail($id);

        if (
            $transaction->transaction_type === 'withdraw_request'
            && $transaction->status !== 'completed'
            && $request->status === 'completed'
            && Schema::hasTable('users')
            && Schema::hasColumn('users', 'wallet_balance')
        ) {
            DB::transaction(function () use ($transaction) {
                $user = DB::table('users')->where('id', $transaction->user_id)->lockForUpdate()->first();
                if (!$user) {
                    return;
                }

                $current = (float) ($user->wallet_balance ?? 0);
                $amount = (float) $transaction->amount;
                $next = max(0, $current - $amount);

                DB::table('users')->where('id', $transaction->user_id)->update(['wallet_balance' => $next]);

                $transaction->balance_before = $current;
                $transaction->balance_after = $next;
                $transaction->status = 'completed';
                $transaction->save();
            });
        } else {
            $transaction->status = $request->status;
            $transaction->save();
        }

        toastr()->success('Wallet transaction status updated.');
        return redirect()->route('admin_ops_wallet');
    }

    private function pendingWithdrawCount(): int
    {
        $userWalletPending = UserWalletTransaction::where('transaction_type', 'withdraw_request')
            ->where('status', 'pending')
            ->count();

        $legacyPending = 0;
        if (Schema::hasTable('withdrawalrequests') && Schema::hasColumn('withdrawalrequests', 'Status')) {
            $legacyPending = (int) DB::table('withdrawalrequests')->where('Status', 'pending')->count();
        }

        return $userWalletPending + $legacyPending;
    }
}
