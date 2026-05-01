<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use App\Models\SystemSetting;
use App\Services\SmsService;
use App\Services\PricingCalculatorService;

class SendDailyPriceAlerts extends Command
{
    protected $signature = 'alerts:send-daily';
    protected $description = 'Send daily SMS market price summaries to subscribed farmers';

    public function handle(SmsService $smsService, PricingCalculatorService $pricingService)
    {
        $this->info('🚀 Starting daily SMS alerts...');
        
        $subscriptions = Subscription::with(['user', 'product'])
            ->where('frequency', 'daily_summary')
            ->get();

        $total = $subscriptions->count();
        $sent = 0;
        $skipped = 0;
        $failed = 0;

        $this->info("📋 Found {$total} active alert subscriptions\n");

        foreach ($subscriptions as $index => $sub) {
            $phone = $sub->user->phone_number ?: $sub->user->phone;
            $userName = $sub->user->name;
            $productName = $sub->product->name;

            if (empty($phone)) {
                $this->warn("[$index] SKIP {$userName}: no phone number");
                $skipped++;
                continue;
            }

            // Get pricing data
            $mrpData = $pricingService->calculateMRP($sub->product_id);
            $mrp = $mrpData['mrp'];
            $provisional = $mrpData['is_provisional'] ? ' (provisional)' : '';
            $map = $pricingService->calculateMAP($sub->cop, $sub->profit_margin);

            // Determine status
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
                $productName,
                $provisional,
                $mrp,
                $map,
                $status,
                $recommendation
            );

            $this->line("[$index] → {$userName} ({$phone})");
            
            if ($smsService->sendSms($phone, $message)) {
                $this->info("    ✓ Sent");
                $sent++;
            } else {
                $this->error("    ✗ Failed (see logs)");
                $failed++;
            }
        }

        // Record that alerts were sent
        SystemSetting::updateOrCreate(['key' => 'last_alert_sent_at'], [
            'value' => now()->setTimezone('Africa/Johannesburg')->toDateTimeString()
        ]);

        $this->info('\n' . str_repeat('=', 50));
        $this->info("📊 Summary: {$sent} sent, {$failed} failed, {$skipped} skipped (Total: {$total})");
        $this->info(str_repeat('=', 50));

        if ($failed > 0) {
            $this->error('\n⚠️  Some SMS failed. Common causes:');
            $this->error('   • Twilio trial account – verify numbers or upgrade');
            $this->error('   • Invalid phone format (should be +263XXXXXXXXXX)');
            $this->error('   • Daily message limit reached');
            $this->error('   • Check logs: storage/logs/laravel.log');
        }

        $this->info('');
        return 0;
    }
}
