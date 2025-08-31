<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Notification;
use SnapBi\Config as SnapBiConfig;
use SnapBi\SnapBi;

class MidtransService
{
    public function __construct()
    {
        $this->configureMidtrans();
    }

    /**
     * Konfigurasi Midtrans
     */
    private function configureMidtrans(): void
    {
        // Set konfigurasi dasar Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Set konfigurasi SnapBi untuk QRIS
        SnapBiConfig::$isProduction = config('midtrans.is_production');
        SnapBiConfig::$snapBiClientId = config('midtrans.client_key');
        SnapBiConfig::$snapBiPrivateKey = ""; // Tidak diperlukan untuk basic implementation
        SnapBiConfig::$snapBiClientSecret = ""; // Tidak diperlukan untuk basic implementation
        SnapBiConfig::$snapBiPartnerId = config('midtrans.merchant_id');
        SnapBiConfig::$snapBiChannelId = "7PLAY";
        SnapBiConfig::$enableLogging = !config('app.env') === 'production';
    }

    /**
     * Buat pembayaran QRIS untuk order
     */
    public function createQrisPayment(Order $order): Payment
    {
        try {
            $external_id = "7play-" . $order->id . "-" . time();
            $valid_until = now()->addMinutes(config('midtrans.qris.validity_period_minutes'))->format('c');

            $qris_body = [
                "partnerReferenceNo" => $external_id,
                "amount" => [
                    "value" => number_format($order->total_amount, 2, '.', ''),
                    "currency" => config('midtrans.qris.currency', 'IDR')
                ],
                "merchantId" => config('midtrans.merchant_id'),
                "validityPeriod" => $valid_until,
                "additionalInfo" => [
                    "acquirer" => "gopay",
                    "items" => $this->formatOrderItems($order),
                    "customerDetails" => $this->formatCustomerDetails($order),
                    "countryCode" => "ID",
                    "locale" => "id_ID"
                ]
            ];

            // Buat payment record di database
            $payment = Payment::create([
                'order_id' => $order->id,
                'external_id' => $external_id,
                'merchant_id' => config('midtrans.merchant_id'),
                'amount' => $order->total_amount,
                'currency' => config('midtrans.qris.currency', 'IDR'),
                'payment_method' => 'qris',
                'payment_type' => 'qris',
                'status' => 'pending',
                'expiry_time' => $valid_until,
                'customer_details' => $this->formatCustomerDetails($order),
                'item_details' => $this->formatOrderItems($order),
                'metadata' => [
                    'order_id' => $order->id,
                    'cinema_name' => $order->orderItems->first()?->showtime?->cinemaHall?->cinema?->name,
                    'movie_title' => $order->orderItems->first()?->showtime?->movie?->title,
                    'showtime' => $order->orderItems->first()?->showtime?->start_time,
                ]
            ]);

            // Panggil Midtrans API untuk membuat QRIS
            $snapbi_response = SnapBi::qris()
                ->withBody($qris_body)
                ->createPayment($external_id);

            // Update payment dengan response dari Midtrans
            $payment->update([
                'reference_no' => $snapbi_response->originalReferenceNo ?? null,
                'qr_code_url' => $snapbi_response->qrCodeUrl ?? null,
                'deep_link_url' => $snapbi_response->deepLinkUrl ?? null,
                'raw_response' => $snapbi_response
            ]);

            return $payment;

        } catch (Exception $e) {
            Log::error('Error creating QRIS payment', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception('Gagal membuat pembayaran QRIS: ' . $e->getMessage());
        }
    }

    /**
     * Format item details untuk Midtrans
     */
    private function formatOrderItems(Order $order): array
    {
        $items = [];
        
        foreach ($order->orderItems as $item) {
            $showtime = $item->showtime;
            $movie = $showtime->movie;
            $cinema = $showtime->cinemaHall->cinema;

            $items[] = [
                "id" => "ticket-{$item->id}",
                "price" => [
                    "value" => number_format($item->price, 2, '.', ''),
                    "currency" => config('midtrans.qris.currency', 'IDR')
                ],
                "quantity" => $item->quantity,
                "name" => "{$movie->title} - {$cinema->name}",
                "brand" => "7PLAY Cinema",
                "category" => "Entertainment",
                "merchantName" => "7PLAY"
            ];
        }

        return $items;
    }

    /**
     * Format customer details untuk Midtrans
     */
    private function formatCustomerDetails(Order $order): array
    {
        $user = $order->user;
        
        return [
            "email" => $user->email,
            "firstName" => $user->name ?? 'Customer',
            "lastName" => "",
            "phone" => $user->phone ?? "+62" . rand(10000000, 99999999) // Generate dummy jika tidak ada
        ];
    }

    /**
     * Handle webhook notification dari Midtrans
     */
    public function handleNotification(): array
    {
        try {
            $notification = new Notification();
            
            Log::info('Midtrans Notification received', [
                'order_id' => $notification->order_id,
                'transaction_status' => $notification->transaction_status,
                'fraud_status' => $notification->fraud_status,
                'payment_type' => $notification->payment_type
            ]);

            // Cari payment berdasarkan order_id
            $payment = Payment::where('external_id', $notification->order_id)->first();
            
            if (!$payment) {
                throw new Exception("Payment tidak ditemukan untuk order_id: {$notification->order_id}");
            }

            // Update status payment berdasarkan notification
            $this->updatePaymentStatus($payment, $notification);

            return [
                'status' => 'success',
                'message' => 'Notification processed successfully',
                'payment_id' => $payment->id
            ];

        } catch (Exception $e) {
            Log::error('Error handling Midtrans notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Update status payment berdasarkan notification
     */
    private function updatePaymentStatus(Payment $payment, Notification $notification): void
    {
        $transaction_status = $notification->transaction_status;
        $fraud_status = $notification->fraud_status;

        // Update payment data
        $payment->update([
            'status' => $transaction_status,
            'fraud_status' => $fraud_status,
            'settlement_time' => $transaction_status === 'settlement' ? now() : null,
            'raw_response' => array_merge($payment->raw_response ?? [], [
                'notification_' . time() => (array) $notification
            ])
        ]);

        // Update order status berdasarkan payment status
        $order = $payment->order;
        if (!$order) {
            return;
        }

        switch ($transaction_status) {
            case 'settlement':
                if ($fraud_status === 'accept') {
                    $order->update(['status' => 'paid']);
                    Log::info("Order {$order->id} marked as paid");
                }
                break;
                
            case 'pending':
                $order->update(['status' => 'pending_payment']);
                break;
                
            case 'deny':
            case 'cancel':
            case 'expire':
            case 'failure':
                $order->update(['status' => 'cancelled']);
                Log::info("Order {$order->id} marked as cancelled due to payment {$transaction_status}");
                break;
        }
    }

    /**
     * Check status payment dari Midtrans
     */
    public function checkPaymentStatus(Payment $payment): array
    {
        try {
            $status_body = [
                "originalReferenceNo" => $payment->reference_no,
                "originalPartnerReferenceNo" => $payment->external_id,
                "merchantId" => $payment->merchant_id,
                "serviceCode" => "54"
            ];

            $response = SnapBi::qris()
                ->withBody($status_body)
                ->getStatus($payment->external_id);

            // Update payment dengan status terbaru
            $this->updatePaymentFromStatusCheck($payment, $response);

            return [
                'status' => 'success',
                'payment_status' => $response->latestTransactionStatus ?? 'unknown',
                'data' => $response
            ];

        } catch (Exception $e) {
            Log::error('Error checking payment status', [
                'payment_id' => $payment->id,
                'external_id' => $payment->external_id,
                'error' => $e->getMessage()
            ]);

            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Update payment dari hasil status check
     */
    private function updatePaymentFromStatusCheck(Payment $payment, $response): void
    {
        $status_mapping = [
            '00' => 'settlement',
            '01' => 'pending',
            '02' => 'pending',
            '03' => 'pending',
            '04' => 'failure',
            '05' => 'failure',
        ];

        $midtrans_status = $response->latestTransactionStatus ?? '';
        $new_status = $status_mapping[$midtrans_status] ?? $payment->status;

        if ($new_status !== $payment->status) {
            $payment->update([
                'status' => $new_status,
                'settlement_time' => $new_status === 'settlement' ? now() : null,
                'raw_response' => array_merge($payment->raw_response ?? [], [
                    'status_check_' . time() => (array) $response
                ])
            ]);

            // Update order status juga
            $order = $payment->order;
            if ($order && $new_status === 'settlement') {
                $order->update(['status' => 'paid']);
            } elseif ($order && in_array($new_status, ['failure', 'cancel', 'expire'])) {
                $order->update(['status' => 'cancelled']);
            }
        }
    }
}
