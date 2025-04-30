@extends('layouts.app')

@section('content')
    <div class="main-layout max-w-full mx-auto bg-white p-3 p-sm-2 shadow-lg rounded-lg">
        <h3 class="text-xl font-bold mb-4">Timesheets</h3>

        {{-- Debugging step --}}
        {{-- {{ dd($timesheetDetails) }} --}}
        <!-- Parent Table -->
        @if ($timesheet->status == 'rejected' && $timesheet->rejection_reason)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Timesheet Rejected!</strong>
                <span class="block sm:inline">Reason: {{ $timesheet->rejection_reason }}</span>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped text-center border border-gray-300 text-sm">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th>SR</th>
                        <th>Date</th>
                        <th>Actual Hours</th>
                        {{-- <th>OT Hours</th> --}}
                        <th>Memo</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($timesheetDetails) && $timesheetDetails->isNotEmpty())
                        @foreach ($timesheetDetails as $index => $detail)
                            <tr class="accordion-toggle cursor-pointer bg-white border-b hover:bg-gray-200"
                                data-target="#taskTable{{ $index + 1 }}" data-detail-id="{{ $detail->id }}">
                                <th class="relative px-2">
                                    <div class="flex justify-between items-center w-full">
                                        <i class="fas fa-chevron-right toggle-icon cursor-pointer"></i>
                                        <span class="flex-1 text-center">{{ $index + 1 }}</span>
                                    </div>
                                </th>
                                <td>{{ \Carbon\Carbon::parse($detail->date)->format('Y-m-d') }}</td>
                                <td data-detail-id="{{ $detail->id }}">
                                    {{ $detail->actual_hours ?? 0 }}
                                    <span class="total-actual-hours"
                                        style="display: none;">{{ $detail->actual_hours ?? 0 }}</span>
                                </td>

                                {{-- <td>{{ $detail->ot_hours ?? 0 }}</td> --}}
                                <td>{{ $detail->memo ?? '-' }}</td>
                            </tr>
                            <tr class="nested-table hidden" id="taskTable{{ $index + 1 }}">
                                <td colspan="7">
                                    <div class="p-3 border rounded bg-gray-50">
                                        <h4 class="text-sm ml-1 font-semibold mb-1 text-left">
                                            Task List for {{ \Carbon\Carbon::parse($detail->date)->format('jS F Y') }}
                                        </h4>
                                        <table class="table table-bordered w-full bg-white m-1">
                                            <thead class="bg-gray-700 text-white">
                                                <tr>
                                                    <th>SR</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Actual Hours</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="task-body">
                                                {{-- Dynamically insert task rows here if available --}}
                                            </tbody>
                                        </table>
                                        <div class="flex justify-end">
                                            <button class="add-task bg-blue-900 text-white px-3 py-1 rounded">Create
                                                Task</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <p>No timesheet details available.</p>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const csrfToken = @json(csrf_token());

            // Fetch and render existing tasks
            function loadTasksForTimesheetDetail(timesheetDetailId, taskBody) {
                $.ajax({
                    url: `/timesheet/${timesheetDetailId}/tasks`,
                    method: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            taskBody.empty();
                            response.data.forEach((task, index) => {
                                const row = `
                                <tr data-task-id="${task.id}">
                                    <td>${index + 1}</td>
                                    <td>${task.title}</td>
                                    <td>${task.description ?? ''}</td>
                                    <td>${task.actual_hours}</td>
                                    <td class="text-center">
                                        <button class="edit-task px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                            <span class="bi bi-pencil text-black"></span>
                                        </button>
                                        <button class="remove-task px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                            <span class="bi bi-trash text-red-500"></span>
                                        </button>
                                    </td>
                                </tr>`;
                                taskBody.append(row);
                            });
                            updateTotalActualHours(
                                timesheetDetailId); // Update total hours after loading tasks
                        }
                    }
                });
            }

            function updateTotalActualHours(timesheetDetailId) {
                $.ajax({
                    url: `/timesheet/${timesheetDetailId}/total-actual-hours`, // Create this route in backend
                    method: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            $(`[data-detail-id="${timesheetDetailId}"]`).find(".total-actual-hours")
                                .text(response.total_hours);
                        }
                    }
                });
            }

            // function updateGrandTotal(timesheetId) {
            //     $.ajax({
            //         url: `/timesheet/${timesheetId}/total-hours`,
            //         method: 'GET',
            //         success: function(response) {
            //             if (response.status === 'success') {
            //                 $(`#grand-total-hours-${timesheetId}`).text(response.total_hours);
            //             }
            //         }
            //     });
            // }

            // Load all existing tasks on page load
            $(".task-body").each(function() {
                const taskBody = $(this);
                const timesheetDetailId = taskBody.closest(".nested-table").prev().data("detail-id");
                if (timesheetDetailId) {
                    loadTasksForTimesheetDetail(timesheetDetailId, taskBody);
                }
            });

            // Add Task Button
            $(document).on("click", ".add-task", function() {
                const taskBody = $(this).closest(".p-3").find(".task-body");
                const nextSr = taskBody.find("tr").length + 1;
                const newRow = `
                <tr>
                    <td>${nextSr}</td>
                    <td><input type="text" class="form-control p-1 task-title" placeholder="Title"></td>
                    <td><input type="text" class="form-control p-1 task-desc" placeholder="Task description"></td>
                    <td><input type="number" class="form-control p-1 task-hours" placeholder="Hours"></td>
                    <td class="text-center">
                        <button class="save-task bg-blue-900 text-white px-3 py-1 rounded-full">Save</button>
                        <button class="remove-task px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                            <span class="bi bi-trash text-red-500"></span>
                        </button>
                    </td>
                </tr>`;
                taskBody.append(newRow);
            });

            // Save Task (Create or Update)
            $(document).on("click", ".save-task", function() {
                let row = $(this).closest("tr");
                let title = row.find(".task-title").val();
                let desc = row.find(".task-desc").val();
                let hours = row.find(".task-hours").val();
                let timesheetDetailId = row.closest(".nested-table").prev().data("detail-id");

                // Get the task ID (if it's an existing task)
                let taskId = row.attr('data-task-id'); // Use attr() to get task ID

                // Make sure that the required fields are filled
                if (!title || !hours) {
                    alert("Title and Hours are required!");
                    return;
                }

                // Determine if it's an update or create
                let url = taskId ?
                    `/timesheet/${timesheetDetailId}/tasks/${taskId}` // Update the task (correct URL)
                    :
                    `{{ route('tasks.store', ['timesheetDetailId' => ':timesheetDetailId']) }}`.replace(
                        ':timesheetDetailId', timesheetDetailId); // Create a new task

                let method = taskId ? "PUT" : "POST"; // Use PUT for update, POST for create

                // Send AJAX request
                $.ajax({
                    url: url,
                    method: method,
                    data: {
                        _token: "{{ csrf_token() }}",
                        timesheet_detail_id: timesheetDetailId,
                        title: title,
                        description: desc,
                        actual_hours: hours,
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // On success, update the row with the task data
                            row.html(
                                `<td>${row.index() + 1}</td>
                            <td>${title}</td>
                            <td>${desc}</td>
                            <td>${hours}</td>
                            <td class="text-center">
                                <button class="edit-task px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="bi bi-pencil text-black"></span>
                                </button>
                                <button class="remove-task px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-trash text-red-500"></span>
                                </button>
                            </td>`
                            );

                            // Remove task ID after update to avoid conflicts
                            row.removeAttr('data-task-id');
                            let totalActualHours = 0;
                            row.closest(".task-body").find("tr").each(function() {
                                totalActualHours += parseFloat($(this).find(
                                    "td:nth-child(4)").text()) || 0;
                            });

                            // Update the actual hours for the timesheet in the UI (you might want to update this value on the backend as well)
                            const timesheetRow = $(`tr[data-detail-id="${timesheetDetailId}"]`);
                            timesheetRow.find("td:nth-child(3)").text(
                                totalActualHours

                            ); // Assuming the actual hours are in the 3rd column

                            // updateGrandTotal(timesheetRow.data("timesheet-id"));
                        } else {
                            alert("Error saving task!");
                        }
                    }
                });
            });

            // Edit Task
            $(document).on("click", ".edit-task", function() {
                let row = $(this).closest("tr");
                let title = row.find("td:nth-child(2)").text();
                let desc = row.find("td:nth-child(3)").text();
                let hours = row.find("td:nth-child(4)").text();
                let taskId = row.data("task-id"); // Preserve this

                // Clear the row and inject inputs (without replacing the row)
                row.html(`
                <td>${row.index() + 1}</td>
                <td><input type="text" class="form-control p-1 task-title" value="${title}"></td>
                <td><input type="text" class="form-control p-1 task-desc" value="${desc}"></td>
                <td><input type="number" class="form-control p-1 task-hours" value="${hours}"></td>
                <td class="text-center">
                    <button class="save-task bg-blue-900 text-white px-3 py-1 rounded-full">Save</button>
                    <button class="remove-task px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                        <span class="bi bi-trash text-red-500"></span>
                    </button>
                </td>
            `);

                // Reattach task ID to the modified row
                row.attr("data-task-id", taskId);

            });

            // Remove Task (from UI and backend)
            $(document).on("click", ".remove-task", function() {
                const row = $(this).closest("tr");
                const taskBody = row.closest(".task-body");

                // Get taskId to delete it from the backend
                let taskId = row.data('task-id');

                // Delete the task from the backend (AJAX request)
                $.ajax({
                    url: `/timesheet/${taskBody.closest(".nested-table").prev().data("detail-id")}/tasks/${taskId}`,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Remove the row from the frontend
                            row.remove();

                            // Reindex the remaining rows
                            taskBody.find("tr").each(function(index) {
                                $(this).find("td:first").text(index +
                                    1); // Update the SR column
                            });

                            // Update the actual hours after task removal
                            let totalActualHours = 0;
                            taskBody.find("tr").each(function() {
                                totalActualHours += parseFloat($(this).find(
                                    "td:nth-child(4)").text()) || 0;
                            });

                            // Update the actual hours for the timesheet in the UI (you might want to update this value on the backend as well)
                            const timesheetRow = $(
                                `tr[data-detail-id="${taskBody.closest(".nested-table").prev().data("detail-id")}"]`
                            );
                            timesheetRow.find("td:nth-child(3)").text(
                                totalActualHours
                            ); // Assuming the actual hours are in the 3rd column
                           
                            // updateGrandTotal(timesheetRow.data("timesheet-id"));
                        } else {
                            alert("Error deleting task!");
                        }
                    },
                    error: function() {
                        alert("An error occurred while deleting the task.");
                    }
                });
            });

            $('#timesheet-table-body tr').each(function() {
                const timesheetId = $(this).data('timesheet-id');
                updateGrandTotal(timesheetId);
            });

        });
    </script>
@endsection
