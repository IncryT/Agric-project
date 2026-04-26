<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        // Define pagination options
        $allowedPerPage = [10, 25, 50, 100];
        $perPage = $request->input('per_page', 10);
        
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $search = $request->input('search');

        // Build the query
        $query = \App\Models\Product::query()->orderBy('name', 'asc');

        // Apply search filter if a user typed something
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Execute query with dynamic pagination and remember query strings
        $products = $query->paginate($perPage)->withQueryString();

        return view('admin.products.index', compact('products', 'perPage', 'search'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'unit_of_measure' => 'required|string|max:50',
        ]);

        Product::create($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product added successfully.');
    }

    /**
     * Remove the specified product from storage (Soft Delete).
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product removed successfully.');
    }
}