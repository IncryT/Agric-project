<section>
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Farm Details Section -->
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Farm Name -->
                <div>
                    <x-input-label for="farm_name" :value="__('Farm Name (Optional)')" />
                    <x-text-input id="farm_name" name="farm_name" type="text" class="mt-1 block w-full" :value="old('farm_name', $user->farmerProfile?->farm_name)" />
                    <x-input-error class="mt-2" :messages="$errors->get('farm_name')" />
                </div>

                <!-- Farm Phone -->
                <div>
                    <x-input-label for="farm_phone" :value="__('Farm Phone Number')" />
                    <x-text-input id="farm_phone" name="farm_phone" type="tel" class="mt-1 block w-full" :value="old('farm_phone', $user->farmerProfile?->farm_phone)" placeholder="+263..." />
                    <x-input-error class="mt-2" :messages="$errors->get('farm_phone')" />
                </div>

                <!-- Farm Address -->
                <div class="md:col-span-2">
                    <x-input-label for="farm_address" :value="__('Farm Address')" />
                    <x-text-input id="farm_address" name="farm_address" type="text" class="mt-1 block w-full" :value="old('farm_address', $user->farmerProfile?->farm_address)" placeholder="Physical location or description" />
                    <x-input-error class="mt-2" :messages="$errors->get('farm_address')" />
                </div>

                <!-- Total Land Size -->
                <div>
                    <x-input-label for="total_land_size" :value="__('Total Land Size')" />
                    <div class="flex gap-2 mt-1">
                        <x-text-input id="total_land_size" name="total_land_size" type="number" step="0.01" min="0" class="flex-1" :value="old('total_land_size', $user->farmerProfile?->total_land_size)" placeholder="e.g., 10.5" />
                        <select name="land_unit" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1">
                            <option value="hectares" {{ (old('land_unit', $user->farmerProfile?->land_unit) == 'hectares') ? 'selected' : '' }}>Hectares</option>
                            <option value="acres" {{ (old('land_unit', $user->farmerProfile?->land_unit) == 'acres') ? 'selected' : '' }}>Acres</option>
                        </select>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('total_land_size')" />
                </div>

                <!-- Irrigation Type -->
                <div>
                    <x-input-label for="irrigation_type" :value="__('Irrigation Type')" />
                    <select id="irrigation_type" name="irrigation_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="none" {{ (old('irrigation_type', $user->farmerProfile?->irrigation_type) == 'none') ? 'selected' : '' }}>None (Rain-fed)</option>
                        <option value="drip" {{ (old('irrigation_type', $user->farmerProfile?->irrigation_type) == 'drip') ? 'selected' : '' }}>Drip Irrigation</option>
                        <option value="sprinkler" {{ (old('irrigation_type', $user->farmerProfile?->irrigation_type) == 'sprinkler') ? 'selected' : '' }}>Sprinkler</option>
                        <option value="furrow" {{ (old('irrigation_type', $user->farmerProfile?->irrigation_type) == 'furrow') ? 'selected' : '' }}>Furrow</option>
                        <option value="other" {{ (old('irrigation_type', $user->farmerProfile?->irrigation_type) == 'other') ? 'selected' : '' }}>Other</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('irrigation_type')" />
                </div>

                <!-- Soil Type -->
                <div>
                    <x-input-label for="soil_type" :value="__('Soil Type')" />
                    <select id="soil_type" name="soil_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="" {{ (old('soil_type', $user->farmerProfile?->soil_type) == '') ? 'selected' : '' }}>Select soil type</option>
                        <option value="clay" {{ (old('soil_type', $user->farmerProfile?->soil_type) == 'clay') ? 'selected' : '' }}>Clay</option>
                        <option value="sandy" {{ (old('soil_type', $user->farmerProfile?->soil_type) == 'sandy') ? 'selected' : '' }}>Sandy</option>
                        <option value="loam" {{ (old('soil_type', $user->farmerProfile?->soil_type) == 'loam') ? 'selected' : '' }}>Loam</option>
                        <option value="silt" {{ (old('soil_type', $user->farmerProfile?->soil_type) == 'silt') ? 'selected' : '' }}>Silt</option>
                        <option value="other" {{ (old('soil_type', $user->farmerProfile?->soil_type) == 'other') ? 'selected' : '' }}>Other</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('soil_type')" />
                </div>

                <!-- Farming Experience -->
                <div>
                    <x-input-label for="farming_experience_years" :value="__('Farming Experience (Years)')" />
                    <x-text-input id="farming_experience_years" name="farming_experience_years" type="number" min="0" max="100" class="mt-1 block w-full" :value="old('farming_experience_years', $user->farmerProfile?->farming_experience_years)" />
                    <x-input-error class="mt-2" :messages="$errors->get('farming_experience_years')" />
                </div>

                <!-- Main Market -->
                <div>
                    <x-input-label for="main_market" :value="__('Main Market')" />
                    <select id="main_market" name="main_market" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="local" {{ (old('main_market', $user->farmerProfile?->main_market) == 'local') ? 'selected' : '' }}>Local Market</option>
                        <option value="mbare" {{ (old('main_market', $user->farmerProfile?->main_market) == 'mbare') ? 'selected' : '' }}>Mbare Musika</option>
                        <option value="export" {{ (old('main_market', $user->farmerProfile?->main_market) == 'export') ? 'selected' : '' }}>Export</option>
                        <option value="contract" {{ (old('main_market', $user->farmerProfile?->main_market) == 'contract') ? 'selected' : '' }}>Contract Buyers</option>
                        <option value="other" {{ (old('main_market', $user->farmerProfile?->main_market) == 'other') ? 'selected' : '' }}>Other</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('main_market')" />
                </div>

                <!-- Cooperative Name -->
                <div>
                    <x-input-label for="cooperative_name" :value="__('Cooperative / Association')" />
                    <x-text-input id="cooperative_name" name="cooperative_name" type="text" class="mt-1 block w-full" :value="old('cooperative_name', $user->farmerProfile?->cooperative_name)" />
                    <x-input-error class="mt-2" :messages="$errors->get('cooperative_name')" />
                </div>

                <!-- Business Type -->
                <div>
                    <x-input-label for="business_type" :value="__('Business Type')" />
                    <select id="business_type" name="business_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="" {{ (old('business_type', $user->farmerProfile?->business_type) == '') ? 'selected' : '' }}>Select type</option>
                        <option value="subsistence" {{ (old('business_type', $user->farmerProfile?->business_type) == 'subsistence') ? 'selected' : '' }}>Subsistence</option>
                        <option value="small_scale" {{ (old('business_type', $user->farmerProfile?->business_type) == 'small_scale') ? 'selected' : '' }}>Small Scale Commercial</option>
                        <option value="commercial" {{ (old('business_type', $user->farmerProfile?->business_type) == 'commercial') ? 'selected' : '' }}>Commercial</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('business_type')" />
                </div>

                <!-- Expected Annual Yield -->
                <div class="md:col-span-2">
                    <x-input-label for="expected_annual_yield" :value="__('Expected Annual Yield (Tonnes)')" />
                    <x-text-input id="expected_annual_yield" name="expected_annual_yield" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('expected_annual_yield', $user->farmerProfile?->expected_annual_yield)" placeholder="Total annual production in tonnes" />
                    <p class="text-sm text-gray-500 mt-1">Used for forecasting and market analysis</p>
                    <x-input-error class="mt-2" :messages="$errors->get('expected_annual_yield')" />
                </div>

                <!-- Crop Varieties (Multi-select with tags) -->
                <div class="md:col-span-2">
                    <x-input-label for="crop_varieties" :value="__('Crop Varieties Grown')" />
                    <p class="text-sm text-gray-500 mb-2">Select all the crop varieties you cultivate on your farm</p>
                    <div class="flex flex-wrap gap-2 mt-2" id="crop-varieties-container">
                        @php
                            $selectedCrops = old('crop_varieties', $user->farmerProfile?->crop_varieties ?? []);
                            if (!is_array($selectedCrops)) $selectedCrops = [$selectedCrops];
                            
                            $commonCrops = ['Maize', 'Wheat', 'Soya Beans', 'Sugar Beans', 'Potatoes', 'Tomatoes', 'Onions', 'Cabbages', 'Carrots', 'Green Beans', 'Butternut', 'Cucumber', 'Watermelon', 'Mopane Worms', 'Groundnuts', 'Sorghum', 'Millet', 'Rice'];
                        @endphp
                        
                        @foreach($commonCrops as $crop)
                            <label class="inline-flex items-center px-3 py-2 border rounded-lg cursor-pointer transition-all hover:bg-gray-50 {{ in_array($crop, $selectedCrops) ? 'bg-emerald-50 border-emerald-500 text-emerald-700' : 'border-gray-300 text-gray-700' }}">
                                <input type="checkbox" name="crop_varieties[]" value="{{ $crop }}" {{ in_array($crop, $selectedCrops) ? 'checked' : '' }} class="hidden crop-checkbox">
                                <span class="text-sm font-medium">{{ $crop }}</span>
                            </label>
                        @endforeach
                    </div>
                    <input type="text" name="other_crops" id="other_crops" class="mt-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                           :value="old('other_crops', $user->farmerProfile?->other_crops)" 
                           placeholder="Other crops (comma separated)" />
                    <x-input-error class="mt-2" :messages="$errors->get('crop_varieties')" />
                    <x-input-error class="mt-2" :messages="$errors->get('other_crops')" />
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                <x-primary-button>{{ __('Save Farm Details') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                        {{ __('Saved.') }}
                    </p>
                @endif
            </div>
        </div>
    </form>
</section>
