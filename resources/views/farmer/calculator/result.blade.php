<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calculation Results: ') }} {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if($mrp >= $map)
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold text-lg">Market price is favourable.</p>
                    <p>The market price is currently above your minimum acceptable price.</p>
                </div>
            @else
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold text-lg">Market price is below your minimum acceptable price.</p>
                    <p>Selling at the current market price will not meet your desired profit margin.</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Your Financials</h3>
                    <ul class="space-y-3">
                        <li class="flex justify-between">
                            <span class="text-gray-600">Cost of Production (COP):</span>
                            <span class="font-medium">${{ number_format($cop, 2) }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600">Desired Profit Margin:</span>
                            <span class="font-medium">{{ $profit_margin }}%</span>
                        </li>
                        <li class="flex justify-between pt-3 border-t">
                            <span class="text-gray-800 font-bold">Minimum Acceptable Price (MAP):</span>
                            <span class="font-bold text-lg text-blue-600">${{ number_format($map, 2) }}</span>
                        </li>
                    </ul>

                    <div class="mt-5 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-bold text-gray-900">Suggested Target Price:</span>
                            <span class="text-lg font-bold text-green-600">
                                ${{ number_format(max($map, $mrp), 2) }}
                            </span>
                        </div>
                        
                        <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                            @if($mrp > $map)
                                <strong class="text-green-600">Favorable Market:</strong> The current market rate is higher than your minimum requirement. We suggest listing at the market price to maximize your profit.
                            @elseif($mrp == $map)
                                <strong class="text-blue-600">Balanced Market:</strong> The market rate perfectly matches your required margin.
                            @else
                                <strong class="text-red-500">Underperforming Market:</strong> The market is currently paying less than you need. You must aim for this target price to achieve your {{ $profit_margin }}% profit margin.
                            @endif
                        </p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Market price</h3>
                    
                    <div class="text-center mt-6">
                        <span class="block text-sm text-gray-500 mb-1">Market price</span>
                        <span class="block text-4xl font-bold text-gray-900">${{ number_format($mrp, 2) }}</span>
                        <span class="block text-sm text-gray-500 mt-1">per {{ $product->unit_of_measure }}</span>
                    </div>

                    @if($is_provisional)
                        <div class="mt-6 bg-yellow-50 border border-yellow-200 text-yellow-800 text-xs px-3 py-2 rounded">
                            <strong>Note:</strong> This market price is provisional. It is based on fewer than 7 days of captured market data.
                        </div>
                    @endif
                </div>

            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('farmer.calculator.index') }}" class="text-gray-600 hover:text-gray-900 underline decoration-gray-400">
                    &larr; Calculate Another Product
                </a>
                <a href="{{ route('farmer.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 transition">
                    Return to Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>