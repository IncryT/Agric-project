<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Schema;
use App\Models\SystemSetting;

// Run the daily alerts command every day at 08:00
// Schedule::command('alerts:send-daily')->dailyAt('08:00');

// 1. Set a fallback default time for alerts
$alertScheduleTime = '08:00';

// 2. Safely try to get the custom time from the database
try {
    if (Schema::hasTable('system_settings')) {
        $dbTime = SystemSetting::where('key', 'alert_schedule_time')->value('value');
        if ($dbTime) {
            $alertScheduleTime = $dbTime; // Override with the Admin's custom time!
        }
    }
} catch (\Exception $e) {
    // If the database isn't connected yet, just stick to 08:00
}

// 3. Schedule the alerts command using the dynamic time
Schedule::command('alerts:send-daily')
    ->dailyAt($alertScheduleTime)
    ->timezone('Africa/Johannesburg');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// 1. Set a fallback default time
$scheduleTime = '06:00';

// 2. Safely try to get the custom time from the database
try {
    if (Schema::hasTable('system_settings')) {
        $dbTime = SystemSetting::where('key', 'scrape_schedule_time')->value('value');
        if ($dbTime) {
            $scheduleTime = $dbTime; // Override with the Admin's custom time!
        }
    }
} catch (\Exception $e) {
    // If the database isn't connected yet, just stick to 06:00
}

// 3. Schedule the command using the dynamic time
Schedule::command('scrape:market-prices')
    ->dailyAt($scheduleTime)
    ->timezone('Africa/Johannesburg');