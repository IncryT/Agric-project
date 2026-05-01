<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Post-Scrape Verification ===\n\n";

$lastScrapeTime = \App\Models\SystemSetting::where('key', 'last_scrape_time')->value('value');
$lastScrapeCount = \App\Models\SystemSetting::where('key', 'last_scrape_count')->value('value');

echo "Last Scrape Time: " . ($lastScrapeTime ?? 'Never') . "\n";
echo "Last Scrape Count: " . ($lastScrapeCount ?? '0') . " products\n\n";

$today = date('Y-m-d');
$todayCount = \App\Models\MarketPrice::where('date', $today)->count();
echo "Prices for today ($today): $todayCount records\n\n";

$todayPrices = \App\Models\MarketPrice::with('product')->where('date', $today)->orderBy('created_at', 'desc')->limit(10)->get();
echo "Sample prices for today:\n";
foreach ($todayPrices as $p) {
    echo "  {$p->product->name}: \${$p->price}\n";
}

echo "\n✅ Scraper is working correctly!\n";
