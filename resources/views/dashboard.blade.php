@extends('layouts.app')

@section('content')
    <div id="dashboard" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8 grid grid-cols-1 lg:grid-cols-3 gap-4">
       
        <div class="lg:col-span-2">
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="bg-white shadow-md rounded-2xl p-1 flex flex-col items-center justify-center w-full text-center">
                    <h3 class="text-sm font-medium text-gray-600 uppercase m-0">Admins</h3>
                    <p class="text-2xl font-bold text-gray-900 m-0">{{ $adminCount }}</p>
                </div>
                <div class="bg-white shadow-md rounded-2xl p-1 flex flex-col items-center justify-center w-full text-center">
                    <h3 class="text-sm font-medium text-gray-600 uppercase m-0">Consultants</h3>
                    <p class="text-2xl font-bold text-gray-900 m-0">{{ $consultantCount }}</p>
                </div>
                <div
                    class="bg-white shadow-md rounded-2xl p-1 flex flex-col items-center justify-center w-full text-center">
                    <h3 class="text-sm font-medium text-gray-600 uppercase m-0">Clients</h3>
                    <p class="text-2xl font-bold text-gray-900 m-0">{{ $clientCount }}</p>
                </div>
                <div
                    class="bg-white shadow-md rounded-2xl p-1 flex flex-col items-center justify-center w-full text-center">
                    <h3 class="text-sm font-medium text-gray-600 uppercase m-0">Contractors</h3>
                    <p class="text-2xl font-bold text-gray-900 m-0">{{ $contractorCount }}</p>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="mt-4 bg-white p-2 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-gray-700">Hours Worked For All Projects</h3>
                 
                    <select class="px-3 py-1 border border-gray-100 rounded-md text-gray-700 text-sm">
                        <option value="all">All</option>
                        <option value="monthly">Monthly</option>
                        <option value="weekly">Weekly</option>
                        <option value="daily">Daily</option>
                    </select>

                </div>
                <canvas id="hoursChart" class=" h-40"></canvas>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-0 overflow-hidden lg:col-span-1 flex flex-col" style="height: 31rem">
          
            <div class="flex justify-between items-center bg-gray-300 px-3 py-2 rounded-t-md">
                <h3 class="text-sm font-medium text-gray-900">Recent Activity</h3>
                <div class="relative inline-block text-left">
                    <div class="flex items-center space-x-2 text-gray-500 cursor-pointer" id="dropdownButton">
                        <i class="fas fa-calendar-alt"></i>
                        <span class="text-xs" id="selectedOption">All</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>

                    <div id="dropdownMenu"
                        class="hidden absolute right-0 mt-2 w-24 bg-white border border-gray-300 rounded-md shadow-lg">
                        <ul class="py-1 p-0 text-sm text-gray-700 m-0">
                            <li class="dropdown-item px-4 py-1 hover:bg-blue-100 cursor-pointer">All</li>
                            <li class="dropdown-item px-4 py-1 hover:bg-blue-100 cursor-pointer">Monthly</li>
                            <li class="dropdown-item px-4 py-1 hover:bg-blue-100 cursor-pointer">Weekly</li>
                            <li class="dropdown-item px-4 py-1 hover:bg-blue-100 cursor-pointer">Daily</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="space-y-4 overflow-y-auto divide-y divide-gray-200">
    @forelse ($activities as $activity)
    <div class="p-2 bg-gray-50 rounded-md">
        <div class="flex justify-between items-center text-xs text-gray-500 px-2">
            <span class="font-semibold uppercase bg-gray-300 text-white px-3 py-1 rounded-xl">
                {{ strtoupper($activity->created_for ?? 'ACTIVITY') }}
            </span>
                <span>{{ \Carbon\Carbon::parse($activity->created_at)->format('F d, Y') }}</span>
            </div>
            <p class="text-sm font-semibold text-gray-800 px-2 mt-2 mb-2">
                {{ $activity->title ?? 'Activity Performed' }}
            </p>
            <p class="text-sm text-gray-800 px-2">
                {{ $activity->description }}
            </p>
            <p class="text-xs text-black font-semibold mt-2 px-2">Creator:
    <span class="font-normal text-gray-500">
        {{ trim("{$activity->creator->firstname} {$activity->creator->lastname}") ?: 'N/A' }}
    </span>
</p>


        </div>
    @empty
        <div class="p-2 text-gray-500 text-sm text-center">No recent activity found.</div>
    @endforelse
</div>
    <script>
        $(document).ready(function() {
            const ctx = document.getElementById('hoursChart').getContext('2d');
            const selectedText = $("#selectedOption");
            const dropdownMenu = $("#dropdownMenu");
            const dropdownItems = $(".dropdown-item");

            // Chart Data
            const hoursChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        label: "Hours Worked",
                        data: [0, 0, 0, 0, 0, 0, 200, 15, 180, 15, 0, 0], // Example data
                        backgroundColor: "rgba(33, 60, 95, 0.9)",
                        borderWidth: 0
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
    
@endsection
