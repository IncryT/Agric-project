<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use App\Models\SystemSetting;
use App\Services\SmsService;

class CheckSmsStatus extends Command
{
    protected $signature = 'sms:check-status';
    protected $description = 'Check SMS system status and diagnose issues';

    public function handle()
    {
        $this->info('🔍 SMS System Status Check');
        $this->line(str_repeat('=', 40));

        // 1. Twilio Configuration
        $this->info('\n📱 Twilio Configuration:');
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');
        
        if (empty($sid) || empty($token) || empty($from)) {
            $this->error("  ✗ Configuration missing. Check .env:");
            $this->line("    TWILIO_SID");
            $this->line("    TWILIO_AUTH_TOKEN");
            $this->line("    TWILIO_PHONE_NUMBER");
            return 1;
        }
        
        $this->line("  ✓ SID: " . substr($sid, 0, 12) . '...');
        $this->line("  ✓ From: {$from}");
        
        try {
            $sms = new SmsService();
            $this->line("  ✓ SMS Service OK");
        } catch (\Exception $e) {
            $this->error("  ✗ Init failed: " . $e->getMessage());
            return 1;
        }

        // 2. Alert Schedule
        $this->info('\n⏰ Alert Schedule:');
        $alertTime = SystemSetting::where('key', 'alert_schedule_time')->value('value') ?? '08:00';
        $now = now()->setTimezone('Africa/Johannesburg');
        $nextRun = $now->copy()->setTimeFromTimeString($alertTime);
        if ($now->gt($nextRun)) {
            $nextRun->addDay();
        }
        $this->line("  Scheduled: {$alertTime} (Africa/Johannesburg)");
        $this->line("  Next run: " . $nextRun->format('Y-m-d H:i'));

        // 3. Subscriptions & Phone Validation
        $this->info('\n📋 Active Subscriptions:');
        $subscriptions = Subscription::with(['user', 'product'])->where('frequency', 'daily_summary')->get();
        $total = $subscriptions->count();
        $this->line("  Total subscriptions: {$total}");
        
        if ($total === 0) {
            $this->warn("  No active subscriptions found!");
            $this->line("  → Farmers need to set up alerts in /farmer/subscriptions");
            return 0;
        }

        $valid = 0;
        $invalid = 0;
        $noPhone = 0;

        foreach ($subscriptions as $sub) {
            $phone = $sub->user->phone_number ?: $sub->user->phone;
            if (empty($phone)) {
                $noPhone++;
                continue;
            }
            
            // Test normalization
            $reflection = new \ReflectionClass($sms);
            $method = $reflection->getMethod('normalizePhoneNumber');
            $method->setAccessible(true);
            $normalized = $method->invoke($sms, $phone);
            $isValid = (bool) preg_match('/^\+[1-9]\d{9,14}$/', $normalized);
            
            if ($isValid) {
                $valid++;
            } else {
                $invalid++;
                $this->line("    ✗ {$sub->user->name}: {$phone} → {$normalized}");
            }
        }

        $this->line("  ✓ Valid: {$valid}");
        if ($invalid > 0) $this->error("  ✗ Invalid: {$invalid}");
        if ($noPhone > 0) $this->warn("  ? No phone: {$noPhone}");

        // 4. Known Issues & Recommendations
        $this->info('\n⚠️  Known Issues from Logs:');
        $this->line("  Twilio error: 'Invalid To Phone Number'");
        $this->line("  Twilio error: 'exceeded the 5 daily messages limit'");
        
        $this->info('\n✅ Fix Steps:');
        $this->line('  1. Verify Twilio account is not in trial mode (upgrade at twilio.com)');
        $this->line('  2. Ensure phone numbers include country code (+263XXXXXXXX)');
        $this->line('  3. If in trial, add recipient numbers to Twilio Verified Caller IDs');
        $this->line('  4. Check Twilio dashboard for remaining message balance');
        $this->line('  5. Test manually: php artisan alerts:send-daily');
        
        $this->info('\n📊 Last Alert Run:');
        $last = SystemSetting::where('key', 'last_alert_sent_at')->value('value') ?: 'Never';
        $this->line("  {$last}");

        $this->line('');
    }
}
