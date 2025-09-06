<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EticketMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load(['orderItems.seat', 'showtime.movie', 'showtime.cinemaHall.cinema.city', 'user']);
    }

    public function build()
    {
        return $this->subject('E-Ticket 7PLAY #' . $this->order->order_number)
            ->view('emails.eticket');
    }
}


