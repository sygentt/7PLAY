<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\MidtransService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private MidtransService $midtrans_service;

    public function __construct(MidtransService $midtrans_service)
    {
        $this->midtrans_service = $midtrans_service;
    }

    /**
     * Tampilkan halaman pilihan metode pembayaran
     */
    public function showPaymentMethods(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke order ini.');
        }

        // Pastikan order belum dibayar
        if ($order->status === 'paid') {
            return redirect()->route('home')
                ->with('info', 'Order ini sudah dibayar.');
        }

        return view('payments.methods', compact('order'));
    }

    /**
     * Buat pembayaran QRIS
     */
    public function createQrisPayment(Request $request, Order $order)
    {
        try {
            // Validasi order
            if ($order->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke order ini.'
                ], 403);
            }

            if ($order->status === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Order ini sudah dibayar.'
                ], 400);
            }

            // Cek apakah sudah ada payment yang pending untuk order ini
            $existing_payment = Payment::where('order_id', $order->id)
                ->where('status', 'pending')
                ->where('expiry_time', '>', now())
                ->first();

            if ($existing_payment) {
                $existing_payment->load('order.showtime.movie', 'order.showtime.cinemaHall.cinema');
                return response()->json([
                    'success' => true,
                    'message' => 'Payment QRIS sudah dibuat sebelumnya.',
                    'payment_id' => $existing_payment->id,
                    'payment' => $existing_payment,
                ]);
            }

            DB::beginTransaction();

            // Buat payment QRIS baru
            $payment = $this->midtrans_service->createQrisPayment($order);

            DB::commit();

            $payment->load('order.showtime.movie', 'order.showtime.cinemaHall.cinema');

            return response()->json([
                'success' => true,
                'message' => 'Payment QRIS berhasil dibuat.',
                'payment_id' => $payment->id,
                'payment' => $payment,
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Error creating QRIS payment', [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pembayaran QRIS: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan halaman pembayaran QRIS
     */
    public function showQrisPayment(Payment $payment)
    {
        // Pastikan payment milik user yang login
        if ($payment->order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke payment ini.');
        }

        // Cek apakah payment sudah expired
        if ($payment->expiry_time && $payment->expiry_time < now()) {
            $payment->update(['status' => 'expire']);
            return view('payments.expired', compact('payment'));
        }

        // Cek apakah payment sudah berhasil
        if ($payment->isPaid()) {
            return redirect()->route('payment.success', $payment);
        }

        return view('payments.qris', compact('payment'));
    }

    /**
     * Cek status pembayaran (AJAX)
     */
    public function checkPaymentStatus(Payment $payment)
    {
        try {
            // Pastikan payment milik user yang login
            if ($payment->order->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Check status dari Midtrans
            $result = $this->midtrans_service->checkPaymentStatus($payment);

            // Refresh payment data
            $payment->refresh();

            // Derive QR URL for frontend update
            $qrUrl = $payment->qr_code_url;
            if (!$qrUrl) {
                $data = $result['data'] ?? null;
                if (is_array($data)) {
                    $qrUrl = $data['qr_url'] ?? null;
                    if (!$qrUrl && !empty($data['actions']) && is_array($data['actions'])) {
                        foreach ($data['actions'] as $a) {
                            $name = $a['name'] ?? null;
                            $url = $a['url'] ?? null;
                            if ($name === 'generate-qr-code' && !empty($url)) { $qrUrl = $url; break; }
                        }
                    }
                    if (!$qrUrl && !empty($data['qr_string'])) {
                        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($data['qr_string']);
                    }
                } elseif (is_object($data)) {
                    $qrUrl = $data->qr_url ?? null;
                    if (!$qrUrl && isset($data->actions)) {
                        foreach ((array) $data->actions as $a) {
                            $name = is_array($a) ? ($a['name'] ?? '') : ($a->name ?? '');
                            $url = is_array($a) ? ($a['url'] ?? null) : ($a->url ?? null);
                            if ($name === 'generate-qr-code' && !empty($url)) { $qrUrl = $url; break; }
                        }
                    }
                    if (!$qrUrl && isset($data->qr_string)) {
                        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($data->qr_string);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'status' => $payment->status,
                'is_paid' => $payment->isPaid(),
                'is_expired' => $payment->expiry_time < now(),
                'message' => $this->getStatusMessage($payment->status),
                'qr_code_url' => $qrUrl,
                'midtrans_result' => $result
            ]);

        } catch (Exception $e) {
            Log::error('Error checking payment status', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengecek status pembayaran.'
            ], 500);
        }
    }

    /**
     * Halaman sukses pembayaran
     */
    public function paymentSuccess(Payment $payment)
    {
        // Pastikan payment milik user yang login
        if ($payment->order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke payment ini.');
        }

        // Pastikan payment sudah berhasil
        if (!$payment->isPaid()) {
            return redirect()->route('payment.qris.show', $payment);
        }

        return view('payments.success', compact('payment'));
    }

    /**
     * Handle webhook notification dari Midtrans
     */
    public function handleNotification(Request $request)
    {
        try {
            $result = $this->midtrans_service->handleNotification();

            Log::info('Midtrans notification handled', [
                'result' => $result,
                'request_data' => $request->all()
            ]);

            return response()->json($result);

        } catch (Exception $e) {
            Log::error('Error handling Midtrans notification', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Batalkan pembayaran
     */
    public function cancelPayment(Payment $payment)
    {
        try {
            // Pastikan payment milik user yang login
            if ($payment->order->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Pastikan payment masih bisa dibatalkan
            if (!$payment->isPending()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment tidak dapat dibatalkan.'
                ], 400);
            }

            $payment->update(['status' => 'cancel']);
            $payment->order->update(['status' => 'cancelled']);

            return response()->json([
                'success' => true,
                'message' => 'Payment berhasil dibatalkan.',
                'redirect_url' => route('home')
            ]);

        } catch (Exception $e) {
            Log::error('Error cancelling payment', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan payment.'
            ], 500);
        }
    }

    /**
     * Get message berdasarkan status
     */
    private function getStatusMessage(string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu pembayaran...',
            'settlement' => 'Pembayaran berhasil!',
            'deny' => 'Pembayaran ditolak.',
            'cancel' => 'Pembayaran dibatalkan.',
            'expire' => 'Pembayaran telah kedaluwarsa.',
            'failure' => 'Pembayaran gagal.',
            default => 'Status tidak dikenal.'
        };
    }
}
