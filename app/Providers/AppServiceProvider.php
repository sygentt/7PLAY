<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use App\Mail\GenericNotificationMail;
use Illuminate\Support\Facades\Log;
use App\Models\Notification as DbNotification;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Locale is set via SetLocaleFromUser middleware
        // Force HTTPS in local environment
        if(config('app.env') === 'local') {
            URL::forceScheme('https');
        }

        // Hook: when DB notification created, optionally send email push if data[send_email]=true
        DbNotification::created(function (DbNotification $n) {
            try {
                $data = $n->data ?? [];
                if (is_array($data) && ($data['send_email'] ?? false) && $n->user && $n->user->email) {
                    // Kirim email melalui queue menggunakan Mailable ter-queue
                    Mail::to($n->user->email)->queue(new GenericNotificationMail($n));
                }
            } catch (\Throwable $e) {
                Log::error('Failed to send push email for notification', ['id' => $n->id, 'error' => $e->getMessage()]);
            }
        });
    }
}
