<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Farmer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Market Insights</h3>
                    <p class="mb-6">Review market prices or calculate your Best Price before selling your produce.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border rounded-lg p-5 shadow-sm bg-green-50 border-green-200">
                            <h4 class="font-semibold text-md text-green-800">Best Price Calculator</h4>
                            <p class="text-sm text-green-700 mt-2 mb-4">Enter your cost of production to see if the market price meets your profit goals.</p>
                            <a href="{{ route('farmer.calculator.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                                Open Calculator
                            </a>
                        </div>

                        <div class="border rounded-lg p-5 shadow-sm bg-gray-50">
                            <h4 class="font-semibold text-md text-gray-700">SMS Alerts</h4>
                            <p class="text-sm text-gray-500 mt-2 mb-4">Manage your product subscriptions and notification frequency (daily).</p>
                            <a href="{{ route('farmer.subscriptions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                                Manage Alerts
                            </a>
                        </div>

                        <div class="border rounded-lg p-5 shadow-sm bg-blue-50 border-blue-200">
                            <h4 class="font-semibold text-md text-blue-800">AI Chatbot Advisor</h4>
                            <p class="text-sm text-blue-700 mt-2 mb-4">Ask the advisor about crop prices, market signals, or selling recommendations in a conversational format.</p>
                            <a href="{{ route('farmer.chatbot') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                Open Chat Advisor
                            </a>
                        </div>
                    </div>

                    
                    <div class="mt-8">
                        <h4 class="font-semibold text-md text-gray-700 mb-3">Market price</h4>
                        
                        @if($marketOverview->isEmpty())
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded shadow-sm">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            Market data will populate here once the administrator captures the daily prices.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-4">
                                <ul class="divide-y divide-gray-100">
                                    @foreach($marketOverview as $data)
                                        <li class="p-4 hover:bg-gray-50 transition flex justify-between items-center">
                                            
                                            <div>
                                                <span class="font-bold text-gray-800">{{ $data['name'] }}</span>
                                                @if($data['is_provisional'])
                                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-yellow-100 text-yellow-800 border border-yellow-200" title="Based on fewer than 7 days of captured data">
                                                        Provisional
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="text-right">
                                                <span class="font-bold text-lg text-green-600">${{ number_format($data['mrp'], 2) }}</span>
                                                <span class="text-sm text-gray-400 font-medium ml-1">/ {{ $data['unit_of_measure'] }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <div>
                                {{ $marketOverview->links() }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>