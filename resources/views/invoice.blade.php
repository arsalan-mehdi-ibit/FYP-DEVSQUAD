@extends('layouts.app')

@section('content')
    <div id="invoice" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">

        <style>
            .success-popup {
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%) translateY(0);
                background: #38a169;
                color: white;
                padding: 10px 20px;
                border-radius: 8px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                opacity: 1;
                transition: opacity 0.5s ease, transform 0.5s ease;
                /* added transform transition */
            }
        </style>


        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Cards for stats -->
            <div
                class="bg-white shadow-md rounded-2xl p-3 flex items-center justify-between transition-all hover:shadow-lg w-full">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600">Revenue This Month</h3>
                    <p class="text-xl font-bold text-gray-800">2310</p>
                </div>
                <div class="p-3 rounded-xl bg-blue-100 flex items-center justify-center">
                    <i class="bi bi-filter text-blue-500 text-2xl"></i>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-3 flex items-center justify-between transition-all hover:shadow-lg w-full">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600">Total Invoices</h3>
                    <p class="text-xl font-bold text-gray-800">1000</p>
                </div>
                <div class="p-3 rounded-xl bg-yellow-100 flex items-center justify-center">
                    <i class="bi bi-receipt text-yellow-500 text-2xl"></i>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-3 flex items-center justify-between transition-all hover:shadow-lg w-full">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600">Active Invoices</h3>
                    <p class="text-xl font-bold text-gray-800">1310</p>
                </div>
                <div class="p-3 rounded-xl bg-green-100 flex items-center justify-center">
                    <i class="bi bi-check-circle text-green-500 text-2xl"></i>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-3 flex items-center justify-between transition-all hover:shadow-lg w-full">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600">Pending Invoices</h3>
                    <p class="text-xl font-bold text-gray-800">1243</p>
                </div>
                <div class="p-3 rounded-xl bg-yellow-100 flex items-center justify-center">
                    <i class="bi bi-receipt text-yellow-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Filters Wrapper -->
        <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between mb-4 mt-4">
            <div class="flex flex-col" style="max-width: 450px !important;">
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

                <div class="relative filter-dropdown">
                    <button type="button"
                        class="filter-button flex items-center bg-gray-100 text-gray-700 border border-gray-300 rounded-md px-3 py-2 text-xs hover:bg-gray-200 focus:outline-none">
                        Timesheet
                        <i class="bi bi-caret-down-fill ml-1 transition-transform duration-200"></i>
                    </button>
                    <div
                        class="filter-options hidden absolute mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-2 max-h-60 overflow-y-auto">
                            @foreach ($invoices->unique(function ($item) {
            return $item->timesheet->week_start_date . $item->timesheet->week_end_date;
        }) as $invoice)
                                <div class="flex items-center px-3 py-1 hover:bg-gray-50">
                                    <input type="checkbox" class="filter-checkbox form-checkbox text-blue-600"
                                        name="timesheets[]" value="{{$invoice->timesheet->week_start_date }} - {{ $invoice->timesheet->week_end_date }}">
                                    <label class="ml-3 mt-1 text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($invoice->timesheet->week_start_date)->format('M d, Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($invoice->timesheet->week_end_date)->format('M d, Y') }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Client Filter -->
                <div class="relative filter-dropdown">
                    <button type="button"
                        class="filter-button flex items-center bg-gray-100 text-gray-700 border border-gray-300 rounded-md px-3 py-2 text-xs hover:bg-gray-200 focus:outline-none">
                        Client
                        <i class="bi bi-caret-down-fill ml-1 transition-transform duration-200"></i>
                    </button>
                    <div
                        class="filter-options hidden absolute mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-2 max-h-60 overflow-y-auto">
                            @foreach ($invoices->unique('client_id') as $invoice)
                                @if ($invoice->client)
                                    <div class="flex items-center px-3 py-1 hover:bg-gray-50">
                                        <input type="checkbox" class="filter-checkbox form-checkbox text-blue-600"
                                            name="clients[]" value="{{ $invoice->client->id }}">
                                        <label class="ml-3 mt-1 text-sm text-gray-700">
                                            {{ $invoice->client->firstname }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Project Filter -->
                <div class="relative filter-dropdown">
                    <button type="button"
                        class="filter-button flex items-center bg-gray-100 text-gray-700 border border-gray-300 rounded-md px-3 py-2 text-xs hover:bg-gray-200 focus:outline-none">
                        Project
                        <i class="bi bi-caret-down-fill ml-1 transition-transform duration-200"></i>
                    </button>
                    <div
                        class="filter-options hidden absolute mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-2 max-h-60 overflow-y-auto">
                            @foreach ($invoices->unique('timesheet.project_id') as $invoice)
                                @if ($invoice->timesheet && $invoice->timesheet->project)
                                    <div class="flex items-center px-3 py-1 hover:bg-gray-50">
                                        <input type="checkbox" class="filter-checkbox form-checkbox text-blue-600"
                                            name="projects[]" value="{{ $invoice->timesheet->project->id }}">
                                        <label class="ml-3 mt-1 text-sm text-gray-700">
                                            {{ $invoice->timesheet->project->name }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="relative filter-dropdown">
                    <button type="button"
                        class="filter-button flex items-center bg-gray-100 text-gray-700 border border-gray-300 rounded-md px-3 py-2 text-xs hover:bg-gray-200 focus:outline-none">
                        Status
                        <i class="bi bi-caret-down-fill ml-1 transition-transform duration-200"></i>
                    </button>
                    <div
                        class="filter-options hidden absolute mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-2">
                            <div class="flex items-center px-3 py-1 hover:bg-gray-50">
                                <input type="checkbox" class="filter-checkbox form-checkbox text-blue-600" name="statuses[]"
                                    value="paid">
                                <label class="ml-3 mt-1 text-sm text-gray-700">Paid</label>
                            </div>
                            <div class="flex items-center px-3 py-1 hover:bg-gray-50">
                                <input type="checkbox" class="filter-checkbox form-checkbox text-blue-600" name="statuses[]"
                                    value="unpaid">
                                <label class="ml-3 mt-1 text-sm text-gray-700">Unpaid</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- Invoice Table (Responsive) -->
        <div class="bg-white p-2 sm:p-5 rounded-lg shadow-md mt-4 sm:mt-6">
            <h2 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4">All Invoices List</h2>

            <div class="max-h-[320px] overflow-y-auto overflow-x-auto relative border rounded-md">
                <table class="w-full min-w-full text-center">
                    <thead class="sticky top-0 bg-gray-100 z-10">
                        <tr class="border-b">
                            <th class="p-2 sm:p-3 font-semibold text-center text-gray-700 text-xs sm:text-sm md:text-base">#
                            </th>
                            <th class="p-2 sm:p-3 font-semibold text-center text-gray-700 text-xs sm:text-sm md:text-base">
                                Timesheet Name</th>

                            @if (auth()->user()->role == 'admin')
                                <th
                                    class="p-2 sm:p-3 font-semibold text-left text-gray-700 text-xs sm:text-sm md:text-base">
                                    Client Name</th>
                                <th
                                    class="p-2 sm:p-3 font-semibold text-center text-gray-700 text-xs sm:text-sm md:text-base">
                                    Project Name</th>
                                <th
                                    class="p-2 sm:p-3 font-semibold text-center text-gray-700 text-xs sm:text-sm md:text-base">
                                    Total Hours</th>
                                <th
                                    class="p-2 sm:p-3 font-semibold text-center text-gray-700 text-xs sm:text-sm md:text-base">
                                    Total Billable</th>
                                <th
                                    class="p-2 sm:p-3 font-semibold text-center text-gray-700 text-xs sm:text-sm md:text-base">
                                    Total Payable</th>
                            @else
                                <th
                                    class="p-2 sm:p-3 font-semibold text-center text-gray-700 text-xs sm:text-sm md:text-base">
                                    Actual Hours</th>
                                <th
                                    class="p-2 sm:p-3 font-semibold text-center text-gray-700 text-xs sm:text-sm md:text-base">
                                    Total Amount</th>
                                <th
                                    class="p-2 sm:p-3 font-semibold text-center text-gray-700 text-xs sm:text-sm md:text-base">
                                    Project Name</th>
                            @endif

                            <th class="p-2 sm:p-3 font-semibold text-center text-gray-700 text-xs sm:text-sm md:text-base">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-table-body">
                        @foreach ($invoices as $invoice)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2 sm:p-3 text-center text-xs sm:text-sm">
                                    {{ ($invoices->currentPage() - 1) * $invoices->perPage() + $loop->iteration }}</td>
                                <td class="p-2 sm:p-3 text-center text-xs sm:text-sm">
                                    {{ \Carbon\Carbon::parse($invoice->timesheet->week_start_date)->format('M d, Y') }} -
                                    {{ \Carbon\Carbon::parse($invoice->timesheet->week_end_date)->format('M d, Y') }}
                                </td>

                                @if (auth()->user()->role == 'admin')
                                    <td class="p-2 sm:p-3 text-left">
                                        <div class="flex items-center">
                                            @if ($invoice->client && $invoice->client->profilePicture && $invoice->client->profilePicture->file_path)
                                                <img src="{{ asset($invoice->client->profilePicture->file_path) }}"
                                                    alt="Client Image" class="h-8 sm:h-10 rounded-full mr-2 object-cover">
                                            @else
                                                <img src="{{ asset('assets/profile.jpeg') }}" alt="Default Image"
                                                    class="h-8 sm:h-10 rounded-full mr-2 object-cover">
                                            @endif
                                            <span class="hidden sm:block text-xs sm:text-sm md:text-base">
                                                {{ $invoice->client->firstname ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="p-2 sm:p-3 text-center text-xs sm:text-sm">
                                        {{ $invoice->timesheet->project->name ?? 'N/A' }}
                                    </td>
                                    <td class="p-2 sm:p-3 text-center text-xs sm:text-sm">
                                        {{ $invoice->timesheet->total_hours ?? 'N/A' }}
                                    </td>
                                    <td class="p-2 sm:p-3 text-center text-xs sm:text-sm">
                                       ${{ number_format($invoice->admin_received, 2) }}
                                    </td>
                                    <td class="p-2 sm:p-3 text-center text-xs sm:text-sm">
                                       ${{ number_format($invoice->contractor_paid, 2) }}
                                    </td>
                                @elseif(Auth::user()->role == 'client')
                                    <td class="p-2 sm:p-3 text-center text-xs sm:text-sm">
                                        {{ $invoice->timesheet->total_hours ?? 'N/A' }}
                                    </td>
                                    <td class="p-2 sm:p-3 text-center text-xs sm:text-sm">
                                    ${{ number_format($invoice->admin_received, 2) }}
                                    </td>
                                    <td class="p-2 sm:p-3 text-center text-xs sm:text-sm">
                                        {{ $invoice->timesheet->project->name ?? 'N/A' }}
                                    </td>
                                @else
                                    <td class="p-2 sm:p-3 text-center text-xs sm:text-sm">
                                        {{ $invoice->timesheet->total_hours ?? 'N/A' }}
                                    </td>
                                    <td class="p-2 sm:p-3 text-center text-xs sm:text-sm">
                                    ${{ number_format($invoice->contractor_paid, 2) }}
                                    </td>
                                    <td class="p-2 sm:p-3 text-center text-xs sm:text-sm">
                                        {{ $invoice->timesheet->project->name ?? 'N/A' }}
                                    </td>
                                @endif

                                <td class="p-2 sm:p-3 text-center">
                                    @if (is_null($invoice->payment_date))
                                        @if (auth()->user()->role == 'admin')
                                            <form action="{{ route('invoice.markAsPaid', $invoice->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="px-3 py-1 rounded-xl bg-green-100 hover:bg-green-200 text-green-700 text-xs sm:text-sm transition-all">
                                                    Mark as Paid
                                                </button>
                                            </form>
                                        @else
                                            <span class="px-3 py-1 rounded-xl bg-red-100 text-red-600 text-xs sm:text-sm">
                                                Unpaid
                                            </span>
                                        @endif
                                    @else
                                        <span class="px-3 py-1 rounded-xl bg-gray-200 text-gray-600 text-xs sm:text-sm">
                                            Paid
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 flex justify-end">
                <div class="bg-transparent dark:bg-gray-800 rounded-lg px-3 py-0">
                    {{ $invoices->links() }}
                </div>
            </div>

        </div>

    </div>

    @if (session('success'))
        <div id="invoiceSuccessPopup" class="success-popup">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const popup = document.getElementById('invoiceSuccessPopup');
                if (popup) {
                    popup.style.opacity = '0';
                    popup.style.transform = 'translateX(-50%) translateY(-20px)'; // slide up a little
                    setTimeout(() => popup.remove(), 500);
                }
            }, 3000); // fade+slide after 3 seconds
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('.filter-checkbox').on('change', function() {
                filterInvoices();
            });

            function filterInvoices() {
                let timesheets = [];
                $('input[name="timesheets[]"]:checked').each(function() {
                    timesheets.push($(this).val());
                });

                let clients = [];
                $('input[name="clients[]"]:checked').each(function() {
                    clients.push($(this).val());
                });

                let projects = [];
                $('input[name="projects[]"]:checked').each(function() {
                    projects.push($(this).val());
                });

                let statuses = [];
                $('input[name="statuses[]"]:checked').each(function() {
                    statuses.push($(this).val());
                });

                $.ajax({
                    url: "{{ route('invoice.index') }}",
                    method: "GET",
                    data: {
                        _token: "{{ csrf_token() }}",
                        timesheets: timesheets,
                        clients: clients,
                        projects: projects,
                        statuses: statuses,
                    },
                    success: function(response) {
                        var tempDiv = $('<div>').html(response.html);
                        var newTbody = tempDiv.find('#invoice-table-body').html();
                        $('#invoice-table-body').html(newTbody);
                    }
                });
            }

        });
    </script>
@endsection
