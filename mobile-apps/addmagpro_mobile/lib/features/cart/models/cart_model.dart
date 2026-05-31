import '../../../core/config/app_config.dart';

class CartItemModel {
  final int id;
  final int productId;
  final String productName;
  final String? productImage;
  final double price;
  final double finalPrice;
  int quantity;

  CartItemModel({
    required this.id,
    required this.productId,
    required this.productName,
    this.productImage,
    required this.price,
    required this.finalPrice,
    required this.quantity,
  });

  factory CartItemModel.fromJson(Map<String, dynamic> json) {
    return CartItemModel(
      id: json['id'] as int? ?? 0,
      productId: json['product_id'] as int? ?? 0,
      productName:
          json['product_name'] as String? ?? json['name'] as String? ?? '',
      productImage: AppConfig.resolveImageUrl(
        json['product_image'] as String? ?? json['image'] as String?,
      ),
      price: (json['price'] as num?)?.toDouble() ?? 0.0,
      finalPrice: (json['final_price'] as num?)?.toDouble() ?? 0.0,
      quantity: json['quantity'] as int? ?? 1,
    );
  }

  Map<String, dynamic> toJson() => {
    'id': id,
    'product_id': productId,
    'product_name': productName,
    'product_image': productImage,
    'price': price,
    'final_price': finalPrice,
    'quantity': quantity,
  };

  double get subtotal => price * quantity;
  double get total => finalPrice * quantity;
}

class CartModel {
  final List<CartItemModel> items;
  final double subtotal;
  final double discount;
  final double tax;
  final double total;
  final String? couponCode;
  final double? couponDiscount;

  CartModel({
    required this.items,
    required this.subtotal,
    required this.discount,
    required this.tax,
    required this.total,
    this.couponCode,
    this.couponDiscount,
  });

  factory CartModel.fromJson(Map<String, dynamic> json) {
    final items = (json['items'] as List? ?? [])
        .map((e) => CartItemModel.fromJson(e as Map<String, dynamic>))
        .toList();

    return CartModel(
      items: items,
      subtotal: (json['subtotal'] as num?)?.toDouble() ?? 0.0,
      discount: (json['discount'] as num?)?.toDouble() ?? 0.0,
      tax: (json['tax'] as num?)?.toDouble() ?? 0.0,
      total: (json['total'] as num?)?.toDouble() ?? 0.0,
      couponCode: json['coupon_code'] as String?,
      couponDiscount: (json['coupon_discount'] as num?)?.toDouble(),
    );
  }

  Map<String, dynamic> toJson() => {
    'items': items.map((e) => e.toJson()).toList(),
    'subtotal': subtotal,
    'discount': discount,
    'tax': tax,
    'total': total,
    'coupon_code': couponCode,
    'coupon_discount': couponDiscount,
  };

  CartModel copyWith({
    List<CartItemModel>? items,
    double? subtotal,
    double? discount,
    double? tax,
    double? total,
    String? couponCode,
    double? couponDiscount,
  }) {
    return CartModel(
      items: items ?? this.items,
      subtotal: subtotal ?? this.subtotal,
      discount: discount ?? this.discount,
      tax: tax ?? this.tax,
      total: total ?? this.total,
      couponCode: couponCode ?? this.couponCode,
      couponDiscount: couponDiscount ?? this.couponDiscount,
    );
  }
}
