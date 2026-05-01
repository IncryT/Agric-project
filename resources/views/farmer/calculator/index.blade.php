<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minimum Acceptable Price (MAP) Calculator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-6 text-gray-600">Calculate your minimum acceptable selling price based on your production costs and compare it to the Market price.</p>

                    <form method="POST" action="{{ route('farmer.calculator.calculate') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700">Select Product</label>
                            <select id="product_id" name="product_id" required class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                                <option value="" disabled selected>-- Choose a product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} (per {{ $product->unit_of_measure }})</option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="cop" class="block text-sm font-medium text-gray-700">Cost of Production (COP)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="cop" id="cop" step="0.01" min="0" required class="pl-7 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" placeholder="0.00">
                                </div>
                                @error('cop')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="profit_margin" class="block text-sm font-medium text-gray-700">Desired Profit Margin (%)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" name="profit_margin" id="profit_margin" step="0.1" min="0" required class="block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm pr-8" placeholder="20">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">%</span>
                                    </div>
                                </div>
                                @error('profit_margin')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Calculate & Compare
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>