<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DRY RUN: Sending SMS Alerts (simulated) ===\n\n";

$subscriptions = \App\Models\Subscription::with(['user', 'product'])->where('frequency', 'daily_summary')->get();
$count = 0;

foreach ($subscriptions as $sub) {
    $phone = $sub->user->phone_number ?: $sub->user->phone;
    
    if (empty($phone)) {
        echo "SKIP {$sub->user->name}: no phone\n";
        continue;
    }
    
    $sms = new \App\Services\SmsService();
    
    // Calculate MRP using PricingCalculatorService
    $pricingService = new \App\Services\PricingCalculatorService();
    $mrpData = $pricingService->calculateMRP($sub->product_id);
    $mrp = $mrpData['mrp'];
    $provisional = $mrpData['is_provisional'] ? ' (provisional)' : '';
    
    $map = $pricingService->calculateMAP($sub->cop, $sub->profit_margin);
    
    if ($mrp > $map) {
        $status = 'Favourable';
        $recommendation = 'Consider selling while market is strong.';
    } elseif ($mrp < $map) {
        $status = 'Unfavourable';
        $recommendation = 'Hold off selling until prices improve.';
    } else {
        $status = 'Neutral';
        $recommendation = 'Monitor prices closely.';
    }
    
    $message = sprintf(
        "FPAS Price Alert for %s:\nMarket price%s: $%.2f\nYour MAP: $%.2f\nStatus: %s\n%s",
        $sub->product->name,
        $provisional,
        $mrp,
        $map,
        $status,
        $recommendation
    );
    
    echo "TO: {$sub->user->name} ({$phone})\n";
    echo "MSG: " . str_replace("\n", " | ", $message) . "\n";
    echo "---\n";
    $count++;
}

echo "\nTotal alerts that would be sent: $count\n";
echo "\nNow testing actual SMS send (first subscription only)...\n";

$first = $subscriptions->first();
if ($first) {
    $sms = new \App\Services\SmsService();
    $phone = $first->user->phone_number ?: $first->user->phone;
    $pricingService = new \App\Services\PricingCalculatorService();
    $mrp = $pricingService->calculateMRP($first->product_id)['mrp'];
    $map = $pricingService->calculateMAP($first->cop, $first->profit_margin);
    
    $testMsg = "TEST: Your {$first->product->name} MAP is \$$map, current market: \$$mrp";
    
    echo "Sending test SMS to $phone...\n";
    $result = $sms->sendSms($phone, $testMsg);
    echo $result ? "✅ SENT!\n" : "❌ FAILED (check logs)\n";
}
