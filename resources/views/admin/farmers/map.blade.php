<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Farmer Location Map') }}
            </h2>

            <a href="{{ route('admin.farmers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition shadow-sm">
                Back to Directory
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm ring-1 ring-gray-200 sm:rounded-lg">
                <div class="p-6">
                     <!-- Search Controls -->
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <label for="radiusInput" class="font-medium text-gray-700">Search Radius (km):</label>
                            <input type="number" id="radiusInput" value="400" step="10" min="10" class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button id="searchButton" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                Search
                            </button>
                            <span id="radiusDisplay" class="ml-3 font-mono text-gray-600">400 km</span>
                        </div>
                    </div>
                    
                    <!-- Map Container -->
                    <div id="map" style="height: 500px; width: 100%;"></div>
                    
                    <!-- District Legend -->
                    <div class="mt-4 p-4 bg-white border border-gray-200 rounded-lg">
                        <h4 class="font-medium text-gray-700 mb-2">District Legend</h4>
                        <div id="districtLegend" class="flex flex-wrap gap-3">
                            <!-- District colors will be generated here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the map centered on Zimbabwe (approximate center)
            var centerLat = -19.0154;
            var centerLng = 29.1549;
            var centerPoint = L.latLng(centerLat, centerLng);
            
            var map = L.map('map').setView(centerPoint, 6);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add a permanent marker for our central location
            L.marker(centerPoint).addTo(map).bindPopup("<b>Center Point</b>").openPopup();

            // Create a marker cluster group
            var markersLayer = L.layerGroup().addTo(map);

            // Get farmers data from PHP
            var farmers = @json($farmers);

                     // District colors map
                    var districtColors = {};
                    var colorPalette = [
                        '#e74c3c', '#3498db', '#2ecc71', '#f39c12', '#9b59b6',
                        '#1abc9c', '#e67e22', '#34495e', '#16a085', '#d35400',
                        '#c0392b', '#2980b9', '#27ae60', '#f1c40f', '#8e44ad'
                    ];
                    
            // Assign colors to districts from PHP data
            var allDistricts = @json($districtData->pluck('district')->toArray());
            allDistricts.forEach(function(district, index) {
                districtColors[district] = colorPalette[index % colorPalette.length];
            });

            // Generate district legend
            allDistricts.forEach(function(district, index) {
                var color = colorPalette[index % colorPalette.length];
                var farmerCount = @json($districtData->keyBy('district')->toArray());
                var count = farmerCount[district] ? farmerCount[district].farmer_count : 0;
                
                var legendItem = document.createElement('div');
                legendItem.className = 'flex items-center';
                legendItem.innerHTML = '<span class="w-4 h-4 rounded-full mr-2" style="background-color: ' + color + '"></span><span class="text-sm text-gray-700">' + district + ' (' + count + ' farmers)</span>';
                document.getElementById('districtLegend').appendChild(legendItem);
            });

            // Variables to hold our dynamic map layers so we can remove them on new searches
            var radiusCircle = null;

            // Function to update the map
            function updateMap() {
                // Get radius from the input field (convert km to meters)
                var radiusInKm = document.getElementById('radiusInput').value;
                var radiusInMeters = radiusInKm * 1000;
                
                // Update display
                document.getElementById('radiusDisplay').textContent = radiusInKm + ' km';

                // Clear previous circle and markers
                if (radiusCircle) {
                    map.removeLayer(radiusCircle);
                }
                markersLayer.clearLayers();

                // Draw the new visual circle on the map
                radiusCircle = L.circle(centerPoint, {
                    color: '#3388ff',
                    fillColor: '#3388ff',
                    fillOpacity: 0.2,
                    radius: radiusInMeters
                }).addTo(map);

                // Add farmer markers that are within the radius
                farmers.forEach(function(farmer) {
                    var itemPoint = L.latLng(farmer.latitude, farmer.longitude);
                    
                    // Calculate distance (returns meters)
                    var distance = centerPoint.distanceTo(itemPoint);

                    // If the distance is less than or equal to our radius, add it to the map
                    if (distance <= radiusInMeters) {
                        // Determine marker color based on district
                        var markerColor = districtColors[farmer.district] || '#95a5a6';
                        
                        // Create a custom colored marker icon
                        var coloredIcon = L.divIcon({
                            className: 'custom-marker-icon',
                            html: '<div style="background-color: ' + markerColor + '; width: 24px; height: 24px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">•</div>',
                            iconSize: [24, 24],
                            iconAnchor: [12, 12]
                        });
                        
                        var marker = L.marker(itemPoint, {icon: coloredIcon});
                        marker.bindPopup('<b>' + farmer.name + '</b><br>District: ' + farmer.district + '<br>Distance: ' + Math.round(distance/1000) + ' km');
                        markersLayer.addLayer(marker);
                    }
                });

                // Adjust the map zoom to fit the new circle
                map.fitBounds(radiusCircle.getBounds());
            }

            // Event listeners
            document.getElementById('searchButton').addEventListener('click', updateMap);
            document.getElementById('radiusInput').addEventListener('change', updateMap);

             // Run the function once on load to populate the initial 400km radius
            updateMap();
        });
    </script>
    @endpush
</x-app-layout>