@extends('layouts.app')

@section('content')
<style>
    .form-label {
        font-size: 0.875rem;
    }

    .form-control,
    .form-control[readonly],
    textarea.form-control {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
        height: auto;
    }

    h2.page-title {
        font-size: 1.25rem;
        margin-bottom: 0;
    }

    .accordion-button {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Responsive column to prevent sidebar overlap -->
        <div class="col-12 col-md-11 col-lg-10 col-xl-9 ms-auto px-4">

            <!-- Back Button and Heading -->
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center pt-4 mb-3 border-bottom">
                <a href="{{ route('project.index') }}" class="btn btn-secondary">
                    ← Back
                </a>
                <h2 class="page-title">View Project</h2>
            </div>

            <!-- Project Accordion -->
            <div class="accordion" id="ProjectAccordion">
                <!-- Basic Details Accordion -->
                <div class="accordion-item border-none rounded-lg mb-4">
                    <h2 class="accordion-header" id="headingOne">
                        <button
                            class="accordion-button text-black text-md font-semibold py-2 px-2 w-full flex justify-between items-center"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                            aria-controls="collapseOne">
                            <i class="bi bi-chevron-right transition-transform font-semibold duration-200 mr-2"></i>
                            Basic Details
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#ProjectAccordion">
                        <div class="accordion-body p-0">
                            <div class="bg-white rounded-lg shadow-sm p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Project Name</label>
                                        <input type="text" readonly class="form-control" value="{{ $project->name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Type</label>
                                        <input type="text" readonly class="form-control" value="{{ $project->type }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Client</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $project->client->firstname  }}  {{$project->client->lastname}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Consultant</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $project->consultant }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Client Rate</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $project->client_rate }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status</label>
                                        <input type="text" readonly class="form-control" value="{{ $project->status }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Start Date</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $project->start_date }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">End Date</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $project->end_date }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Referral Source</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $project->referral_source }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Notes</label>
                                        <textarea readonly class="form-control"
                                            rows="2">{{ $project->notes }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Contractor List (Read-Only) -->
                <div class="accordion-item border-none rounded-lg mb-3">
                    <h2 class="accordion-header" id="headingTwo">
                        <button
                            class="accordion-button text-black collapsed text-sm font-semibold py-2 px-3 w-full flex justify-between items-center"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                            aria-controls="collapseTwo">
                            <i class="bi bi-chevron-right transition-transform font-semibold duration-200 mr-2"></i>
                            Contractor List
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#ProjectAccordion">
                        <div class="accordion-body p-0">
                            <div class="bg-white rounded-lg shadow-sm p-3">
                                <table class="table table-sm table-bordered text-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="p-2 text-black">Sr</th>
                                            <th class="p-2 text-black">Contractor Name</th>
                                            <th class="p-2 text-black">Contractor's Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($projectContractors as $index => $contractor)
                                        <tr class="text-black">
                                            <td class="p-2">{{ $index + 1 }}</td>
                                            <td class="p-2">{{ $contractor['firstname'] }} {{ $contractor['lastname'] }}
                                            </td>
                                            <td class="p-2">${{ number_format($contractor['contractor_rate'], 2) }}</td>
                                        </tr>
                                        @endforeach
                                        @if(count($projectContractors) === 0)
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No contractors assigned.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-none rounded-lg mb-4">
                    <h2 class="accordion-header" id="headingThree">
                        <button
                            class="accordion-button text-black collapsed text-md font-semibold py-2 px-2 w-full flex justify-between items-center"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                            <i class="bi bi-chevron-right transition-transform font-semibold duration-200 mr-2"></i>
                            File Attachments
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#ProjectAccordion">
                        <div class="accordion-body p-0">
                            <div class="bg-white rounded-lg shadow-sm p-0">
                                <table class="w-full border-none rounded-lg">
                                    <thead class="bg-gray-100 text-gray-600 text-sm">
                                        <tr>
                                            <th class="p-2 text-left">Sr</th>
                                            <th class="p-2 text-left">File</th>
                                            <th class="p-2 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="file-table-body">
                                        @if (isset($project) && $project->fileAttachments)
                                        @foreach ($project->fileAttachments as $file)
                                        <tr>
                                            <td class="p-2">{{ $loop->iteration }}</td>
                                            <td class="p-2">{{ Str::afterLast($file->file_path, '_') }}</td>
                                            <td class="p-2 text-right">
                                                <a href="{{ route('project.downloadFile', $file->id) }}"
                                                    class="bg-blue-500 text-white px-2 py-1 text-xs rounded"
                                                    title="Download File" target="_blank">
                                                    Download
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3" class="text-center p-2 text-gray-500">No files attached</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div> <!-- end col -->
    </div> <!-- end row -->
</div> <!-- end container -->
@endsection
<script>
    document.querySelectorAll('.accordion-button').forEach(button => {
        button.addEventListener('click', function () {
            const icon = this.querySelector('i.bi');
            const isCollapsed = this.classList.contains('collapsed');
            icon.classList.toggle('rotate-90', !isCollapsed);
        });
    });
</script>

<style>
    .rotate-90 {
        transform: rotate(90deg);
    }
</style>






<script>
    $(document).ready(function () {
        const csrfToken = @json(csrf_token());

        // Fetch and render existing tasks
        function loadTasksForTimesheetDetail(timesheetDetailId, taskBody) {
            $.ajax({
                url: `/timesheet/${timesheetDetailId}/tasks`,
                method: 'GET',
                success: function (response) {
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
                            timesheetDetailId);
                    }
                }
            });
        }

        function updateTotalActualHours(timesheetDetailId) {
            $.ajax({
                url: `/timesheet/${timesheetDetailId}/total-actual-hours`, // Create this route in backend
                method: 'GET',
                success: function (response) {
                    if (response.status === 'success') {
                        $(`[data-detail-id="${timesheetDetailId}"]`).find(".total-actual-hours")
                            .text(response.total_hours);
                    }
                }
            });
        }

        // Load all existing tasks on page load
        $(".task-body").each(function () {
            const taskBody = $(this);
            const timesheetDetailId = taskBody.closest(".nested-table").prev().data("detail-id");
            if (timesheetDetailId) {
                loadTasksForTimesheetDetail(timesheetDetailId, taskBody);
            }
        });

        // Add Task Button
        $(document).on("click", ".add-task", function () {
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
        $(document).on("click", ".save-task", function () {
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

            // Send AJAX request to save task
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
                success: function (response) {
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

                        // Calculate total actual hours after saving the task and update the timesheet
                        let totalActualHours = 0;
                        row.closest(".task-body").find("tr").each(function () {
                            totalActualHours += parseFloat($(this).find("td:nth-child(4)").text()) || 0;
                        });

                        // Update the actual hours for the timesheet in the UI (you might want to update this value on the backend as well)
                        const timesheetRow = $(`tr[data-detail-id="${timesheetDetailId}"]`);
                        timesheetRow.find("td:nth-child(3)").text(totalActualHours); // Assuming the actual hours are in the 3rd column
                    } else {
                        alert("Error saving task!");
                    }
                }
            });
        });

        // Edit Task
        $(document).on("click", ".edit-task", function () {
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
        $(document).on("click", ".remove-task", function () {
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
                success: function (response) {
                    if (response.status === 'success') {
                        // Remove the row from the frontend
                        row.remove();

                        // Reindex the remaining rows
                        taskBody.find("tr").each(function (index) {
                            $(this).find("td:first").text(index +
                                1); // Update the SR column
                        });

                        // Update the actual hours after task removal
                        let totalActualHours = 0;
                        taskBody.find("tr").each(function () {
                            totalActualHours += parseFloat($(this).find("td:nth-child(4)").text()) || 0;
                        });

                        // Update the actual hours for the timesheet in the UI (you might want to update this value on the backend as well)
                        const timesheetRow = $(`tr[data-detail-id="${taskBody.closest(".nested-table").prev().data("detail-id")}"]`);
                        timesheetRow.find("td:nth-child(3)").text(totalActualHours); // Assuming the actual hours are in the 3rd column
                    } else {
                        alert("Error deleting task!");
                    }
                },
                error: function () {
                    alert("An error occurred while deleting the task.");
                }
            });
        });

    });
</script>