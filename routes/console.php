<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

use App\Jobs\ExpireSeatReservationsJob;
use App\Jobs\CancelExpiredOrdersJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Scheduled tasks
Schedule::job(new ExpireSeatReservationsJob())->everyMinute();
Schedule::job(new CancelExpiredOrdersJob())->everyMinute();
