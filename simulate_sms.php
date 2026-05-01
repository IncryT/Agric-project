<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Simulating Daily SMS Alert Dispatch ===\n\n";

$subscriptions = \App\Models\Subscription::with(['user', 'product'])->where('frequency', 'daily_summary')->take(2)->get();

foreach ($subscriptions as $sub) {
    $phone = $sub->user->phone_number ?: $sub->user->phone;
    $sms = new \App\Services\SmsService();
    $normalized = $sms->normalizePhoneNumber($phone);
    
    echo "Would send SMS to {$sub->user->name}\n";
    echo "  Original phone: $phone\n";
    echo "  Normalized to: $normalized\n";
    echo "  Product: {$sub->product->name}\n";
    echo "  COP: \${$sub->cop}, Margin: {$sub->profit_margin}%\n";
    echo "  Skipping actual send (test mode)\n\n";
}

echo "Total subscriptions that would receive alerts: " . \App\Models\Subscription::where('frequency', 'daily_summary')->count() . "\n";
