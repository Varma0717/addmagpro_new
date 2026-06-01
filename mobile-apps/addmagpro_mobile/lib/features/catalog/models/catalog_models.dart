import '../../../core/config/app_config.dart';

enum ProductSortOption {
  latest('latest', 'Latest'),
  priceAsc('price_asc', 'Price: Low to High'),
  priceDesc('price_desc', 'Price: High to Low'),
  rating('rating', 'Rating');

  const ProductSortOption(this.value, this.label);
  final String value;
  final String label;

  static ProductSortOption fromValue(String? value) {
    return ProductSortOption.values.firstWhere(
      (option) => option.value == value,
      orElse: () => ProductSortOption.latest,
    );
  }
}

class ProductFilterQuery {
  const ProductFilterQuery({
    this.minPrice,
    this.maxPrice,
    this.minRating,
    this.brandId,
    this.sort = ProductSortOption.latest,
  });

  final double? minPrice;
  final double? maxPrice;
  final double? minRating;
  final int? brandId;
  final ProductSortOption sort;

  bool get hasActiveFilters =>
      minPrice != null ||
      maxPrice != null ||
      minRating != null ||
      brandId != null ||
      sort != ProductSortOption.latest;

  ProductFilterQuery copyWith({
    double? minPrice,
    double? maxPrice,
    double? minRating,
    int? brandId,
    ProductSortOption? sort,
    bool clearMinPrice = false,
    bool clearMaxPrice = false,
    bool clearMinRating = false,
    bool clearBrandId = false,
  }) {
    return ProductFilterQuery(
      minPrice: clearMinPrice ? null : (minPrice ?? this.minPrice),
      maxPrice: clearMaxPrice ? null : (maxPrice ?? this.maxPrice),
      minRating: clearMinRating ? null : (minRating ?? this.minRating),
      brandId: clearBrandId ? null : (brandId ?? this.brandId),
      sort: sort ?? this.sort,
    );
  }
}

class ProductListResponse {
  ProductListResponse({
    required this.items,
    required this.currentPage,
    required this.lastPage,
    required this.availableBrands,
  });

  final List<ProductListItem> items;
  final int currentPage;
  final int lastPage;
  final List<BrandFilterOption> availableBrands;

  factory ProductListResponse.fromJson(Map<String, dynamic> json) {
    final data = json['data'] ?? json;
    final pagination = json['pagination'] as Map<String, dynamic>?;

    final currentPage =
        _toInt(json['current_page']) ??
        _toInt(pagination?['current_page']) ??
        1;
    final lastPage =
        _toInt(json['last_page']) ?? _toInt(pagination?['last_page']) ?? 1;

    return ProductListResponse(
      items: data is List
          ? data
                .whereType<Map<String, dynamic>>()
                .map(ProductListItem.fromJson)
                .toList(growable: false)
          : <ProductListItem>[],
      currentPage: currentPage,
      lastPage: lastPage,
      availableBrands: const <BrandFilterOption>[],
    );
  }
}

class ProductListItem {
  ProductListItem({
    required this.id,
    required this.name,
    required this.slug,
    required this.effectivePrice,
    required this.primaryImageUrl,
    required this.ratingAvg,
    required this.brandId,
    required this.brandName,
  });

  final int id;
  final String name;
  final String slug;
  final double effectivePrice;
  final String? primaryImageUrl;
  final double? ratingAvg;
  final int? brandId;
  final String? brandName;

  factory ProductListItem.fromJson(Map<String, dynamic> json) {
    final brand = json['brand'];
    final id = _toInt(json['id']) ?? _toInt(json['product_id']) ?? 0;
    final name =
        (json['name'] as String?) ?? (json['product_name'] as String?) ?? '-';
    final slug =
        (json['slug'] as String?) ?? (id > 0 ? id.toString() : _slugify(name));

    return ProductListItem(
      id: id,
      name: name,
      slug: slug,
      effectivePrice:
          _toDouble(json['effective_price']) ??
          _toDouble(json['price']) ??
          _toDouble(json['unit_price']) ??
          0,
      primaryImageUrl: AppConfig.resolveImageUrl(
        json['primary_image_url'] as String? ??
            json['image_url'] as String? ??
            json['product_images'] as String?,
      ),
      ratingAvg: _toDouble(json['rating_avg']),
      brandId:
          _toInt(json['brand_id']) ??
          (brand is Map<String, dynamic> ? _toInt(brand['id']) : null),
      brandName:
          json['brand_name'] as String? ??
          (brand is Map<String, dynamic> ? brand['name'] as String? : null),
    );
  }
}

class BrandFilterOption {
  BrandFilterOption({required this.id, required this.name});

  final int id;
  final String name;

  factory BrandFilterOption.fromJson(Map<String, dynamic> json) {
    return BrandFilterOption(
      id: _toInt(json['id']) ?? 0,
      name: (json['name'] as String?) ?? '-',
    );
  }
}

class ProductDetail {
  ProductDetail({
    required this.id,
    required this.name,
    required this.slug,
    required this.description,
    required this.shortDescription,
    required this.price,
    required this.effectivePrice,
    required this.discountPercent,
    required this.images,
    required this.ratingAvg,
    required this.stock,
    required this.category,
    required this.reviews,
  });

  final int id;
  final String name;
  final String slug;
  final String? description;
  final String? shortDescription;
  final double price;
  final double effectivePrice;
  final double discountPercent;
  final List<String> images;
  final double? ratingAvg;
  final int stock;
  final String? category;
  final List<ProductReview> reviews;

  factory ProductDetail.fromJson(Map<String, dynamic> json) {
    final rootData = json['data'];
    final data = rootData is Map<String, dynamic>
        ? (rootData['product'] is Map<String, dynamic>
              ? rootData['product'] as Map<String, dynamic>
              : rootData)
        : <String, dynamic>{};
    final images = data['images'] ?? data['product_images'];
    final reviews = data['reviews'];
    final category = data['category'];

    return ProductDetail(
      id: _toInt(data['id']) ?? 0,
      name:
          (data['name'] as String?) ?? (data['product_name'] as String?) ?? '-',
      slug:
          (data['slug'] as String?) ??
          ((_toInt(data['id']) ?? _toInt(data['product_id']) ?? 0) > 0
              ? (_toInt(data['id']) ?? _toInt(data['product_id'])!).toString()
              : _slugify(
                  (data['name'] as String?) ??
                      (data['product_name'] as String?),
                )),
      description:
          data['description'] as String? ??
          data['product_description'] as String?,
      shortDescription: data['short_description'] as String?,
      price:
          _toDouble(data['price']) ??
          _toDouble(data['unit_price']) ??
          _toDouble(data['original_price']) ??
          _toDouble(data['mrp']) ??
          _toDouble(data['effective_price']) ??
          0,
      effectivePrice:
          _toDouble(data['effective_price']) ??
          _toDouble(data['price']) ??
          _toDouble(data['unit_price']) ??
          0,
      discountPercent:
          _toDouble(data['discount_percent']) ??
          _toDouble(data['discount_percentage']) ??
          0,
      images: images is List
          ? images
                .map((e) {
                  if (e is String) {
                    return AppConfig.resolveImageUrl(e);
                  }
                  if (e is Map<String, dynamic>) {
                    return AppConfig.resolveImageUrl(
                      e['image_url'] as String? ??
                          e['url'] as String? ??
                          e['path'] as String?,
                    );
                  }
                  return null;
                })
                .whereType<String>()
                .toList(growable: false)
          : <String>[],
      ratingAvg: _toDouble(data['rating_avg']),
      stock: _toInt(data['stock']) ?? 0,
      category: category is Map<String, dynamic>
          ? category['name'] as String?
          : null,
      reviews: reviews is List
          ? reviews
                .whereType<Map<String, dynamic>>()
                .map(ProductReview.fromJson)
                .toList(growable: false)
          : <ProductReview>[],
    );
  }
}

class ProductReview {
  ProductReview({
    required this.id,
    required this.rating,
    required this.comment,
    required this.userName,
    required this.createdAt,
  });

  final int id;
  final int rating;
  final String? comment;
  final String? userName;
  final String? createdAt;

  factory ProductReview.fromJson(Map<String, dynamic> json) {
    final user = json['user'];
    return ProductReview(
      id: _toInt(json['id']) ?? 0,
      rating: _toInt(json['rating']) ?? 0,
      comment: json['comment'] as String?,
      userName: user is Map<String, dynamic> ? user['name'] as String? : null,
      createdAt: json['created_at']?.toString(),
    );
  }
}

class ListingListResponse {
  ListingListResponse({
    required this.items,
    required this.currentPage,
    required this.lastPage,
  });

  final List<ListingListItem> items;
  final int currentPage;
  final int lastPage;

  factory ListingListResponse.fromJson(Map<String, dynamic> json) {
    final rootData = json['data'];
    final data = rootData is Map<String, dynamic> ? rootData['data'] : rootData;
    final meta = json['meta'];
    final pagination =
        meta is Map<String, dynamic> &&
            meta['pagination'] is Map<String, dynamic>
        ? meta['pagination'] as Map<String, dynamic>
        : null;
    final inlinePagination =
        rootData is Map<String, dynamic> &&
            rootData['meta'] is Map<String, dynamic> &&
            (rootData['meta'] as Map<String, dynamic>)['pagination']
                is Map<String, dynamic>
        ? (rootData['meta'] as Map<String, dynamic>)['pagination']
              as Map<String, dynamic>
        : null;

    return ListingListResponse(
      items: data is List
          ? data
                .whereType<Map<String, dynamic>>()
                .map(ListingListItem.fromJson)
                .toList(growable: false)
          : <ListingListItem>[],
      currentPage:
          _toInt(pagination?['current_page']) ??
          _toInt(inlinePagination?['current_page']) ??
          _toInt(json['current_page']) ??
          1,
      lastPage:
          _toInt(pagination?['last_page']) ??
          _toInt(inlinePagination?['last_page']) ??
          _toInt(json['last_page']) ??
          1,
    );
  }
}

class ListingListItem {
  ListingListItem({
    required this.id,
    required this.type,
    required this.businessName,
    required this.slug,
    required this.city,
    required this.ratingAvg,
    required this.primaryImageUrl,
    required this.categoryName,
  });

  final int id;
  final String type;
  final String businessName;
  final String slug;
  final String? city;
  final double? ratingAvg;
  final String? primaryImageUrl;
  final String? categoryName;

  factory ListingListItem.fromJson(Map<String, dynamic> json) {
    final category = json['category'];
    final id =
        _toInt(json['id']) ??
        _toInt(json['service_id']) ??
        _toInt(json['StoreID']) ??
        _toInt(json['store_id']) ??
        _toInt(json['vendor_id']) ??
        0;
    final type =
        (json['type'] as String?) ??
        (_toInt(json['service_id']) != null ? 'service' : null) ??
        (_toInt(json['StoreID']) != null || _toInt(json['store_id']) != null
            ? 'store'
            : null) ??
        (_toInt(json['vendor_id']) != null ? 'vendor' : null) ??
        'listing';
    final name =
        (json['business_name'] as String?) ??
        (json['shop_name'] as String?) ??
        (json['StoreName'] as String?) ??
        (json['store_name'] as String?) ??
        (json['service_name'] as String?) ??
        (json['name'] as String?) ??
        '-';

    return ListingListItem(
      id: id,
      type: type,
      businessName: name,
      slug: (json['slug'] as String?) ?? (id > 0 ? '$type-$id' : ''),
      city:
          (json['city'] as String?) ??
          (json['City'] as String?) ??
          (json['district_name'] as String?),
      ratingAvg: _toDouble(json['rating_avg']),
      primaryImageUrl: AppConfig.resolveImageUrl(
        json['primary_image_url'] as String? ??
            json['image_url'] as String? ??
            json['ImageURL'] as String? ??
            json['StoreImage'] as String? ??
            json['store_image'] as String? ??
            json['service_category_image'] as String? ??
            json['service_image'] as String? ??
            json['vendor_banner_image'] as String? ??
            json['shop_image'] as String?,
      ),
      categoryName:
          (json['category_name'] as String?) ??
          (category is Map<String, dynamic>
              ? category['name'] as String?
              : null),
    );
  }
}

class ListingDetail {
  ListingDetail({
    required this.id,
    required this.type,
    required this.businessName,
    required this.slug,
    required this.description,
    required this.address,
    required this.city,
    required this.phone,
    required this.whatsapp,
    required this.websiteUrl,
    required this.images,
    required this.ratingAvg,
  });

  final int id;
  final String type;
  final String businessName;
  final String slug;
  final String? description;
  final String? address;
  final String? city;
  final String? phone;
  final String? whatsapp;
  final String? websiteUrl;
  final List<String> images;
  final double? ratingAvg;

  factory ListingDetail.fromJson(Map<String, dynamic> json) {
    final data = json['data'] as Map<String, dynamic>? ?? <String, dynamic>{};
    final images = data['images'];
    final id =
        _toInt(data['id']) ??
        _toInt(data['service_id']) ??
        _toInt(data['StoreID']) ??
        _toInt(data['store_id']) ??
        _toInt(data['vendor_id']) ??
        0;
    final type = (data['type'] as String?) ?? 'listing';
    final fallbackImage = AppConfig.resolveImageUrl(
      data['primary_image_url'] as String? ??
          data['image_url'] as String? ??
          data['ImageURL'] as String? ??
          data['StoreImage'] as String? ??
          data['store_image'] as String? ??
          data['service_category_image'] as String? ??
          data['service_image'] as String? ??
          data['vendor_banner_image'] as String? ??
          data['shop_image'] as String?,
    );
    final parsedImages = images is List
        ? images
              .map((e) {
                if (e is String) {
                  return AppConfig.resolveImageUrl(e);
                }
                if (e is Map<String, dynamic>) {
                  return AppConfig.resolveImageUrl(
                    e['image_url'] as String? ??
                        e['url'] as String? ??
                        e['path'] as String?,
                  );
                }
                return null;
              })
              .whereType<String>()
              .toList(growable: false)
        : <String>[];

    return ListingDetail(
      id: id,
      type: type,
      businessName:
          (data['business_name'] as String?) ??
          (data['shop_name'] as String?) ??
          (data['StoreName'] as String?) ??
          (data['store_name'] as String?) ??
          (data['service_name'] as String?) ??
          (data['name'] as String?) ??
          '-',
      slug: (data['slug'] as String?) ?? (id > 0 ? '$type-$id' : ''),
      description:
          (data['description'] as String?) ??
          (data['service_description'] as String?) ??
          (data['store_description'] as String?),
      address:
          (data['address'] as String?) ??
          (data['service_address'] as String?) ??
          (data['store_address'] as String?) ??
          (data['shop_address'] as String?),
      city:
          (data['city'] as String?) ??
          (data['City'] as String?) ??
          (data['district_name'] as String?),
      phone:
          (data['phone'] as String?) ??
          (data['mobile'] as String?) ??
          (data['contact_no'] as String?),
      whatsapp:
          (data['whatsapp'] as String?) ?? (data['whatsapp_number'] as String?),
      websiteUrl:
          (data['website_url'] as String?) ?? (data['website'] as String?),
      images: parsedImages.isNotEmpty
          ? parsedImages
          : (fallbackImage != null ? <String>[fallbackImage] : <String>[]),
      ratingAvg: _toDouble(data['rating_avg']),
    );
  }
}

int? _toInt(dynamic value) {
  if (value == null) return null;
  if (value is int) return value;
  if (value is num) return value.toInt();
  if (value is String) return int.tryParse(value);
  return null;
}

String _slugify(String? value) {
  if (value == null) return '';
  final normalized = value
      .trim()
      .toLowerCase()
      .replaceAll(RegExp(r'[^a-z0-9]+'), '-')
      .replaceAll(RegExp(r'^-+|-+$'), '');
  return normalized;
}

double? _toDouble(dynamic value) {
  if (value == null) return null;
  if (value is double) return value;
  if (value is num) return value.toDouble();
  if (value is String) return double.tryParse(value);
  return null;
}
