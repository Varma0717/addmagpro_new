import '../../../core/config/app_config.dart';

class AuthUser {
  final int id;
  final String name;
  final String? email;
  final String? phone;
  final String? referralCode;
  final String? avatarUrl;
  final String? role;
  final bool isActive;
  final double walletBalance;
  final String? kycStatus;
  final String? locationAddress;

  const AuthUser({
    required this.id,
    required this.name,
    this.email,
    this.phone,
    this.referralCode,
    this.avatarUrl,
    this.role,
    this.isActive = true,
    this.walletBalance = 0,
    this.kycStatus,
    this.locationAddress,
  });

  factory AuthUser.fromJson(Map<String, dynamic> json) {
    final location = json['location'];
    final locationMap = location is Map<String, dynamic>
        ? location
        : const <String, dynamic>{};

    return AuthUser(
      id: _toInt(json['id']) ?? 0,
      name: (json['name'] as String?) ?? 'User',
      email: json['email'] as String?,
      phone: json['phone'] as String?,
      referralCode: json['referral_code'] as String?,
      avatarUrl: AppConfig.resolveImageUrl(json['avatar_url'] as String?),
      role: json['role'] as String?,
      isActive: _toBool(json['is_active']) ?? true,
      walletBalance: _toDouble(json['wallet_balance']) ?? 0,
      kycStatus: json['kyc_status'] as String?,
      locationAddress:
          json['location_address'] as String? ??
          locationMap['address'] as String?,
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

  static bool? _toBool(dynamic value) {
    if (value == null) return null;
    if (value is bool) return value;
    if (value is num) return value != 0;
    if (value is String) {
      final normalized = value.trim().toLowerCase();
      if (normalized == 'true' || normalized == '1') return true;
      if (normalized == 'false' || normalized == '0') return false;
    }
    return null;
  }
}
