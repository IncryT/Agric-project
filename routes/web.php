<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\MarketPriceController;
use App\Http\Controllers\Farmer\CalculatorController;
use App\Http\Controllers\Farmer\SubscriptionController;
use App\Models\Product;
use App\Services\PricingCalculatorService;

Route::post('/chat', [ChatController::class, 'respond']);

Route::get('/', function () {
    // Fetch real market prices from database
    $products = \App\Models\Product::with(['marketPrices' => function ($query) {
        $query->latest('date')->limit(1);
    }])->get();

    $marketData = $products->map(function ($product) {
        $latestPrice = $product->marketPrices->first();
        return [
            'crop' => $product->name,
            'price' => $latestPrice ? '$' . number_format($latestPrice->price, 2) : 'N/A',
            'change' => $latestPrice ? '+0.0%' : 'N/A',
            'status' => 'up'
        ];
    })->filter(function ($item) {
        return $item['price'] !== 'N/A';
    })->values();

    // Fallback if no data
    if ($marketData->isEmpty()) {
        $marketData = collect([
            ['crop' => 'Wheat', 'price' => '$240.50', 'change' => '+1.2%', 'status' => 'up'],
            ['crop' => 'Corn', 'price' => '$185.20', 'change' => '-0.5%', 'status' => 'down'],
            ['crop' => 'Soybeans', 'price' => '$410.00', 'change' => '+2.8%', 'status' => 'up'],
            ['crop' => 'Rice', 'price' => '$320.15', 'change' => '+0.3%', 'status' => 'up'],
            ['crop' => 'Barley', 'price' => '$210.80', 'change' => '-1.1%', 'status' => 'down'],
        ]);
    }

    return view('landing', compact('marketData'));
});


Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('farmer.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// ADMINISTRATOR ROUTES
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    /* Admin Dashboard
    Route::get('/dashboard', function () {
        $productCount = \App\Models\Product::count();
        $priceCount = \App\Models\MarketPrice::count();
        
        return view('admin.dashboard', compact('productCount', 'priceCount'));
    })->name('dashboard');*/

    // Inside your Admin route group:
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/schedule', [\App\Http\Controllers\Admin\DashboardController::class, 'updateSchedule'])->name('schedule.update');
    Route::post('/dashboard/alert-schedule', [\App\Http\Controllers\Admin\DashboardController::class, 'updateAlertSchedule'])->name('alert-schedule.update');


    // Manage Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Capture Market Prices
    Route::get('/market-prices', [MarketPriceController::class, 'index'])->name('market-prices.index');
    Route::get('/market-prices/create', [MarketPriceController::class, 'create'])->name('market-prices.create');
    Route::post('/market-prices', [MarketPriceController::class, 'store'])->name('market-prices.store');


    // Farmer Management
    Route::get('/farmers', [\App\Http\Controllers\Admin\FarmerController::class, 'index'])->name('farmers.index');
    Route::get('/farmers/create', [\App\Http\Controllers\Admin\FarmerController::class, 'create'])->name('farmers.create');
    Route::post('/farmers', [\App\Http\Controllers\Admin\FarmerController::class, 'store'])->name('farmers.store');
    Route::get('/farmers/map', [\App\Http\Controllers\Admin\FarmerController::class, 'map'])->name('farmers.map');
    Route::get('/farmers/{farmer}', [\App\Http\Controllers\Admin\FarmerController::class, 'show'])->name('farmers.show');

    Route::delete('/farmers/{user}', [\App\Http\Controllers\Admin\FarmerController::class, 'destroy'])->name('farmers.destroy');
    
});

// ==========================================
// FARMER ROUTES
// ==========================================
Route::middleware(['auth', 'role:farmer'])->prefix('farmer')->name('farmer.')->group(function () {
        
        /* Farmer Dashboard
        Route::get('/dashboard', function () {
            return view('farmer.dashboard');
        })->name('dashboard');
        */

        Route::get('/dashboard', function (\App\Services\PricingCalculatorService $calculatorService) {
        
            $marketOverview = \App\Models\Product::has('marketPrices')
                ->orderBy('name')
                ->paginate(10)
                ->through(function ($product) use ($calculatorService) {
                    $calc = $calculatorService->calculateMRP($product->id);
                    
                    return [
                        'name' => $product->name,
                        'unit_of_measure' => $product->unit_of_measure,
                        'mrp' => $calc['mrp'],
                        'is_provisional' => $calc['is_provisional'],
                    ];
                });

            return view('farmer.dashboard', compact('marketOverview'));
            
        })->name('dashboard');


    // MAP Calculator
    Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator.index');
    Route::post('/calculator', [CalculatorController::class, 'calculate'])->name('calculator.calculate');

    // AI Chatbot Advisor
    Route::get('/chatbot', function () {
        return view('farmer.chatbot');
    })->name('chatbot');

    // SMS Alerts (Subscriptions)
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
    
});

require __DIR__.'/auth.php';
