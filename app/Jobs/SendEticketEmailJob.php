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

class SendEticketEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $order_id;

    public function __construct(int $order_id)
    {
        $this->order_id = $order_id;
    }

    public function handle(): void
    {
        $order = Order::with('user')->find($this->order_id);
        if (!$order || !$order->user || !$order->user->email) return;

        Mail::to($order->user->email)->queue(new EticketMail($order));
    }
}


