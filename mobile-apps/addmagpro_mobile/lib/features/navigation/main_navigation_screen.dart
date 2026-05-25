import 'package:flutter/material.dart';

import '../../app_state.dart';
import '../account/presentation/account_screen.dart';
import '../cart/presentation/cart_screen.dart';
import '../catalog/presentation/catalog_screen.dart';
import '../home/home_screen.dart';
import '../wishlist/presentation/wishlist_screen.dart';

class MainNavigationScreen extends StatefulWidget {
  final String token;
  final AppState appState;

  const MainNavigationScreen({
    super.key,
    required this.token,
    required this.appState,
  });

  @override
  State<MainNavigationScreen> createState() => _MainNavigationScreenState();
}

class _MainNavigationScreenState extends State<MainNavigationScreen> {
  int _selectedIndex = 0;

  late final List<Widget> _pages;

  @override
  void initState() {
    super.initState();
    _pages = [
      HomeScreen(appState: widget.appState),
      CatalogScreen(token: widget.token),
      CartScreen(token: widget.token, appState: widget.appState),
      WishlistScreen(token: widget.token),
      AccountScreen(appState: widget.appState),
    ];
  }

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _pages[_selectedIndex],
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _selectedIndex,
        onTap: _onItemTapped,
        type: BottomNavigationBarType.fixed,
        items: const [
          BottomNavigationBarItem(icon: Icon(Icons.home), label: 'Home'),
          BottomNavigationBarItem(
            icon: Icon(Icons.shopping_bag),
            label: 'Shop',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.shopping_cart),
            label: 'Cart',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.favorite),
            label: 'Wishlist',
          ),
          BottomNavigationBarItem(icon: Icon(Icons.person), label: 'Account'),
        ],
      ),
    );
  }
}
