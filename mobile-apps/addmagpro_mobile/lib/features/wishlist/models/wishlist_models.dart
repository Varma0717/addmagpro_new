import '../../../core/config/app_config.dart';

class WishlistItem {
  WishlistItem({
    required this.id,
    required this.productId,
    required this.name,
    required this.slug,
    required this.effectivePrice,
    required this.primaryImageUrl,
    required this.addedAt,
  });

  final int id;
  final int productId;
  final String name;
  final String slug;
  final double effectivePrice;
  final String? primaryImageUrl;
  final String? addedAt;

  factory WishlistItem.fromJson(Map<String, dynamic> json) {
    final product =
        json['product'] as Map<String, dynamic>? ?? <String, dynamic>{};
    final fallbackName =
        (json['name'] as String?) ?? (product['name'] as String?) ?? '-';

    return WishlistItem(
      id: _toInt(json['id']) ?? _toInt(json['wishlist_id']) ?? 0,
      productId: _toInt(json['product_id']) ?? _toInt(product['id']) ?? 0,
      name: fallbackName,
      slug:
          (json['slug'] as String?) ??
          (product['slug'] as String?) ??
          (_toInt(json['product_id'])?.toString() ?? _slugify(fallbackName)),
      effectivePrice:
          _toDouble(json['effective_price']) ??
          _toDouble(product['final_price']) ??
          _toDouble(product['price']) ??
          0,
      primaryImageUrl: _resolveFirstImageUrl(
        json['primary_image_url'] as String? ??
            product['primary_image_url'] as String? ??
            product['image_url'] as String? ??
            product['product_images'] as String?,
      ),
      addedAt: json['added_at'] as String?,
    );
  }

  static int? _toInt(dynamic value) {
    if (value == null) return null;
    if (value is int) return value;
    if (value is num) return value.toInt();
    if (value is String) return int.tryParse(value);
    return null;
  }

  static double? _toDouble(dynamic value) {
    if (value == null) return null;
    if (value is double) return value;
    if (value is num) return value.toDouble();
    if (value is String) return double.tryParse(value);
    return null;
  }

  static String _slugify(String value) {
    return value
        .trim()
        .toLowerCase()
        .replaceAll(RegExp(r'[^a-z0-9]+'), '-')
        .replaceAll(RegExp(r'^-+|-+$'), '');
  }

  static String? _resolveFirstImageUrl(String? value) {
    if (value == null || value.trim().isEmpty) return null;
    final cleaned = value
        .replaceAll('"', '')
        .replaceAll("'", '')
        .replaceAll('\\', '/');
    final first = cleaned
        .split(',')
        .map((entry) => entry.trim())
        .firstWhere((entry) => entry.isNotEmpty, orElse: () => '');
    return first.isEmpty ? null : AppConfig.resolveImageUrl(first);
  }
}
