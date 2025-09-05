<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Notification as DbNotification;

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
        // Hook: when DB notification created, optionally send email push if data[send_email]=true
        DbNotification::created(function (DbNotification $n) {
            try {
                $data = $n->data ?? [];
                if (is_array($data) && ($data['send_email'] ?? false) && $n->user && $n->user->email) {
                    $subject = $n->title;
                    $body = view('emails.generic-notification', ['notification' => $n])->render();
                    Mail::raw(strip_tags($body), function($m) use ($n, $subject){
                        $m->to($n->user->email)->subject($subject);
                    });
                }
            } catch (\Throwable $e) {
                Log::error('Failed to send push email for notification', ['id' => $n->id, 'error' => $e->getMessage()]);
            }
        });
    }
}
