<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\RoutingService;

class RoutingServiceTest extends TestCase
{
    public function test_routing_service_can_be_instantiated()
    {
        $service = new RoutingService();
        $this->assertInstanceOf(RoutingService::class, $service);
    }

    public function test_calculate_distance_to_mbare_method_exists()
    {
        $service = new RoutingService();
        $this->assertTrue(method_exists($service, 'calculateDistanceToMbare'));
    }

    public function test_calculate_distance_method_exists()
    {
        $service = new RoutingService();
        $this->assertTrue(method_exists($service, 'calculateDistance'));
    }

    public function test_calculate_distance_between_points_method_exists()
    {
        $service = new RoutingService();
        $this->assertTrue(method_exists($service, 'calculateDistanceBetweenPoints'));
    }
}