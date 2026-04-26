<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use App\Services\SmsService;
use App\Services\PricingCalculatorService;

class SendDailyPriceAlerts extends Command
{
    protected $signature = 'alerts:send-daily';
    protected $description = 'Send daily SMS market price summaries to subscribed farmers';

    public function handle(SmsService $smsService, PricingCalculatorService $pricingService)
    {
        // Retrieve all active daily subscriptions with their associated user and product
        $subscriptions = Subscription::with(['user', 'product'])
            ->where('frequency', 'daily_summary')
            ->get();

        $count = 0;

        foreach ($subscriptions as $sub) {
            $phone = $sub->user->phone_number ?: $sub->user->phone;

            // Skip if user has no phone number
            if (empty($phone)) {
                continue;
            }

            // 1. Get the current MRP
            $mrpData = $pricingService->calculateMRP($sub->product_id);
            $mrp = $mrpData['mrp'];
            $provisional = $mrpData['is_provisional'] ? ' (provisional)' : '';

            // 2. Calculate the farmer's MAP based on their saved subscription settings
            $map = $pricingService->calculateMAP($sub->cop, $sub->profit_margin);

            // 3. Determine the market status and recommendation
            if ($mrp > $map) {
                $status = 'Favourable: Market price is above your MAP.';
                $recommendation = 'Consider selling while the market is strong.';
            } elseif ($mrp < $map) {
                $status = 'Unfavourable: Market price is below your MAP.';
                $recommendation = 'Hold off selling until prices improve.';
            } else {
                $status = 'Neutral: Market price equals your MAP.';
                $recommendation = 'Monitor prices closely for the next update.';
            }

            // 4. Construct the SMS message
            $message = sprintf(
                "FPAS Price Alert for %s:\nMarket price%s: $%s\nYour MAP: $%s\nStatus: %s\n%s",
                $sub->product->name,
                $provisional,
                number_format($mrp, 2),
                number_format($map, 2),
                $status,
                $recommendation
            );

            // 5. Send the SMS and count only successful deliveries
            if ($smsService->sendSms($phone, $message)) {
                $count++;
            }
        }

        $this->info("Successfully sent {$count} daily price alerts.");
    }
}