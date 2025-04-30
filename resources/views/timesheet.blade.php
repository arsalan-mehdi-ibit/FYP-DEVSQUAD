@extends('layouts.app')

@section('content')
    <div id="timesheet" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-2">
                    <div class="p-3 sm:p-3 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="bi bi-filter text-blue-500"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">This Month's</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">{{ $thisMonthCount }}</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑
                        34.4%</span>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-3 sm:p-3 rounded-xl bg-green-100 flex items-center justify-center">
                        <i class="bi bi-check-circle text-green-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">APPROVED</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">{{ $approvedCount }}</p>
                    <span class="text-xs sm:text-sm text-red-600 bg-red-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↓
                        8.1%</span>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-3 sm:p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-x-circle text-red-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">REJECTED</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">{{ $rejectedCount }}</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑
                        12.6%</span>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-3 sm:p-3 rounded-xl bg-yellow-100 flex items-center justify-center">
                        <i class="bi bi-receipt text-yellow-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">PENDING APPROVAL</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">{{ $pendingApprovalCount }}</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑
                        45.9%</span>
                </div>
            </div>
        </div>

        <!-- Filters Wrapper -->
        <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between mb-4 mt-4 ">
            <!-- Left side: Filter label and active filters -->
            <div class="flex flex-col " style="max-width: 365px !important;">
                <span class="text-gray-500 font-semibold text-xs mb-2">Filters:</span>
                <div id="applied-filters" class="flex flex-wrap gap-2">
                    <!-- Dynamically generated badges will appear here -->
                </div>
            </div>

            <div class="flex flex-wrap gap-2 bg-white px-3 py-2 rounded-md shadow-sm">
                <div class="flex items-center text-gray-700 text-sm font-semibold mr-2">
                    <i class="bi bi-funnel-fill mr-1 text-gray-600"></i>
                    Filter By
                </div>
                <!-- Date Filter -->
                <div class="relative filter-dropdown">
                    <button type="button"
                        class="filter-button flex items-center bg-gray-100 text-gray-700 border border-gray-300 rounded-md px-3 py-2 text-sm hover:bg-gray-200 focus:outline-none">
                        Date <i class="bi bi-caret-down-fill ml-1 transition-transform duration-200"></i>
                    </button>
                    <div
                        class="filter-options hidden absolute mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-2 max-h-60 overflow-y-auto">
                            @foreach ($timesheets->unique(function ($item) {
            return $item->week_start_date . $item->week_end_date;
        }) as $timesheet)
                                <div class="flex items-center px-3 py-0 hover:bg-gray-50">
                                    <input type="checkbox" class="filter-checkbox form-checkbox text-blue-600"
                                        name="dates[]"
                                        value="{{ $timesheet->week_start_date }} - {{ $timesheet->week_end_date }}">
                                    <label class="ml-3 mt-1 text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($timesheet->week_start_date)->format('M d, Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($timesheet->week_end_date)->format('M d, Y') }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Project Filter -->
                <div class="relative filter-dropdown">
                    <button type="button"
                        class="filter-button flex items-center bg-gray-100 text-gray-700 border border-gray-300 rounded-md px-3 py-2 text-sm hover:bg-gray-200 focus:outline-none">
                        Project <i class="bi bi-caret-down-fill ml-1 transition-transform duration-200"></i>
                    </button>
                    <div
                        class="filter-options hidden absolute mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-2 max-h-60 overflow-y-auto">
                            @foreach ($timesheets->unique('project_id') as $timesheet)
                                @if ($timesheet->project)
                                    <div class="flex items-center px-3 py-0 hover:bg-gray-50">
                                        <input type="checkbox" class="filter-checkbox form-checkbox text-blue-600"
                                            name="projects[]" value="{{ $timesheet->project->id }}">
                                        <label
                                            class="ml-3 mt-1 text-sm text-gray-700">{{ $timesheet->project->name }}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @if (in_array(Auth::user()->role, ['admin', 'consultant']))
                    <!-- Client Filter -->
                    <div class="relative filter-dropdown">
                        <button type="button"
                            class="filter-button flex items-center bg-gray-100 text-gray-700 border border-gray-300 rounded-md px-3 py-2 text-sm hover:bg-gray-200 focus:outline-none">
                            Client <i class="bi bi-caret-down-fill ml-1 transition-transform duration-200"></i>
                        </button>
                        <div
                            class="filter-options hidden absolute mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-2 max-h-60 overflow-y-auto">
                                @foreach ($timesheets->unique(function ($item) {
                            return $item->project ? $item->project->client_id : null;
                        }) as $timesheet)
                                    @if ($timesheet->project && $timesheet->project->client)
                                        <div class="flex items-center px-3 py-0 hover:bg-gray-50">
                                            <input type="checkbox" class="filter-checkbox form-checkbox text-blue-600"
                                                name="clients[]" value="{{ $timesheet->project->client->id }}">
                                            <label
                                                class="ml-3 mt-1 text-sm text-gray-700">{{ $timesheet->project->client->firstname }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Contractor Filter -->
                    <div class="relative filter-dropdown">
                        <button type="button"
                            class="filter-button flex items-center bg-gray-100 text-gray-700 border border-gray-300 rounded-md px-3 py-2 text-sm hover:bg-gray-200 focus:outline-none">
                            Contractor <i class="bi bi-caret-down-fill ml-1 transition-transform duration-200"></i>
                        </button>
                        <div
                            class="filter-options hidden absolute mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-2 max-h-60 overflow-y-auto">
                                @foreach ($timesheets->unique('contractor_id') as $timesheet)
                                    @if ($timesheet->contractor)
                                        <div class="flex items-center px-3 py-0 hover:bg-gray-50">
                                            <input type="checkbox" class="filter-checkbox form-checkbox text-blue-600"
                                                name="contractors[]" value="{{ $timesheet->contractor->id }}">
                                            <label
                                                class="ml-3 mt-1 text-sm text-gray-700">{{ $timesheet->contractor->firstname }}</label>
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
                        class="filter-button flex items-center bg-gray-100 text-gray-700 border border-gray-300 rounded-md px-3 py-2 text-sm hover:bg-gray-200 focus:outline-none">
                        Status <i class="bi bi-caret-down-fill ml-1 transition-transform duration-200"></i>
                    </button>
                    <div
                        class="filter-options hidden absolute mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-2 max-h-60 overflow-y-auto">
                            @foreach (['pending', 'submitted', 'approved', 'rejected', 'in_progress'] as $status)
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
        <!-- End Filters Wrapper -->

        <div class="bg-white p-2 sm:p-5 rounded-lg shadow-md mt-4 sm:mt-6">
            <h2 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4">Timesheets</h2>

            <div class="max-h-[220px] overflow-y-auto overflow-x-auto relative border rounded-md" style="height: 460px"
                id="timesheet-table-wrapper">
                <table class="w-full min-w-full text-center">
                    <thead class="sticky top-0 bg-gray-100 z-10 text-center">
                        <tr class="border-b">
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                SR</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Timesheet Name</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Status</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Total Hours</th>

                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Project</th>
                            @if (Auth::user()->role != 'client')
                                <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                    Contractor</th>
                            @endif
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'consultant')
                                <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                    Client</th>
                            @endif
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Detail</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody id="timesheet-table-body">
                        @foreach ($timesheets as $timesheet)
                            <tr class="border-b {{ $timesheet->status == 'rejected' ? 'bg-red-100' : 'hover:bg-gray-50' }}"
                                data-timesheet-id="{{ $timesheet->id }}"
                                data-date="{{ \Carbon\Carbon::parse($timesheet->week_start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($timesheet->week_end_date)->format('M d, Y') }}"
                                data-project="{{ $timesheet->project->name ?? '' }}"
                                data-client="{{ $timesheet->project->client->firstname ?? '' }}"
                                data-contractor="{{ $timesheet->contractor->firstname ?? '' }}"
                                data-status="{{ $timesheet->status ?? '' }}">
                                <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base filter-input">
                                    {{ ($timesheets->currentPage() - 1) * $timesheets->perPage() + $loop->iteration }}
                                </td>
                                <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">
                                    {{ \Carbon\Carbon::parse($timesheet->week_start_date)->format('M d, Y') }} -
                                    {{ \Carbon\Carbon::parse($timesheet->week_end_date)->format('M d, Y') }}
                                </td>
                                <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base filter-input">
                                    {{ $timesheet->status ?? 'N/A' }}
                                </td>
                                <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">
                                    {{ $timesheet->total_actual_hours }}
                                </td>

                                <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base filter-input">
                                    {{ $timesheet->project->name ?? 'N/A' }}
                                </td>
                                @if (Auth::user()->role != 'client')
                                    <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base filter-input">
                                        {{ $timesheet->contractor->firstname ?? 'N/A' }}
                                    </td>
                                @endif

                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'consultant')
                                    <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base filter-input">
                                        {{ $timesheet->project->client->firstname ?? 'N/A' }}
                                    </td>
                                @endif
                                <td class="p-2 sm:p-3 text-center">
                                    <button class="text-gray-600 hover:text-gray-900 transition-all">
                                        <a href="{{ route('timesheet.details.detail', $timesheet->id) }}"
                                            class="text-gray-600 hover:text-gray-900 transition-all">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </button>
                                </td>
                                <td class="p-2 sm:p-2 text-center">
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'client')
                                        <div class="inline-flex space-x-1">
                                            <!-- Approve Button -->
                                            <button
                                                class="px-2 py-1 rounded-lg transition-all text-xs 
                                                {{ $timesheet->status == 'submitted' ? 'bg-green-200 hover:bg-green-100' : 'bg-gray-300 cursor-not-allowed' }}"
                                                id="approve-btn-{{ $timesheet->id }}"
                                                {{ $timesheet->status != 'submitted' ? 'disabled' : '' }}
                                                onclick="openApproveModal({{ $timesheet->id }})">
                                                <span class="text-black">Approve</span>
                                            </button>

                                            <!-- Reject Button -->
                                            <button
                                                class="px-2 py-1 rounded-lg transition-all text-xs 
                                                {{ $timesheet->status == 'submitted' ? 'bg-red-100 hover:bg-red-200' : 'bg-gray-300 cursor-not-allowed' }}"
                                                id="reject-btn-{{ $timesheet->id }}"
                                                {{ $timesheet->status != 'submitted' ? 'disabled' : '' }}
                                                onclick="openRejectModal({{ $timesheet->id }})">
                                                <span class="text-black">Reject</span>
                                            </button>
                                        </div>
                                        @include('components.approve-timesheet-modal')
                                        @include('components.approval-success-modal')
                                        @include('components.reject-timesheet-modal')
                                        @include('components.rejection-success-modal')
                                    @else
                                        <div class="inline-flex space-x-1">
                                            <!-- Submit Button for Contractor -->
                                            <button
                                                class="px-2 py-1 rounded-lg transition-all text-xs 
                                                @if ($timesheet->status == 'pending') bg-blue-200 hover:bg-blue-100
                                                @elseif($timesheet->status == 'rejected')
                                                    bg-red-200 hover:bg-red-100
                                                @else
                                                    bg-gray-300 cursor-not-allowed @endif"
                                                onclick="{{ in_array($timesheet->status, ['pending', 'rejected']) ? "openSubmitModal({$timesheet->id})" : '' }}"
                                                {{ !in_array($timesheet->status, ['pending', 'rejected']) ? 'disabled' : '' }}>
                                                <span class="text-black">
                                                    @if ($timesheet->status == 'rejected')
                                                        Resubmit
                                                    @else
                                                        Submit
                                                    @endif
                                                </span>
                                            </button>
                                        </div>
                                        <!-- Modals -->
                                        @include('components.submit-timesheet-modal')
                                        @include('components.submitted-success-modal')
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <div class="mt-0 flex justify-end">
                <div class="bg-transparent dark:bg-gray-800  rounded-lg px-3 py-0">
                    {{ $timesheets->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        function openSubmitModal(timesheetId) {
            $('#submitForm').attr('action', `/timesheet/${timesheetId}/submit`);
            new bootstrap.Modal(document.getElementById('submitModal')).show();
        }

        function closeSubmitModal() {
            $('#submitModal').modal('hide');
        }

        function closeSubmittedSuccessModal(id) {
            $(`#submittedSuccessModal-${id}`).modal('hide');
        }

        function openApproveModal(timesheetId) {
            $('#approveForm').attr('action', `/timesheet/${timesheetId}/approve`);
            new bootstrap.Modal(document.getElementById('approveModal')).show();
        }

        function openRejectModal(timesheetId) {
            $('#rejectForm').attr('action', `/timesheet/${timesheetId}/reject`);
            new bootstrap.Modal(document.getElementById('rejectModal')).show();
        }

        $(document).ready(function() {
            @if (session('success'))
                @php
                    $successMessage = session('success');
                @endphp

                @if (str_contains($successMessage, 'submitted'))
                    new bootstrap.Modal(document.getElementById('submittedSuccessModal')).show();
                @elseif ($successMessage == 'Timesheet approved successfully.')
                    new bootstrap.Modal(document.getElementById('approveSuccessModal')).show();
                @elseif ($successMessage == 'Timesheet rejected successfully.')
                    new bootstrap.Modal(document.getElementById('rejectSuccessModal')).show();
                @endif
            @endif


            $('.filter-checkbox').on('change', function() {
                filterTimesheets();
            });

            function filterTimesheets() {
                let dates = [];
                $('input[name="dates[]"]:checked').each(function() {
                    dates.push($(this).val());
                });

                let projects = [];
                $('input[name="projects[]"]:checked').each(function() {
                    projects.push($(this).val());
                });

                let clients = [];
                $('input[name="clients[]"]:checked').each(function() {
                    clients.push($(this).val());
                });

                let contractors = [];
                $('input[name="contractors[]"]:checked').each(function() {
                    contractors.push($(this).val());
                });

                let statuses = [];
                $('input[name="statuses[]"]:checked').each(function() {
                    statuses.push($(this).val());
                });

                $.ajax({
                    url: "{{ route('timesheet.index') }}", // <-- call 'index', not 'filter'
                    method: "GET",
                    data: {
                        _token: "{{ csrf_token() }}",
                        dates: dates,
                        projects: projects,
                        clients: clients,
                        contractors: contractors,
                        statuses: statuses,
                    },
                    success: function(response) {
                        // Create a temporary DOM element to hold the response
                        var tempDiv = $('<div>').html(response.html);

                        // Find the tbody inside that response
                        var newTbody = tempDiv.find('#timesheet-table-body').html();

                        // Replace your current tbody content
                        $('#timesheet-table-body').html(newTbody);
                    }
                });
            }
        });
    </script>
@endsection
