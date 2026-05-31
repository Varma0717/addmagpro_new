import '../../../core/network/api_client.dart';
import '../../../core/network/api_exception.dart';
import '../../auth/models/auth_user.dart';

class ProfileRepository {
  ProfileRepository({required ApiClient apiClient}) : _apiClient = apiClient;

  final ApiClient _apiClient;

  Future<AuthUser> updateProfile(
    String token, {
    required String name,
    String? phone,
    String? email,
    String? avatarPath,
  }) async {
    final payload = await _apiClient.patch(
      '/account/profile',
      bearerToken: token,
      body: <String, dynamic>{
        'name': name,
        'phone': (phone ?? '').trim().isEmpty ? null : phone,
        // API currently accepts avatar_url, not multipart upload.
        'avatar_url': (avatarPath ?? '').trim().isEmpty ? null : avatarPath,
      },
    );

    final data = payload['data'];
    if (data is! Map<String, dynamic>) {
      throw ApiException('Invalid profile response');
    }

    return AuthUser.fromJson(data);
  }
}
