import 'dart:async';

import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:mobile_scanner/mobile_scanner.dart';
import 'package:shimmer/shimmer.dart';
import 'package:speech_to_text/speech_to_text.dart' as stt;
import 'package:smooth_page_indicator/smooth_page_indicator.dart';

import '../../app_state.dart';
import '../../core/network/api_client.dart';
import '../../core/theme/app_theme.dart';
import '../../core/widgets/app_widgets.dart';
import '../account/presentation/account_screen.dart';
import '../catalog/presentation/categories_screen.dart';
import '../catalog/presentation/listing_detail_screen.dart';
import '../catalog/presentation/listing_list_screen.dart';
import '../catalog/presentation/product_detail_screen.dart';
import '../catalog/presentation/product_list_screen.dart';
import '../cart/presentation/cart_screen.dart';
import '../wallet/presentation/wallet_screen.dart';
import '../wishlist/presentation/wishlist_screen.dart';
import 'data/home_repository.dart';
import 'models/home_feed_models.dart';
import '../notifications/presentation/notifications_screen.dart';
import '../referral/data/referral_repository.dart';
import '../referral/models/referral_models.dart';
import '../search/presentation/search_screen.dart';
import '../location/services/geo_location_service.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key, required this.appState});

  final AppState appState;

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  int _currentIndex = 0;
  int? _selectedStateId;
  int? _selectedDistrictId;
  String? _selectedLocationLabel;
  bool _locationBusy = false;
  final HomeRepository _repository = HomeRepository(apiClient: ApiClient());

  @override
  Widget build(BuildContext context) {
    final token = widget.appState.token;
    if (token == null) return const SizedBox.shrink();

    final pages = <Widget>[
      _DashboardView(
        appState: widget.appState,
        token: token,
        stateId: _selectedStateId,
        districtId: _selectedDistrictId,
      ),
      CategoriesScreen(appState: widget.appState, token: token),
      CartScreen(token: token, appState: widget.appState),
      WishlistScreen(token: token),
      AccountScreen(appState: widget.appState),
    ];

    return Scaffold(
      appBar: _currentIndex == 0
          ? AppBar(
              title: Row(
                children: [
                  Container(
                    width: 34,
                    height: 34,
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(10),
                      border: Border.all(color: AppColors.borderLight),
                    ),
                    child: ClipRRect(
                      borderRadius: BorderRadius.circular(10),
                      child: Image.asset(
                        'assets/branding/logo_square.png',
                        fit: BoxFit.cover,
                      ),
                    ),
                  ),
                  const SizedBox(width: 10),
                  Expanded(
                    child: Row(
                      children: [
                        const Flexible(
                          child: Text(
                            'AddMagPro',
                            overflow: TextOverflow.ellipsis,
                          ),
                        ),
                        const SizedBox(width: 8),
                        Flexible(child: _buildLocationChip(context)),
                      ],
                    ),
                  ),
                ],
              ),
              actions: [
                Padding(
                  padding: const EdgeInsets.symmetric(vertical: 10),
                  child: _buildWalletChip(context),
                ),
                IconButton(
                  onPressed: () => Navigator.of(context).push(
                    MaterialPageRoute<void>(
                      builder: (_) => NotificationsScreen(token: token),
                    ),
                  ),
                  icon: const Icon(Icons.notifications_outlined),
                ),
              ],
            )
          : AppBar(title: Text(_titleForIndex(_currentIndex))),
      body: IndexedStack(index: _currentIndex, children: pages),
      bottomNavigationBar: Container(
        decoration: BoxDecoration(
          boxShadow: [
            BoxShadow(
              color: Colors.black.withAlpha(8),
              blurRadius: 10,
              offset: const Offset(0, -2),
            ),
          ],
        ),
        child: NavigationBar(
          selectedIndex: _currentIndex,
          onDestinationSelected: (index) =>
              setState(() => _currentIndex = index),
          destinations: const [
            NavigationDestination(
              icon: Icon(Icons.home_outlined),
              selectedIcon: Icon(Icons.home_rounded),
              label: 'Home',
            ),
            NavigationDestination(
              icon: Icon(Icons.category_outlined),
              selectedIcon: Icon(Icons.category_rounded),
              label: 'Categories',
            ),
            NavigationDestination(
              icon: Icon(Icons.shopping_bag_outlined),
              selectedIcon: Icon(Icons.shopping_bag_rounded),
              label: 'Cart',
            ),
            NavigationDestination(
              icon: Icon(Icons.favorite_outline_rounded),
              selectedIcon: Icon(Icons.favorite_rounded),
              label: 'Wishlist',
            ),
            NavigationDestination(
              icon: Icon(Icons.person_outline_rounded),
              selectedIcon: Icon(Icons.person_rounded),
              label: 'Account',
            ),
          ],
        ),
      ),
    );
  }

  String _titleForIndex(int index) {
    switch (index) {
      case 1:
        return 'Categories';
      case 2:
        return 'My Cart';
      case 3:
        return 'Wishlist';
      case 4:
        return 'My Account';
      default:
        return 'AddMagPro';
    }
  }

  Widget _buildLocationChip(BuildContext context) {
    final width = MediaQuery.of(context).size.width;
    final compact = width < 380;
    final label = _selectedLocationLabel ?? 'All India';
    return ActionChip(
      avatar: Icon(
        Icons.location_on_outlined,
        size: compact ? 14 : 16,
        color: AppColors.primary,
      ),
      label: Text(
        compact ? _compactLocationLabel(label) : label,
        overflow: TextOverflow.ellipsis,
      ),
      labelStyle: TextStyle(
        fontSize: compact ? 11 : 12,
        color: AppColors.textPrimary,
        fontWeight: FontWeight.w600,
      ),
      onPressed: _locationBusy ? null : _openLocationSheet,
      padding: EdgeInsets.symmetric(
        horizontal: compact ? 6 : 8,
        vertical: compact ? 0 : 2,
      ),
      side: BorderSide(color: AppColors.primary.withAlpha(40)),
      backgroundColor: AppColors.primaryLight,
    );
  }

  Widget _buildWalletChip(BuildContext context) {
    final width = MediaQuery.of(context).size.width;
    final compact = width < 380;
    final wallet = widget.appState.currentUser?.walletBalance;
    final walletLabel = wallet == null
        ? 'Wallet --'
        : '₹${wallet.toStringAsFixed(2)}';

    return InkWell(
      borderRadius: BorderRadius.circular(20),
      onTap: () => Navigator.of(context).push(
        MaterialPageRoute<void>(
          builder: (_) => WalletScreen(
            token: widget.appState.token ?? '',
            appState: widget.appState,
          ),
        ),
      ),
      child: Container(
        margin: const EdgeInsets.only(right: 4),
        padding: EdgeInsets.symmetric(
          horizontal: compact ? 8 : 10,
          vertical: compact ? 6 : 7,
        ),
        decoration: BoxDecoration(
          color: AppColors.primaryLight,
          borderRadius: BorderRadius.circular(20),
          border: Border.all(color: AppColors.primary.withAlpha(40)),
        ),
        child: Row(
          mainAxisSize: MainAxisSize.min,
          children: [
            const Icon(
              Icons.account_balance_wallet_outlined,
              size: 15,
              color: AppColors.primary,
            ),
            if (!compact) ...[
              const SizedBox(width: 4),
              Text(
                walletLabel,
                style: const TextStyle(
                  fontSize: 12,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ],
        ),
      ),
    );
  }

  String _compactLocationLabel(String label) {
    final parts = label.split(',');
    return parts.first.trim();
  }

  Future<void> _openLocationSheet() async {
    setState(() => _locationBusy = true);
    try {
      final states = await _repository.fetchStates(
        token: widget.appState.token,
      );
      if (!mounted) return;
      final result = await showModalBottomSheet<_LocationSelection>(
        context: context,
        isScrollControlled: true,
        builder: (_) => _LocationPickerSheet(
          repository: _repository,
          token: widget.appState.token,
          states: states,
          initialStateId: _selectedStateId,
          initialDistrictId: _selectedDistrictId,
        ),
      );
      if (result == null || !mounted) return;
      setState(() {
        _selectedStateId = result.stateId;
        _selectedDistrictId = result.districtId;
        _selectedLocationLabel = result.label;
      });
    } catch (_) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text(
            'Location options unavailable right now. Showing all locations.',
          ),
        ),
      );
    } finally {
      if (mounted) setState(() => _locationBusy = false);
    }
  }
}

// ── Dashboard View ──────────────────────────────────────────────────

class _DashboardView extends StatefulWidget {
  const _DashboardView({
    required this.appState,
    required this.token,
    this.stateId,
    this.districtId,
  });
  final AppState appState;
  final String token;
  final int? stateId;
  final int? districtId;

  @override
  State<_DashboardView> createState() => _DashboardViewState();
}

class _DashboardViewState extends State<_DashboardView> {
  late final HomeRepository _repository;
  late final ReferralRepository _referralRepository;
  final PageController _bannerController = PageController();
  final PageController _promoController = PageController();
  final stt.SpeechToText _speech = stt.SpeechToText();
  Timer? _bannerTimer;
  Timer? _promoTimer;
  bool _loading = true;
  String? _error;
  HomeFeed? _feed;
  ReferralResponse? _referralData;

  @override
  void initState() {
    super.initState();
    final apiClient = ApiClient();
    _repository = HomeRepository(apiClient: apiClient);
    _referralRepository = ReferralRepository(apiClient: apiClient);
    _tryAutoDetectLocation();
    _load();
  }

  /// Try to auto-detect user's current location
  Future<void> _tryAutoDetectLocation() async {
    try {
      final position = await GeoLocationService.getCurrentLocation();
      if (position != null && mounted) {
        // Location detected successfully
        // Can be used in _load() for location-based results
      }
    } catch (e) {
      // Silently fail - user will still see all locations
    }
  }

  @override
  void didUpdateWidget(covariant _DashboardView oldWidget) {
    super.didUpdateWidget(oldWidget);
    if (oldWidget.stateId != widget.stateId ||
        oldWidget.districtId != widget.districtId) {
      _load();
    }
  }

  @override
  void dispose() {
    _bannerTimer?.cancel();
    _promoTimer?.cancel();
    _bannerController.dispose();
    _promoController.dispose();
    super.dispose();
  }

  void _openSearch({String? query}) {
    Navigator.of(context).push(
      MaterialPageRoute<void>(
        builder: (_) => SearchScreen(
          appState: widget.appState,
          token: widget.token,
          initialQuery: query,
        ),
      ),
    );
  }

  Future<void> _startVoiceSearch() async {
    final available = await _speech.initialize();
    if (!available) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Voice search is unavailable on this device.'),
        ),
      );
      return;
    }

    String spokenText = '';
    await _speech.listen(
      onResult: (result) {
        spokenText = result.recognizedWords;
      },
    );

    await Future<void>.delayed(const Duration(seconds: 2));
    await _speech.stop();
    if (!mounted) return;

    if (spokenText.trim().length >= 2) {
      _openSearch(query: spokenText.trim());
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Could not detect enough voice input.')),
      );
    }
  }

  Future<void> _startBarcodeScan() async {
    bool handled = false;
    await showModalBottomSheet<void>(
      context: context,
      isScrollControlled: true,
      builder: (_) => SizedBox(
        height: MediaQuery.of(context).size.height * 0.72,
        child: MobileScanner(
          onDetect: (capture) {
            if (handled) return;
            final code = capture.barcodes.isNotEmpty
                ? (capture.barcodes.first.rawValue ?? '').trim()
                : '';
            if (code.isEmpty) return;
            handled = true;
            Navigator.of(context).pop();
            _openSearch(query: code);
          },
        ),
      ),
    );
  }

  Future<void> _load() async {
    setState(() {
      _loading = true;
      _error = null;
    });
    try {
      final response = await _repository.fetch(
        token: widget.token,
        stateId: widget.stateId,
        districtId: widget.districtId,
      );
      ReferralResponse? referralData;
      try {
        referralData = await _referralRepository.fetch(widget.token);
      } catch (_) {
        referralData = null;
      }
      if (!mounted) return;
      setState(() {
        _feed = response;
        _referralData = referralData;
      });
      _startBannerAutoScroll();
    } catch (error) {
      if (!mounted) return;
      setState(() => _error = error.toString());
    } finally {
      if (mounted) setState(() => _loading = false);
    }
  }

  void _startBannerAutoScroll() {
    _bannerTimer?.cancel();
    final banners = _feed?.banners ?? [];
    if (banners.length <= 1) return;
    _bannerTimer = Timer.periodic(const Duration(seconds: 4), (_) {
      if (!mounted || !_bannerController.hasClients) return;
      final next =
          ((_bannerController.page?.round() ?? 0) + 1) % banners.length;
      _bannerController.animateToPage(
        next,
        duration: const Duration(milliseconds: 400),
        curve: Curves.easeInOut,
      );
    });
  }

  void _startPromoAutoScroll(int itemCount) {
    _promoTimer?.cancel();
    if (itemCount <= 1) return;

    _promoTimer = Timer.periodic(const Duration(seconds: 3), (_) {
      if (!mounted || !_promoController.hasClients) return;
      final next = ((_promoController.page?.round() ?? 0) + 1) % itemCount;
      _promoController.animateToPage(
        next,
        duration: const Duration(milliseconds: 450),
        curve: Curves.easeInOut,
      );
    });
  }

  @override
  Widget build(BuildContext context) {
    if (_loading) return _buildShimmer();

    if (_error != null) {
      return Center(
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            const Icon(
              Icons.wifi_off_rounded,
              size: 48,
              color: AppColors.textMuted,
            ),
            const SizedBox(height: 12),
            Text(
              _error!,
              style: const TextStyle(color: AppColors.textMuted),
              textAlign: TextAlign.center,
            ),
            const SizedBox(height: 16),
            FilledButton.tonal(onPressed: _load, child: const Text('Retry')),
          ],
        ),
      );
    }

    final feed = _feed!;
    final user = widget.appState.currentUser;
    final validBannerImages = feed.banners
        .where((banner) => (banner.imageUrl ?? '').trim().isNotEmpty)
        .toList(growable: false);
    final fallbackBannerImages = feed.featuredProducts
        .where((product) => (product.primaryImageUrl ?? '').trim().isNotEmpty)
        .map(
          (product) => HomeBannerItem(
            id: product.id,
            title: product.name,
            subtitle: product.category,
            imageUrl: product.primaryImageUrl,
            linkType: 'product',
            linkValue: product.slug,
          ),
        )
        .toList(growable: false);
    final bannerItems = validBannerImages.isNotEmpty
        ? validBannerImages
        : fallbackBannerImages;
    _startPromoAutoScroll(bannerItems.length);

    return RefreshIndicator(
      color: AppColors.primary,
      onRefresh: _load,
      child: ListView(
        padding: EdgeInsets.zero,
        children: [
          Padding(
            padding: const EdgeInsets.fromLTRB(16, 12, 16, 0),
            child: Row(
              children: [
                Expanded(
                  child: InkWell(
                    borderRadius: BorderRadius.circular(14),
                    onTap: () => _openSearch(),
                    child: Container(
                      height: 48,
                      padding: const EdgeInsets.symmetric(horizontal: 12),
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(14),
                        border: Border.all(color: AppColors.borderLight),
                      ),
                      child: const Row(
                        children: [
                          Icon(
                            Icons.search_rounded,
                            color: AppColors.textMuted,
                          ),
                          SizedBox(width: 8),
                          Expanded(
                            child: Text(
                              'Search products and services',
                              style: TextStyle(color: AppColors.textMuted),
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                ),
                const SizedBox(width: 10),
                _QuickActionIcon(
                  icon: Icons.mic_none_rounded,
                  onTap: _startVoiceSearch,
                ),
                const SizedBox(width: 8),
                _QuickActionIcon(
                  icon: Icons.qr_code_scanner_rounded,
                  onTap: _startBarcodeScan,
                ),
              ],
            ),
          ),

          const SizedBox(height: 16),

          // ── Banner Carousel ──
          if (bannerItems.isNotEmpty) ...[
            SizedBox(
              height: 180,
              child: Stack(
                children: [
                  PageView.builder(
                    controller: _bannerController,
                    itemCount: bannerItems.length,
                    itemBuilder: (_, index) {
                      final banner = bannerItems[index];
                      return Container(
                        margin: const EdgeInsets.symmetric(
                          horizontal: 16,
                          vertical: 8,
                        ),
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(20),
                          boxShadow: [
                            BoxShadow(
                              color: Colors.black.withAlpha(15),
                              blurRadius: 12,
                              offset: const Offset(0, 4),
                            ),
                          ],
                        ),
                        child: ClipRRect(
                          borderRadius: BorderRadius.circular(20),
                          child:
                              (banner.imageUrl != null &&
                                  banner.imageUrl!.isNotEmpty)
                              ? CachedNetworkImage(
                                  imageUrl: banner.imageUrl!,
                                  fit: BoxFit.cover,
                                  errorWidget: (_, _, _) =>
                                      _bannerPlaceholder(),
                                )
                              : _bannerPlaceholder(),
                        ),
                      );
                    },
                  ),
                  if (bannerItems.length > 1)
                    Positioned(
                      bottom: 16,
                      left: 0,
                      right: 0,
                      child: Center(
                        child: SmoothPageIndicator(
                          controller: _bannerController,
                          count: bannerItems.length,
                          effect: const WormEffect(
                            dotWidth: 7,
                            dotHeight: 7,
                            activeDotColor: Colors.white,
                            dotColor: Colors.white38,
                            spacing: 6,
                          ),
                        ),
                      ),
                    ),
                ],
              ),
            ),
          ],

          const SizedBox(height: 8),

          // ── Welcome Card ──
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: Container(
              padding: const EdgeInsets.all(18),
              decoration: BoxDecoration(
                gradient: AppColors.primaryGradient,
                borderRadius: BorderRadius.circular(20),
                boxShadow: [
                  BoxShadow(
                    color: AppColors.primary.withAlpha(40),
                    blurRadius: 16,
                    offset: const Offset(0, 6),
                  ),
                ],
              ),
              child: Row(
                children: [
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          'Hello, ${user?.name ?? 'Member'} 👋',
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 18,
                            fontWeight: FontWeight.w700,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          'Wallet: ₹${(user?.walletBalance ?? 0).toStringAsFixed(2)}',
                          style: TextStyle(
                            color: Colors.white.withAlpha(200),
                            fontSize: 14,
                          ),
                        ),
                      ],
                    ),
                  ),
                  Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 14,
                      vertical: 8,
                    ),
                    decoration: BoxDecoration(
                      color: Colors.white.withAlpha(50),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Text(
                      user?.referralCode ?? '',
                      style: const TextStyle(
                        color: Colors.white,
                        fontWeight: FontWeight.w800,
                        fontSize: 13,
                        letterSpacing: 1,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),

          const SizedBox(height: 24),

          // ── Services ──
          if (feed.services.isNotEmpty) ...[
            SectionHeader(
              title: 'Services',
              actionLabel: 'See All',
              onAction: () => Navigator.of(context).push(
                MaterialPageRoute<void>(
                  builder: (_) => ListingListScreen(
                    appState: widget.appState,
                    title: 'All Services',
                    listingType: 'service',
                  ),
                ),
              ),
              padding: const EdgeInsets.symmetric(horizontal: 16),
            ),
            const SizedBox(height: 14),
            GridView.builder(
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              padding: const EdgeInsets.symmetric(horizontal: 16),
              gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 4,
                mainAxisSpacing: 16,
                crossAxisSpacing: 12,
                childAspectRatio: 0.85,
              ),
              itemCount: feed.services.length,
              itemBuilder: (_, index) {
                final service = feed.services[index];
                return GestureDetector(
                  onTap: () {
                    Navigator.of(context).push(
                      MaterialPageRoute<void>(
                        builder: (_) =>
                            ListingDetailScreen(slug: 'service-${service.id}'),
                      ),
                    );
                  },
                  child: Column(
                    children: [
                      Container(
                        width: 60,
                        height: 60,
                        decoration: BoxDecoration(
                          color: AppColors.primaryLight,
                          borderRadius: BorderRadius.circular(14),
                          border: Border.all(
                            color: AppColors.primary.withAlpha(30),
                          ),
                        ),
                        child: service.iconUrl != null
                            ? ClipRRect(
                                borderRadius: BorderRadius.circular(14),
                                child: CachedNetworkImage(
                                  imageUrl: service.iconUrl!,
                                  fit: BoxFit.cover,
                                  errorWidget: (_, _, _) => const Icon(
                                    Icons.miscellaneous_services_rounded,
                                    color: AppColors.primary,
                                  ),
                                ),
                              )
                            : const Icon(
                                Icons.miscellaneous_services_rounded,
                                color: AppColors.primary,
                                size: 24,
                              ),
                      ),
                      const SizedBox(height: 6),
                      Text(
                        service.name,
                        maxLines: 2,
                        textAlign: TextAlign.center,
                        overflow: TextOverflow.ellipsis,
                        style: const TextStyle(
                          fontSize: 10,
                          fontWeight: FontWeight.w600,
                          color: AppColors.textPrimary,
                        ),
                      ),
                    ],
                  ),
                );
              },
            ),
            const SizedBox(height: 24),
          ],

          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: Row(
              children: [
                Expanded(
                  child: _HomeNavTile(
                    icon: Icons.store_outlined,
                    title: 'Stores',
                    color: const Color(0xFF22C55E),
                    onTap: () => Navigator.of(context).push(
                      MaterialPageRoute<void>(
                        builder: (_) => ListingListScreen(
                          appState: widget.appState,
                          title: 'All Stores',
                          listingType: 'store',
                        ),
                      ),
                    ),
                  ),
                ),
                const SizedBox(width: 10),
                Expanded(
                  child: _HomeNavTile(
                    icon: Icons.storefront_outlined,
                    title: 'Vendors',
                    color: const Color(0xFF0EA5E9),
                    onTap: () => Navigator.of(context).push(
                      MaterialPageRoute<void>(
                        builder: (_) => ListingListScreen(
                          appState: widget.appState,
                          title: 'All Vendors',
                          listingType: 'vendor',
                        ),
                      ),
                    ),
                  ),
                ),
                const SizedBox(width: 10),
                Expanded(
                  child: _HomeNavTile(
                    icon: Icons.apps_outlined,
                    title: 'All',
                    color: AppColors.primary,
                    onTap: () => Navigator.of(context).push(
                      MaterialPageRoute<void>(
                        builder: (_) =>
                            ListingListScreen(appState: widget.appState),
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),

          const SizedBox(height: 20),

          // ── Referral Card ──
          if (feed.referralCard != null) ...[
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16),
              child: Container(
                padding: const EdgeInsets.all(16),
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    colors: [
                      AppColors.primary.withAlpha(220),
                      AppColors.primary,
                    ],
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                  ),
                  borderRadius: BorderRadius.circular(16),
                  boxShadow: [
                    BoxShadow(
                      color: AppColors.primary.withAlpha(40),
                      blurRadius: 12,
                      offset: const Offset(0, 4),
                    ),
                  ],
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              feed.referralCard!.text,
                              style: const TextStyle(
                                color: Colors.white,
                                fontSize: 16,
                                fontWeight: FontWeight.w700,
                              ),
                            ),
                            const SizedBox(height: 6),
                            Text(
                              'Code: ${feed.referralCard!.referralCode}',
                              style: TextStyle(
                                color: Colors.white.withAlpha(200),
                                fontSize: 12,
                                fontWeight: FontWeight.w600,
                                letterSpacing: 1,
                              ),
                            ),
                          ],
                        ),
                        Container(
                          padding: const EdgeInsets.symmetric(
                            horizontal: 12,
                            vertical: 6,
                          ),
                          decoration: BoxDecoration(
                            color: Colors.white.withAlpha(50),
                            borderRadius: BorderRadius.circular(8),
                          ),
                          child: const Text(
                            'Refer Now',
                            style: TextStyle(
                              color: Colors.white,
                              fontWeight: FontWeight.w700,
                              fontSize: 12,
                            ),
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 12),
                    ClipRRect(
                      borderRadius: BorderRadius.circular(6),
                      child: LinearProgressIndicator(
                        value: 0.6,
                        minHeight: 6,
                        backgroundColor: Colors.white.withAlpha(100),
                        valueColor: AlwaysStoppedAnimation<Color>(
                          Colors.white.withAlpha(200),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),
            const SizedBox(height: 24),
          ],

          const SizedBox(height: 24),

          // ── Categories ──
          if (feed.categories.isNotEmpty) ...[
            SectionHeader(
              title: 'Shop by Category',
              actionLabel: 'See All',
              onAction: () {},
              padding: const EdgeInsets.symmetric(horizontal: 16),
            ),
            const SizedBox(height: 14),
            SizedBox(
              height: 100,
              child: ListView.separated(
                scrollDirection: Axis.horizontal,
                padding: const EdgeInsets.symmetric(horizontal: 16),
                itemCount: feed.categories.length,
                separatorBuilder: (_, _) => const SizedBox(width: 14),
                itemBuilder: (_, index) {
                  final cat = feed.categories[index];
                  return GestureDetector(
                    onTap: () => Navigator.of(context).push(
                      MaterialPageRoute<void>(
                        builder: (_) => ProductListScreen(
                          appState: widget.appState,
                          categorySlug: cat.slug,
                          title: cat.name,
                          token: widget.token,
                        ),
                      ),
                    ),
                    child: SizedBox(
                      width: 76,
                      child: Column(
                        children: [
                          Container(
                            width: 60,
                            height: 60,
                            decoration: BoxDecoration(
                              color: AppColors.primaryLight,
                              borderRadius: BorderRadius.circular(18),
                              border: Border.all(
                                color: AppColors.primary.withAlpha(30),
                              ),
                            ),
                            child: cat.imageUrl != null
                                ? ClipRRect(
                                    borderRadius: BorderRadius.circular(18),
                                    child: CachedNetworkImage(
                                      imageUrl: cat.imageUrl!,
                                      fit: BoxFit.cover,
                                      errorWidget: (_, _, _) => const Icon(
                                        Icons.category_rounded,
                                        color: AppColors.primary,
                                      ),
                                    ),
                                  )
                                : const Icon(
                                    Icons.category_rounded,
                                    color: AppColors.primary,
                                    size: 26,
                                  ),
                          ),
                          const SizedBox(height: 6),
                          Text(
                            cat.name,
                            maxLines: 2,
                            textAlign: TextAlign.center,
                            overflow: TextOverflow.ellipsis,
                            style: const TextStyle(
                              fontSize: 11,
                              fontWeight: FontWeight.w600,
                              color: AppColors.textPrimary,
                            ),
                          ),
                        ],
                      ),
                    ),
                  );
                },
              ),
            ),
            const SizedBox(height: 24),
          ],

          // ── Featured Products ──
          if (feed.featuredProducts.isNotEmpty) ...[
            SectionHeader(
              title: 'Featured Products',
              actionLabel: 'View All',
              onAction: () => Navigator.of(context).push(
                MaterialPageRoute<void>(
                  builder: (_) => ProductListScreen(
                    appState: widget.appState,
                    title: 'Featured Products',
                    token: widget.token,
                  ),
                ),
              ),
              padding: const EdgeInsets.symmetric(horizontal: 16),
            ),
            const SizedBox(height: 14),
            SizedBox(
              height: 220,
              child: ListView.separated(
                scrollDirection: Axis.horizontal,
                padding: const EdgeInsets.symmetric(horizontal: 16),
                itemCount: feed.featuredProducts.length,
                separatorBuilder: (_, _) => const SizedBox(width: 12),
                itemBuilder: (_, index) {
                  final product = feed.featuredProducts[index];
                  return _FeaturedProductCard(
                    product: product,
                    token: widget.token,
                  );
                },
              ),
            ),
            const SizedBox(height: 24),
          ],

          // ── Recommended Products ──
          if (feed.recommendedProducts.isNotEmpty) ...[
            SectionHeader(
              title: 'Recommended 🌟',
              padding: const EdgeInsets.symmetric(horizontal: 16),
            ),
            const SizedBox(height: 14),
            SizedBox(
              height: 220,
              child: ListView.separated(
                scrollDirection: Axis.horizontal,
                padding: const EdgeInsets.symmetric(horizontal: 16),
                itemCount: feed.recommendedProducts.length,
                separatorBuilder: (_, _) => const SizedBox(width: 12),
                itemBuilder: (_, index) {
                  final product = feed.recommendedProducts[index];
                  return _FeaturedProductCard(
                    product: product,
                    token: widget.token,
                  );
                },
              ),
            ),
            const SizedBox(height: 24),
          ],

          // ── New Launches ──
          if (feed.newLaunches.isNotEmpty) ...[
            SectionHeader(
              title: 'New Launches 🎉',
              padding: const EdgeInsets.symmetric(horizontal: 16),
            ),
            const SizedBox(height: 14),
            SizedBox(
              height: 220,
              child: ListView.separated(
                scrollDirection: Axis.horizontal,
                padding: const EdgeInsets.symmetric(horizontal: 16),
                itemCount: feed.newLaunches.length,
                separatorBuilder: (_, _) => const SizedBox(width: 12),
                itemBuilder: (_, index) {
                  final product = feed.newLaunches[index];
                  return _FeaturedProductCard(
                    product: product,
                    token: widget.token,
                  );
                },
              ),
            ),
            const SizedBox(height: 24),
          ],

          if (bannerItems.isNotEmpty) ...[
            SectionHeader(
              title: 'Recommended Benefits',
              padding: const EdgeInsets.symmetric(horizontal: 16),
            ),
            const SizedBox(height: 12),
            SizedBox(
              height: 220,
              child: Stack(
                children: [
                  PageView.builder(
                    controller: _promoController,
                    itemCount: bannerItems.length,
                    itemBuilder: (_, index) {
                      final banner = bannerItems[index];
                      return Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 16),
                        child: ClipRRect(
                          borderRadius: BorderRadius.circular(18),
                          child: Stack(
                            fit: StackFit.expand,
                            children: [
                              (banner.imageUrl != null &&
                                      banner.imageUrl!.isNotEmpty)
                                  ? CachedNetworkImage(
                                      imageUrl: banner.imageUrl!,
                                      fit: BoxFit.cover,
                                      errorWidget: (_, _, _) =>
                                          _bannerPlaceholder(),
                                    )
                                  : _bannerPlaceholder(),
                              Positioned(
                                left: 0,
                                right: 0,
                                bottom: 0,
                                child: Container(
                                  padding: const EdgeInsets.fromLTRB(
                                    14,
                                    28,
                                    14,
                                    14,
                                  ),
                                  decoration: const BoxDecoration(
                                    gradient: LinearGradient(
                                      begin: Alignment.topCenter,
                                      end: Alignment.bottomCenter,
                                      colors: [
                                        Colors.transparent,
                                        Colors.black87,
                                      ],
                                    ),
                                  ),
                                  child: Column(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    mainAxisSize: MainAxisSize.min,
                                    children: [
                                      if ((banner.title ?? '')
                                          .trim()
                                          .isNotEmpty)
                                        Text(
                                          banner.title!,
                                          maxLines: 1,
                                          overflow: TextOverflow.ellipsis,
                                          style: const TextStyle(
                                            color: Colors.white70,
                                            fontSize: 11,
                                            fontWeight: FontWeight.w600,
                                          ),
                                        ),
                                      if ((banner.subtitle ?? '')
                                          .trim()
                                          .isNotEmpty) ...[
                                        const SizedBox(height: 4),
                                        Text(
                                          banner.subtitle!,
                                          maxLines: 2,
                                          overflow: TextOverflow.ellipsis,
                                          style: const TextStyle(
                                            color: Colors.white,
                                            fontSize: 16,
                                            fontWeight: FontWeight.w700,
                                          ),
                                        ),
                                      ],
                                    ],
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      );
                    },
                  ),
                  if (bannerItems.length > 1)
                    Positioned(
                      bottom: 12,
                      left: 0,
                      right: 0,
                      child: Center(
                        child: SmoothPageIndicator(
                          controller: _promoController,
                          count: bannerItems.length,
                          effect: const WormEffect(
                            dotWidth: 7,
                            dotHeight: 7,
                            activeDotColor: Colors.white,
                            dotColor: Colors.white38,
                            spacing: 6,
                          ),
                        ),
                      ),
                    ),
                ],
              ),
            ),
            const SizedBox(height: 24),
          ],

          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(16),
                border: Border.all(color: AppColors.borderLight),
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    children: const [
                      Icon(Icons.group_add_outlined, color: AppColors.primary),
                      SizedBox(width: 8),
                      Text(
                        'Invite People & Earn',
                        style: TextStyle(
                          fontWeight: FontWeight.w700,
                          color: AppColors.textPrimary,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 8),
                  Text(
                    'Referral Code: ${user?.referralCode ?? 'Not available'}',
                    style: const TextStyle(color: AppColors.textSecondary),
                  ),
                  const SizedBox(height: 14),
                  const Text(
                    'Account Level',
                    style: TextStyle(
                      fontWeight: FontWeight.w700,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 8),
                  _AccountLevelProgress(
                    currentLevel: _currentLevel(_referralData),
                  ),
                ],
              ),
            ),
          ),

          const SizedBox(height: 20),
        ],
      ),
    );
  }

  Widget _bannerPlaceholder() {
    return Container(
      decoration: const BoxDecoration(gradient: AppColors.primaryGradient),
      alignment: Alignment.center,
      child: const Icon(Icons.image_rounded, color: Colors.white54, size: 48),
    );
  }

  Widget _buildShimmer() {
    return Shimmer.fromColors(
      baseColor: const Color(0xFFE5E7EB),
      highlightColor: const Color(0xFFF9FAFB),
      child: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          Container(
            height: 170,
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(20),
            ),
          ),
          const SizedBox(height: 16),
          Container(
            height: 80,
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(20),
            ),
          ),
          const SizedBox(height: 20),
          Container(height: 20, width: 140, color: Colors.white),
          const SizedBox(height: 14),
          Row(
            children: List.generate(
              4,
              (_) => Expanded(
                child: Container(
                  height: 80,
                  margin: const EdgeInsets.only(right: 12),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(16),
                  ),
                ),
              ),
            ),
          ),
          const SizedBox(height: 20),
          Container(height: 20, width: 160, color: Colors.white),
          const SizedBox(height: 14),
          Row(
            children: List.generate(
              2,
              (_) => Expanded(
                child: Container(
                  height: 200,
                  margin: const EdgeInsets.only(right: 12),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(16),
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _LocationSelection {
  const _LocationSelection({
    required this.stateId,
    required this.districtId,
    required this.label,
  });

  final int? stateId;
  final int? districtId;
  final String label;
}

class _LocationPickerSheet extends StatefulWidget {
  const _LocationPickerSheet({
    required this.repository,
    required this.states,
    required this.initialStateId,
    required this.initialDistrictId,
    this.token,
  });

  final HomeRepository repository;
  final List<LocationStateOption> states;
  final int? initialStateId;
  final int? initialDistrictId;
  final String? token;

  @override
  State<_LocationPickerSheet> createState() => _LocationPickerSheetState();
}

class _LocationPickerSheetState extends State<_LocationPickerSheet> {
  int? _stateId;
  int? _districtId;
  bool _loadingDistricts = false;
  List<LocationDistrictOption> _districts = const [];

  @override
  void initState() {
    super.initState();
    _stateId = widget.initialStateId;
    _districtId = widget.initialDistrictId;
    if (_stateId != null) {
      _loadDistricts(_stateId!, keepDistrict: true);
    }
  }

  Future<void> _loadDistricts(int stateId, {bool keepDistrict = false}) async {
    setState(() => _loadingDistricts = true);
    try {
      final items = await widget.repository.fetchDistricts(
        stateId,
        token: widget.token,
      );
      if (!mounted) return;
      setState(() {
        _districts = items;
        if (!keepDistrict || !_districts.any((d) => d.id == _districtId)) {
          _districtId = null;
        }
      });
    } catch (_) {
      if (!mounted) return;
      setState(() => _districts = const []);
    } finally {
      if (mounted) setState(() => _loadingDistricts = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    final bottomInset = MediaQuery.of(context).viewInsets.bottom;

    return SafeArea(
      child: Padding(
        padding: EdgeInsets.fromLTRB(16, 16, 16, 16 + bottomInset),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Choose location',
              style: TextStyle(fontWeight: FontWeight.w700, fontSize: 18),
            ),
            const SizedBox(height: 12),
            DropdownButtonFormField<int>(
              initialValue: _stateId ?? 0,
              decoration: const InputDecoration(
                labelText: 'State',
                prefixIcon: Icon(Icons.map_outlined),
              ),
              items: [
                const DropdownMenuItem<int>(value: 0, child: Text('All India')),
                ...widget.states.map(
                  (state) => DropdownMenuItem<int>(
                    value: state.id,
                    child: Text(state.name),
                  ),
                ),
              ],
              onChanged: (value) {
                final stateValue = value == null || value == 0 ? null : value;
                setState(() {
                  _stateId = stateValue;
                  _districtId = null;
                  _districts = const [];
                });
                if (stateValue != null) {
                  _loadDistricts(stateValue);
                }
              },
            ),
            const SizedBox(height: 10),
            DropdownButtonFormField<int>(
              initialValue: _districtId ?? 0,
              decoration: InputDecoration(
                labelText: 'District',
                prefixIcon: const Icon(Icons.location_city_outlined),
                helperText: _stateId == null ? 'Select a state first' : null,
              ),
              items: [
                const DropdownMenuItem<int>(
                  value: 0,
                  child: Text('All districts'),
                ),
                ..._districts.map(
                  (district) => DropdownMenuItem<int>(
                    value: district.id,
                    child: Text(district.name),
                  ),
                ),
              ],
              onChanged: _stateId == null || _loadingDistricts
                  ? null
                  : (value) => setState(
                      () => _districtId = value == null || value == 0
                          ? null
                          : value,
                    ),
            ),
            const SizedBox(height: 14),
            Row(
              children: [
                TextButton(
                  onPressed: () => Navigator.of(context).pop(
                    const _LocationSelection(
                      stateId: null,
                      districtId: null,
                      label: 'All India',
                    ),
                  ),
                  child: const Text('Clear'),
                ),
                const Spacer(),
                FilledButton(
                  onPressed: () {
                    String? stateName;
                    for (final state in widget.states) {
                      if (state.id == _stateId) {
                        stateName = state.name;
                        break;
                      }
                    }
                    String? districtName;
                    for (final district in _districts) {
                      if (district.id == _districtId) {
                        districtName = district.name;
                        break;
                      }
                    }
                    final label = districtName != null
                        ? '$districtName, ${stateName ?? ''}'.trim().replaceAll(
                            RegExp(r',\s*$'),
                            '',
                          )
                        : (stateName ?? 'All India');
                    Navigator.of(context).pop(
                      _LocationSelection(
                        stateId: _stateId,
                        districtId: _districtId,
                        label: label,
                      ),
                    );
                  },
                  child: const Text('Apply'),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}

// ── Featured Product Card ────────────────────────────────────────────

class _FeaturedProductCard extends StatelessWidget {
  const _FeaturedProductCard({required this.product, this.token});
  final HomeProductItem product;
  final String? token;

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () => Navigator.of(context).push(
        MaterialPageRoute<void>(
          builder: (_) => ProductDetailScreen(slug: product.slug, token: token),
        ),
      ),
      child: Container(
        width: 160,
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(16),
          border: Border.all(color: AppColors.border, width: 0.5),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withAlpha(6),
              blurRadius: 8,
              offset: const Offset(0, 2),
            ),
          ],
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Image
            ClipRRect(
              borderRadius: const BorderRadius.vertical(
                top: Radius.circular(16),
              ),
              child: SizedBox(
                height: 130,
                width: double.infinity,
                child: product.primaryImageUrl != null
                    ? CachedNetworkImage(
                        imageUrl: product.primaryImageUrl!,
                        fit: BoxFit.cover,
                        errorWidget: (_, _, _) => _imagePlaceholder(),
                      )
                    : _imagePlaceholder(),
              ),
            ),
            // Info
            Padding(
              padding: const EdgeInsets.all(10),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    product.name,
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                    style: const TextStyle(
                      fontSize: 13,
                      fontWeight: FontWeight.w600,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  const SizedBox(height: 6),
                  Row(
                    children: [
                      Text(
                        '₹${product.effectivePrice.toStringAsFixed(0)}',
                        style: const TextStyle(
                          fontSize: 15,
                          fontWeight: FontWeight.w800,
                          color: AppColors.primary,
                        ),
                      ),
                      const Spacer(),
                      if (product.ratingAvg != null)
                        StarRating(rating: product.ratingAvg!, size: 11),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _imagePlaceholder() => Container(
    color: AppColors.borderLight,
    child: const Center(
      child: Icon(Icons.image_outlined, color: AppColors.textMuted, size: 32),
    ),
  );
}

class _HomeNavTile extends StatelessWidget {
  const _HomeNavTile({
    required this.icon,
    required this.title,
    required this.color,
    required this.onTap,
  });

  final IconData icon;
  final String title;
  final Color color;
  final VoidCallback onTap;

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(12),
      child: Ink(
        padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 12),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(12),
          color: color.withAlpha(18),
          border: Border.all(color: color.withAlpha(60)),
        ),
        child: Column(
          children: [
            Icon(icon, color: color, size: 20),
            const SizedBox(height: 6),
            Text(
              title,
              style: TextStyle(
                fontSize: 11,
                fontWeight: FontWeight.w700,
                color: color,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _QuickActionIcon extends StatelessWidget {
  const _QuickActionIcon({required this.icon, required this.onTap});

  final IconData icon;
  final VoidCallback onTap;

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(12),
      child: Ink(
        width: 44,
        height: 44,
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: AppColors.borderLight),
        ),
        child: Icon(icon, color: AppColors.textPrimary, size: 20),
      ),
    );
  }
}

class _AccountLevelProgress extends StatelessWidget {
  const _AccountLevelProgress({required this.currentLevel});

  final int currentLevel;

  @override
  Widget build(BuildContext context) {
    final normalizedLevel = currentLevel.clamp(1, 5);

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        for (var level = 1; level <= 5; level++) ...[
          _AccountLevelRow(
            label: 'Level $level',
            active: level <= normalizedLevel,
          ),
          if (level < 5) const SizedBox(height: 6),
        ],
      ],
    );
  }
}

int _currentLevel(ReferralResponse? referralData) {
  final levels = referralData?.levelSummary ?? const <LevelSummary>[];
  var currentLevel = 1;

  for (final level in levels) {
    if (level.members > 0 && level.depth > currentLevel) {
      currentLevel = level.depth;
    }
  }

  return currentLevel.clamp(1, 5);
}

class _AccountLevelRow extends StatelessWidget {
  const _AccountLevelRow({required this.label, required this.active});

  final String label;
  final bool active;

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        Icon(
          active ? Icons.check_circle_rounded : Icons.radio_button_unchecked,
          size: 16,
          color: active ? AppColors.success : AppColors.textMuted,
        ),
        const SizedBox(width: 8),
        Text(
          label,
          style: TextStyle(
            color: active ? AppColors.textPrimary : AppColors.textSecondary,
            fontWeight: active ? FontWeight.w700 : FontWeight.w500,
          ),
        ),
      ],
    );
  }
}
