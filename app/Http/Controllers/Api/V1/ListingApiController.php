<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ListingApiController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $type = strtolower((string) $request->get('type', 'all'));
            $page = max(1, (int) $request->get('page', 1));
            $perPage = max(1, min(50, (int) $request->get('per_page', 20)));
            $stateId = $request->get('state_id');
            $districtId = $request->get('district_id');

            $items = [];
            if ($type === 'all' || $type === 'service') {
                $items = array_merge($items, $this->fetchServices($stateId, $districtId));
            }
            if ($type === 'all' || $type === 'store') {
                $items = array_merge($items, $this->fetchStores($stateId, $districtId));
            }
            if ($type === 'all' || $type === 'vendor') {
                $items = array_merge($items, $this->fetchVendors($stateId, $districtId));
            }

            usort($items, function (array $a, array $b) {
                return strcasecmp($a['business_name'] ?? '', $b['business_name'] ?? '');
            });

            $total = count($items);
            $lastPage = max(1, (int) ceil($total / $perPage));
            $currentPage = min($page, $lastPage);
            $offset = ($currentPage - 1) * $perPage;
            $slice = array_slice($items, $offset, $perPage);

            return $this->successResponse([
                'data' => $slice,
                'meta' => [
                    'pagination' => [
                        'current_page' => $currentPage,
                        'per_page' => $perPage,
                        'total' => $total,
                        'last_page' => $lastPage,
                    ],
                ],
            ], 'Listings retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch listings: ' . $e->getMessage(), [], 500);
        }
    }

    public function show(string $slug)
    {
        try {
            [$type, $id] = $this->parseSlug($slug);
            if ($type === null || $id === null) {
                return $this->notFoundResponse('Listing not found');
            }

            $listing = match ($type) {
                'service' => $this->findService($id),
                'store' => $this->findStore($id),
                'vendor' => $this->findVendor($id),
                default => null,
            };

            if ($listing === null) {
                return $this->notFoundResponse('Listing not found');
            }

            return $this->successResponse($listing, 'Listing details retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch listing details: ' . $e->getMessage(), [], 500);
        }
    }

    private function fetchServices($stateId, $districtId): array
    {
        $query = DB::table('services');
        if ($stateId !== null && $this->hasColumn('services', 'state_id')) {
            $query->where('state_id', $stateId);
        }
        if ($districtId !== null && $this->hasColumn('services', 'district_id')) {
            $query->where('district_id', $districtId);
        }

        return $query->get()->map(function ($row) {
            $id = $this->firstInt($row, ['service_id', 'id']) ?? 0;
            $title = $this->firstString($row, ['service_name', 'name', 'classified_name', 'title']) ?? "Service {$id}";
            $image = $this->firstString($row, ['service_category_image', 'service_image', 'ImageURL', 'icon_url', 'image_url']);

            return [
                'id' => $id,
                'type' => 'service',
                'slug' => "service-{$id}",
                'business_name' => $title,
                'description' => $this->firstString($row, ['description', 'service_description', 'about']),
                'address' => $this->firstString($row, ['address', 'service_address']),
                'city' => $this->firstString($row, ['city', 'City', 'district_name']),
                'phone' => $this->firstString($row, ['phone', 'mobile', 'contact_no', 'service_mobile']),
                'whatsapp' => $this->firstString($row, ['whatsapp', 'whatsapp_number']),
                'website_url' => $this->firstString($row, ['website_url', 'website']),
                'category_name' => 'Service',
                'rating_avg' => null,
                'primary_image_url' => $image,
                'images' => $image ? [['image_url' => $image]] : [],
            ];
        })->all();
    }

    private function fetchStores($stateId, $districtId): array
    {
        $query = DB::table('stores');
        if ($stateId !== null && $this->hasColumn('stores', 'state_id')) {
            $query->where('state_id', $stateId);
        }
        if ($districtId !== null && $this->hasColumn('stores', 'district_id')) {
            $query->where('district_id', $districtId);
        }

        return $query->get()->map(function ($row) {
            $id = $this->firstInt($row, ['StoreID', 'store_id', 'id']) ?? 0;
            $title = $this->firstString($row, ['StoreName', 'store_name', 'name', 'business_name']) ?? "Store {$id}";
            $image = $this->firstString($row, ['StoreImage', 'store_image', 'ImageURL', 'image_url']);

            return [
                'id' => $id,
                'type' => 'store',
                'slug' => "store-{$id}",
                'business_name' => $title,
                'description' => $this->firstString($row, ['description', 'store_description', 'about']),
                'address' => $this->firstString($row, ['address', 'store_address']),
                'city' => $this->firstString($row, ['city', 'City', 'district_name']),
                'phone' => $this->firstString($row, ['phone', 'mobile', 'contact_no']),
                'whatsapp' => $this->firstString($row, ['whatsapp', 'whatsapp_number']),
                'website_url' => $this->firstString($row, ['website_url', 'website']),
                'category_name' => 'Store',
                'rating_avg' => null,
                'primary_image_url' => $image,
                'images' => $image ? [['image_url' => $image]] : [],
            ];
        })->all();
    }

    private function fetchVendors($stateId, $districtId): array
    {
        $query = DB::table('vendors')
            ->leftJoin('vendor_banners', 'vendors.vendor_id', '=', 'vendor_banners.vendor_id')
            ->select('vendors.*', 'vendor_banners.*');

        if ($stateId !== null && $this->hasColumn('vendors', 'state_id')) {
            $query->where('vendors.state_id', $stateId);
        }
        if ($districtId !== null && $this->hasColumn('vendors', 'district_id')) {
            $query->where('vendors.district_id', $districtId);
        }

        return $query->get()->map(function ($row) {
            $id = $this->firstInt($row, ['vendor_id', 'id']) ?? 0;
            $title = $this->firstString($row, ['shop_name', 'business_name', 'vendor_name', 'name']) ?? "Vendor {$id}";
            $image = $this->firstString($row, ['vendor_banner_image', 'ImageURL', 'shop_image', 'image_url']);

            return [
                'id' => $id,
                'type' => 'vendor',
                'slug' => "vendor-{$id}",
                'business_name' => $title,
                'description' => $this->firstString($row, ['description', 'about']),
                'address' => $this->firstString($row, ['address', 'shop_address']),
                'city' => $this->firstString($row, ['city', 'City', 'district_name']),
                'phone' => $this->firstString($row, ['phone', 'mobile', 'contact_no']),
                'whatsapp' => $this->firstString($row, ['whatsapp', 'whatsapp_number']),
                'website_url' => $this->firstString($row, ['website_url', 'website']),
                'category_name' => 'Vendor',
                'rating_avg' => null,
                'primary_image_url' => $image,
                'images' => $image ? [['image_url' => $image]] : [],
            ];
        })->all();
    }

    private function findService(int $id): ?array
    {
        $row = DB::table('services')->where('service_id', $id)->orWhere('id', $id)->first();
        if (!$row) return null;

        $name = $this->firstString($row, ['service_name', 'name', 'classified_name']) ?? "Service {$id}";
        $image = $this->firstString($row, ['service_category_image', 'service_image', 'ImageURL', 'icon_url', 'image_url']);

        return [
            'id' => $id,
            'type' => 'service',
            'slug' => "service-{$id}",
            'business_name' => $name,
            'description' => $this->firstString($row, ['description', 'service_description', 'about']),
            'address' => $this->firstString($row, ['address', 'service_address']),
            'city' => $this->firstString($row, ['city', 'City', 'district_name']),
            'phone' => $this->firstString($row, ['phone', 'mobile', 'contact_no', 'service_mobile']),
            'whatsapp' => $this->firstString($row, ['whatsapp', 'whatsapp_number']),
            'website_url' => $this->firstString($row, ['website_url', 'website']),
            'rating_avg' => null,
            'images' => $image ? [['image_url' => $image]] : [],
        ];
    }

    private function findStore(int $id): ?array
    {
        $row = DB::table('stores')->where('StoreID', $id)->orWhere('store_id', $id)->orWhere('id', $id)->first();
        if (!$row) return null;

        $name = $this->firstString($row, ['StoreName', 'store_name', 'name']) ?? "Store {$id}";
        $image = $this->firstString($row, ['StoreImage', 'store_image', 'ImageURL', 'image_url']);

        return [
            'id' => $id,
            'type' => 'store',
            'slug' => "store-{$id}",
            'business_name' => $name,
            'description' => $this->firstString($row, ['description', 'store_description', 'about']),
            'address' => $this->firstString($row, ['address', 'store_address']),
            'city' => $this->firstString($row, ['city', 'City', 'district_name']),
            'phone' => $this->firstString($row, ['phone', 'mobile', 'contact_no']),
            'whatsapp' => $this->firstString($row, ['whatsapp', 'whatsapp_number']),
            'website_url' => $this->firstString($row, ['website_url', 'website']),
            'rating_avg' => null,
            'images' => $image ? [['image_url' => $image]] : [],
        ];
    }

    private function findVendor(int $id): ?array
    {
        $row = DB::table('vendors')
            ->leftJoin('vendor_banners', 'vendors.vendor_id', '=', 'vendor_banners.vendor_id')
            ->select('vendors.*', 'vendor_banners.*')
            ->where('vendors.vendor_id', $id)
            ->first();

        if (!$row) return null;

        $name = $this->firstString($row, ['shop_name', 'business_name', 'vendor_name', 'name']) ?? "Vendor {$id}";
        $image = $this->firstString($row, ['vendor_banner_image', 'ImageURL', 'shop_image', 'image_url']);

        return [
            'id' => $id,
            'type' => 'vendor',
            'slug' => "vendor-{$id}",
            'business_name' => $name,
            'description' => $this->firstString($row, ['description', 'about']),
            'address' => $this->firstString($row, ['address', 'shop_address']),
            'city' => $this->firstString($row, ['city', 'City', 'district_name']),
            'phone' => $this->firstString($row, ['phone', 'mobile', 'contact_no']),
            'whatsapp' => $this->firstString($row, ['whatsapp', 'whatsapp_number']),
            'website_url' => $this->firstString($row, ['website_url', 'website']),
            'rating_avg' => null,
            'images' => $image ? [['image_url' => $image]] : [],
        ];
    }

    private function parseSlug(string $slug): array
    {
        $normalized = strtolower(trim($slug));
        foreach (['service', 'store', 'vendor'] as $type) {
            if (Str::startsWith($normalized, $type . '-')) {
                $id = (int) str_replace($type . '-', '', $normalized);
                if ($id > 0) {
                    return [$type, $id];
                }
            }
        }

        return [null, null];
    }

    private function firstString(object $row, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = data_get($row, $key);
            if ($value === null) {
                continue;
            }
            $str = trim((string) $value);
            if ($str !== '') {
                return $str;
            }
        }
        return null;
    }

    private function firstInt(object $row, array $keys): ?int
    {
        foreach ($keys as $key) {
            $value = data_get($row, $key);
            if (is_numeric($value)) {
                return (int) $value;
            }
        }
        return null;
    }

    private function hasColumn(string $table, string $column): bool
    {
        static $columns = [];
        if (!array_key_exists($table, $columns)) {
            $columns[$table] = DB::getSchemaBuilder()->getColumnListing($table);
        }
        return in_array($column, $columns[$table], true);
    }
}
