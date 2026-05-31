import '../../../core/network/api_client.dart';
import '../models/cart_models.dart';

class CartRepository {
  CartRepository({required ApiClient apiClient}) : _apiClient = apiClient;

  final ApiClient _apiClient;

  Future<CartOverview> fetch(String token) async {
    final payload = await _apiClient.get('/cart', bearerToken: token);
    return CartOverview.fromJson(payload);
  }

  Future<void> addItem({
    required String token,
    required int productId,
    int quantity = 1,
  }) async {
    await _apiClient.post(
      '/cart/add',
      bearerToken: token,
      body: <String, dynamic>{'product_id': productId, 'quantity': quantity},
    );
  }

  Future<void> updateQty({
    required String token,
    required int itemId,
    required int quantity,
  }) async {
    await _apiClient.patch(
      '/cart/items/$itemId',
      bearerToken: token,
      body: <String, dynamic>{'quantity': quantity},
    );
  }

  Future<void> removeItem({required String token, required int itemId}) async {
    await _apiClient.delete('/cart/items/$itemId', bearerToken: token);
  }

  Future<CouponQuote> applyCoupon({
    required String token,
    required String code,
  }) async {
    final payload = await _apiClient.post(
      '/cart/apply-coupon',
      bearerToken: token,
      body: <String, dynamic>{'coupon_code': code.trim().toUpperCase()},
    );

    return CouponQuote.fromJson(payload);
  }
}
