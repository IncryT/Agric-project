<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Checking subscription phone status ===\n\n";

$subs = \App\Models\Subscription::with(['user', 'product'])->where('frequency', 'daily_summary')->get();
foreach ($subs as $sub) {
    $phone = $sub->user->phone_number ?: $sub->user->phone;
    echo "User: {$sub->user->name}\n";
    echo "  Raw phone from DB: " . var_export($phone, true) . "\n";
    
    $sms = new \App\Services\SmsService();
    // Use reflection to test protected normalize method
    $ref = new ReflectionClass($sms);
    $method = $ref->getMethod('normalizePhoneNumber');
    $method->setAccessible(true);
    $normalized = $method->invoke($sms, $phone);
    echo "  Normalized: $normalized\n";
    // Manual E.164 validation
    $isValid = (bool) preg_match('/^\+[1-9]\d{9,14}$/', $normalized);
    echo "  Valid: " . ($isValid ? 'YES' : 'NO') . "\n\n";
}
