<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\MarketPrice;
use Illuminate\Http\Request;

class MarketPriceController extends Controller
{
    /**
     * Display a listing of the market prices.
     */
   public function index(Request $request)
    {
        // Define pagination options
        $allowedPerPage = [10, 25, 50, 100];
        $perPage = $request->input('per_page', 10);
        
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $search = $request->input('search');

        // Build the query
        $query = MarketPrice::with('product')->orderBy('date', 'desc');

        // Apply search filter if a user typed something
        if ($search) {
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Execute query with dynamic pagination and remember query strings
        $marketPrices = $query->paginate($perPage)->withQueryString();

        return view('admin.market-prices.index', compact('marketPrices', 'perPage', 'search'));
    }

    /**
     * Show the form for manually creating a new market price.
     */
    public function create()
    {
        // Get all products to populate the dropdown menu
        $products = Product::orderBy('name')->get();
        
        return view('admin.market-prices.create', compact('products'));
    }

    /**
     * Store a newly created market price in storage.
     */
    public function store(Request $request)
    {
        // Validate the new single-price schema
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'date' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        // Use updateOrCreate so we don't get duplicate entries for the same crop on the same day
        MarketPrice::updateOrCreate(
            [
                'product_id' => $validated['product_id'],
                'date' => $validated['date'],
            ],
            [
                'price' => $validated['price'],
            ]
        );

        return redirect()->route('admin.market-prices.index')
            ->with('success', 'Market price recorded successfully.');
    }
}