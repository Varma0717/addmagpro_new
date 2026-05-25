import 'package:flutter/material.dart';

import '../../../core/network/api_client.dart';
import '../models/product_model.dart';

class ProductRepository {
  final ApiClient _apiClient;

  ProductRepository({required ApiClient apiClient}) : _apiClient = apiClient;

  Future<List<ProductModel>> getProducts({
    String? token,
    int page = 1,
    int limit = 20,
    String? category,
    double? minPrice,
    double? maxPrice,
    String? sortBy,
  }) async {
    try {
      final params = <String, dynamic>{
        'page': page,
        'limit': limit,
        'category': ?category,
        'min_price': ?minPrice,
        'max_price': ?maxPrice,
        'sort_by': ?sortBy,
      };

      final queryString = params.entries
          .map((e) => '${e.key}=${e.value}')
          .join('&');

      final response = await _apiClient.get(
        '/products?$queryString',
        bearerToken: token,
      );

      final data = response['data'] as List?;
      return (data ?? [])
          .map((e) => ProductModel.fromJson(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      debugPrint('Error fetching products: $e');
      rethrow;
    }
  }

  Future<ProductModel> getProductDetail({
    required String productSlug,
    String? token,
  }) async {
    try {
      final response = await _apiClient.get(
        '/products/$productSlug',
        bearerToken: token,
      );

      return ProductModel.fromJson(response['data'] as Map<String, dynamic>);
    } catch (e) {
      debugPrint('Error fetching product detail: $e');
      rethrow;
    }
  }

  Future<List<ProductModel>> searchProducts({
    required String query,
    String? token,
    int page = 1,
  }) async {
    try {
      final response = await _apiClient.get(
        '/search/products?query=$query&page=$page',
        bearerToken: token,
      );

      final data = response['data'] as List?;
      return (data ?? [])
          .map((e) => ProductModel.fromJson(e as Map<String, dynamic>))
          .toList();
    } catch (e) {
      debugPrint('Error searching products: $e');
      rethrow;
    }
  }

  Future<List<String>> getProductCategories({String? token}) async {
    try {
      final response = await _apiClient.get(
        '/products/categories',
        bearerToken: token,
      );

      final data = response['data'] as List?;
      return (data ?? []).map((e) => e.toString()).toList();
    } catch (e) {
      debugPrint('Error fetching categories: $e');
      rethrow;
    }
  }

  Future<Map<String, dynamic>> getPriceRange({String? token}) async {
    try {
      final response = await _apiClient.get(
        '/products/price-range',
        bearerToken: token,
      );

      return response['data'] as Map<String, dynamic>;
    } catch (e) {
      debugPrint('Error fetching price range: $e');
      rethrow;
    }
  }
}
