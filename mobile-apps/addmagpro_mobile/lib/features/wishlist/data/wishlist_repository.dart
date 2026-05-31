import '../../../core/network/api_client.dart';
import '../models/wishlist_models.dart';

class WishlistRepository {
  WishlistRepository({required ApiClient apiClient}) : _apiClient = apiClient;

  final ApiClient _apiClient;

  Future<List<WishlistItem>> fetchAll(String token) async {
    final payload = await _apiClient.get('/wishlist', bearerToken: token);
    final data = payload['data'];
    if (data is! Map<String, dynamic>) return <WishlistItem>[];
    final items = data['items'];
    if (items is! List) return <WishlistItem>[];
    return items
        .whereType<Map<String, dynamic>>()
        .map(WishlistItem.fromJson)
        .toList(growable: false);
  }

  Future<void> add({required String token, required int productId}) async {
    await _apiClient.post(
      '/wishlist/add',
      body: {'product_id': productId},
      bearerToken: token,
    );
  }

  Future<void> remove({required String token, required int itemId}) async {
    await _apiClient.delete('/wishlist/items/$itemId', bearerToken: token);
  }

  Future<bool> toggle({required String token, required int productId}) async {
    final inWishlist = await check(token: token, productId: productId);
    if (inWishlist) {
      final items = await fetchAll(token);
      WishlistItem? existing;
      for (final item in items) {
        if (item.productId == productId) {
          existing = item;
          break;
        }
      }
      if (existing != null) {
        await remove(token: token, itemId: existing.id);
      }
      return false;
    }

    await add(token: token, productId: productId);
    return true;
  }

  Future<bool> check({required String token, required int productId}) async {
    final payload = await _apiClient.get(
      '/wishlist/is-in-wishlist/$productId',
      bearerToken: token,
    );
    final data =
        payload['data'] as Map<String, dynamic>? ?? <String, dynamic>{};
    return (data['is_in_wishlist'] as bool?) ?? false;
  }
}
