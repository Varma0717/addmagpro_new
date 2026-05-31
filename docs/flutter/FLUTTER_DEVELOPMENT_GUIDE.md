# Flutter Mobile Development - Complete Implementation Guide

## Project Structure Overview

```
lib/
├── main.dart                          # App entry point
├── app.dart                           # App configuration
├── core/
│   ├── config/
│   │   └── app_config.dart           # API URLs, keys, constants
│   ├── network/
│   │   ├── api_client.dart           # HTTP client with auth
│   │   ├── api_service.dart          # API wrapper
│   │   └── interceptors.dart         # Request/response interceptors
│   ├── storage/
│   │   ├── local_storage.dart        # SharedPreferences wrapper
│   │   └── secure_storage.dart       # Secure token storage
│   ├── theme/
│   │   ├── app_theme.dart            # Material theme
│   │   ├── colors.dart               # Color palette
│   │   └── text_styles.dart          # Typography
│   └── widgets/
│       ├── custom_app_bar.dart       # Reusable AppBar
│       ├── loading_widget.dart       # Loading indicators
│       └── error_widget.dart         # Error displays
├── features/
│   ├── auth/
│   │   ├── screens/
│   │   │   ├── login_screen.dart
│   │   │   ├── register_screen.dart
│   │   │   └── forgot_password_screen.dart
│   │   ├── providers/
│   │   │   └── auth_provider.dart
│   │   └── models/
│   │       ├── user_model.dart
│   │       └── login_response.dart
│   ├── home/
│   │   ├── screens/
│   │   │   └── home_screen.dart
│   │   ├── widgets/
│   │   │   ├── banner_carousel.dart
│   │   │   ├── category_grid.dart
│   │   │   ├── featured_products.dart
│   │   │   └── quick_services.dart
│   │   └── providers/
│   │       └── home_provider.dart
│   ├── search/
│   │   ├── screens/
│   │   │   └── search_screen.dart
│   │   ├── widgets/
│   │   │   ├── search_bar.dart
│   │   │   ├── search_filters.dart
│   │   │   └── search_results.dart
│   │   └── providers/
│   │       └── search_provider.dart
│   ├── catalog/
│   │   ├── screens/
│   │   │   ├── products_list_screen.dart
│   │   │   └── product_detail_screen.dart
│   │   ├── widgets/
│   │   │   ├── product_card.dart
│   │   │   ├── product_image_gallery.dart
│   │   │   └── product_reviews.dart
│   │   └── providers/
│   │       └── product_provider.dart
│   ├── cart/
│   │   ├── screens/
│   │   │   └── cart_screen.dart
│   │   ├── widgets/
│   │   │   └── cart_item_card.dart
│   │   └── providers/
│   │       └── cart_provider.dart
│   ├── checkout/
│   │   ├── screens/
│   │   │   ├── checkout_screen.dart
│   │   │   ├── address_screen.dart
│   │   │   └── payment_screen.dart
│   │   └── providers/
│   │       └── checkout_provider.dart
│   ├── wallet/
│   │   ├── screens/
│   │   │   ├── wallet_screen.dart
│   │   │   ├── topup_screen.dart
│   │   │   └── transaction_history_screen.dart
│   │   └── providers/
│   │       └── wallet_provider.dart
│   ├── referral/
│   │   ├── screens/
│   │   │   └── referral_screen.dart
│   │   ├── widgets/
│   │   │   └── referral_card.dart
│   │   └── providers/
│   │       └── referral_provider.dart
│   ├── orders/
│   │   ├── screens/
│   │   │   ├── orders_list_screen.dart
│   │   │   └── order_detail_screen.dart
│   │   └── providers/
│   │       └── order_provider.dart
│   └── profile/
│       ├── screens/
│       │   ├── profile_screen.dart
│       │   └── settings_screen.dart
│       └── providers/
│           └── profile_provider.dart
```

---

## Step 1: Core Configuration

### lib/core/config/app_config.dart
```dart
class AppConfig {
  // API Configuration
  static const String apiBaseUrl = 'http://localhost/admagpro/api/v1';
  static const String apiTimeout = '30000';
  
  // Razorpay Configuration
  static const String razorpayKeyId = 'rzp_live_ClCu3iwRLchrGu';
  
  // Wallet Configuration
  static const double minTopup = 100;
  static const double maxTopup = 100000;
  
  // Referral Configuration
  static const double referrerBonusAmount = 500; // paise
  static const double referredBonusAmount = 300;
}
```

---

## Step 2: Network Layer

### lib/core/network/api_client.dart
```dart
import 'package:http/http.dart' as http;
import 'dart:convert';
import '../storage/secure_storage.dart';
import '../config/app_config.dart';

class ApiClient {
  final http.Client _httpClient;
  final SecureStorage _storage;
  
  ApiClient(this._httpClient, this._storage);
  
  Future<Map<String, String>> _getHeaders() async {
    final token = await _storage.getToken();
    return {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      if (token != null) 'Authorization': 'Bearer $token',
    };
  }
  
  Future<dynamic> get(String endpoint) async {
    try {
      final headers = await _getHeaders();
      final response = await _httpClient
          .get(
            Uri.parse('${AppConfig.apiBaseUrl}$endpoint'),
            headers: headers,
          )
          .timeout(Duration(seconds: 30));
      
      return _handleResponse(response);
    } catch (e) {
      throw ApiException('Network error: $e');
    }
  }
  
  Future<dynamic> post(String endpoint, Map<String, dynamic> body) async {
    try {
      final headers = await _getHeaders();
      final response = await _httpClient
          .post(
            Uri.parse('${AppConfig.apiBaseUrl}$endpoint'),
            headers: headers,
            body: jsonEncode(body),
          )
          .timeout(Duration(seconds: 30));
      
      return _handleResponse(response);
    } catch (e) {
      throw ApiException('Network error: $e');
    }
  }
  
  dynamic _handleResponse(http.Response response) {
    if (response.statusCode == 200 || response.statusCode == 201) {
      return jsonDecode(response.body);
    } else if (response.statusCode == 401) {
      // Token expired - trigger re-login
      throw AuthException('Unauthorized');
    } else {
      final error = jsonDecode(response.body);
      throw ApiException(error['message'] ?? 'Request failed');
    }
  }
}

class ApiException implements Exception {
  final String message;
  ApiException(this.message);
}

class AuthException implements Exception {
  final String message;
  AuthException(this.message);
}
```

---

## Step 3: Models

### lib/features/auth/models/user_model.dart
```dart
class User {
  final int id;
  final String name;
  final String email;
  final String? phone;
  final String? avatarUrl;
  final double walletBalance;
  final String referralCode;
  final String? kycStatus;
  final Map<String, dynamic>? preferences;
  
  User({
    required this.id,
    required this.name,
    required this.email,
    this.phone,
    this.avatarUrl,
    required this.walletBalance,
    required this.referralCode,
    this.kycStatus,
    this.preferences,
  });
  
  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'],
      name: json['name'],
      email: json['email'],
      phone: json['phone'],
      avatarUrl: json['avatar_url'],
      walletBalance: (json['wallet_balance'] ?? 0).toDouble(),
      referralCode: json['referral_code'],
      kycStatus: json['kyc_status'],
      preferences: json['preferences'],
    );
  }
}
```

### lib/features/catalog/models/product_model.dart
```dart
class Product {
  final int id;
  final String name;
  final String slug;
  final String description;
  final double price;
  final double? discountPercent;
  final int stockQuantity;
  final String? sku;
  final double? rating;
  final int? reviewCount;
  final String? imageUrl;
  final int? categoryId;
  
  Product({
    required this.id,
    required this.name,
    required this.slug,
    required this.description,
    required this.price,
    this.discountPercent,
    required this.stockQuantity,
    this.sku,
    this.rating,
    this.reviewCount,
    this.imageUrl,
    this.categoryId,
  });
  
  double get finalPrice => price * (1 - (discountPercent ?? 0) / 100);
  
  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'],
      name: json['name'],
      slug: json['slug'],
      description: json['description'],
      price: (json['price'] ?? 0).toDouble(),
      discountPercent: (json['discount_percent'] ?? 0).toDouble(),
      stockQuantity: json['stock_quantity'],
      sku: json['sku'],
      rating: json['rating']?.toDouble(),
      reviewCount: json['review_count'],
      imageUrl: json['image_url'],
      categoryId: json['category_id'],
    );
  }
}
```

---

## Step 4: State Management (Provider)

### lib/features/auth/providers/auth_provider.dart
```dart
import 'package:flutter/material.dart';
import '../models/user_model.dart';
import '../../../core/network/api_client.dart';
import '../../../core/storage/secure_storage.dart';

class AuthProvider with ChangeNotifier {
  final ApiClient _apiClient;
  final SecureStorage _storage;
  
  User? _user;
  String? _token;
  bool _isLoading = false;
  String? _error;
  
  AuthProvider(this._apiClient, this._storage);
  
  User? get user => _user;
  String? get token => _token;
  bool get isLoading => _isLoading;
  String? get error => _error;
  bool get isAuthenticated => _token != null;
  
  Future<bool> login(String email, String password) async {
    try {
      _isLoading = true;
      _error = null;
      notifyListeners();
      
      final response = await _apiClient.post('/auth/login', {
        'email': email,
        'password': password,
      });
      
      if (response['success']) {
        _token = response['data']['token'];
        _user = User.fromJson(response['data']['user']);
        await _storage.saveToken(_token!);
        notifyListeners();
        return true;
      }
      
      _error = response['message'];
      return false;
    } catch (e) {
      _error = e.toString();
      return false;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }
  
  Future<bool> register(Map<String, dynamic> data) async {
    try {
      _isLoading = true;
      _error = null;
      notifyListeners();
      
      final response = await _apiClient.post('/auth/register', data);
      
      if (response['success']) {
        _token = response['data']['token'];
        _user = User.fromJson(response['data']['user']);
        await _storage.saveToken(_token!);
        notifyListeners();
        return true;
      }
      
      _error = response['message'];
      return false;
    } catch (e) {
      _error = e.toString();
      return false;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }
  
  Future<void> logout() async {
    try {
      await _apiClient.post('/auth/logout', {});
    } catch (_) {}
    
    _user = null;
    _token = null;
    await _storage.clearToken();
    notifyListeners();
  }
  
  Future<bool> initializeAuth() async {
    _token = await _storage.getToken();
    if (_token != null) {
      try {
        final response = await _apiClient.get('/auth/me');
        if (response['success']) {
          _user = User.fromJson(response['data']);
          notifyListeners();
          return true;
        }
      } catch (_) {
        await logout();
      }
    }
    notifyListeners();
    return false;
  }
}
```

### lib/features/cart/providers/cart_provider.dart
```dart
import 'package:flutter/material.dart';

class CartItem {
  final int productId;
  final String productName;
  final double price;
  int quantity;
  final String? imageUrl;
  
  CartItem({
    required this.productId,
    required this.productName,
    required this.price,
    required this.quantity,
    this.imageUrl,
  });
  
  double get subtotal => price * quantity;
}

class CartProvider with ChangeNotifier {
  final List<CartItem> _items = [];
  double _tax = 0;
  double _discount = 0;
  String? _couponCode;
  
  List<CartItem> get items => _items;
  int get itemCount => _items.fold(0, (sum, item) => sum + item.quantity);
  double get subtotal => _items.fold(0, (sum, item) => sum + item.subtotal);
  double get tax => _tax;
  double get discount => _discount;
  double get total => (subtotal + _tax - _discount).clamp(0, double.infinity);
  String? get couponCode => _couponCode;
  
  void addItem(CartItem item) {
    final existingIndex = _items.indexWhere((i) => i.productId == item.productId);
    
    if (existingIndex >= 0) {
      _items[existingIndex].quantity += item.quantity;
    } else {
      _items.add(item);
    }
    
    _calculateTax();
    notifyListeners();
  }
  
  void updateQuantity(int productId, int quantity) {
    final index = _items.indexWhere((i) => i.productId == productId);
    if (index >= 0) {
      if (quantity <= 0) {
        _items.removeAt(index);
      } else {
        _items[index].quantity = quantity;
      }
      _calculateTax();
      notifyListeners();
    }
  }
  
  void removeItem(int productId) {
    _items.removeWhere((i) => i.productId == productId);
    _calculateTax();
    notifyListeners();
  }
  
  void applyCoupon(String code, double discountAmount) {
    _couponCode = code;
    _discount = discountAmount;
    notifyListeners();
  }
  
  void removeCoupon() {
    _couponCode = null;
    _discount = 0;
    notifyListeners();
  }
  
  void clearCart() {
    _items.clear();
    _tax = 0;
    _discount = 0;
    _couponCode = null;
    notifyListeners();
  }
  
  void _calculateTax() {
    _tax = subtotal * 0.18; // 18% GST
  }
}
```

---

## Step 5: Key Screens

### lib/features/home/screens/home_screen.dart
```dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../../core/theme/colors.dart';
import '../widgets/banner_carousel.dart';
import '../widgets/category_grid.dart';
import '../widgets/featured_products.dart';
import '../widgets/quick_services.dart';
import '../providers/home_provider.dart';

class HomeScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        children: [
          // Search Bar
          Padding(
            padding: EdgeInsets.all(16),
            child: GestureDetector(
              onTap: () => Navigator.pushNamed(context, '/search'),
              child: Container(
                decoration: BoxDecoration(
                  color: Colors.grey[100],
                  borderRadius: BorderRadius.circular(10),
                  border: Border.all(color: Colors.grey[300]!),
                ),
                padding: EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                child: Row(
                  children: [
                    Icon(Icons.search, color: Colors.grey[600]),
                    SizedBox(width: 12),
                    Expanded(
                      child: Text(
                        'Search for products...',
                        style: TextStyle(color: Colors.grey[600]),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
          
          // Banners
          BannerCarousel(),
          
          // Categories
          Padding(
            padding: EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  'Shop by Category',
                  style: Theme.of(context).textTheme.titleLarge,
                ),
                SizedBox(height: 12),
                CategoryGrid(),
              ],
            ),
          ),
          
          // Quick Services
          Padding(
            padding: EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  'Quick Services',
                  style: Theme.of(context).textTheme.titleLarge,
                ),
                SizedBox(height: 12),
                QuickServices(),
              ],
            ),
          ),
          
          // Featured Products
          Padding(
            padding: EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      'Featured Products',
                      style: Theme.of(context).textTheme.titleLarge,
                    ),
                    TextButton(
                      onPressed: () => Navigator.pushNamed(context, '/products'),
                      child: Text('View All'),
                    ),
                  ],
                ),
                SizedBox(height: 12),
                FeaturedProducts(),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
```

### lib/features/search/screens/search_screen.dart
```dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../widgets/search_bar.dart';
import '../widgets/search_filters.dart';
import '../widgets/search_results.dart';
import '../providers/search_provider.dart';

class SearchScreen extends StatefulWidget {
  @override
  State<SearchScreen> createState() => _SearchScreenState();
}

class _SearchScreenState extends State<SearchScreen> {
  late TextEditingController _searchController;
  
  @override
  void initState() {
    super.initState();
    _searchController = TextEditingController();
  }
  
  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Search'),
        elevation: 0,
      ),
      body: Column(
        children: [
          // Search Bar
          SearchBar(controller: _searchController),
          
          // Filters
          SearchFilters(),
          
          // Results
          Expanded(
            child: Consumer<SearchProvider>(
              builder: (context, provider, _) {
                if (provider.isLoading) {
                  return Center(child: CircularProgressIndicator());
                }
                
                if (provider.error != null) {
                  return Center(child: Text(provider.error!));
                }
                
                return SearchResults(products: provider.results);
              },
            ),
          ),
        ],
      ),
    );
  }
}
```

### lib/features/wallet/screens/wallet_screen.dart
```dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/wallet_provider.dart';

class WalletScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('My Wallet')),
      body: Consumer<WalletProvider>(
        builder: (context, provider, _) {
          return SingleChildScrollView(
            child: Column(
              children: [
                // Wallet Balance Card
                Container(
                  margin: EdgeInsets.all(16),
                  padding: EdgeInsets.all(24),
                  decoration: BoxDecoration(
                    gradient: LinearGradient(
                      colors: [Colors.blue[400]!, Colors.blue[800]!],
                    ),
                    borderRadius: BorderRadius.circular(16),
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Wallet Balance',
                        style: TextStyle(color: Colors.white70),
                      ),
                      SizedBox(height: 8),
                      Text(
                        '₹${provider.balance.toStringAsFixed(2)}',
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 32,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ],
                  ),
                ),
                
                // Action Buttons
                Padding(
                  padding: EdgeInsets.all(16),
                  child: Row(
                    children: [
                      Expanded(
                        child: ElevatedButton(
                          onPressed: () => Navigator.pushNamed(context, '/wallet/topup'),
                          child: Text('Add Money'),
                        ),
                      ),
                      SizedBox(width: 12),
                      Expanded(
                        child: ElevatedButton(
                          onPressed: () => Navigator.pushNamed(context, '/wallet/send'),
                          child: Text('Send Money'),
                        ),
                      ),
                    ],
                  ),
                ),
                
                // Transaction History
                Padding(
                  padding: EdgeInsets.all(16),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Recent Transactions',
                        style: Theme.of(context).textTheme.titleLarge,
                      ),
                      SizedBox(height: 12),
                      ListView.builder(
                        shrinkWrap: true,
                        physics: NeverScrollableScrollPhysics(),
                        itemCount: provider.transactions.length,
                        itemBuilder: (context, index) {
                          final transaction = provider.transactions[index];
                          return ListTile(
                            title: Text(transaction.description),
                            subtitle: Text(transaction.date),
                            trailing: Text(
                              '₹${transaction.amount}',
                              style: TextStyle(
                                color: transaction.type == 'credit' ? Colors.green : Colors.red,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          );
                        },
                      ),
                    ],
                  ),
                ),
              ],
            ),
          );
        },
      ),
    );
  }
}
```

---

## Step 6: Bottom Navigation (Main App Shell)

### lib/app.dart
```dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'features/home/screens/home_screen.dart';
import 'features/search/screens/search_screen.dart';
import 'features/cart/screens/cart_screen.dart';
import 'features/wallet/screens/wallet_screen.dart';
import 'features/profile/screens/profile_screen.dart';

class AddMagProApp extends StatefulWidget {
  @override
  State<AddMagProApp> createState() => _AddMagProAppState();
}

class _AddMagProAppState extends State<AddMagProApp> {
  int _selectedIndex = 0;
  
  final List<Widget> _screens = [
    HomeScreen(),
    SearchScreen(),
    CartScreen(),
    WalletScreen(),
    ProfileScreen(),
  ];
  
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'AddMagPro',
      theme: ThemeData(
        useMaterial3: true,
        primarySwatch: Colors.blue,
      ),
      home: Scaffold(
        body: _screens[_selectedIndex],
        bottomNavigationBar: BottomNavigationBar(
          currentIndex: _selectedIndex,
          onTap: (index) => setState(() => _selectedIndex = index),
          items: [
            BottomNavigationBarItem(
              icon: Icon(Icons.home),
              label: 'Home',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.search),
              label: 'Search',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.shopping_cart),
              label: 'Cart',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.wallet),
              label: 'Wallet',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.person),
              label: 'Profile',
            ),
          ],
        ),
      ),
    );
  }
}
```

---

## Step 7: Complete Setup Instructions

### 1. Install Dependencies
```bash
cd mobile-apps/addmagpro_mobile
flutter pub get
```

### 2. Configure API Base URL
Update `lib/core/config/app_config.dart` with your backend URL:
```dart
static const String apiBaseUrl = 'http://your-domain.com/api/v1';
```

### 3. Generate Models (if using freezed/json_serializable)
```bash
flutter pub run build_runner build --delete-conflicting-outputs
```

### 4. Run the App
```bash
flutter run
```

---

## Complete Screens to Build (15 Total)

### Authentication (3)
- ✅ Login Screen
- ✅ Register Screen
- ✅ Forgot Password Screen

### Main App (5)
- ✅ Home Screen (Dashboard)
- ✅ Search Screen (Text/Voice/Barcode)
- ✅ Catalog/Products List Screen
- ✅ Product Detail Screen
- ✅ Wishlist Screen

### Shopping (3)
- ✅ Cart Screen
- ✅ Checkout Screen (Address)
- ✅ Payment Screen (Razorpay)

### Account (4)
- ✅ Orders List Screen
- ✅ Order Detail/Track Screen
- ✅ Wallet Screen
- ✅ Profile/Settings Screen

### Referral (1)
- ✅ Referral Screen

---

## Integration Checklist

- [ ] Implement Auth Flow (Login/Register/Token Refresh)
- [ ] Implement Home Dashboard with all widgets
- [ ] Implement Search (Text/Voice/Barcode)
- [ ] Implement Product Catalog with filters
- [ ] Implement Shopping Cart
- [ ] Implement Razorpay Payment Integration
- [ ] Implement Wallet (Topup/Send Money/Transactions)
- [ ] Implement Referral System
- [ ] Implement Order Management (List/Detail/Track)
- [ ] Implement User Profile & Settings
- [ ] Implement Push Notifications (Firebase)
- [ ] Add Offline Support (Hive/SQLite)
- [ ] Implement Image Caching
- [ ] Add Error Handling & Logging
- [ ] Implement Theme Switching (Light/Dark)
- [ ] Add Loading & Error States
- [ ] Test all API integrations

---

Generated: May 25, 2026
