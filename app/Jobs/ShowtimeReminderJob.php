<?php

namespace App\Jobs;

use App\Mail\EticketMail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ShowtimeReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Kirim reminder H-1 jam sebelum showtime untuk order completed dan belum check-in
        $thresholdStart = now()->addHour()->startOfMinute();
        $thresholdEnd = now()->addHour()->endOfMinute();

        Order::completed()
            ->whereHas('orderItems.showtime', function ($q) use ($thresholdStart, $thresholdEnd) {
                // relation via order->showtime, so we filter orders directly
            })
            ->whereHas('showtime', function ($q) use ($thresholdStart, $thresholdEnd) {
                $q->whereBetween('show_time', [$thresholdStart, $thresholdEnd]);
            })
            ->with(['user'])
            ->chunkById(100, function ($orders) {
                foreach ($orders as $order) {
                    if (!$order->user || !$order->user->email) continue;
                    // Bisa gunakan template reminder khusus. Sementara reuse EticketMail (ringkas)
                    Mail::to($order->user->email)->queue(new EticketMail($order));
                }
            });
    }
}


