@extends('layouts.master')
@section('page_title', 'Products | Admin Operations')
@section('mainsection')
<div class="admin-page">
    <section class="admin-section">
        <div class="admin-section-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="admin-page-title">Product Management</h2>
                </div><a class="btn btn-theme" href="{{ route('admin_ops') }}">Back to Hub</a>
            </div>

            <div class="card admin-card mb-4">
                <div class="card-header admin-card-header">
                    <h4>Add Product</h4>
                </div>
                <div class="card-body admin-card-body">
                    <form method="POST" action="{{ route('admin_ops_products_store') }}" class="row g-2">@csrf
                        <div class="col-md-3"><input class="form-control" name="product_name" required placeholder="Product name"></div>
                        <div class="col-md-3"><input class="form-control" name="product_description" placeholder="Description"></div>
                        <div class="col-md-2"><select class="form-select" name="category_id" required>@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->CategoryName }}</option>@endforeach</select></div>
                        <div class="col-md-2"><select class="form-select" name="vendor_id" required>@foreach($vendors as $vendor)<option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_name }}</option>@endforeach</select></div>
                        <div class="col-md-2"><select class="form-select" name="brand_id">
                                <option value="">No brand</option>@foreach($brands as $brand)<option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>@endforeach
                            </select></div>
                        <div class="col-md-2"><input class="form-control" name="item_code" placeholder="Item code"></div>
                        <div class="col-md-2"><input class="form-control" type="number" step="0.01" name="unit_price" required placeholder="Selling price"></div>
                        <div class="col-md-2"><input class="form-control" type="number" step="0.01" name="purchase_price" placeholder="Purchase price"></div>
                        <div class="col-md-4"><input class="form-control" name="product_images" placeholder="Image URL/path"></div>
                        <div class="col-md-2"><button class="btn btn-theme w-100" type="submit">Add Product</button></div>
                    </form>
                </div>
            </div>

            <div class="card admin-card">
                <div class="card-header admin-card-header">
                    <h4>Product List</h4>
                </div>
                <div class="card-body admin-card-body p-0">
                    <div class="table-responsive admin-table-wrap">
                        <table class="table admin-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Vendor</th>
                                    <th>Price</th>
                                    <th>Item Code</th>
                                    <th>Image</th>
                                    <th>Save</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <form method="POST" action="{{ route('admin_ops_products_update', ['id' => $product->product_id]) }}">@csrf
                                        <td>{{ $product->product_id }}</td>
                                        <td style="min-width:220px;"><input class="form-control" name="product_name" value="{{ $product->product_name }}" required><input class="form-control mt-1" name="product_description" value="{{ $product->product_description }}"></td>
                                        <td><select class="form-select" name="category_id">@foreach($categories as $category)<option value="{{ $category->id }}" {{ (int)$product->category_id === (int)$category->id ? 'selected' : '' }}>{{ $category->CategoryName }}</option>@endforeach</select></td>
                                        <td><select class="form-select" name="vendor_id">@foreach($vendors as $vendor)<option value="{{ $vendor->vendor_id }}" {{ (int)$product->vendor_id === (int)$vendor->vendor_id ? 'selected' : '' }}>{{ $vendor->vendor_name }}</option>@endforeach</select></td>
                                        <td style="min-width:150px;"><input class="form-control" type="number" step="0.01" name="unit_price" value="{{ $product->unit_price }}"><input class="form-control mt-1" type="number" step="0.01" name="purchase_price" value="{{ $product->purchase_price }}"></td>
                                        <td><input class="form-control" name="item_code" value="{{ $product->item_code }}"></td>
                                        <td><input class="form-control" name="product_images" value="{{ $product->product_images }}"></td>
                                        <td><button class="btn btn-theme btn-sm" type="submit">Save</button></td>
                                    </form>
                                    <td>
                                        <form method="POST" action="{{ route('admin_ops_products_delete', ['id' => $product->product_id]) }}" onsubmit="return confirm('Delete this product?')">@csrf
                                            <button class="status-badge badge-rejected border-0" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">No products found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">{{ $products->links() }}</div>
            </div>
        </div>
    </section>
</div>
@endsection