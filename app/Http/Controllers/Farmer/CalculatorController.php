<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\PricingCalculatorService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CalculatorController extends Controller
{
    protected PricingCalculatorService $calculatorService;
    // Mbare Market, Harare Coordinates
    protected array $mbareCoordinates = ['lat' => -17.8596, 'lng' => 31.0384];

    // Inject the service class to handle the financial logic
    public function __construct(PricingCalculatorService $calculatorService)
    {
        $this->calculatorService = $calculatorService;
    }

    /**
     * Show the MAP calculator form.
     */
    public function index()
    {
        // Fetch all products to populate the dropdown menu
        $products = Product::orderBy('name')->get();
        
        return view('farmer.calculator.index', compact('products'));
    }

    /**
     * Calculate the Minimum Acceptable Price (MAP) and compare with MRP.
     */
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'cop' => 'required|numeric|min:0', // Cost of Production per unit
            'profit_margin' => 'required|numeric|min:0', // Desired profit margin percentage
            'transport_rate' => 'nullable|numeric|min:0', // Cost per KM
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $user = auth()->user();
        $distanceInKm = 0;
        $transportRate = $validated['transport_rate'] ?? 0;
        $supportServices = [];

        $client = new Client(['timeout' => 10.0]);

        // 1. Calculate road distance using OSRM
        if ($user && $user->latitude && $user->longitude) {
            try {
                $osrmUrl = sprintf(
                    'http://router.project-osrm.org/route/v1/driving/%f,%f;%f,%f?overview=false',
                    $user->longitude, $user->latitude,
                    $this->mbareCoordinates['lng'], $this->mbareCoordinates['lat']
                );

                $osrmResponse = $client->get($osrmUrl);
                $osrmData = json_decode($osrmResponse->getBody(), true);
                if (isset($osrmData['routes'][0]['distance'])) {
                    $distanceInKm = $osrmData['routes'][0]['distance'] / 1000;
                }
            } catch (\Exception $e) {
                Log::error('OSRM Distance Calculation Failed: ' . $e->getMessage());
            }
        }

        // 2. Discover Agro-Dealers near Market using Overpass API (Independent of farm location)
        $supportServices = $this->fetchNearbyServices($client);
        
        // 3. Retrieve the market price
        $mrpData = $this->calculatorService->calculateMRP($product->id);
        
        // 4. Calculate the MAP
        $map = $this->calculatorService->calculateMAP($validated['cop'], $validated['profit_margin']);

        // 5. Calculate Net Price: Net = Market Price - (Distance * Rate)
        $totalTransportCost = $distanceInKm * $transportRate;
        $netPrice = $mrpData['mrp'] - $totalTransportCost;

        // 6. Determine the market status message based on Net Price
        $statusMessage = $netPrice >= $map 
            ? 'Market price is favourable.' 
            : 'Market price is below your minimum acceptable price after transport costs.';

        return view('farmer.calculator.result', [
            'product' => $product,
            'distance' => round($distanceInKm, 2),
            'transport_cost' => round($totalTransportCost, 2),
            'net_price' => round($netPrice, 2),
            'support_services' => $supportServices,
            'cop' => $validated['cop'],
            'profit_margin' => $validated['profit_margin'],
            'map' => $map,
            'mrp' => $mrpData['mrp'],
            'is_provisional' => $mrpData['is_provisional'],
            'status_message' => $statusMessage
        ]);
    }

    /**
     * Fetch Nearby Infrastructure (POIs) using OSM Overpass API.
     * Only searches for Agro-Dealers (shops).
     */
    private function fetchNearbyServices(Client $client): array
    {
        // Query for agrarian shops within 10km of Mbare
        $query = sprintf('
            [out:json][timeout:25];
            (
              node["shop"~"agrarian|farm|seeds|fertilizer"](around:10000,%f,%f);
            );
            out body;
        ', $this->mbareCoordinates['lat'], $this->mbareCoordinates['lng']);

        try {
            $response = $client->post('https://overpass-api.de/api/interpreter', [
                'body' => $query
            ]);
            $data = json_decode($response->getBody(), true);
            
            return array_map(fn($element) => [
                'name' => $element['tags']['name'] ?? 'Unnamed Agro-Dealer',
                'type' => 'Agro-Dealer',
                'lat'  => $element['lat'],
                'lng'  => $element['lon'],
            ], $data['elements'] ?? []);
        } catch (\Exception $e) {
            Log::error('Overpass POI Query Failed: ' . $e->getMessage());
            return [];
        }
    }
}