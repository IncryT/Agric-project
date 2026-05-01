<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg mx-auto bg-slate-800/50 backdrop-blur-xl p-8 sm:p-10 rounded-3xl shadow-2xl border border-slate-700/50">
            <h2 class="text-2xl font-bold text-white text-center mb-4">Create Account</h2>
            <p class="text-slate-400 text-center mb-6">Join our growing community of farmers.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Full Name -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Full Name')" class="text-slate-400" />
                    <x-text-input id="name" class="block mt-1 w-full bg-white text-black" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email Address')" class="text-slate-400" />
                    <x-text-input id="email" class="block mt-1 w-full bg-white text-black" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="kupyd@mailin" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone Number -->
                <div class="mb-4">
                    <x-input-label for="phone" :value="__('Phone Number')" class="text-slate-400" />
                    <x-text-input id="phone" class="block mt-1 w-full bg-white text-black" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" placeholder="+263..." />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- District -->
                <div class="mb-4">
                    <x-input-label for="district" :value="__('District')" class="text-slate-400" />
                    <div class="flex gap-2">
                        <x-text-input id="district" class="block flex-1 bg-white text-black" type="text" name="district" :value="old('district')" required placeholder="e.g. Mutoko" />
                        <button type="button" id="detect-location-button" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-md transition flex items-center gap-2 whitespace-nowrap" title="Detect your location">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Detect
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('district')" class="mt-2" />
                </div>

                <!-- Latitude & Longitude (Optional - Auto-filled) -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-input-label for="latitude" :value="__('Latitude')" class="text-slate-400" />
                        <x-text-input id="latitude" class="block mt-1 w-full bg-white text-black" type="text" name="latitude" :value="old('latitude')" placeholder="Auto-detected" readonly />
                        <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="longitude" :value="__('Longitude')" class="text-slate-400" />
                        <x-text-input id="longitude" class="block mt-1 w-full bg-white text-black" type="text" name="longitude" :value="old('longitude')" placeholder="Auto-detected" readonly />
                        <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" class="text-slate-400" />
                    <x-text-input id="password" class="block mt-1 w-full bg-white text-black" type="password" name="password" required autocomplete="new-password" placeholder="********" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-slate-400" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white text-black" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="********" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a class="text-sm text-emerald-400 hover:underline" href="{{ route('login') }}">
                        {{ __('Already registered? Sign In') }}
                    </a>
                    <x-primary-button class="w-full bg-emerald-600 hover:bg-emerald-500">
                        {{ __('Create Account') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

     <script>
         document.addEventListener('DOMContentLoaded', function () {
             const button = document.getElementById('detect-location-button');
             const latitude = document.getElementById('latitude');
             const longitude = document.getElementById('longitude');
             const districtInput = document.getElementById('district');

             function showStatus(message) {
                 // Create or update status element
                 let statusEl = document.getElementById('location-status');
                 if (!statusEl) {
                     statusEl = document.createElement('p');
                     statusEl.id = 'location-status';
                     statusEl.className = 'text-sm mt-2 text-center';
                     button.parentElement.appendChild(statusEl);
                 }
                 statusEl.textContent = message;
                 statusEl.className = 'text-sm mt-2 text-center ' + 
                     (message.includes('Error') || message.includes('failed') || message.includes('denied') 
                      ? 'text-red-400' : 'text-slate-400');
             }

             async function reverseGeocode(lat, lng) {
                 try {
                     const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=10&addressdetails=1&accept-language=en`);
                     const data = await response.json();

                     if (data && data.address) {
                         // Try district in order of specificity
                         const districtName = data.address.state || 
                                            data.address.county || 
                                            data.address.city_district || 
                                            data.address.district || 
                                            data.address.suburb ||
                                            data.address.town ||
                                            data.address.village;
                         if (districtName && districtInput) {
                             districtInput.value = districtName;
                         }
                     }
                 } catch (error) {
                     console.log('Reverse geocoding failed:', error);
                 }
             }

             function detectLocation() {
                 if (!navigator.geolocation) {
                     showStatus('Error: Geolocation is not supported by this browser.');
                     return;
                 }

                 showStatus('Getting your location...');
                 
                 navigator.geolocation.getCurrentPosition(
                     async function(position) {
                         const lat = position.coords.latitude.toFixed(6);
                         const lng = position.coords.longitude.toFixed(6);

                         latitude.value = lat;
                         longitude.value = lng;

                         showStatus('Location captured! Looking up district...');

                         // Reverse geocode to get district
                         await reverseGeocode(lat, lng);
                         
                         if (districtInput.value) {
                             showStatus('Location and district detected successfully!');
                         } else {
                             showStatus('Location captured. Please enter your district manually.');
                         }
                     },
                     function(error) {
                         let msg = 'Unable to get location. ';
                         switch(error.code) {
                             case error.PERMISSION_DENIED:
                                 msg += 'Please allow location access.';
                                 break;
                             case error.POSITION_UNAVAILABLE:
                                 msg += 'Location information unavailable.';
                                 break;
                             case error.TIMEOUT:
                                 msg += 'Location request timed out.';
                                 break;
                             default:
                                 msg += error.message;
                         }
                         showStatus(msg);
                     },
                     { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                 );
             }

             if (button) {
                 button.addEventListener('click', detectLocation);
             }
         });
     </script>
</x-guest-layout>
