<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\RoutingService;
use App\Http\Controllers\Farmer\CalculatorController;
use App\Services\PricingCalculatorService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mockery;

class CalculatorControllerTest extends TestCase
{
    public function test_calculator_controller_is_instantiated_with_routing_service()
    {
        // Mock the dependencies
        $pricingCalculator = Mockery::mock(PricingCalculatorService::class);
        $routingService = Mockery::mock(RoutingService::class);

        // Instantiate the controller
        $controller = new CalculatorController($pricingCalculator, $routingService);

        // Assert that the controller was created successfully
        $this->assertInstanceOf(CalculatorController::class, $controller);
    }
}