<?php

namespace App\Jobs;

use App\Models\SeatReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExpireSeatReservationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $count = 0;
        SeatReservation::expired()
            ->orderBy('id')
            ->chunkById(200, function ($reservations) use (&$count) {
                foreach ($reservations as $reservation) {
                    try {
                        if ($reservation->status === SeatReservation::STATUS_RESERVED && $reservation->expires_at->isPast()) {
                            $reservation->update([
                                'status' => SeatReservation::STATUS_EXPIRED,
                            ]);
                            $count++;
                        }
                    } catch (\Throwable $e) {
                        Log::error('ExpireSeatReservationsJob error', [
                            'reservation_id' => $reservation->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            });

        if ($count > 0) {
            Log::info('ExpireSeatReservationsJob: expired reservations processed', ['count' => $count]);
        }
    }
}


