import '../../../core/network/api_client.dart';
import '../../../core/network/api_exception.dart';
import '../models/notification_item.dart';

class NotificationRepository {
  NotificationRepository({required ApiClient apiClient})
    : _apiClient = apiClient;

  final ApiClient _apiClient;

  Future<List<NotificationItem>> fetch(String token) async {
    try {
      final payload = await _apiClient.get(
        '/account/notifications',
        bearerToken: token,
      );
      final raw = payload['data'];
      final data = raw is List
          ? raw
          : (raw is Map<String, dynamic>
                ? (raw['items'] ?? raw['notifications'])
                : null);

      if (data is! List) {
        return <NotificationItem>[];
      }

      return data
          .whereType<Map<String, dynamic>>()
          .map(NotificationItem.fromJson)
          .toList();
    } on ApiException catch (error) {
      if (error.statusCode != null && error.statusCode! >= 500) {
        return <NotificationItem>[];
      }
      rethrow;
    }
  }

  Future<void> markRead(String token, int notificationId) async {
    await _apiClient.post(
      '/account/notifications/$notificationId/read',
      bearerToken: token,
    );
  }

  Future<int> unreadCount(String token) async {
    final items = await fetch(token);
    return items.where((item) => !item.isRead).length;
  }
}
