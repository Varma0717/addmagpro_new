class ProductModel {
  final int id;
  final String name;
  final String slug;
  final String? description;
  final double price;
  final double? discountPercent;
  final double finalPrice;
  final String? imageUrl;
  final List<String> images;
  final double? rating;
  final int? reviewCount;
  final int? stock;
  final String? sku;
  final String? category;
  final List<String>? tags;

  ProductModel({
    required this.id,
    required this.name,
    required this.slug,
    this.description,
    required this.price,
    this.discountPercent,
    required this.finalPrice,
    this.imageUrl,
    this.images = const [],
    this.rating,
    this.reviewCount,
    this.stock,
    this.sku,
    this.category,
    this.tags,
  });

  factory ProductModel.fromJson(Map<String, dynamic> json) {
    return ProductModel(
      id: json['id'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      slug: json['slug'] as String? ?? '',
      description: json['description'] as String?,
      price: (json['price'] as num?)?.toDouble() ?? 0.0,
      discountPercent: (json['discount_percent'] as num?)?.toDouble(),
      finalPrice: (json['final_price'] as num?)?.toDouble() ?? 0.0,
      imageUrl: json['image_url'] as String? ?? json['image'] as String?,
      images: List<String>.from(json['images'] as List? ?? []),
      rating: (json['rating'] as num?)?.toDouble(),
      reviewCount:
          json['review_count'] as int? ?? json['reviews_count'] as int?,
      stock: json['stock'] as int?,
      sku: json['sku'] as String?,
      category: json['category'] as String?,
      tags: List<String>.from(json['tags'] as List? ?? []),
    );
  }

  Map<String, dynamic> toJson() => {
    'id': id,
    'name': name,
    'slug': slug,
    'description': description,
    'price': price,
    'discount_percent': discountPercent,
    'final_price': finalPrice,
    'image_url': imageUrl,
    'images': images,
    'rating': rating,
    'review_count': reviewCount,
    'stock': stock,
    'sku': sku,
    'category': category,
    'tags': tags,
  };

  ProductModel copyWith({
    int? id,
    String? name,
    String? slug,
    String? description,
    double? price,
    double? discountPercent,
    double? finalPrice,
    String? imageUrl,
    List<String>? images,
    double? rating,
    int? reviewCount,
    int? stock,
    String? sku,
    String? category,
    List<String>? tags,
  }) {
    return ProductModel(
      id: id ?? this.id,
      name: name ?? this.name,
      slug: slug ?? this.slug,
      description: description ?? this.description,
      price: price ?? this.price,
      discountPercent: discountPercent ?? this.discountPercent,
      finalPrice: finalPrice ?? this.finalPrice,
      imageUrl: imageUrl ?? this.imageUrl,
      images: images ?? this.images,
      rating: rating ?? this.rating,
      reviewCount: reviewCount ?? this.reviewCount,
      stock: stock ?? this.stock,
      sku: sku ?? this.sku,
      category: category ?? this.category,
      tags: tags ?? this.tags,
    );
  }
}
