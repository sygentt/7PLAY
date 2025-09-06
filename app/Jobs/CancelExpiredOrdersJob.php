<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SeatReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CancelExpiredOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $affected = 0;

        Order::query()
            ->pending()
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<', now())
            ->orderBy('id')
            ->chunkById(100, function ($orders) use (&$affected) {
                foreach ($orders as $order) {
                    DB::beginTransaction();
                    try {
                        // Mark order as cancelled
                        $order->update(['status' => Order::STATUS_CANCELLED]);

                        // Release seats: mark reservations expired if tied to same showtime+seat
                        $seatIds = $order->orderItems()->pluck('seat_id')->all();
                        if (!empty($seatIds)) {
                            SeatReservation::query()
                                ->where('showtime_id', $order->showtime_id)
                                ->whereIn('seat_id', $seatIds)
                                ->where('status', SeatReservation::STATUS_RESERVED)
                                ->update(['status' => SeatReservation::STATUS_EXPIRED]);
                        }

                        // Mark order items cancelled
                        $order->orderItems()->update(['status' => OrderItem::STATUS_CANCELLED]);

                        DB::commit();
                        $affected++;
                    } catch (\Throwable $e) {
                        DB::rollBack();
                        Log::error('CancelExpiredOrdersJob error', [
                            'order_id' => $order->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            });

        if ($affected > 0) {
            Log::info('CancelExpiredOrdersJob: cancelled expired orders', ['count' => $affected]);
        }
    }
}


