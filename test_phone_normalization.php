<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sms = new \App\Services\SmsService();

$testNumbers = [
    '07688992',
    '0782123456',
    '+263787126351',
    '0782123456',
    '0779123456',
];

foreach ($testNumbers as $num) {
    $normalized = $sms->normalizePhoneNumber($num);
    $valid = $sms->isValidPhoneNumber($normalized);
    echo "$num => $normalized => " . ($valid ? 'VALID' : 'INVALID') . "\n";
}
