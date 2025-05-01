@extends('layouts.app')

@section('content')
    <style>
        .success-popup {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #38a169;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: opacity 0.3s ease-in-out;
        }
    </style>
    <div id="project" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-2">
                    <div class="p-3 sm:p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-people text-orange-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">Active Projects</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">{{ $activeProjectsCount }} Projects</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑
                        34.4%</span>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-3 sm:p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-box-seam text-red-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">Admins</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">{{ $adminsCount }} Admins</p>
                    <span class="text-xs sm:text-sm text-red-600 bg-red-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↓
                        8.1%</span>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-3 sm:p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-headset text-orange-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">Clients</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">{{ $clientsCount }} Clients</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑
                        12.6%</span>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-3 sm:p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-receipt text-orange-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">Contractors</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">{{ $contractorsCount }} Contractors</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑
                        45.9%</span>
                </div>
            </div>
        </div>

        <!-- Filters Wrapper -->
        <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between mb-4 mt-4">

            
            <!-- Mobile Toggle Button -->
            <div class="flex justify-between items-center md:hidden bg-white p-3 rounded-md shadow-sm">
                <span class="text-gray-700 font-semibold text-sm">Filter By</span>
                <button id="toggleFilters" class="text-sm text-black hover:underline">
                   Show Filters
                </button>
            </div>
            <!-- Left side: Filter label and active filters -->
            <div class="flex flex-col" style="max-width: 550px !important;">
                <span class="text-gray-500 font-semibold text-xs mb-2">Filters:</span>
                <div id="applied-filters" class="flex flex-wrap gap-2">
                    <!-- Dynamically generated badges will appear here -->
                </div>
            </div>

            <!-- Right side: Filter dropdowns -->
            <div id="filterSection" class="hidden md:flex flex-wrap gap-2 bg-white px-3 py-2 rounded-md shadow-sm"
                style="margin-right: 130px">
                <!-- Filter By Label with Icon -->
                <div class="flex items-center text-gray-700 text-sm font-semibold mr-2">
                    <i class="bi bi-funnel-fill mr-1 text-gray-600"></i>
                    Filter By
                </div>
                <div class="flex flex-wrap gap-2 sm:gap-3">
                    @if (in_array(Auth::user()->role, ['admin', 'consultant']))
                        <!-- Client Filter -->
                        <div class="relative filter-dropdown">
                            <button type="button"
                                class="filter-button flex items-center bg-gray-100 text-gray-700 border border-gray-300 rounded-md 
           px-2 py-1 text-xs sm:px-3 sm:py-2 sm:text-sm 
           hover:bg-gray-200">
                                Client
                                <i class="bi bi-caret-down-fill ml-1 transition-transform duration-200"></i>
                            </button>

                            <div
                                class="filter-options hidden absolute mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-2 max-h-60 overflow-y-auto">
                                    @foreach ($projects->unique('client_id') as $project)
                                        @if ($project->client)
                                            <div class="flex items-center px-3 py-0 hover:bg-gray-50">
                                                <input type="checkbox" class="filter-checkbox form-checkbox text-blue-600"
                                                    name="clients[]" value="{{ $project->client->id }}">
                                                <label class="ml-3 mt-1 text-sm text-gray-700">
                                                    {{ $project->client->firstname }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- Status Filter -->
                    <div class="relative filter-dropdown">
                        <button type="button"
                            class="filter-button flex items-center bg-gray-100 text-gray-700 border border-gray-300 rounded-md 
           px-2 py-1 text-xs sm:px-3 sm:py-2 sm:text-sm 
           hover:bg-gray-200">
                            Status <i class="bi bi-caret-down-fill ml-1 transition-transform duration-200"></i>
                        </button>
                        <div
                            class="filter-options hidden absolute mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-2 max-h-60 overflow-y-auto">
                                @foreach (['pending', 'in_progress', 'completed', 'cancelled'] as $status)
                                    <div class="flex items-center px-3 py-0 hover:bg-gray-50">
                                        <input type="checkbox" class="filter-checkbox form-checkbox text-blue-600"
                                            name="statuses[]" value="{{ $status }}">
                                        <label class="ml-3 mt-1 text-sm text-gray-700 capitalize">
                                            {{ str_replace('_', ' ', $status) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Filters Wrapper -->


        <div class="bg-white p-2 sm:p-5 rounded-lg shadow-md mt-4 sm:mt-6">
            <div class="mx-2 flex justify-between items-center mb-1 sm:mb-4">
                <h2 class="text-lg sm:text-xl font-bold">Projects</h2>
                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('project.add') }}"
                        class="px-2 py-1 text-xs sm:text-sm font-medium text-white bg-gradient-to-r from-yellow-400 to-red-400 
            hover:from-red-400 hover:to-yellow-400 rounded-lg shadow-sm transform hover:scale-105 transition-all duration-300 flex items-center gap-1">
                        <i class="bi bi-person-plus text-sm"></i> Add
                    </a>
                @endif

            </div>
            <div class="max-h-[220px] overflow-y-auto overflow-x-auto relative border rounded-md" style="height: 320px">


                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                SR</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Project Name</th>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'consultant')
                                <th
                                    class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                    Client Name</th>
                            @endif
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Start Date</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                End Date</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Status</th>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'consultant')
                                <th
                                    class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                    Client Rate</th>
                            @endif
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Created At</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Updated At</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="project-table-body">
                        @foreach ($projects as $project)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $loop->iteration }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->name }}</td>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'consultant')
                                    <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                        {{ isset($project->client) ? trim("{$project->client->firstname} {$project->client->middlename} {$project->client->lastname}") : 'N/A' }}
                                    </td>
                                @endif
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->start_date }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->end_date }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ ucfirst($project->status) }}</td>

                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'consultant')
                                    <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                        {{ $project->client_rate }}</td>
                                @endif
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->created_at }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->updated_at }}</td>
                                <td class="p-2 sm:p-2 flex justify-center space-x-1">

                                    <a href="{{ route('project.view', $project->id) }}">
                                        <button class="p-2 rounded-xl bg-blue-100 hover:bg-blue-200 transition-all">
                                            <i class="fas fa-eye text-blue-500"></i>
                                        </button>
                                    </a>
                                    @if (Auth::user()->role == 'admin')
                                        <a href="{{ route('project.edit', $project->id) }}">
                                            <button
                                                class="p-2 rounded-xl bg-yellow-100 hover:bg-orange-200 transition-all">
                                                <i class="bi bi-pencil text-orange-500"></i>
                                            </button>
                                        </a>
                                        @if (in_array($project->status, ['pending', 'cancelled']))
                                            <form method="POST" action="{{ route('project.destroy', $project->id) }}"
                                                class="inline-block"
                                                onsubmit="return confirm('Are you sure you want to delete this project?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-2 py-2 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-sm">
                                                    <span class="bi bi-trash text-red-500 text-base"></span>
                                                </button>
                                            </form>
                                        @endif
                                    @endif


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (session('project_created') || session('project_updated') || session('success'))
        <div id="projectSuccessPopup" class="success-popup">
            @if (session('project_created'))
                Project has been successfully created.
            @elseif(session('project_updated'))
                Project has been successfully updated.
            @else
                Action sucessful.
            @endif
        </div>
        <script>
            setTimeout(() => {
                const popup = document.getElementById('projectSuccessPopup');
                if (popup) {
                    popup.style.opacity = '0';
                    setTimeout(() => popup.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('.filter-checkbox').on('change', function() {
                filterProjects();
            });

            function filterProjects() {
                let clients = [];
                $('input[name="clients[]"]:checked').each(function() {
                    clients.push($(this).val());
                });
                let statuses = [];
                $('input[name="statuses[]"]:checked').each(function() {
                    statuses.push($(this).val());
                });

                $.ajax({
                    url: "{{ route('project.index') }}",
                    method: "GET",
                    data: {
                        _token: "{{ csrf_token() }}",
                        clients: clients,
                        statuses: statuses,
                    },
                    success: function(response) {
                        var tempDiv = $('<div>').html(response.html);
                        var newTbody = tempDiv.find('#project-table-body').html();
                        $('#project-table-body').html(newTbody);
                    }
                });
            }

        });
    </script>
@endsection
