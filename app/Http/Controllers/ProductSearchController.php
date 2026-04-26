<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductSearchController extends Controller
{
    public function index(Request $request): Response
    {
        $request->validate([
            'lat' => 'nullable|numeric|between:-90,90',
            'lng' => 'nullable|numeric|between:-180,180',
            'radius' => 'nullable|numeric|min:1|max:100', // radius in kilometers
        ]);

        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $radius = $request->input('radius', 10); // Default 10km

        $query = Product::whereNotNull('latitude')->whereNotNull('longitude');

        if ($lat && $lng) {
            // Haversine Formula (6371 is Earth radius in km)
            $query->select('products.*')
                ->selectRaw("(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
                ->having('distance', '<=', $radius)
                ->orderBy('distance');
        }

        $products = $query->paginate(15);
        $totalNearby = $query->count();

        return Inertia::render('Products/Nearby', [
            'products' => $products,
            'totalNearby' => $totalNearby,
            'filters' => [
                'lat' => (float) $lat,
                'lng' => (float) $lng,
                'radius' => (float) $radius,
            ],
        ]);
    }
}