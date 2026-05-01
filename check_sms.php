<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== SMS Alert System Diagnostic ===\n\n";

// Check active subscriptions
$subscriptions = \App\Models\Subscription::with(['user', 'product'])->where('frequency', 'daily_summary')->get();
echo "Active daily alert subscriptions: " . $subscriptions->count() . "\n\n";

foreach ($subscriptions as $sub) {
    $phone = $sub->user->phone_number ?: $sub->user->phone;
    // Validate phone: should start with + and have 10-15 digits
    $isValid = $phone && preg_match('/^\+[1-9]\d{9,14}$/', preg_replace('/[^\d+]/', '', $phone));
    
    echo "User: {$sub->user->name}\n";
    echo "  Product: {$sub->product->name}\n";
    echo "  COP: \${$sub->cop}, Margin: {$sub->profit_margin}%\n";
    echo "  Phone: " . ($phone ?? 'NOT SET') . "\n";
    echo "  Phone valid: " . ($isValid ? 'YES' : 'NO') . "\n\n";
}

// Check alert schedule
$alertTime = \App\Models\SystemSetting::where('key', 'alert_schedule_time')->value('value');
echo " SMS Alert Schedule Time: " . ($alertTime ?? '08:00 (default)') . "\n";
echo " Current time: " . date('H:i') . "\n";

// Test SMS service
echo "=== Testing SMS Service ===\n";
try {
    $sms = new \App\Services\SmsService();
    echo "SMS Service initialized successfully\n";
    echo "From number: " . $sms->from . "\n";
} catch (Exception $e) {
    echo "SMS Service Error: " . $e->getMessage() . "\n";
}
