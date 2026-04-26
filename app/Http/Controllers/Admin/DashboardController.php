<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\MarketPrice;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Basic Stats
        $totalProducts = Product::count();
        $lastScrapeTime = SystemSetting::where('key', 'last_scrape_time')->value('value') ?? 'Never';
        $lastScrapeCount = SystemSetting::where('key', 'last_scrape_count')->value('value') ?? 0;
        $scheduleTime = SystemSetting::where('key', 'scrape_schedule_time')->value('value') ?? '06:00';
        $alertScheduleTime = SystemSetting::where('key', 'alert_schedule_time')->value('value') ?? '08:00';

        // 2. Farmer Location Stats
        $totalFarmers = User::where('role', 'farmer')->count();
        $farmersWithLocation = User::where('role', 'farmer')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('latitude', '!=', '')
            ->where('longitude', '!=', '')
            ->count();

        // Get unique districts with farmers
        $districts = User::where('role', 'farmer')
            ->whereNotNull('district')
            ->where('district', '!=', '')
            ->distinct()
            ->pluck('district')
            ->toArray();

        // 3. Chart Data: Top 10 and Bottom 10 Prices for Today
        $today = Carbon::today()->toDateString();
        $todayPrices = MarketPrice::with('product')->where('date', $today)->get();

        $top10 = $todayPrices->sortByDesc('price')->take(10)->values();
        $bottom10 = $todayPrices->sortBy('price')->take(10)->values();

        $topData = $top10->map(function ($item) {
            return [
                'product' => ['name' => $item->product?->name ?? 'Unknown'],
                'price' => $item->price,
            ];
        })->values();

        $bottomData = $bottom10->map(function ($item) {
            return [
                'product' => ['name' => $item->product?->name ?? 'Unknown'],
                'price' => $item->price,
            ];
        })->values();

        return view('admin.dashboard', compact(
            'totalProducts', 'lastScrapeTime', 'lastScrapeCount', 'scheduleTime', 'alertScheduleTime', 'top10', 'bottom10', 'topData', 'bottomData',
            'totalFarmers', 'farmersWithLocation', 'districts'
        ));
    }

    // Method to handle the user changing the schedule time from the dashboard
    public function updateSchedule(Request $request)
    {
        $request->validate(['schedule_time' => 'required|date_format:H:i']);
        SystemSetting::updateOrCreate(['key' => 'scrape_schedule_time'], ['value' => $request->schedule_time]);
        return back()->with('success', 'Scraper schedule updated successfully!');
    }

    // Method to handle the user changing the alert schedule time from the dashboard
    public function updateAlertSchedule(Request $request)
    {
        $request->validate(['alert_schedule_time' => 'required|date_format:H:i']);
        SystemSetting::updateOrCreate(['key' => 'alert_schedule_time'], ['value' => $request->alert_schedule_time]);
        return back()->with('success', 'SMS alert schedule updated successfully!');
    }
}
