<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" placeholder="+263787126351" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- District -->
        <div class="mt-4">
            <x-input-label for="district" :value="__('District')" />
            <x-text-input id="district" class="block mt-1 w-full" type="text" name="district" :value="old('district')" placeholder="e.g. Mutoko" />
            <x-input-error :messages="$errors->get('district')" class="mt-2" />
        </div>

        <!-- Location -->
        <div class="mt-4">
            <x-input-label for="latitude" :value="__('Latitude')" />
            <x-text-input id="latitude" class="block mt-1 w-full" type="text" name="latitude" :value="old('latitude')" placeholder="Auto-detected from device" readonly />
            <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="longitude" :value="__('Longitude')" />
            <x-text-input id="longitude" class="block mt-1 w-full" type="text" name="longitude" :value="old('longitude')" placeholder="Auto-detected from device" readonly />
            <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
        </div>

        <div class="mt-4 flex items-center gap-3">
            <button type="button" id="detect-location-button" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 transition">Detect location</button>
            <span id="location-status" class="text-sm text-slate-400">Your browser can fill latitude and longitude automatically.</span>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Minimum 8 characters" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const status = document.getElementById('location-status');
            const button = document.getElementById('detect-location-button');
            const latitude = document.getElementById('latitude');
            const longitude = document.getElementById('longitude');
            const district = document.getElementById('district');

            function setStatus(message) {
                if (status) {
                    status.textContent = message;
                }
            }

            async function reverseGeocode(lat, lng) {
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=10&addressdetails=1`);
                    const data = await response.json();

                    if (data && data.address) {
                        // Try to get district/state information
                        const districtName = data.address.state || data.address.county || data.address.city_district || data.address.suburb;
                        if (districtName && district) {
                            district.value = districtName;
                        }
                    }
                } catch (error) {
                    console.log('Reverse geocoding failed:', error);
                }
            }

            function setLocation(position) {
                if (!position) {
                    setStatus('Unable to get coordinates. Please allow location access.');
                    return;
                }
                const lat = position.coords.latitude.toFixed(6);
                const lng = position.coords.longitude.toFixed(6);

                latitude.value = lat;
                longitude.value = lng;

                setStatus('Location captured. Getting district information...');

                // Reverse geocode to get district
                reverseGeocode(lat, lng).then(() => {
                    setStatus('Location and district captured successfully.');
                });
            }

            function detectLocation() {
                if (!navigator.geolocation) {
                    setStatus('Geolocation is not supported by your browser.');
                    return;
                }

                setStatus('Requesting location access...');
                navigator.geolocation.getCurrentPosition(
                    setLocation,
                    function () {
                        setStatus('Location access denied or unavailable.');
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
                );
            }

            button?.addEventListener('click', detectLocation);
            detectLocation();
        });
    </script>
</x-guest-layout>
