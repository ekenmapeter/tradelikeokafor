<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Forex AI Blogging Pipeline Schedule
Schedule::command('forex:fetch-articles')->dailyAt('06:00');
Schedule::command('forex:generate-posts')->dailyAt('07:00');
Schedule::command('forex:cleanup')->weekly();
