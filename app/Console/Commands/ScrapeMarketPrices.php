<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\MarketPrice;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;

class ScrapeMarketPrices extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'scrape:market-prices';

    /**
     * The console command description.
     */
    protected $description = 'Scrape daily fruit and vegetable prices from ZimPriceCheck and update the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting web scraper...');
        $url = 'https://zimpricecheck.com/price-updates/fruit-and-vegetable-prices/';
        $response = \Illuminate\Support\Facades\Http::withoutVerifying()->get($url);

        if (!$response->successful()) return;

        $dom = new \DOMDocument();
        @$dom->loadHTML($response->body()); 
        $xpath = new \DOMXPath($dom);
        $rows = $xpath->query('//table//tbody//tr');

        $today = \Carbon\Carbon::today()->toDateString();
        $productsUpdated = 0;

        foreach ($rows as $row) {
            $cells = $xpath->query('td', $row);
            
            if ($cells->length >= 3) {
                $scrapedName = trim($cells->item(0)->nodeValue);
                $scrapedUnit = trim($cells->item(1)->nodeValue); // Extracting the measure
                $scrapedPriceString = trim($cells->item(2)->nodeValue); 
                
                $cleanPrice = preg_replace('/[^0-9.]/', '', $scrapedPriceString);
                
                if (!is_numeric($cleanPrice) || empty($scrapedName)) continue; 

                // 1. Check if product exists, if not, create it!
                $product = \App\Models\Product::firstOrCreate(
                    ['name' => $scrapedName],
                    ['unit_of_measure' => $scrapedUnit ?: 'unit']
                );

                // 2. Save today's price
                \App\Models\MarketPrice::updateOrCreate(
                    ['product_id' => $product->id, 'date' => $today],
                    ['price' => $cleanPrice]
                );

                $productsUpdated++;
            }
        }

        // 3. Save scrape stats to System Settings for the dashboard
        \App\Models\SystemSetting::updateOrCreate(['key' => 'last_scrape_time'], ['value' => now()->toDateTimeString()]);
        \App\Models\SystemSetting::updateOrCreate(['key' => 'last_scrape_count'], ['value' => $productsUpdated]);

        $this->info("Scraping complete! Updated {$productsUpdated} products.");
    }
}