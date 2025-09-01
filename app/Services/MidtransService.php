<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\CoreApi;
use Midtrans\Transaction;

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
        // Set konfigurasi dasar Midtrans (Core API)
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Buat pembayaran QRIS untuk order
     */
    public function createQrisPayment(Order $order): Payment
    {
        try {
            $externalId = '7play-' . $order->id . '-' . time();
            $grossAmount = (int) round($order->total_amount);

            $payload = [
                'payment_type' => 'qris',
                'transaction_details' => [
                    'order_id' => $externalId,
                    'gross_amount' => $grossAmount,
                ],
                'qris' => ['acquirer' => 'gopay'],
                'item_details' => array_map(function ($item) use ($order) {
                    return [
                        'id' => 'ticket-' . $item->id,
                        'price' => (int) round($item->price),
                        'quantity' => 1,
                        'name' => $order->showtime?->movie?->title ?? 'Tiket',
                    ];
                }, $order->orderItems->all()),
                'customer_details' => [
                    'first_name' => $order->user->name ?? 'Customer',
                    'email' => $order->user->email,
                    'phone' => $order->user->phone ?? '+62' . rand(10000000,99999999),
                ],
            ];

            $resp = CoreApi::charge($payload);
            $respArray = json_decode(json_encode($resp), true);
            
            // Debug log untuk melihat response dari Midtrans
            Log::info('Midtrans QRIS Charge Response', [
                'order_id' => $order->id,
                'external_id' => $externalId,
                'response' => json_encode($resp, JSON_PRETTY_PRINT),
                'qr_url' => $resp->qr_url ?? 'NULL',
                'actions' => isset($resp->actions) ? json_encode($resp->actions) : 'NULL',
                'qr_string' => $resp->qr_string ?? 'NULL'
            ]);

            $payment = Payment::create([
                'order_id' => (string) $order->id,
                'external_id' => $externalId,
                'merchant_id' => config('midtrans.merchant_id'),
                'amount' => $order->total_amount,
                'currency' => 'IDR',
                'payment_method' => 'qris',
                'payment_type' => 'qris',
                'status' => $respArray['transaction_status'] ?? 'pending',
                'reference_no' => $respArray['transaction_id'] ?? null,
                'expiry_time' => now()->addMinutes((int) config('midtrans.qris.validity_period_minutes')),
                'customer_details' => $payload['customer_details'],
                'item_details' => array_map(function ($i) {
                    return ['id' => $i['id'], 'price' => $i['price'], 'quantity' => 1, 'name' => $i['name']];
                }, $payload['item_details']),
                'raw_response' => $respArray,
            ]);

            $qrUrl = $respArray['qr_url'] ?? null;
            if (!$qrUrl && !empty($respArray['actions']) && is_array($respArray['actions'])) {
                foreach ($respArray['actions'] as $a) {
                    $name = $a['name'] ?? '';
                    $url = $a['url'] ?? null;
                    if ($name === 'generate-qr-code' && !empty($url)) { $qrUrl = (string) $url; break; }
                }
            }
            if (!$qrUrl && isset($respArray['qr_string'])) {
                // Fallback: render QR locally via public QR service
                $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode((string) $respArray['qr_string']);
            }

            // Log hasil QR URL yang didapat
            Log::info('QR URL Processing Result', [
                'order_id' => $order->id,
                'qr_url_from_resp' => $respArray['qr_url'] ?? 'NULL',
                'actions_count' => isset($respArray['actions']) && is_array($respArray['actions']) ? count($respArray['actions']) : 0,
                'qr_string_exists' => isset($respArray['qr_string']),
                'final_qr_url' => $qrUrl,
                'payment_id' => $payment->id
            ]);

            if ($qrUrl) {
                $payment->update(['qr_code_url' => $qrUrl]);
                Log::info('Payment QR URL Updated', ['payment_id' => $payment->id, 'qr_url' => $qrUrl]);
            }

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
        
        $showtime = $order->showtime;
        $movie = $showtime?->movie;
        $cinema = $showtime?->cinemaHall?->cinema;

        foreach ($order->orderItems as $item) {

            $items[] = [
                "id" => "ticket-{$item->id}",
                "price" => [
                    "value" => number_format($item->price, 2, '.', ''),
                    "currency" => config('midtrans.qris.currency', 'IDR')
                ],
                "quantity" => 1,
                "name" => trim(($movie->title ?? 'Tiket') . ' - ' . ($cinema->name ?? 'Cinema')),
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
            $resp = Transaction::status($payment->external_id);
            $respArray = json_decode(json_encode($resp), true);
            $status = $resp->transaction_status ?? 'pending';
            // Merge raw response safely without casting non-arrays directly
            $existing_raw = is_array($payment->raw_response) ? $payment->raw_response : [];
            $resp_array = is_array($respArray) ? $respArray : [];

            $payment->update([
                'status' => $status,
                'settlement_time' => $status === 'settlement' ? now() : null,
                'raw_response' => array_merge($existing_raw, ['status_check_' . time() => $resp_array]),
            ]);
            // Update/derive QR URL when available in status response
            if (empty($payment->qr_code_url)) {
                $qrUrl = $respArray['qr_url'] ?? null;
                if (!$qrUrl && !empty($respArray['actions']) && is_array($respArray['actions'])) {
                    foreach ($respArray['actions'] as $a) {
                        $name = $a['name'] ?? '';
                        $url = $a['url'] ?? null;
                        if ($name === 'generate-qr-code' && !empty($url)) { $qrUrl = (string) $url; break; }
                    }
                }
                if (!$qrUrl && isset($respArray['qr_string'])) {
                    $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode((string) $respArray['qr_string']);
                }
                if ($qrUrl) {
                    $payment->update(['qr_code_url' => $qrUrl]);
                }
            }
            $order = $payment->order;
            if ($order) {
                if ($status === 'settlement') $order->update(['status' => 'paid']);
                elseif (in_array($status, ['deny','cancel','expire','failure'])) $order->update(['status' => 'cancelled']);
            }
            return ['status' => 'success', 'payment_status' => $status, 'data' => $resp];

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
