<?php

namespace App\Mail;

use App\Models\Notification as DbNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public DbNotification $notification;

    public function __construct(DbNotification $notification)
    {
        // Eager-load user relation if not loaded to avoid N+1 in views
        if (!$notification->relationLoaded('user')) {
            $notification->load('user');
        }
        $this->notification = $notification;
    }

    public function build()
    {
        return $this->subject((string) $this->notification->title)
            ->view('emails.generic-notification');
    }
}


