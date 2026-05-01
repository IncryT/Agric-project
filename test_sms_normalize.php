<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sms = new \App\Services\SmsService();

// Test numbers in various formats
$tests = [
    '07688992',
    '0782123456',
    '+263787126351',
    '0779 123 456',
    '263787126351',
];

foreach ($tests as $input) {
    $reflection = new ReflectionClass($sms);
    $normMethod = $reflection->getMethod('normalizePhoneNumber');
    $normMethod->setAccessible(true);
    $normalized = $normMethod->invoke($sms, $input);
    
    // Validate manually using regex
    $isValid = (bool) preg_match('/^\+[1-9]\d{9,14}$/', $normalized);
    echo "$input => $normalized => " . ($isValid ? 'VALID' : 'INVALID') . "\n";
}

echo "\nSMS Service from: " . $sms->from . "\n";
