<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

use App\Jobs\ExpireSeatReservationsJob;
use App\Jobs\CancelExpiredOrdersJob;
use App\Jobs\ShowtimeReminderJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Scheduled tasks
Schedule::job(new ExpireSeatReservationsJob())->everyMinute();
Schedule::job(new CancelExpiredOrdersJob())->everyMinute();
// Reminder showtime H-1 jam setiap menit cek jendela 1 menit
Schedule::job(new ShowtimeReminderJob())->everyMinute();
