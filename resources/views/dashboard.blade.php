@extends('layouts.app')

@section('content')
    <div id="dashboard" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8 grid grid-cols-1 lg:grid-cols-3 gap-4">

        <div class="lg:col-span-2">
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                {{-- Admin Cards --}}
                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'consultant')
                    <div class="bg-white shadow-md rounded-2xl p-1 flex flex-col items-center justify-center w-full text-center">
                        <h3 class="text-sm font-medium text-gray-600 uppercase m-0">Admins</h3>
                        <p class="text-2xl font-bold text-gray-900 m-0">{{ $adminCount }}</p>
                    </div>
                    <div class="bg-white shadow-md rounded-2xl p-1 flex flex-col items-center justify-center w-full text-center">
                        <h3 class="text-sm font-medium text-gray-600 uppercase m-0">Consultants</h3>
                        <p class="text-2xl font-bold text-gray-900 m-0">{{ $consultantCount }}</p>
                    </div>
                    <div class="bg-white shadow-md rounded-2xl p-1 flex flex-col items-center justify-center w-full text-center">
                        <h3 class="text-sm font-medium text-gray-600 uppercase m-0">Clients</h3>
                        <p class="text-2xl font-bold text-gray-900 m-0">{{ $clientCount }}</p>
                    </div>
                    <div class="bg-white shadow-md rounded-2xl p-1 flex flex-col items-center justify-center w-full text-center">
                        <h3 class="text-sm font-medium text-gray-600 uppercase m-0">Contractors</h3>
                        <p class="text-2xl font-bold text-gray-900 m-0">{{ $contractorCount }}</p>
                    </div>
                @endif

                {{-- Client & Contractor Cards (Project Stats) --}}
                @if (auth()->user()->role === 'client' || auth()->user()->role === 'contractor')
                    <div class="bg-white shadow-md rounded-2xl p-1 flex flex-col items-center justify-center w-full text-center">
                        <h3 class="text-sm font-medium text-gray-600 uppercase m-0">Total Projects</h3>
                        <p class="text-2xl font-bold text-gray-900 m-0">{{ $totalProjects }}</p>
                    </div>
                    <div class="bg-white shadow-md rounded-2xl p-1 flex flex-col items-center justify-center w-full text-center">
                        <h3 class="text-sm font-medium text-gray-600 uppercase m-0">Active Projects</h3>
                        <p class="text-2xl font-bold text-gray-900 m-0">{{ $activeProjects }}</p>
                    </div>
                    <div class="bg-white shadow-md rounded-2xl p-1 flex flex-col items-center justify-center w-full text-center">
                        <h3 class="text-sm font-medium text-gray-600 uppercase m-0">Pending Projects</h3>
                        <p class="text-2xl font-bold text-gray-900 m-0">{{ $pendingProjects }}</p>
                    </div>
                    <div class="bg-white shadow-md rounded-2xl p-1 flex flex-col items-center justify-center w-full text-center">
                        <h3 class="text-sm font-medium text-gray-600 uppercase m-0">Completed Projects</h3>
                        <p class="text-2xl font-bold text-gray-900 m-0">{{ $completedProjects }}</p>
                    </div>
                @endif
            </div>

            <!-- Chart Section -->
            @if ($projects->count() > 0)
                <div class="mt-4 bg-white p-2 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-semibold text-gray-700">Hours Worked For All Projects</h3>
                        <select id="projectSelect"
                            class="px-3 py-1 border border-gray-100 rounded-md text-gray-700 text-sm">
                            <option value="all">All Projects</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <canvas id="hoursChart" class="h-40"></canvas>
                </div>
            @else
                <div class="mt-4 bg-white p-4 rounded-lg shadow-md text-gray-500">
                    You don’t have access to any projects yet.
                </div>
            @endif

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
        </div>

    </div>

    <script>
        $(document).ready(function() {
            const chartCanvas = document.getElementById('hoursChart');
            if (!chartCanvas) return; // Exit if no canvas present (e.g. no projects)

            const ctx = chartCanvas.getContext('2d');
            const projectDropdown = $("#projectSelect");
            let hoursChart;

            function loadChart(projectId = 'all') {
                $.ajax({
                    url: '/dashboard/monthly-hours',
                    method: 'GET',
                    data: {
                        project_id: projectId
                    },
                    success: function(res) {
                        const data = res.data;

                        if (hoursChart) hoursChart.destroy();

                        hoursChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                                ],
                                datasets: [{
                                    label: "Hours Worked",
                                    data: data,
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
                    }
                });
            }

            // Initial load
            loadChart();

            // Reload when project changes
            projectDropdown.on('change', function() {
                const selectedProject = $(this).val();
                loadChart(selectedProject);
            });

            // Dropdown toggle logic
            $('#dropdownButton').on('click', function(e) {
                e.stopPropagation();
                $('#dropdownMenu').toggleClass('hidden');
            });

            $(document).on('click', function() {
                $('#dropdownMenu').addClass('hidden');
            });

            $('#dropdownMenu').on('click', function(e) {
                e.stopPropagation();
            });

            // Function to load activities with a given filter
            function loadActivities(filter) {
                // Show loading message while data is fetched
                $('.space-y-4').html('<div class="p-2 text-gray-500 text-sm text-center">Loading...</div>');

                $.ajax({
                    url: '/dashboard/activities/filter',
                    type: 'GET',
                    data: {
                        filter: filter
                    },
                    success: function(response) {
                        $('.space-y-4').html(response.html);
                    },
                    error: function() {
                        $('.space-y-4').html(
                            '<div class="p-2 text-red-500 text-sm text-center">Failed to load activities.</div>'
                            );
                    }
                });
            }

            // Click on filter option
            $('.dropdown-item').on('click', function() {
                let filter = $(this).text().trim().toLowerCase();
                $('#selectedOption').text($(this).text());
                $('#dropdownMenu').addClass('hidden');
                loadActivities(filter);
            });

            // Load "All" filter by default on page load
            loadActivities('all');
        });
    </script>

@endsection
