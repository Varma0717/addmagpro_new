import '../../../core/config/app_config.dart';

class CartOverview {
  CartOverview({required this.items, required this.summary});

  final List<CartLineItem> items;
  final CartSummary summary;

  factory CartOverview.fromJson(Map<String, dynamic> json) {
    final data = json['data'];
    if (data is! Map<String, dynamic>) {
      throw StateError('Invalid cart response');
    }

    final rawItems = data['items'];
    final items = rawItems is List
        ? rawItems
              .whereType<Map<String, dynamic>>()
              .map(CartLineItem.fromJson)
              .toList(growable: false)
        : <CartLineItem>[];

    return CartOverview(items: items, summary: CartSummary.fromJson(data));
  }
}

class CartLineItem {
  CartLineItem({
    required this.id,
    required this.productId,
    required this.quantity,
    required this.price,
    required this.subtotal,
    required this.product,
  });

  final int id;
  final int productId;
  final int quantity;
  final double price;
  final double subtotal;
  final CartProduct product;

  factory CartLineItem.fromJson(Map<String, dynamic> json) {
    return CartLineItem(
      id: _toInt(json['id']) ?? 0,
      productId: _toInt(json['product_id']) ?? 0,
      quantity: _toInt(json['quantity']) ?? 0,
      price: _toDouble(json['price']) ?? 0,
      subtotal: _toDouble(json['subtotal']) ?? 0,
      product: CartProduct.fromJson(
        json['product'] as Map<String, dynamic>? ?? <String, dynamic>{},
      ),
    );
  }
}

class CartProduct {
  CartProduct({
    required this.id,
    required this.name,
    required this.slug,
    required this.effectivePrice,
    required this.primaryImageUrl,
  });

  final int id;
  final String name;
  final String slug;
  final double effectivePrice;
  final String? primaryImageUrl;

  factory CartProduct.fromJson(Map<String, dynamic> json) {
    return CartProduct(
      id: _toInt(json['id']) ?? 0,
      name: (json['name'] as String?) ?? '-',
      slug: (json['slug'] as String?) ?? '',
      effectivePrice:
          _toDouble(json['effective_price']) ??
          _toDouble(json['price']) ??
          _toDouble(json['final_price']) ??
          0,
      primaryImageUrl: _resolveFirstImageUrl(
        json['primary_image_url'] as String? ??
            json['image_url'] as String? ??
            json['product_images'] as String?,
      ),
    );
  }
}

class CartSummary {
  CartSummary({
    required this.itemCount,
    required this.quantityCount,
    required this.subtotal,
    required this.total,
  });

  final int itemCount;
  final int quantityCount;
  final double subtotal;
  final double total;

  factory CartSummary.fromJson(Map<String, dynamic> json) {
    return CartSummary(
      itemCount: _toInt(json['item_count']) ?? 0,
      quantityCount: _toInt(json['quantity_count']) ?? 0,
      subtotal: _toDouble(json['subtotal']) ?? 0,
      total: _toDouble(json['total']) ?? 0,
    );
  }
}

class CouponQuote {
  CouponQuote({
    required this.couponId,
    required this.code,
    required this.discount,
    required this.subtotal,
    required this.finalTotal,
  });

  final int couponId;
  final String code;
  final double discount;
  final double subtotal;
  final double finalTotal;

  factory CouponQuote.fromJson(Map<String, dynamic> json) {
    final data = json['data'] as Map<String, dynamic>? ?? <String, dynamic>{};
    final cart = data['cart'] as Map<String, dynamic>? ?? <String, dynamic>{};
    final couponDetails =
        data['coupon_details'] as Map<String, dynamic>? ?? <String, dynamic>{};
    return CouponQuote(
      couponId: 0,
      code:
          (couponDetails['code'] as String?) ??
          (cart['coupon_code'] as String?) ??
          '',
      discount:
          _toDouble(data['discount']) ??
          _toDouble(cart['discount_amount']) ??
          0,
      subtotal: _toDouble(cart['subtotal']) ?? 0,
      finalTotal: _toDouble(cart['total']) ?? 0,
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

double? _toDouble(dynamic value) {
  if (value == null) return null;
  if (value is double) return value;
  if (value is num) return value.toDouble();
  if (value is String) return double.tryParse(value);
  return null;
}

String? _resolveFirstImageUrl(String? value) {
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
