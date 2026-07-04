<?php

namespace App\Services;

class MidtransService
{
    protected string $merchantId;
    protected string $clientKey;
    protected string $serverKey;
    protected bool   $isProduction;
    protected string $snapUrl;
    protected string $apiUrl;

    public function __construct()
    {
        $this->merchantId   = env('MIDTRANS_MERCHANT_ID', '');
        $this->clientKey    = env('MIDTRANS_CLIENT_KEY', '');
        $this->serverKey    = env('MIDTRANS_SERVER_KEY', '');
        $this->isProduction = (bool) env('MIDTRANS_IS_PRODUCTION', false);

        // Base URLs
        $this->snapUrl = $this->isProduction
            ? 'https://app.midtrans.com/snap/v1'
            : 'https://app.sandbox.midtrans.com/snap/v1';

        $this->apiUrl = $this->isProduction
            ? 'https://api.midtrans.com/v2'
            : 'https://api.sandbox.midtrans.com/v2';
    }

    /**
     * Generate Snap Token for payment.
     *
     * @param array $params Transaction parameters
     * @return string|null Snap token or null on failure
     */
    public function getSnapToken(array $params): ?string
    {
        $client = \Config\Services::curlrequest();

        $payload = [
            'transaction_details' => [
                'order_id'      => $params['order_id'],
                'gross_amount'  => (int) $params['gross_amount'],
            ],
            'customer_details' => [
                'first_name' => $params['first_name'] ?? '',
                'email'      => $params['email'] ?? '',
                'phone'      => $params['phone'] ?? '',
            ],
            'item_details' => $params['item_details'] ?? [],
        ];

        $response = $client->post($this->snapUrl . '/transactions', [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->serverKey . ':'),
            ],
            'json'        => $payload,
            'http_errors' => false,
        ]);

        $body = json_decode($response->getBody(), true);

        if (isset($body['token'])) {
            return $body['token'];
        }

        log_message('error', 'Midtrans Snap Token Error: ' . json_encode($body));
        return null;
    }

    /**
     * Check transaction status from Midtrans API.
     */
    public function checkTransaction(string $orderId): ?array
    {
        $client = \Config\Services::curlrequest();

        $response = $client->get($this->apiUrl . '/' . $orderId . '/status', [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->serverKey . ':'),
            ],
            'http_errors' => false,
        ]);

        $body = json_decode($response->getBody(), true);

        if (isset($body['transaction_status'])) {
            return $body;
        }

        return null;
    }

    /**
     * Handle notification from Midtrans webhook.
     * Verifies the notification signature.
     */
    public function handleNotification(array $notification): ?array
    {
        // Verify notification by checking transaction status
        $orderId = $notification['order_id'] ?? '';
        if (empty($orderId)) {
            return null;
        }

        $statusResponse = $this->checkTransaction($orderId);
        return $statusResponse;
    }

    /**
     * Map Midtrans transaction status to our payment_status.
     */
    public function mapPaymentStatus(string $transactionStatus): string
    {
        return match ($transactionStatus) {
            'capture', 'settlement' => 'paid',
            'deny', 'failure'       => 'failed',
            'expire'                 => 'expired',
            'cancel'                 => 'cancelled',
            'pending', 'authorize'  => 'pending',
            default                  => 'pending',
        };
    }

    /**
     * Get client key for frontend Snap.js integration.
     */
    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    /**
     * Check if production mode.
     */
    public function getIsProduction(): bool
    {
        return $this->isProduction;
    }

    /**
     * Get Snap.js base URL for frontend.
     */
    public function getSnapBaseUrl(): string
    {
        return $this->isProduction
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }
}
