import '../../../core/network/api_client.dart';
import '../../../core/network/api_exception.dart';
import '../../auth/models/auth_user.dart';

class ProfileRepository {
  ProfileRepository({required ApiClient apiClient}) : _apiClient = apiClient;

  final ApiClient _apiClient;

  Future<AuthUser> fetchProfile(String token) async {
    final payload = await _apiClient.get('/account/profile', bearerToken: token);
    final data = payload['data'];
    if (data is! Map<String, dynamic>) {
      throw ApiException('Invalid profile response');
    }
    return AuthUser.fromJson(data);
  }

  Future<AuthUser> updateProfile(
    String token, {
    required String name,
    String? phone,
    String? email,
    String? locationAddress,
    String? avatarPath,
  }) async {
    final payload = await _apiClient.patch(
      '/account/profile',
      bearerToken: token,
      body: <String, dynamic>{
        'name': name,
        'phone': (phone ?? '').trim().isEmpty ? null : phone,
        'location_address': (locationAddress ?? '').trim().isEmpty
            ? null
            : locationAddress,
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
