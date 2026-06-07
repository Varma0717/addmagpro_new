import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:mobile_scanner/mobile_scanner.dart';
import 'package:razorpay_flutter/razorpay_flutter.dart';

import '../../../app_state.dart';
import '../../../core/network/api_client.dart';
import '../../../core/theme/app_theme.dart';
import '../../../core/widgets/app_widgets.dart';
import '../data/wallet_repository.dart';
import '../models/wallet_models.dart';

enum _WalletTab { pay, scan, send, selfTransfer, addWallet }

class WalletScreen extends StatefulWidget {
  const WalletScreen({super.key, required this.token, this.appState});

  final String token;
  final AppState? appState;

  @override
  State<WalletScreen> createState() => _WalletScreenState();
}

class _WalletScreenState extends State<WalletScreen> {
  late final WalletRepository _repository;
  late final Razorpay _razorpay;

  bool _loading = true;
  bool _submitting = false;
  String? _error;
  WalletOverview? _wallet;
  int? _pendingTopupAmount;

  _WalletTab _tab = _WalletTab.pay;
  String? _lastScannedValue;

  final TextEditingController _payRecipientController = TextEditingController();
  final TextEditingController _payAmountController = TextEditingController();
  final TextEditingController _payNoteController = TextEditingController();

  final TextEditingController _sendRecipientController =
      TextEditingController();
  final TextEditingController _sendAmountController = TextEditingController();
  final TextEditingController _sendNoteController = TextEditingController();

  final TextEditingController _selfAmountController = TextEditingController();
  final TextEditingController _selfNameController = TextEditingController();
  final TextEditingController _selfAccountController = TextEditingController();
  final TextEditingController _selfIfscController = TextEditingController();
  final TextEditingController _selfNoteController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _repository = WalletRepository(apiClient: ApiClient());
    _razorpay = Razorpay();
    _razorpay.on(Razorpay.EVENT_PAYMENT_SUCCESS, _handleTopupSuccess);
    _razorpay.on(Razorpay.EVENT_PAYMENT_ERROR, _handleTopupError);
    _load();
  }

  @override
  void dispose() {
    _razorpay.clear();
    _payRecipientController.dispose();
    _payAmountController.dispose();
    _payNoteController.dispose();
    _sendRecipientController.dispose();
    _sendAmountController.dispose();
    _sendNoteController.dispose();
    _selfAmountController.dispose();
    _selfNameController.dispose();
    _selfAccountController.dispose();
    _selfIfscController.dispose();
    _selfNoteController.dispose();
    super.dispose();
  }

  Future<void> _load() async {
    setState(() {
      _loading = true;
      _error = null;
    });
    try {
      final wallet = await _repository.fetch(widget.token);
      await widget.appState?.refreshProfile();
      if (!mounted) return;
      setState(() => _wallet = wallet);
    } catch (error) {
      if (!mounted) return;
      setState(() => _error = error.toString());
    } finally {
      if (mounted) setState(() => _loading = false);
    }
  }

  Future<void> _handleTopupSuccess(PaymentSuccessResponse response) async {
    try {
      await _repository.verifyTopup(
        widget.token,
        razorpayOrderId: response.orderId ?? '',
        razorpayPaymentId: response.paymentId ?? '',
        razorpaySignature: response.signature ?? '',
        amount: _pendingTopupAmount ?? 0,
      );
      await _load();
      if (!mounted) return;
      _showSnack(
        '₹${_pendingTopupAmount ?? 0} added to wallet!',
        color: AppColors.success,
      );
    } catch (error) {
      if (!mounted) return;
      _showSnack('Verification failed: $error');
    }
    _pendingTopupAmount = null;
  }

  void _handleTopupError(PaymentFailureResponse response) {
    _pendingTopupAmount = null;
    if (!mounted) return;
    _showSnack(
      'Payment failed: ${response.message ?? 'Unknown error'}',
      color: AppColors.error,
    );
  }

  void _showSnack(String text, {Color? color}) {
    if (!mounted) return;
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(text),
        behavior: SnackBarBehavior.floating,
        backgroundColor: color,
      ),
    );
  }

  Future<void> _requestWithdraw() async {
    final controller = TextEditingController();
    final remarksController = TextEditingController();

    final amount = await showModalBottomSheet<double>(
      context: context,
      isScrollControlled: true,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
      ),
      builder: (context) {
        return Padding(
          padding: EdgeInsets.fromLTRB(
            20,
            20,
            20,
            MediaQuery.of(context).viewInsets.bottom + 24,
          ),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Center(
                child: Container(
                  width: 40,
                  height: 4,
                  decoration: BoxDecoration(
                    color: AppColors.border,
                    borderRadius: BorderRadius.circular(2),
                  ),
                ),
              ),
              const SizedBox(height: 20),
              const Text(
                'Withdraw Request',
                style: TextStyle(fontSize: 18, fontWeight: FontWeight.w700),
              ),
              const SizedBox(height: 16),
              TextField(
                controller: controller,
                keyboardType: const TextInputType.numberWithOptions(
                  decimal: true,
                ),
                decoration: const InputDecoration(
                  labelText: 'Amount (₹)',
                  prefixIcon: Icon(Icons.currency_rupee_rounded),
                ),
              ),
              const SizedBox(height: 12),
              TextField(
                controller: remarksController,
                decoration: const InputDecoration(
                  labelText: 'Remarks (optional)',
                  prefixIcon: Icon(Icons.notes_rounded),
                ),
              ),
              const SizedBox(height: 20),
              FilledButton(
                onPressed: () => Navigator.of(
                  context,
                ).pop(double.tryParse(controller.text.trim())),
                style: FilledButton.styleFrom(
                  minimumSize: const Size(double.infinity, 52),
                ),
                child: const Text('Submit Withdraw'),
              ),
            ],
          ),
        );
      },
    );

    if (amount == null) return;

    setState(() => _submitting = true);
    try {
      await _repository.submitWithdraw(
        widget.token,
        amount: amount,
        remarks: remarksController.text.trim(),
      );
      await _load();
      _showSnack('Withdraw request submitted', color: AppColors.success);
    } catch (error) {
      _showSnack(error.toString());
    } finally {
      if (mounted) setState(() => _submitting = false);
      controller.dispose();
      remarksController.dispose();
    }
  }

  Future<void> _startTopup() async {
    final presets = _wallet?.presetAmounts ?? [100, 200, 500, 1000];
    final customController = TextEditingController();

    final amount = await showModalBottomSheet<int>(
      context: context,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
      ),
      builder: (context) {
        return Padding(
          padding: EdgeInsets.fromLTRB(
            20,
            20,
            20,
            MediaQuery.of(context).viewInsets.bottom + 24,
          ),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Center(
                child: Container(
                  width: 40,
                  height: 4,
                  decoration: BoxDecoration(
                    color: AppColors.border,
                    borderRadius: BorderRadius.circular(2),
                  ),
                ),
              ),
              const SizedBox(height: 20),
              const Text(
                'Add Money to Wallet',
                style: TextStyle(fontSize: 18, fontWeight: FontWeight.w700),
              ),
              const SizedBox(height: 6),
              const Text(
                'Choose amount and continue to secure payment',
                style: TextStyle(color: AppColors.textMuted, fontSize: 13),
              ),
              const SizedBox(height: 18),
              Wrap(
                spacing: 10,
                runSpacing: 10,
                children: presets
                    .map(
                      (amt) => OutlinedButton(
                        onPressed: () => Navigator.of(context).pop(amt),
                        style: OutlinedButton.styleFrom(
                          padding: const EdgeInsets.symmetric(
                            horizontal: 20,
                            vertical: 14,
                          ),
                          side: const BorderSide(color: AppColors.primary),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                        ),
                        child: Text(
                          '₹$amt',
                          style: const TextStyle(
                            fontWeight: FontWeight.w700,
                            fontSize: 16,
                            color: AppColors.primary,
                          ),
                        ),
                      ),
                    )
                    .toList(),
              ),
              const SizedBox(height: 16),
              TextField(
                controller: customController,
                keyboardType: TextInputType.number,
                decoration: const InputDecoration(
                  labelText: 'Custom amount (₹)',
                  prefixIcon: Icon(Icons.edit_rounded),
                ),
              ),
              const SizedBox(height: 16),
              FilledButton(
                onPressed: () => Navigator.of(
                  context,
                ).pop(int.tryParse(customController.text.trim())),
                style: FilledButton.styleFrom(
                  minimumSize: const Size(double.infinity, 52),
                ),
                child: const Text('Proceed to Pay'),
              ),
            ],
          ),
        );
      },
    );

    customController.dispose();

    if (amount == null || amount <= 0) return;

    try {
      _pendingTopupAmount = amount;
      final order = await _repository.createTopupOrder(
        widget.token,
        amount: amount,
      );
      final options = <String, dynamic>{
        'key': order.keyId,
        'amount': order.amount * 100,
        'currency': order.currency,
        'order_id': order.orderId,
        'name': 'AddMagPro',
        'description': 'Wallet Top-up ₹$amount',
        'theme': {'color': '#FF7F11'},
      };
      _razorpay.open(options);
    } catch (error) {
      _pendingTopupAmount = null;
      _showSnack(error.toString());
    }
  }

  Future<void> _submitPay() async {
    await _submitTransfer(
      recipientController: _payRecipientController,
      amountController: _payAmountController,
      noteController: _payNoteController,
      defaultDescription: 'Merchant payment',
      successMessage: 'Payment sent successfully',
      clearOnSuccess: true,
    );
  }

  Future<void> _submitSendMoney() async {
    await _submitTransfer(
      recipientController: _sendRecipientController,
      amountController: _sendAmountController,
      noteController: _sendNoteController,
      defaultDescription: 'Wallet transfer',
      successMessage: 'Money sent successfully',
      clearOnSuccess: true,
    );
  }

  Future<void> _submitTransfer({
    required TextEditingController recipientController,
    required TextEditingController amountController,
    required TextEditingController noteController,
    required String defaultDescription,
    required String successMessage,
    bool clearOnSuccess = false,
  }) async {
    final recipient = recipientController.text.trim();
    final amount = double.tryParse(amountController.text.trim());
    final description = noteController.text.trim();

    if (recipient.isEmpty || amount == null || amount <= 0) {
      _showSnack('Enter valid recipient and amount');
      return;
    }

    setState(() => _submitting = true);
    try {
      await _repository.sendMoney(
        widget.token,
        recipientIdentifier: recipient,
        amount: amount,
        description: description.isEmpty ? defaultDescription : description,
      );
      await _load();
      _showSnack(successMessage, color: AppColors.success);
      if (clearOnSuccess) {
        recipientController.clear();
        amountController.clear();
        noteController.clear();
      }
    } catch (error) {
      _showSnack(error.toString());
    } finally {
      if (mounted) setState(() => _submitting = false);
    }
  }

  Future<void> _submitSelfTransfer() async {
    final amount = double.tryParse(_selfAmountController.text.trim());
    final name = _selfNameController.text.trim();
    final account = _selfAccountController.text.trim();
    final ifsc = _selfIfscController.text.trim().toUpperCase();
    final note = _selfNoteController.text.trim();

    if (amount == null || amount < 100) {
      _showSnack('Amount should be at least ₹100');
      return;
    }
    if (name.isEmpty || account.length != 12 || ifsc.length != 11) {
      _showSnack('Enter valid account holder, account number and IFSC');
      return;
    }

    setState(() => _submitting = true);
    try {
      await _repository.selfTransfer(
        widget.token,
        amount: amount,
        accountHolderName: name,
        accountNumber: account,
        ifscCode: ifsc,
        description: note,
      );
      await _load();
      _showSnack(
        'Self transfer request submitted for approval',
        color: AppColors.success,
      );
      _selfAmountController.clear();
      _selfNameController.clear();
      _selfAccountController.clear();
      _selfIfscController.clear();
      _selfNoteController.clear();
    } catch (error) {
      _showSnack(error.toString());
    } finally {
      if (mounted) setState(() => _submitting = false);
    }
  }

  Future<void> _openScanner() async {
    final raw = await Navigator.of(context).push<String>(
      MaterialPageRoute<String>(builder: (_) => const _QrScannerPage()),
    );

    if (raw == null || raw.trim().isEmpty) return;
    final parsed = _parseScannedPayload(raw);

    if (parsed.recipientIdentifier == null) {
      await Clipboard.setData(ClipboardData(text: raw));
      _showSnack(
        'QR scanned, but no phone/email found for wallet transfer. Copied raw data.',
      );
      setState(() {
        _tab = _WalletTab.scan;
        _lastScannedValue = raw;
      });
      return;
    }

    setState(() {
      _lastScannedValue = raw;
      _payRecipientController.text = parsed.recipientIdentifier!;
      _sendRecipientController.text = parsed.recipientIdentifier!;
      if (parsed.amountText != null) {
        _payAmountController.text = parsed.amountText!;
        _sendAmountController.text = parsed.amountText!;
      }
      _payNoteController.text = parsed.note ?? _payNoteController.text;
      _sendNoteController.text = parsed.note ?? _sendNoteController.text;
      _tab = _WalletTab.pay;
    });

    _showSnack('QR details imported. Review and tap Pay.');
  }

  _ParsedScanResult _parseScannedPayload(String raw) {
    final value = raw.trim();
    final uri = Uri.tryParse(value);

    String? recipient;
    String? amount;
    String? note;

    if (uri != null) {
      final params = uri.queryParameters;
      recipient =
          params['recipient_identifier'] ??
          params['recipient'] ??
          params['mobile'] ??
          params['phone'] ??
          params['email'] ??
          params['pa'];
      amount = params['amount'] ?? params['am'];
      note = params['description'] ?? params['tn'] ?? params['note'];
    }

    recipient ??= _extractEmail(value) ?? _extractPhone(value);
    amount ??= _extractAmount(value);

    if (recipient != null && !_isPhoneOrEmail(recipient)) {
      recipient = null;
    }

    return _ParsedScanResult(
      recipientIdentifier: recipient,
      amountText: amount,
      note: note,
    );
  }

  String? _extractEmail(String input) {
    final match = RegExp(
      r'[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}',
    ).firstMatch(input);
    return match?.group(0);
  }

  String? _extractPhone(String input) {
    final match = RegExp(r'(?:\\+91[- ]?)?[6-9]\\d{9}').firstMatch(input);
    if (match == null) return null;
    final raw = match.group(0) ?? '';
    final digits = raw.replaceAll(RegExp(r'[^0-9]'), '');
    if (digits.length >= 10) {
      return digits.substring(digits.length - 10);
    }
    return null;
  }

  String? _extractAmount(String input) {
    final match = RegExp(
      r'(?:amount|am|rs|inr)[:= ]*([0-9]+(?:\\.[0-9]{1,2})?)',
      caseSensitive: false,
    ).firstMatch(input);
    return match?.group(1);
  }

  bool _isPhoneOrEmail(String value) {
    final clean = value.trim();
    final phone = RegExp(r'^\\+?[0-9]{10,13}$').hasMatch(clean);
    final email = RegExp(
      r'^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$',
    ).hasMatch(clean);
    return phone || email;
  }

  double _totalCredits(WalletOverview wallet) {
    return wallet.transactions
        .where((t) => t.isCredit)
        .fold(0.0, (sum, t) => sum + t.amount);
  }

  double _totalDebits(WalletOverview wallet) {
    return wallet.transactions
        .where((t) => !t.isCredit)
        .fold(0.0, (sum, t) => sum + t.amount);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text(_titleForTab(_tab))),
      body: _buildBody(),
      bottomNavigationBar: NavigationBar(
        selectedIndex: _tab.index,
        onDestinationSelected: (index) {
          setState(() => _tab = _WalletTab.values[index]);
          if (_WalletTab.values[index] == _WalletTab.scan) {
            _openScanner();
          }
        },
        destinations: const [
          NavigationDestination(
            icon: Icon(Icons.payments_outlined),
            selectedIcon: Icon(Icons.payments_rounded),
            label: 'Pay',
          ),
          NavigationDestination(
            icon: Icon(Icons.qr_code_scanner_outlined),
            selectedIcon: Icon(Icons.qr_code_scanner_rounded),
            label: 'Scan',
          ),
          NavigationDestination(
            icon: Icon(Icons.send_outlined),
            selectedIcon: Icon(Icons.send_rounded),
            label: 'Send',
          ),
          NavigationDestination(
            icon: Icon(Icons.account_balance_outlined),
            selectedIcon: Icon(Icons.account_balance_rounded),
            label: 'Self',
          ),
          NavigationDestination(
            icon: Icon(Icons.account_balance_wallet_outlined),
            selectedIcon: Icon(Icons.account_balance_wallet_rounded),
            label: 'Add',
          ),
        ],
      ),
    );
  }

  String _titleForTab(_WalletTab tab) {
    switch (tab) {
      case _WalletTab.pay:
        return 'Pay';
      case _WalletTab.scan:
        return 'Scan Any QR';
      case _WalletTab.send:
        return 'Send Money';
      case _WalletTab.selfTransfer:
        return 'Self Transfer';
      case _WalletTab.addWallet:
        return 'Add to Wallet';
    }
  }

  Widget _buildBody() {
    if (_loading) {
      return const Center(
        child: CircularProgressIndicator(color: AppColors.primary),
      );
    }

    if (_error != null) {
      return Center(
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            const Icon(
              Icons.error_outline_rounded,
              size: 48,
              color: AppColors.textMuted,
            ),
            const SizedBox(height: 12),
            Text(
              _error!,
              style: const TextStyle(color: AppColors.textMuted),
              textAlign: TextAlign.center,
            ),
            const SizedBox(height: 12),
            FilledButton.tonal(onPressed: _load, child: const Text('Retry')),
          ],
        ),
      );
    }

    final wallet = _wallet;
    if (wallet == null) {
      return const EmptyState(
        icon: Icons.account_balance_wallet_outlined,
        title: 'Wallet unavailable',
      );
    }

    switch (_tab) {
      case _WalletTab.pay:
        return _buildPayPage(wallet);
      case _WalletTab.scan:
        return _buildScanPage(wallet);
      case _WalletTab.send:
        return _buildSendMoneyPage(wallet);
      case _WalletTab.selfTransfer:
        return _buildSelfTransferPage(wallet);
      case _WalletTab.addWallet:
        return _buildAddWalletPage(wallet);
    }
  }

  Widget _buildPayPage(WalletOverview wallet) {
    return RefreshIndicator(
      color: AppColors.primary,
      onRefresh: _load,
      child: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          _buildBalanceCard(wallet),
          const SizedBox(height: 16),
          _ActionFormCard(
            title: 'Pay Merchant',
            subtitle: 'Pay by mobile number or email',
            actionLabel: _submitting ? 'Processing...' : 'Pay Now',
            icon: Icons.store_mall_directory_rounded,
            submitting: _submitting,
            onAction: _submitPay,
            children: [
              TextField(
                controller: _payRecipientController,
                decoration: const InputDecoration(
                  labelText: 'Recipient (phone or email)',
                  prefixIcon: Icon(Icons.person_outline_rounded),
                ),
              ),
              const SizedBox(height: 10),
              TextField(
                controller: _payAmountController,
                keyboardType: const TextInputType.numberWithOptions(
                  decimal: true,
                ),
                decoration: const InputDecoration(
                  labelText: 'Amount',
                  prefixIcon: Icon(Icons.currency_rupee_rounded),
                ),
              ),
              const SizedBox(height: 10),
              TextField(
                controller: _payNoteController,
                decoration: const InputDecoration(
                  labelText: 'Note',
                  prefixIcon: Icon(Icons.notes_rounded),
                ),
              ),
            ],
          ),
          const SizedBox(height: 24),
          SectionHeader(title: 'Recent Transactions', padding: EdgeInsets.zero),
          const SizedBox(height: 12),
          if (wallet.transactions.isEmpty)
            const Padding(
              padding: EdgeInsets.symmetric(vertical: 24),
              child: Center(
                child: Text(
                  'No transactions yet',
                  style: TextStyle(color: AppColors.textMuted),
                ),
              ),
            )
          else
            ...wallet.transactions.map((t) => _WalletTransactionCard(item: t)),
        ],
      ),
    );
  }

  Widget _buildScanPage(WalletOverview wallet) {
    return RefreshIndicator(
      color: AppColors.primary,
      onRefresh: _load,
      child: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          _buildBalanceCard(wallet),
          const SizedBox(height: 16),
          Container(
            padding: const EdgeInsets.all(18),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(16),
              border: Border.all(color: AppColors.border),
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Row(
                  children: [
                    Icon(
                      Icons.qr_code_scanner_rounded,
                      color: AppColors.primary,
                    ),
                    SizedBox(width: 10),
                    Text(
                      'Scan Any QR',
                      style: TextStyle(
                        fontWeight: FontWeight.w700,
                        fontSize: 16,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 10),
                const Text(
                  'We auto-detect recipient and amount when available. Supported transfer identifier: phone or email.',
                  style: TextStyle(color: AppColors.textMuted, fontSize: 13),
                ),
                const SizedBox(height: 14),
                FilledButton.icon(
                  onPressed: _openScanner,
                  icon: const Icon(Icons.center_focus_strong_rounded),
                  label: const Text('Open Camera Scanner'),
                ),
                if (_lastScannedValue != null) ...[
                  const SizedBox(height: 12),
                  SelectableText(
                    _lastScannedValue!,
                    style: const TextStyle(fontSize: 12),
                  ),
                ],
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSendMoneyPage(WalletOverview wallet) {
    return RefreshIndicator(
      color: AppColors.primary,
      onRefresh: _load,
      child: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          _buildBalanceCard(wallet),
          const SizedBox(height: 16),
          _ActionFormCard(
            title: 'Send Money',
            subtitle: 'Instant transfer to AddMagPro users',
            actionLabel: _submitting ? 'Sending...' : 'Send Money',
            icon: Icons.send_rounded,
            submitting: _submitting,
            onAction: _submitSendMoney,
            children: [
              TextField(
                controller: _sendRecipientController,
                decoration: const InputDecoration(
                  labelText: 'Recipient phone or email',
                  prefixIcon: Icon(Icons.person_search_rounded),
                ),
              ),
              const SizedBox(height: 10),
              TextField(
                controller: _sendAmountController,
                keyboardType: const TextInputType.numberWithOptions(
                  decimal: true,
                ),
                decoration: const InputDecoration(
                  labelText: 'Amount',
                  prefixIcon: Icon(Icons.currency_rupee_rounded),
                ),
              ),
              const SizedBox(height: 10),
              TextField(
                controller: _sendNoteController,
                decoration: const InputDecoration(
                  labelText: 'Message',
                  prefixIcon: Icon(Icons.message_outlined),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildSelfTransferPage(WalletOverview wallet) {
    return RefreshIndicator(
      color: AppColors.primary,
      onRefresh: _load,
      child: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          _buildBalanceCard(wallet),
          const SizedBox(height: 16),
          _ActionFormCard(
            title: 'Self Transfer',
            subtitle: 'Transfer wallet balance to your bank account',
            actionLabel: _submitting ? 'Submitting...' : 'Submit Transfer',
            icon: Icons.account_balance_rounded,
            submitting: _submitting,
            onAction: _submitSelfTransfer,
            children: [
              TextField(
                controller: _selfNameController,
                decoration: const InputDecoration(
                  labelText: 'Account holder name',
                  prefixIcon: Icon(Icons.badge_outlined),
                ),
              ),
              const SizedBox(height: 10),
              TextField(
                controller: _selfAccountController,
                keyboardType: TextInputType.number,
                decoration: const InputDecoration(
                  labelText: 'Account number (12 digits)',
                  prefixIcon: Icon(Icons.numbers_rounded),
                ),
              ),
              const SizedBox(height: 10),
              TextField(
                controller: _selfIfscController,
                textCapitalization: TextCapitalization.characters,
                decoration: const InputDecoration(
                  labelText: 'IFSC code (11 characters)',
                  prefixIcon: Icon(Icons.qr_code_2_rounded),
                ),
              ),
              const SizedBox(height: 10),
              TextField(
                controller: _selfAmountController,
                keyboardType: const TextInputType.numberWithOptions(
                  decimal: true,
                ),
                decoration: const InputDecoration(
                  labelText: 'Amount (min ₹100)',
                  prefixIcon: Icon(Icons.currency_rupee_rounded),
                ),
              ),
              const SizedBox(height: 10),
              TextField(
                controller: _selfNoteController,
                decoration: const InputDecoration(
                  labelText: 'Description (optional)',
                  prefixIcon: Icon(Icons.notes_rounded),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildAddWalletPage(WalletOverview wallet) {
    return RefreshIndicator(
      color: AppColors.primary,
      onRefresh: _load,
      child: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          _buildBalanceCard(wallet),
          const SizedBox(height: 16),
          Row(
            children: [
              Expanded(
                child: OutlinedButton.icon(
                  onPressed: _startTopup,
                  icon: const Icon(Icons.add_rounded),
                  label: const Text('Add to Wallet'),
                  style: OutlinedButton.styleFrom(
                    minimumSize: const Size(0, 52),
                    side: const BorderSide(color: AppColors.primary),
                    foregroundColor: AppColors.primary,
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(14),
                    ),
                  ),
                ),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: FilledButton.icon(
                  onPressed: _submitting ? null : _requestWithdraw,
                  icon: const Icon(Icons.arrow_upward_rounded),
                  label: Text(_submitting ? 'Submitting...' : 'Withdraw'),
                  style: FilledButton.styleFrom(
                    minimumSize: const Size(0, 52),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(14),
                    ),
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(height: 24),
          SectionHeader(title: 'Withdraw Requests', padding: EdgeInsets.zero),
          const SizedBox(height: 12),
          if (wallet.withdrawRequests.isEmpty)
            const Padding(
              padding: EdgeInsets.symmetric(vertical: 24),
              child: Center(
                child: Text(
                  'No withdraw requests yet',
                  style: TextStyle(color: AppColors.textMuted),
                ),
              ),
            )
          else
            ...wallet.withdrawRequests.map((w) => _WithdrawCard(item: w)),
        ],
      ),
    );
  }

  Widget _buildBalanceCard(WalletOverview wallet) {
    return Container(
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        gradient: AppColors.primaryGradient,
        borderRadius: BorderRadius.circular(24),
        boxShadow: [
          BoxShadow(
            color: AppColors.primary.withAlpha(40),
            blurRadius: 16,
            offset: const Offset(0, 6),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Container(
                width: 42,
                height: 42,
                decoration: BoxDecoration(
                  color: Colors.white.withAlpha(25),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Icon(
                  Icons.account_balance_wallet_rounded,
                  color: Colors.white,
                  size: 22,
                ),
              ),
              const SizedBox(width: 12),
              const Text(
                'Available Balance',
                style: TextStyle(color: Colors.white70, fontSize: 14),
              ),
              const Spacer(),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                decoration: BoxDecoration(
                  color: Colors.white.withAlpha(20),
                  borderRadius: BorderRadius.circular(8),
                ),
                child: const Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Icon(
                      Icons.verified_rounded,
                      color: Colors.greenAccent,
                      size: 14,
                    ),
                    SizedBox(width: 4),
                    Text(
                      'Active',
                      style: TextStyle(
                        color: Colors.greenAccent,
                        fontSize: 11,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
          const SizedBox(height: 20),
          Text(
            '₹${wallet.balance.toStringAsFixed(2)}',
            style: const TextStyle(
              color: Colors.white,
              fontWeight: FontWeight.w800,
              fontSize: 38,
            ),
          ),
          const SizedBox(height: 16),
          Row(
            children: [
              _BalanceStat(
                label: 'Credited',
                value: '₹${_totalCredits(wallet).toStringAsFixed(0)}',
                icon: Icons.south_west_rounded,
                iconColor: Colors.greenAccent,
              ),
              const SizedBox(width: 16),
              _BalanceStat(
                label: 'Debited',
                value: '₹${_totalDebits(wallet).toStringAsFixed(0)}',
                icon: Icons.north_east_rounded,
                iconColor: Colors.redAccent,
              ),
            ],
          ),
        ],
      ),
    );
  }
}

class _ActionFormCard extends StatelessWidget {
  const _ActionFormCard({
    required this.title,
    required this.subtitle,
    required this.actionLabel,
    required this.icon,
    required this.children,
    required this.onAction,
    required this.submitting,
  });

  final String title;
  final String subtitle;
  final String actionLabel;
  final IconData icon;
  final List<Widget> children;
  final VoidCallback onAction;
  final bool submitting;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(18),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: AppColors.border),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Icon(icon, color: AppColors.primary),
              const SizedBox(width: 8),
              Text(
                title,
                style: const TextStyle(
                  fontWeight: FontWeight.w700,
                  fontSize: 16,
                ),
              ),
            ],
          ),
          const SizedBox(height: 6),
          Text(
            subtitle,
            style: const TextStyle(color: AppColors.textMuted, fontSize: 13),
          ),
          const SizedBox(height: 14),
          ...children,
          const SizedBox(height: 16),
          FilledButton.icon(
            onPressed: submitting ? null : onAction,
            icon: const Icon(Icons.check_circle_outline_rounded),
            label: Text(actionLabel),
            style: FilledButton.styleFrom(
              minimumSize: const Size(double.infinity, 52),
            ),
          ),
        ],
      ),
    );
  }
}

class _QrScannerPage extends StatefulWidget {
  const _QrScannerPage();

  @override
  State<_QrScannerPage> createState() => _QrScannerPageState();
}

class _QrScannerPageState extends State<_QrScannerPage> {
  final MobileScannerController _controller = MobileScannerController();
  bool _handled = false;

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      appBar: AppBar(
        title: const Text('Scan QR'),
        backgroundColor: Colors.black,
        foregroundColor: Colors.white,
      ),
      body: Stack(
        children: [
          MobileScanner(
            controller: _controller,
            onDetect: (capture) {
              if (_handled) return;
              final raw = capture.barcodes
                  .map((b) => b.rawValue)
                  .whereType<String>()
                  .firstWhere(
                    (value) => value.trim().isNotEmpty,
                    orElse: () => '',
                  );
              if (raw.isEmpty) return;
              _handled = true;
              Navigator.of(context).pop(raw);
            },
          ),
          Align(
            alignment: Alignment.bottomCenter,
            child: Container(
              margin: const EdgeInsets.all(20),
              padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 10),
              decoration: BoxDecoration(
                color: Colors.black.withAlpha(160),
                borderRadius: BorderRadius.circular(10),
              ),
              child: const Text(
                'Point camera at any QR code',
                style: TextStyle(color: Colors.white),
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _ParsedScanResult {
  const _ParsedScanResult({
    this.recipientIdentifier,
    this.amountText,
    this.note,
  });

  final String? recipientIdentifier;
  final String? amountText;
  final String? note;
}

class _WalletTransactionCard extends StatelessWidget {
  const _WalletTransactionCard({required this.item});

  final WalletTransactionItem item;

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.only(bottom: 10),
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: AppColors.border, width: 0.5),
      ),
      child: Row(
        children: [
          Container(
            width: 42,
            height: 42,
            decoration: BoxDecoration(
              color: item.isCredit
                  ? const Color(0xFFECFDF3)
                  : const Color(0xFFFEF3F2),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(
              item.isCredit
                  ? Icons.south_west_rounded
                  : Icons.north_east_rounded,
              color: item.isCredit ? AppColors.success : AppColors.error,
              size: 20,
            ),
          ),
          const SizedBox(width: 12),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  item.description,
                  style: const TextStyle(
                    fontWeight: FontWeight.w600,
                    fontSize: 13,
                    color: AppColors.textPrimary,
                  ),
                ),
                const SizedBox(height: 3),
                Text(
                  _formatDate(item.createdAt),
                  style: const TextStyle(
                    color: AppColors.textMuted,
                    fontSize: 12,
                  ),
                ),
              ],
            ),
          ),
          Text(
            '${item.isCredit ? '+' : '-'}₹${item.amount.toStringAsFixed(0)}',
            style: TextStyle(
              fontWeight: FontWeight.w700,
              fontSize: 15,
              color: item.isCredit ? AppColors.success : AppColors.error,
            ),
          ),
        ],
      ),
    );
  }

  String _formatDate(DateTime? value) {
    if (value == null) return '-';
    final local = value.toLocal();
    return '${local.day.toString().padLeft(2, '0')}/${local.month.toString().padLeft(2, '0')}/${local.year}';
  }
}

class _WithdrawCard extends StatelessWidget {
  const _WithdrawCard({required this.item});

  final WithdrawRequestItem item;

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.only(bottom: 10),
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: AppColors.border, width: 0.5),
      ),
      child: Row(
        children: [
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  item.requestNo,
                  style: const TextStyle(
                    fontWeight: FontWeight.w600,
                    fontSize: 13,
                    color: AppColors.textPrimary,
                  ),
                ),
                const SizedBox(height: 3),
                Text(
                  '₹${item.amount.toStringAsFixed(0)}',
                  style: const TextStyle(
                    color: AppColors.textSecondary,
                    fontWeight: FontWeight.w700,
                  ),
                ),
              ],
            ),
          ),
          StatusChip(label: item.status),
        ],
      ),
    );
  }
}

class _BalanceStat extends StatelessWidget {
  const _BalanceStat({
    required this.label,
    required this.value,
    required this.icon,
    required this.iconColor,
  });

  final String label;
  final String value;
  final IconData icon;
  final Color iconColor;

  @override
  Widget build(BuildContext context) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.all(10),
        decoration: BoxDecoration(
          color: Colors.white.withAlpha(25),
          borderRadius: BorderRadius.circular(12),
        ),
        child: Row(
          children: [
            Icon(icon, color: iconColor, size: 16),
            const SizedBox(width: 8),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  label,
                  style: const TextStyle(color: Colors.white60, fontSize: 11),
                ),
                Text(
                  value,
                  style: const TextStyle(
                    color: Colors.white,
                    fontWeight: FontWeight.w700,
                    fontSize: 14,
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
