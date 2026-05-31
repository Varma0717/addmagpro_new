<?php

namespace App\Services;

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Exception;

class RazorpayService
{
    protected \Razorpay\Api\Api $api;

    public function __construct()
    {
        $this->api = new Api(
            config('razorpay.key_id'),
            config('razorpay.key_secret')
        );
    }

    /**
     * Create a Razorpay order
     */
    public function createOrder(
        string $orderId,
        int $amount,
        string $currency = 'INR',
        string $customerName = null,
        string $customerEmail = null,
        string $customerPhone = null,
        string $description = null,
        array $metadata = []
    ): array {
        try {
            $data = [
                'amount' => $amount, // in paise
                'currency' => $currency,
                'receipt' => $orderId,
            ];

            if ($description) {
                $data['description'] = $description;
            }

            // Add metadata
            if (!empty($metadata)) {
                $data['notes'] = $metadata;
            }

            $order = $this->api->order->create($data);

            return $order->toArray();
        } catch (Exception $e) {
            throw new Exception('Failed to create Razorpay order: ' . $e->getMessage());
        }
    }

    /**
     * Get order details
     */
    public function getOrder(string $orderId): array
    {
        try {
            $order = $this->api->order->fetch($orderId);
            return $order->toArray();
        } catch (Exception $e) {
            throw new Exception('Failed to fetch order: ' . $e->getMessage());
        }
    }

    /**
     * Get payment details
     */
    public function getPayment(string $paymentId): array
    {
        try {
            $payment = $this->api->payment->fetch($paymentId);
            return $payment->toArray();
        } catch (Exception $e) {
            throw new Exception('Failed to fetch payment: ' . $e->getMessage());
        }
    }

    /**
     * Verify payment signature
     */
    public function verifyPaymentSignature(string $orderId, string $paymentId, string $signature): bool
    {
        try {
            $this->api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
            ]);

            return true;
        } catch (SignatureVerificationError $e) {
            return false;
        } catch (Exception $e) {
            throw new Exception('Error verifying signature: ' . $e->getMessage());
        }
    }

    /**
     * Capture payment
     */
    public function capturePayment(string $paymentId, int $amount, string $currency = 'INR'): array
    {
        try {
            $payment = $this->api->payment->fetch($paymentId);
            $payment->capture($amount, $currency);

            return $payment->toArray();
        } catch (Exception $e) {
            throw new Exception('Failed to capture payment: ' . $e->getMessage());
        }
    }

    /**
     * Refund payment
     */
    public function refundPayment(string $paymentId, int $amount = null, array $notes = []): array
    {
        try {
            $data = [];

            if ($amount) {
                $data['amount'] = $amount; // in paise
            }

            if (!empty($notes)) {
                $data['notes'] = $notes;
            }

            $refund = $this->api->payment->fetch($paymentId)->refund($data);

            return $refund->toArray();
        } catch (Exception $e) {
            throw new Exception('Failed to refund payment: ' . $e->getMessage());
        }
    }

    /**
     * Create QR code for payments
     */
    public function createQRCode(
        string $amount,
        string $description = 'Payment to AdMagPro',
        array $metadata = []
    ): array {
        try {
            $data = [
                'amount' => $amount, // in paise
                'currency' => 'INR',
                'description' => $description,
                'customer_notification' => 1,
                'close_reason' => 'on_demand',
                'closed_reason' => 'on_demand',
            ];

            if (!empty($metadata)) {
                $data['notes'] = $metadata;
            }

            // Note: QR code creation requires specific API endpoint
            // This is a placeholder - actual implementation depends on Razorpay API version
            $qrCode = $this->api->qrCode->create($data);

            return $qrCode->toArray();
        } catch (Exception $e) {
            throw new Exception('Failed to create QR code: ' . $e->getMessage());
        }
    }

    /**
     * Get refund details
     */
    public function getRefund(string $refundId): array
    {
        try {
            $refund = $this->api->refund->fetch($refundId);
            return $refund->toArray();
        } catch (Exception $e) {
            throw new Exception('Failed to fetch refund: ' . $e->getMessage());
        }
    }

    /**
     * Get refunds for a payment
     */
    public function getRefundsForPayment(string $paymentId): array
    {
        try {
            $refunds = $this->api->payment->fetch($paymentId)->refunds();
            return $refunds->toArray();
        } catch (Exception $e) {
            throw new Exception('Failed to fetch refunds: ' . $e->getMessage());
        }
    }

    /**
     * Create invoice
     */
    public function createInvoice(
        string $customerId,
        string $description,
        int $amount,
        string $currency = 'INR',
        array $notes = []
    ): array {
        try {
            $data = [
                'customer_id' => $customerId,
                'description' => $description,
                'amount' => $amount, // in paise
                'currency' => $currency,
                'expire_by' => now()->addDays(7)->timestamp,
                'sms_notify' => 1,
                'email_notify' => 1,
            ];

            if (!empty($notes)) {
                $data['notes'] = $notes;
            }

            $invoice = $this->api->invoice->create($data);
            return $invoice->toArray();
        } catch (Exception $e) {
            throw new Exception('Failed to create invoice: ' . $e->getMessage());
        }
    }

    /**
     * Validate Razorpay response
     */
    public function validateWebhook(string $payload, string $signature): bool
    {
        try {
            $expectedSignature = hash_hmac(
                'sha256',
                $payload,
                config('razorpay.webhook_secret')
            );

            return hash_equals($expectedSignature, $signature);
        } catch (Exception $e) {
            return false;
        }
    }
}
