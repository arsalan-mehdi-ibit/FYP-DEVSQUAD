<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
$schedule->command('app:emailremindersforsubmittedtimesheets')->weeklyOn(1, '9:00');
$schedule->command('app:emailremindersforpendingtimesheets')->weeklyOn(1, '9:00');
$schedule->command('app:emailremindersforrejectedtimesheets')->weeklyOn(1, '9:00');
