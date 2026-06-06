@extends('layouts.master')
@section('page_title', 'Categories | Admin Operations')
@section('mainsection')
<div class="admin-page">
    <section class="admin-section">
        <div class="admin-section-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="admin-page-title">Category Management</h2>
                </div><a class="btn btn-theme" href="{{ route('admin_ops') }}">Back to Hub</a>
            </div>

            <div class="card admin-card mb-4">
                <div class="card-header admin-card-header">
                    <h4>Add Category</h4>
                </div>
                <div class="card-body admin-card-body">
                    <form method="POST" action="{{ route('admin_ops_categories_store') }}" class="row g-2">@csrf
                        <div class="col-md-5"><input required class="form-control" name="name" placeholder="Category name"></div>
                        <div class="col-md-5"><input class="form-control" name="image_url" placeholder="Image URL or path"></div>
                        <div class="col-md-2"><button class="btn btn-theme w-100" type="submit">Add</button></div>
                    </form>
                </div>
            </div>

            <div class="card admin-card">
                <div class="card-header admin-card-header">
                    <h4>Category List</h4>
                </div>
                <div class="card-body admin-card-body p-0">
                    <div class="table-responsive admin-table-wrap">
                        <table class="table admin-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td style="min-width:220px;">
                                        <form method="POST" action="{{ route('admin_ops_categories_update', ['id' => $category->id]) }}" class="d-flex gap-2">@csrf
                                            <input class="form-control" name="name" value="{{ $category->CategoryName }}" required>
                                    </td>
                                    <td style="min-width:260px;"><input class="form-control" name="image_url" value="{{ $category->ImageURL }}"></td>
                                    <td><button class="btn btn-theme btn-sm" type="submit">Save</button></form>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin_ops_categories_delete', ['id' => $category->id]) }}" onsubmit="return confirm('Delete this category?')">@csrf
                                            <button class="status-badge badge-rejected border-0" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No categories found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">{{ $categories->links() }}</div>
            </div>
        </div>
    </section>
</div>
@endsection