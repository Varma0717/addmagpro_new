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

    final normalized = url.trim().replaceAll('\\', '/');
    if (normalized.isEmpty) return null;

    final absolute =
        (normalized.startsWith('http://') || normalized.startsWith('https://'))
        ? normalized
        : (normalized.startsWith('/')
              ? '$baseUrl$normalized'
              : '$baseUrl/$normalized');

    return Uri.encodeFull(absolute);
  }
}
