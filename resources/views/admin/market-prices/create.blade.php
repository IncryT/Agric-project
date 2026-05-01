<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Record Manual Price') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-8">
                
                <form method="POST" action="{{ route('admin.market-prices.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Record Date</label>
                            <input type="date" name="date" id="date" value="{{ old('date', \Carbon\Carbon::today()->toDateString()) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @error('date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                            <select name="product_id" id="product_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white" required>
                                <option value="" disabled selected>Select a product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (/{{ $product->unit_of_measure }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-100 mb-6">
                        <div class="w-full md:w-1/2">
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Captured Price</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price') }}" class="pl-7 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="0.00" required>
                            </div>
                            @error('price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 mt-2">
                        <a href="{{ route('admin.market-prices.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 underline transition">Cancel</a>
                        
                        <button type="submit" class="px-6 py-3 bg-gray-900 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-800 focus:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            Save Price
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>