<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\AgriculturalService;
use Illuminate\Http\Request;

class ServiceDiscoveryController extends Controller
{
    /**
     * Display nearby agricultural services.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user->latitude || !$user->longitude) {
            return view('farmer.services.index', [
                'services' => collect(),
                'message' => 'Please update your location in your profile to find nearby services.'
            ]);
        }

        $radius = $request->get('radius', 50); // km

        $services = AgriculturalService::selectRaw(
            "*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance",
            [$user->latitude, $user->longitude, $user->latitude]
        )
        ->having('distance', '<', $radius)
        ->orderBy('distance')
        ->get();

        return view('farmer.services.index', compact('services', 'radius'));
    }
}
