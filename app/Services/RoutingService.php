<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RoutingService
{
    protected Client $client;
    
    /**
     * Mbare Market, Harare Coordinates
     */
    protected array $mbareCoordinates = ['lat' => -17.8596, 'lng' => 31.0384];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new Client(['timeout' => 10.0]);
    }

    /**
     * Calculate road distance between two points using OSRM
     *
     * @param float $startLat Starting latitude
     * @param float $startLng Starting longitude
     * @param float $endLat Ending latitude (default: Mbare market)
     * @param float $endLng Ending longitude (default: Mbare market)
     * @return float Distance in kilometers
     */
    public function calculateDistance(float $startLat, float $startLng, float $endLat = null, float $endLng = null): float
    {
        // Use Mbare coordinates as default destination
        if ($endLat === null) {
            $endLat = $this->mbareCoordinates['lat'];
        }
        if ($endLng === null) {
            $endLng = $this->mbareCoordinates['lng'];
        }

        try {
            $osrmUrl = sprintf(
                'http://router.project-osrm.org/route/v1/driving/%f,%f;%f,%f?overview=false',
                $startLng, $startLat,
                $endLng, $endLat
            );

            $osrmResponse = $this->client->get($osrmUrl);
            $osrmData = json_decode($osrmResponse->getBody(), true);
            
            if (isset($osrmData['routes'][0]['distance'])) {
                return $osrmData['routes'][0]['distance'] / 1000; // Convert meters to kilometers
            }
            
            return 0;
        } catch (\Exception $e) {
            Log::error('OSRM Distance Calculation Failed: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Calculate distance from user's location to Mbare market
     *
     * @param float $userLat User's latitude
     * @param float $userLng User's longitude
     * @return float Distance in kilometers
     */
    public function calculateDistanceToMbare(float $userLat, float $userLng): float
    {
        return $this->calculateDistance($userLat, $userLng);
    }

    /**
     * Calculate distance between two arbitrary points
     *
     * @param float $lat1 Latitude of point 1
     * @param float $lng1 Longitude of point 1
     * @param float $lat2 Latitude of point 2
     * @param float $lng2 Longitude of point 2
     * @return float Distance in kilometers
     */
    public function calculateDistanceBetweenPoints(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        return $this->calculateDistance($lat1, $lng1, $lat2, $lng2);
    }
}