@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-green-600 text-white">
                <h1 class="text-2xl font-bold">Nearby Agricultural Services</h1>
                <p class="mt-2">Find agronomists, veterinarians, equipment rentals, and more near you.</p>
            </div>

            <div class="p-6">
                @if(isset($message))
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
                        <p>{{ $message }}</p>
                        <a href="{{ route('profile.edit') }}" class="text-yellow-600 hover:text-yellow-800 underline">Update your location</a>
                    </div>
                @else
                    <div class="mb-6">
                        <label for="radius" class="block text-sm font-medium text-gray-700 mb-2">Search Radius (km)</label>
                        <select id="radius" name="radius" class="block w-full max-w-xs border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            <option value="10" {{ $radius == 10 ? 'selected' : '' }}>10 km</option>
                            <option value="25" {{ $radius == 25 ? 'selected' : '' }}>25 km</option>
                            <option value="50" {{ $radius == 50 ? 'selected' : '' }}>50 km</option>
                            <option value="100" {{ $radius == 100 ? 'selected' : '' }}>100 km</option>
                        </select>
                    </div>

                    @if($services->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No services found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try increasing the search radius or check back later.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($services as $service)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $service->name }}</h3>
                                            <p class="text-sm text-green-600 font-medium">{{ ucfirst($service->type) }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $service->description }}</p>
                                        </div>
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                            {{ number_format($service->distance, 1) }} km away
                                        </span>
                                    </div>

                                    @if($service->address)
                                        <p class="text-sm text-gray-500 mt-2">{{ $service->address }}</p>
                                    @endif

                                    @if($service->services_offered && count($service->services_offered) > 0)
                                        <div class="mt-3">
                                            <p class="text-sm font-medium text-gray-700">Services Offered:</p>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @foreach($service->services_offered as $offered)
                                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $offered }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mt-4 flex space-x-2">
                                        @if($service->contact_phone)
                                            <a href="tel:{{ $service->contact_phone }}" class="text-sm text-green-600 hover:text-green-800 font-medium">
                                                📞 Call
                                            </a>
                                        @endif
                                        @if($service->contact_email)
                                            <a href="mailto:{{ $service->contact_email }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                ✉️ Email
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('radius').addEventListener('change', function() {
        const url = new URL(window.location);
        url.searchParams.set('radius', this.value);
        window.location.href = url.toString();
    });
</script>
@endsection