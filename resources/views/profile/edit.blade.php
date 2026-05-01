<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Tab Navigation -->
            <div class="mb-6 border-b border-gray-200">
                <nav class="flex space-x-8" aria-label="Tabs">
                    <button type="button" 
                            class="tab-button py-4 px-1 border-b-2 border-indigo-500 font-medium text-sm text-indigo-600"
                            data-tab="basic-info">
                        Basic Information
                    </button>
                    <button type="button" 
                            class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300"
                            data-tab="farm-details">
                        Farm Details
                    </button>
                    <button type="button" 
                            class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300"
                            data-tab="location">
                        Location
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="space-y-6">
                <!-- Basic Info Tab -->
                <div id="tab-basic-info" class="tab-content">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        @include('profile.partials.basic-info-form')
                    </div>
                </div>

                <!-- Farm Details Tab -->
                <div id="tab-farm-details" class="tab-content hidden">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        @include('profile.partials.farm-details-form')
                    </div>
                </div>

                <!-- Location Tab -->
                <div id="tab-location" class="tab-content hidden">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl space-y-6">
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Location Information</h3>
                                <p class="text-sm text-gray-600 mt-1">Click on the map to set your location, or use the "Get Current Location" button.</p>
                                <div id="location-map" style="height: 300px; width: 100%; margin-top: 10px;"></div>
                                <button type="button" id="get-location" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Get Current Location</button>
                            </div>

                            <!-- District -->
                            <div>
                                <x-input-label for="district" :value="__('District')" />
                                <x-text-input id="district" name="district" type="text" class="mt-1 block w-full" :value="old('district', $user->district)" />
                                <x-input-error class="mt-2" :messages="$errors->get('district')" />
                            </div>

                            <!-- Latitude & Longitude -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="latitude" :value="__('Latitude')" />
                                    <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full" :value="old('latitude', $user->latitude)" placeholder="e.g., -19.0154" readonly />
                                    <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                                </div>
                                <div>
                                    <x-input-label for="longitude" :value="__('Longitude')" />
                                    <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full" :value="old('longitude', $user->longitude)" placeholder="e.g., 29.1549" readonly />
                                    <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                                </div>
                            </div>

                            <div class="flex items-center gap-4 pt-4">
                                <x-primary-button>{{ __('Save Location') }}</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                                        {{ __('Saved.') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Change Section (Separate Card) -->
            <div class="mt-6 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Section (Separate Card) -->
            <div class="mt-6 p-4 sm:p-8 bg-white shadow sm:rounded-lg border-red-200">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetTab = button.getAttribute('data-tab');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    
                    // Show target tab content
                    document.getElementById('tab-' + targetTab).classList.remove('hidden');
                    
                    // Update tab button styles
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-indigo-500', 'text-indigo-600');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });
                    button.classList.remove('border-transparent', 'text-gray-500');
                    button.classList.add('border-indigo-500', 'text-indigo-600');
                });
            });

            // Map initialization for location tab
            var map = L.map('location-map').setView([-19.0154, 29.1549], 6);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            var marker;
            var lat = document.getElementById('latitude').value;
            var lng = document.getElementById('longitude').value;
            if (lat && lng) {
                marker = L.marker([parseFloat(lat), parseFloat(lng)]).addTo(map);
            }
            
            map.on('click', function(e) {
                var latlng = e.latlng;
                document.getElementById('latitude').value = latlng.lat.toFixed(6);
                document.getElementById('longitude').value = latlng.lng.toFixed(6);
                if (marker) {
                    marker.setLatLng(latlng);
                } else {
                    marker = L.marker(latlng).addTo(map);
                }
            });
            
            document.getElementById('get-location').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;
                        document.getElementById('latitude').value = lat.toFixed(6);
                        document.getElementById('longitude').value = lng.toFixed(6);
                        if (marker) {
                            marker.setLatLng([lat, lng]);
                        } else {
                            marker = L.marker([lat, lng]).addTo(map);
                        }
                        map.setView([lat, lng], 10);
                    }, function(error) {
                        alert('Unable to retrieve your location. Please click on the map.');
                    });
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            });

            // Crop varieties checkbox styling
            const checkboxes = document.querySelectorAll('.crop-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const label = this.closest('label');
                    if (this.checked) {
                        label.classList.add('bg-emerald-50', 'border-emerald-500', 'text-emerald-700');
                        label.classList.remove('border-gray-300', 'text-gray-700');
                    } else {
                        label.classList.remove('bg-emerald-50', 'border-emerald-500', 'text-emerald-700');
                        label.classList.add('border-gray-300', 'text-gray-700');
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
