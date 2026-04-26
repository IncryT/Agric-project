<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Command Center') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-sm font-medium text-gray-500 uppercase">Tracked Products</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalProducts }}</div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-sm font-medium text-gray-500 uppercase">Latest Scrape</div>
                    <div class="mt-2 text-xl font-bold text-green-600">{{ $lastScrapeCount }} Items</div>
                    <div class="text-xs text-gray-400 mt-1">
                        @if ($lastScrapeTime && $lastScrapeTime !== 'Never')
                            {{ \Carbon\Carbon::parse($lastScrapeTime)->diffForHumans() }}
                        @else
                            Never
                        @endif
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-sm font-medium text-gray-500 uppercase">Next Auto-Scrape</div>
                    <form action="{{ route('admin.schedule.update') }}" method="POST" class="mt-2 flex items-center gap-2">
                        @csrf
                        <input type="time" name="schedule_time" value="{{ $scheduleTime }}" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm w-full">
                        <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700">Set</button>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="text-sm font-medium text-gray-500 uppercase">SMS Alert Schedule</div>
                    <form action="{{ route('admin.alert-schedule.update') }}" method="POST" class="mt-2 flex items-center gap-2">
                        @csrf
                        <input type="time" name="alert_schedule_time" value="{{ $alertScheduleTime }}" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm w-full">
                        <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700">Set</button>
                    </form>
                </div>
            </div>

            <!-- Farmer Location Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                <div class="bg-emerald-600 p-6 rounded-lg shadow-md text-white border-t-4 border-emerald-400">
                    <div class="text-sm font-bold text-emerald-100 uppercase">Total Farmers</div>
                    <div class="mt-2 text-4xl font-bold">{{ $totalFarmers }}</div>
                    <div class="text-xs text-emerald-200 mt-2">
                        <a href="{{ route('admin.farmers.index') }}" class="hover:underline">View Directory →</a>
                    </div>
                </div>

               
                
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Top 10 Most Expensive (Today)</h3>
                    <canvas id="topChart"></canvas>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">10 Most Affordable (Today)</h3>
                    <canvas id="bottomChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const topData = @json($topData);
        const bottomData = @json($bottomData);

        const createChart = (elementId, data, color) => {
            new Chart(document.getElementById(elementId), {
                type: 'bar',
                data: {
                    labels: data.map(item => item.product?.name ?? 'Unknown'),
                    datasets: [{
                        label: 'Price ($)',
                        data: data.map(item => item.price ?? 0),
                        backgroundColor: color,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    scales: { y: { beginAtZero: true } }
                }
            });
        };

        createChart('topChart', topData, 'rgba(239, 68, 68, 0.7)'); // Red for expensive
        createChart('bottomChart', bottomData, 'rgba(34, 197, 94, 0.7)'); // Green for cheap
    </script>
</x-app-layout>