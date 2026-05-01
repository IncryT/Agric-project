<?php

namespace App\Services;

use App\Models\MarketPrice;

class PricingCalculatorService
{
    /**
     * Compute the 7-day Simple Moving Average (Market Reference Price - MRP).
     */
    public function calculateMRP(int $productId): array
    {
        // Query the time-series data: the last 7 recorded daily averages
        // CHANGED: We now pluck 'price' instead of 'daily_average_price'
        $recentPrices = MarketPrice::where('product_id', $productId)
            ->orderBy('date', 'desc')
            ->take(7)
            ->pluck('price');

        $count = $recentPrices->count();

        // Handle edge case: No market data exists yet
        if ($count === 0) {
            return [
                'mrp' => 0.00,
                'is_provisional' => true,
                'days_used' => 0
            ];
        }

        // Calculate the SMA (Sum of prices / Number of days)
        $mrp = $recentPrices->sum() / $count;

        return [
            'mrp' => round($mrp, 2),
            // Flag as provisional if the moving average window is less than 7 days
            'is_provisional' => $count < 7, 
            'days_used' => $count
        ];
    }

    /**
     * Compute the Minimum Acceptable Price (MAP).
     * Formula: MAP = COP + (COP * Profit Margin %)
     */
    public function calculateMAP(float $cop, float $profitMarginPercentage): float
    {
        // Normalize the percentage input into a decimal multiplier (e.g., 20 becomes 0.20)
        $marginMultiplier = $profitMarginPercentage / 100;
        
        // Execute the MAP formula
        $map = $cop + ($cop * $marginMultiplier);

        return round($map, 2);
    }
}