<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Scraper Status Check ===\n\n";

// Check last scrape info
$lastScrapeTime = \App\Models\SystemSetting::where('key', 'last_scrape_time')->value('value');
$lastScrapeCount = \App\Models\SystemSetting::where('key', 'last_scrape_count')->value('value');

echo "Last Scrape Time: " . ($lastScrapeTime ?? 'Never') . "\n";
echo "Last Scrape Count: " . ($lastScrapeCount ?? '0') . " products\n\n";

// Check current database state
$totalProducts = \App\Models\Product::count();
$totalPrices = \App\Models\MarketPrice::count();

echo "Total Products in DB: $totalProducts\n";
echo "Total Price Records: $totalPrices\n\n";

// Show most recent price entries
$recent = \App\Models\MarketPrice::with('product')
    ->orderBy('date', 'desc')
    ->limit(5)
    ->get();

echo "Most Recent Price Entries:\n";
foreach ($recent as $record) {
    echo "  {$record->date} - {$record->product->name}: \${$record->price}\n";
}

// Check for any products without today's prices
$today = \Carbon\Carbon::today()->toDateString();
$todayCount = \App\Models\MarketPrice::where('date', $today)->count();
echo "\nPrices for today ($today): $todayCount records\n";

// Check scraper schedule
$schedule = \App\Models\SystemSetting::where('key', 'scrape_schedule_time')->value('value');
echo "Next Auto-Scrape Scheduled: {$schedule}\n\n";

// Test scraper manually
echo "=== Testing Manual Scrape ===\n";
try {
    $command = \App\Console\Commands\ScrapeMarketPrices::class;
    $instance = new $command();
    $result = $instance->handle();
    echo "Manual scrape completed successfully.\n";
} catch (Exception $e) {
    echo "Scraper Error: " . $e->getMessage() . "\n";
}
