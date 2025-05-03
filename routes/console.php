<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::command('app:emailremindersforsubmittedtimesheets')->monthlyOn(1, '9:00');
Schedule::command('app:emailremindersforpendingtimesheets')->monthlyOn(1, '9:00');
Schedule::command('app:emailremindersforrejectedtimesheets')->monthlyOn(1, '9:00');