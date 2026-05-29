class AppConfig {
  static const String appName = 'AddMagPro';

  // Production: Use live server only
  static const bool isDevelopment = false;

  static const String apiBaseUrl = isDevelopment
      ? 'http://localhost:8000/api/v1' // Development: localhost (DISABLED)
      : 'https://addmagpro.pmratnam.com/api/v1';

  static const String baseUrl = isDevelopment
      ? 'http://localhost:8000'
      : 'https://addmagpro.pmratnam.com';

  /// Ensures an image URL is absolute.
  /// Backend may return relative paths like `/storage/...`.
  static String? resolveImageUrl(String? url) {
    if (url == null || url.isEmpty) return null;
    if (url.startsWith('http://') || url.startsWith('https://')) return url;
    if (url.startsWith('/')) return '$baseUrl$url';
    return '$baseUrl/$url';
  }
}
