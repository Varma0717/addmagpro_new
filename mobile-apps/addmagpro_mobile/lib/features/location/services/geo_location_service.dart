import 'package:geolocator/geolocator.dart';
import 'package:permission_handler/permission_handler.dart';

class GeoLocationService {
  /// Request location permissions and get current position
  static Future<Position?> getCurrentLocation() async {
    try {
      // Request permissions
      final permissionStatus = await _requestLocationPermission();
      if (!permissionStatus) {
        return null; // Permission denied
      }

      // Get current position
      final position = await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high,
        timeLimit: const Duration(seconds: 10),
      );

      return position;
    } catch (e) {
      return null; // Failed to get location
    }
  }

  /// Request location permission
  static Future<bool> _requestLocationPermission() async {
    try {
      final status = await Permission.location.request();

      return status.isGranted ||
          status.isDenied ||
          status.isLimited ||
          status.isDenied;
    } catch (e) {
      return false;
    }
  }

  /// Get location name from coordinates using reverse geocoding
  /// (would require a separate package or API call)
  static Future<String?> getLocationName(double lat, double lng) async {
    // This is a placeholder - would need geocoding service
    // For now, we just return the coordinates
    return 'Lat: $lat, Lng: $lng';
  }
}
