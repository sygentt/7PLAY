<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PointTransaction;
use App\Models\UserPoint;
use App\Models\SeatReservation;
use App\Models\OrderItem;
use App\Models\UserVoucher;
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
     * Set konfigurasi Midtrans untuk Core API.
     */
    private function configureMidtrans(): void
    {
        // Terapkan konfigurasi dasar Midtrans (Core API)
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Buat pembayaran QRIS untuk sebuah pesanan.
     */
    public function createQrisPayment(Order $order): Payment
    {
        try {
            $externalId = '7play-' . $order->id . '-' . time();
            $grossAmount = (int) round($order->total_amount);

            // Susun item_details agar sesuai dengan gross_amount (subtotal - diskon)
            $itemDetails = array_map(function ($item) use ($order) {
                return [
                    'id' => 'ticket-' . $item->id,
                    'price' => (int) round($item->price),
                    'quantity' => 1,
                    'name' => $order->showtime?->movie?->title ?? 'Tiket',
                ];
            }, $order->orderItems->all());

            // Tambahkan item diskon sebagai nilai negatif jika tersedia
            $discountAmount = (int) round(max(0, (float) $order->discount_amount));
            if ($discountAmount > 0) {
                $itemDetails[] = [
                    'id' => 'discount',
                    'price' => -$discountAmount,
                    'quantity' => 1,
                    'name' => 'Voucher Discount',
                ];
            }

            $payload = [
                'payment_type' => 'qris',
                'transaction_details' => [
                    'order_id' => $externalId,
                    'gross_amount' => $grossAmount,
                ],
                'qris' => ['acquirer' => 'gopay'],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $order->user->name ?? 'Customer',
                    'email' => $order->user->email,
                    'phone' => $order->user->phone ?? '+62' . rand(10000000,99999999),
                ],
            ];

            $resp = CoreApi::charge($payload);
            $respArray = json_decode(json_encode($resp), true);
            
            // Catat response Midtrans untuk kebutuhan debug
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
                'expiry_time' => now()->addMinutes((int) config('booking.ttl_minutes', (int) config('midtrans.qris.validity_period_minutes', 10))),
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
                // Alternatif: render QR secara lokal melalui layanan QR publik
                $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode((string) $respArray['qr_string']);
            }

            // Catat hasil URL QR yang diperoleh
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
                Log::info('Payment QR URL diperbarui', ['payment_id' => $payment->id, 'qr_url' => $qrUrl]);
            }

            return $payment;

        } catch (Exception $e) {
            Log::error('Gagal membuat pembayaran QRIS', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new Exception('Gagal membuat pembayaran QRIS: ' . $e->getMessage());
        }
    }

    /**
     * Format daftar item untuk Midtrans.
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
     * Format detail pelanggan untuk Midtrans.
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
     * Tangani webhook notifikasi dari Midtrans.
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

            // Validasi opsional: token callback dan daftar IP yang diizinkan
            try {
                $this->assertValidWebhookRequest();
            } catch (\Throwable $sec) {
                Log::warning('Midtrans webhook rejected by security check', ['error' => $sec->getMessage()]);
                return [ 'status' => 'ignored', 'message' => 'Invalid webhook source' ];
            }

            // Cari payment berdasarkan order_id
            $payment = Payment::where('external_id', $notification->order_id)->first();
            
            if (!$payment) {
                throw new Exception("Payment tidak ditemukan untuk order_id: {$notification->order_id}");
            }

            // Perbarui status payment berdasarkan notifikasi
            $this->updatePaymentStatus($payment, $notification);

            return [
                'status' => 'success',
                'message' => 'Notification processed successfully',
                'payment_id' => $payment->id
            ];

        } catch (Exception $e) {
            Log::error('Terjadi kesalahan saat memproses notifikasi Midtrans', [
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
     * Perbarui status payment berdasarkan notifikasi.
     */
    private function updatePaymentStatus(Payment $payment, Notification $notification): void
    {
        $transaction_status = $notification->transaction_status;
        $fraud_status = $notification->fraud_status;

        // Perbarui data payment
        $payment->update([
            'status' => $transaction_status,
            'fraud_status' => $fraud_status,
            'settlement_time' => $transaction_status === 'settlement' ? now() : null,
            'raw_response' => array_merge($payment->raw_response ?? [], [
                'notification_' . time() => (array) $notification
            ])
        ]);

        // Perbarui status order berdasarkan status payment
        $order = $payment->order;
        if (!$order) {
            return;
        }

        switch ($transaction_status) {
            case 'settlement':
                if ($fraud_status === 'accept') {
                    // Tandai order sebagai dibayar, isi data pembayaran, dan konfirmasi kursi
                    try {
                        $this->finalizeOrderOnSettlement($order, $payment, $notification);
                    } catch (\Throwable $e) {
                        Log::error('Finalize settlement failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                    }
                    // Antrikan email e-ticket
                    try {
                        \App\Jobs\SendEticketEmailJob::dispatch((int) $order->id)->onQueue('default');
                    } catch (\Throwable $e) {
                        Log::error('Queue Eticket email failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                    }
                    Log::info("Order {$order->id} marked as paid");
                    // Berikan poin setelah settlement
                    try {
                        $this->awardPointsForOrder($order->user_id, (int) round($order->total_amount), (string) $order->id);
                    } catch (Exception $e) {
                        Log::error('Award points failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                    }
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
                try {
                    $this->handleOrderOnCancelOrExpire($order);
                } catch (\Throwable $e) {
                    Log::error('Handle cancel/expire failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                }
                Log::info("Order {$order->id} marked as cancelled due to payment {$transaction_status}");
                break;
        }
    }

    /**
     * Periksa status payment ke Midtrans.
     */
    public function checkPaymentStatus(Payment $payment): array
    {
        try {
            $resp = Transaction::status($payment->external_id);
            $respArray = json_decode(json_encode($resp), true);
            $status = $resp->transaction_status ?? 'pending';
            // Gabungkan raw response dengan aman tanpa memaksa tipe non-array
            $existing_raw = is_array($payment->raw_response) ? $payment->raw_response : [];
            $resp_array = is_array($respArray) ? $respArray : [];

            $payment->update([
                'status' => $status,
                'settlement_time' => $status === 'settlement' ? now() : null,
                'raw_response' => array_merge($existing_raw, ['status_check_' . time() => $resp_array]),
            ]);
            // Perbarui/ambil QR URL jika tersedia pada response status
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
                if ($status === 'settlement') {
                    try {
                        $this->finalizeOrderOnSettlement($order, $payment, null);
                    } catch (\Throwable $e) {
                        Log::error('Finalize settlement (polling) failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                    }
                    // Berikan poin juga di jalur polling (idempoten di awardPointsForOrder)
                    try {
                        $this->awardPointsForOrder((int) $order->user_id, (int) round($order->total_amount), (string) $order->id);
                    } catch (Exception $e) {
                        Log::error('Award points (polling) failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                    }
                } elseif (in_array($status, ['deny','cancel','expire','failure'])) {
                    $order->update(['status' => 'cancelled']);
                    try {
                        $this->handleOrderOnCancelOrExpire($order);
                    } catch (\Throwable $e) {
                        Log::error('Handle cancel/expire (polling) failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                    }
                }
            }
            return ['status' => 'success', 'payment_status' => $status, 'data' => $resp];

        } catch (Exception $e) {
            Log::error('Gagal memeriksa status pembayaran', [
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
     * Perbarui payment dari hasil pemeriksaan status.
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

            // Perbarui status order juga
            $order = $payment->order;
            if ($order && $new_status === 'settlement') {
                try {
                    $this->finalizeOrderOnSettlement($order, $payment, null);
                } catch (\Throwable $e) {
                    Log::error('Finalize settlement (status check) failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                }
            } elseif ($order && in_array($new_status, ['failure', 'cancel', 'expire'])) {
                $order->update(['status' => 'cancelled']);
                try {
                    $this->handleOrderOnCancelOrExpire($order);
                } catch (\Throwable $e) {
                    Log::error('Handle cancel/expire (status check) failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                }
            }
        }
    }

    /**
     * Berikan poin ke pengguna berdasarkan nominal order dan level member.
     */
    private function awardPointsForOrder(int $user_id, int $amount_idr, string $order_id): void
    {
        $earn_per_rupiah = (int) config('points.earn_per_rupiah', 10000);
        $min_per_order = (int) config('points.min_per_order', 1);

        $user_points = UserPoint::firstOrCreate(['user_id' => $user_id], [
            'total_points' => 0,
            'total_orders' => 0,
            'membership_level' => 'bronze',
        ]);

        // Idempoten: jika transaksi untuk order ini sudah ada, lewati
        $already = PointTransaction::where('user_id', $user_id)
            ->where('order_id', $order_id)
            ->where('type', 'earned')
            ->exists();
        if ($already) {
            return;
        }

        $base_points = max((int) floor($amount_idr / max($earn_per_rupiah, 1)), $min_per_order);
        $mult = (float) (config('points.multipliers.' . $user_points->membership_level, 1.0));
        $earned = (int) max(1, round($base_points * $mult));

        // Perbarui total poin dan order
        $user_points->increment('total_points', $earned);
        $user_points->increment('total_orders');
        $user_points->update(['last_order_date' => now()]);

        // Update membership level based on new points total
        $user_points->fresh()->updateMembershipLevel();

        // Catat transaksi poin
        PointTransaction::create([
            'user_id' => $user_id,
            'type' => 'earned',
            'points' => $earned,
            'description' => 'Poin dari order #' . $order_id,
            'order_id' => $order_id,
        ]);
    }

    /**
     * Validasi webhook Midtrans via token callback atau IP sumber.
     */
    private function assertValidWebhookRequest(): void
    {
        $allowed_ips = (array) config('midtrans.webhook.allowed_ips', []);
        $callback_token = (string) config('midtrans.webhook.callback_token', '');

        $request = request();
        $remote_ip = $request->ip();

        // Utamakan token callback melalui header X-Callback-Token (custom) atau query param
        $header_token = $request->header('X-Callback-Token', $request->query('callback_token'));
        if (!empty($callback_token)) {
            if (!hash_equals($callback_token, (string) $header_token)) {
                throw new \RuntimeException('Invalid callback token');
            }
            return; // token passes, skip IP check
        }

        // Jika daftar IP diatur, wajibkan pemeriksaan ini
        if (!empty($allowed_ips)) {
            if (!in_array($remote_ip, $allowed_ips, true)) {
                throw new \RuntimeException('IP not allowed: ' . $remote_ip);
            }
        }
    }

    /**
     * Finalisasi order saat settlement: isi data pembayaran, konfirmasi kursi, tandai voucher terpakai.
     */
    private function finalizeOrderOnSettlement(Order $order, Payment $payment, ?Notification $notification): void
    {
        // Perbarui kolom pembayaran order dan statusnya
        $payment_method = $payment->payment_method ?? ($notification->payment_type ?? null);
        $payment_reference = $payment->reference_no
            ?? ($payment->raw_response['transaction_id'] ?? null)
            ?? ($notification->transaction_id ?? null);

        $order->update([
            'status' => Order::STATUS_PAID,
            'payment_method' => $payment_method,
            'payment_reference' => $payment_reference,
            'payment_date' => now(),
            'payment_data' => array_merge((array) ($order->payment_data ?? []), [
                'payment_id' => $payment->id,
                'external_id' => $payment->external_id,
                'settlement_time' => $payment->settlement_time?->toISOString(),
            ]),
        ]);

        // Konfirmasi reservasi kursi pada order ini
        $seatIds = $order->orderItems()->pluck('seat_id')->all();
        if (!empty($seatIds)) {
            SeatReservation::query()
                ->where('showtime_id', $order->showtime_id)
                ->whereIn('seat_id', $seatIds)
                ->whereIn('status', [SeatReservation::STATUS_RESERVED, SeatReservation::STATUS_EXPIRED])
                ->update(['status' => SeatReservation::STATUS_CONFIRMED]);
        }

        // Tandai voucher pengguna sebagai terpakai jika ada
        if (!empty($order->voucher_id)) {
            $userVoucher = UserVoucher::query()
                ->where('user_id', $order->user_id)
                ->where('voucher_id', $order->voucher_id)
                ->where('is_used', false)
                ->orderBy('redeemed_at')
                ->orderBy('id')
                ->first();
            if ($userVoucher) {
                $userVoucher->update([
                    'is_used' => true,
                    'used_at' => now(),
                    'order_id' => $order->id,
                ]);
            }
        }
    }

    /**
     * Lakukan rollback kursi dan voucher saat order dibatalkan atau kedaluwarsa.
     */
    private function handleOrderOnCancelOrExpire(Order $order): void
    {
        // Batalkan item pada order
        $order->orderItems()->update(['status' => OrderItem::STATUS_CANCELLED]);

        // Lepaskan reservasi kursi (tandai sebagai kedaluwarsa)
        $seatIds = $order->orderItems()->pluck('seat_id')->all();
        if (!empty($seatIds)) {
            SeatReservation::query()
                ->where('showtime_id', $order->showtime_id)
                ->whereIn('seat_id', $seatIds)
                ->whereIn('status', [SeatReservation::STATUS_RESERVED, SeatReservation::STATUS_CONFIRMED])
                ->update(['status' => SeatReservation::STATUS_EXPIRED]);
        }

        // Pulihkan penggunaan voucher jika sebelumnya ditandai terpakai oleh order ini
        $usedVoucher = UserVoucher::query()
            ->where('order_id', $order->id)
            ->where('is_used', true)
            ->first();
        if ($usedVoucher) {
            $usedVoucher->update([
                'is_used' => false,
                'used_at' => null,
                'order_id' => null,
            ]);
        }
    }
}
