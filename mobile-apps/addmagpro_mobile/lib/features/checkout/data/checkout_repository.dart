import '../../../core/network/api_client.dart';

class CheckoutResult {
  CheckoutResult({
    required this.orderId,
    required this.orderNumber,
    required this.status,
    required this.total,
  });

  final int orderId;
  final String orderNumber;
  final String status;
  final double total;

  factory CheckoutResult.fromJson(Map<String, dynamic> json) {
    final order = json['data'] as Map<String, dynamic>? ?? <String, dynamic>{};
    return CheckoutResult(
      orderId: _toInt(order['id']) ?? 0,
      orderNumber: (order['order_number'] as String?) ?? '-',
      status: (order['status'] as String?) ?? '-',
      total: _toDouble(order['total']) ?? 0,
    );
  }
}

class RazorpayOrderResult {
  RazorpayOrderResult({
    required this.orderId,
    required this.amount,
    required this.currency,
    required this.keyId,
  });

  final String orderId;
  final int amount;
  final String currency;
  final String keyId;

  factory RazorpayOrderResult.fromJson(Map<String, dynamic> json) {
    final data = json['data'] as Map<String, dynamic>? ?? <String, dynamic>{};
    return RazorpayOrderResult(
      orderId: (data['order_id'] as String?) ?? '',
      amount: _toInt(data['amount']) ?? 0,
      currency: (data['currency'] as String?) ?? 'INR',
      keyId: (data['key_id'] as String?) ?? '',
    );
  }
}

class CheckoutRepository {
  CheckoutRepository({required ApiClient apiClient}) : _apiClient = apiClient;

  final ApiClient _apiClient;

  Future<CheckoutResult> placeOrder({
    required String token,
    required String name,
    required String phone,
    required String address,
    required String city,
    required String state,
    required String pincode,
    required String paymentMethod,
    int? couponId,
  }) async {
    final payload = await _apiClient.post(
      '/orders/create',
      bearerToken: token,
      body: <String, dynamic>{
        'shipping_address': address,
        'shipping_city': city,
        'shipping_state': state,
        'shipping_postal_code': pincode,
        'shipping_phone': phone,
        'billing_address': address,
        'billing_city': city,
        'billing_state': state,
        'billing_postal_code': pincode,
        'billing_phone': phone,
        'payment_method': paymentMethod,
        'notes': 'Placed via mobile app by $name',
        'coupon_id': couponId,
      },
    );

    return CheckoutResult.fromJson(payload);
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
