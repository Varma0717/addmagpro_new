import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';

import '../../../core/theme/app_theme.dart';

class SupportScreen extends StatelessWidget {
  const SupportScreen({super.key});

  Future<void> _openUri(BuildContext context, Uri uri) async {
    final ok = await launchUrl(uri, mode: LaunchMode.externalApplication);
    if (!ok && context.mounted) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Unable to open support link')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Support')),
      body: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: AppColors.primaryLight,
              borderRadius: BorderRadius.circular(14),
              border: Border.all(color: AppColors.primary.withAlpha(40)),
            ),
            child: const Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  'Need Help?',
                  style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.w700,
                    color: AppColors.textPrimary,
                  ),
                ),
                SizedBox(height: 6),
                Text(
                  'Contact our support team for account, payment, order, and app issues.',
                  style: TextStyle(color: AppColors.textSecondary),
                ),
              ],
            ),
          ),
          const SizedBox(height: 16),
          ListTile(
            leading: const Icon(Icons.call_outlined, color: AppColors.primary),
            title: const Text('Call Support'),
            subtitle: const Text('+91 94940 12003'),
            onTap: () => _openUri(context, Uri.parse('tel:+919494012003')),
          ),
          const Divider(height: 1),
          ListTile(
            leading: const Icon(Icons.chat_outlined, color: Colors.green),
            title: const Text('WhatsApp Support'),
            subtitle: const Text('Chat with support team'),
            onTap: () =>
                _openUri(context, Uri.parse('https://wa.me/919494012003')),
          ),
          const Divider(height: 1),
          ListTile(
            leading: const Icon(Icons.email_outlined, color: AppColors.info),
            title: const Text('Email Support'),
            subtitle: const Text('support@addmagpro.com'),
            onTap: () =>
                _openUri(context, Uri.parse('mailto:support@addmagpro.com')),
          ),
          const Divider(height: 1),
          ListTile(
            leading: const Icon(
              Icons.language_outlined,
              color: AppColors.textPrimary,
            ),
            title: const Text('Visit Website'),
            subtitle: const Text('www.addmagpro.com'),
            onTap: () =>
                _openUri(context, Uri.parse('https://www.addmagpro.com')),
          ),
        ],
      ),
    );
  }
}
