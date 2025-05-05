@php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('content')
    <div id="add_user" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">

        <a href="{{ route('project.index') }}" class="text-gray-500 hover:text-black flex items-center mb-3">
            <i class="bi bi-arrow-left"></i> <span class="ml-2">Back</span>
        </a>

        <h2 class="text-2xl font-bold text-gray-800">{{ isset($project) ? 'Edit Project' : 'Add New Project' }}</h2>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                <strong>Whoops! Something went wrong.</strong>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white shadow-xl rounded-xl p-2 mt-4">
            <form action="{{ isset($project) ? route('project.update', $project->id) : route('project.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($project))
                    @method('PUT') <!-- This ensures the request method is PUT for updating -->
                @endif

                <div class="accordion" id="ProjectAccordion">

                    <!-- Project Details -->
                    <div class="accordion-item border-none rounded-lg mb-3">
                        <h2 class="accordion-header" id="headingOne">
                            <button
                                class="basic_details accordion-button text-black collapsed text-md font-semibold py-2 px-2 w-full flex justify-between items-center"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                <i class="bi bi-chevron-right transition-transform duration-200 mr-2"></i>
                                Basic Details
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#ProjectAccordion">
                            <div class="accordion-body p-5 sm:p-3 responsive-padding m-3 bg-white shadow-xl rounded-lg">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

                                    <!-- Project Name -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Project
                                            Name*</label>
                                        <input type="text" name="name" value="{{ old('name', $project->name ?? '') }}"
                                            required style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'"
                                            class="w-full px-2 py-1 text-sm border rounded-md ">
                                    </div>

                                    <!-- Type -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Type*</label>
                                        <select name="type" class="w-full px-2 py-1 text-sm border rounded-md "
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'" required>
                                            <option value="" disabled selected>Select Type</option>
                                            <!-- Default option -->
                                            @foreach (['fixed', 'time_and_material'] as $type)
                                                <option value="{{ $type }}"
                                                    @if (isset($project) && strtolower($project->type) == strtolower($type)) selected @endif>
                                                    {{ ucfirst(str_replace('_', ' ', $type)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Client -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Client*</label>
                                        <select name="client_id" required
                                            class="w-full px-2 py-1 text-sm border rounded-md "
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'">
                                            <option>Select Client</option>
                                            @foreach ($users->where('role', 'client') as $client)
                                                <option value="{{ $client->id }}"
                                                    @if (isset($project) && $project->client_id == $client->id) selected @endif>
                                                    {{ $client->firstname }} {{ $client->lastname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Consultant -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Consultant*</label>
                                        <select name="consultant_id" required
                                            class="w-full px-2 py-1 text-sm border rounded-md overflow-auto max-h-40"
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'">
                                            <option>Select Consultant</option>
                                            @foreach ($users->where('role', 'consultant') as $consultant)
                                                <option value="{{ $consultant->id }}"
                                                    @if (isset($project) && $project->consultant_id == $consultant->id) selected @endif>
                                                    {{ $consultant->firstname }} {{ $consultant->lastname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Client Rate --}}
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Client Rate</label>
                                        <div class="flex relative">
                                            <div
                                                class="bg-gray-300 text-sm px-1 py-0  border border-gray-400 rounded-l-md focus:outline-none">
                                                <p class="m-0 ">USD</p>

                                            </div>
                                            <input type="number" name="client_rate"
                                                value="{{ old('client_rate', $project->client_rate ?? '') }}"
                                                style="background-color: #F3F4F6;"
                                                onfocus="this.style.backgroundColor='#FFFFFF'"
                                                onblur="this.style.backgroundColor='#F3F4F6'"
                                                class="w-full px-2 py-1 text-sm border border-gray-400 rounded-r-md">
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Status</label>
                                        <select name="status" id="status"
                                            class="w-full px-2 py-1 text-sm border rounded-md"
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'" required>
                                            <option value="">Select Status</option>
                                            @if (isset($project))
                                                {{-- Edit form: show all statuses --}}
                                                @foreach (['pending', 'in_progress', 'completed', 'cancelled'] as $status)
                                                    <option value="{{ $status }}"
                                                        @if ($project->status == $status) selected @endif>
                                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                    </option>
                                                @endforeach
                                            @else
                                                {{-- Add form: only show pending and in_progress --}}
                                                <option value="pending" selected>Pending</option>
                                                <option value="in_progress" disabled>In Progress</option>
                                            @endif
                                        </select>
                                    </div>

                                    <!-- Start Date -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Start Date</label>

                                        @php
                                            $isInProgress = isset($project) && $project->status === 'in_progress';
                                            $startDateValue = old('start_date', $project->start_date ?? '');
                                        @endphp

                                        <input type="date" name="start_date" value="{{ $startDateValue }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            class="w-full px-2 py-1 text-sm border rounded-md
                  {{ $isInProgress ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
                                            @if ($isInProgress) disabled @endif>

                                        @if ($isInProgress)
                                            <!-- Hidden input to submit the start date even if disabled -->
                                            <input type="hidden" name="start_date" value="{{ $startDateValue }}">
                                        @endif
                                    </div>

                                    <!-- End Date -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">End Date</label>
                                        <input type="date" name="end_date"
                                            value="{{ old('end_date', $project->end_date ?? '') }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-white">
                                    </div>

                                    <!-- Referral Source -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Referral
                                            Source</label>
                                        <input type="text" name="referral_source"
                                            value="{{ old('referral_source', $project->referral_source ?? '') }}"
                                            class="w-full px-2 py-1 text-sm border rounded-md"
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'" required>
                                    </div>

                                    <!-- Notes -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Notes</label>
                                        <textarea name="notes" class="w-full px-2 py-1 text-sm border rounded-md bg-white">{{ old('notes', $project->notes ?? '') }}</textarea>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-b border-black my-2"></div>

                    <!-- Contractor List -->
                    <div class="accordion-item border-none rounded-lg mb-3">
                        <h2 class="accordion-header" id="headingTwo">
                            <div class="w-full flex justify-between items-center">
                                <button
                                    class="accordion-button text-black collapsed text-md font-semibold py-2 px-2 flex items-center"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    <i class="bi bi-chevron-right transition-transform duration-200 mr-2"></i>
                                    Contractor List
                                </button>
                                <button id="addContractorBtn" type="button"
                                    class="bg-indigo-800 text-white px-3 py-1 mr-2 text-xs rounded-full shadow-md hover:bg-indigo-700 hidden">
                                    +
                                </button>
                            </div>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#ProjectAccordion">
                            <div class="accordion-body p-0">
                                <div class="bg-white rounded-lg shadow-sm p-4 relative">
                                    <table class="w-full border-none rounded-lg">
                                        <thead class="bg-gray-100 text-gray-600 text-sm">
                                            <tr>
                                                <th class="p-2 text-left">Sr</th>
                                                <th class="p-2 text-left">Contractor Name</th>
                                                <th class="p-2 text-left">Contractor's Rate</th>
                                                <th class="p-2 text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contractor-table-body">
                                            <!-- Contractor rows will be dynamically added here -->
                                            @if (isset($projectContractors))
                                                @foreach ($projectContractors as $index => $contractor)
                                                    <tr class="border-b" id="contractor-row-{{ $index }}">
                                                        <td class="p-2 text-left">{{ $index + 1 }}</td>
                                                        <td class="p-2">
                                                            <select name="contractors[{{ $index }}][contractor_id]"
                                                                class="contractor-id w-56 px-2 py-1 border rounded-md bg-gray-100">
                                                                @foreach ($contractors as $contractorOption)
                                                                    @if (
                                                                        $contractorOption->id == $contractor['contractor_id'] ||
                                                                            !in_array($contractorOption->id, $projectContractors->pluck('contractor_id')->toArray()))
                                                                        <option value="{{ $contractorOption->id }}"
                                                                            {{ $contractorOption->id == $contractor['contractor_id'] ? 'selected' : '' }}>
                                                                            {{ $contractorOption->firstname }}
                                                                            {{ $contractorOption->lastname }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach

                                                            </select>
                                                        </td>
                                                        <td class="p-2 flex">
                                                            <div
                                                                class="bg-gray-300 text-sm px-1 py-0  border border-gray-400 rounded-l-md focus:outline-none">
                                                                <p class="m-0 ">USD</p>

                                                            </div>
                                                            <input type="number"
                                                                name="contractors[{{ $index }}][rate]"
                                                                value="{{ $contractor['contractor_rate'] }}"
                                                                class="contractor-rate w-40 px-2 py-1 text-sm border rounded-r-md bg-gray-100"
                                                                min="0">
                                                        </td>
                                                        <td class="p-2 text-right">
                                                            @php $isInProgress = $project->status === 'in_progress'; @endphp
                                                            <button type="button"
                                                                class="remove-contractor-btn text-md px-3 py-0 rounded
                                                                    {{ $isInProgress ? 'bg-gray-300 text-gray-600 cursor-not-allowed' : 'bg-red-500 text-white' }}"
                                                                data-contractor-id="{{ $contractor['contractor_id'] }}"
                                                                data-project-id="{{ $project->id }}"
                                                                @if ($isInProgress) disabled @endif>
                                                                X
                                                            </button>
                                                        </td>


                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-b border-black my-2"></div>

                    <!-- File Attachments -->
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
                                                        <td class="p-2">{{ Str::afterLast($file->file_path, '_') }}
                                                        </td>
                                                        <td class="p-2 text-right">
                                                            <button type="button"
                                                                class="delete-file-btn bg-red-500 text-white px-4 py-1 text-xs rounded"
                                                                data-file-id="{{ $file->id }}">
                                                                &times;
                                                            </button>
                                                            <a href="{{ route('project.downloadFile', $file->id) }}"
                                                                class="bg-blue-500 text-white px-2 py-1 text-xs rounded"
                                                                title="Download File" target="_blank">
                                                                download
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                <input type="hidden" name="file_for" value="project">

                                <div class="flex justify-end mt-4 mr-2">
                                    <button id="uploadBtn" type="button"
                                        class=" text-white px-4 py-2 text-sm rounded-full shadow-md hover:bg-indigo-700 bg-gradient-to-r from-yellow-400 to-red-400   hover:from-yellow-300 hover:to-red-300"
                                        data-bs-toggle="modal" data-bs-target="#uploadModal">
                                        File Upload
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="border-b border-black my-2"></div>

                <!-- Submit Button -->
                <div class="flex justify-end my-4 mx-1">
                    <button type="submit"
                        class="bg-gradient-to-r from-yellow-400 to-red-400 
                        hover:from-yellow-300 hover:to-red-300 text-white px-4 py-2 rounded-full text-sm font-medium   transition-all shadow-md">
                        {{ isset($project) ? 'Update Project' : 'Create Project' }}
                    </button>
                </div>
                @include('components.file-upload-modal')
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.basic_details').click();

            @if (isset($project))
                $('h2.text-2xl').text('Edit Project');
            @endif

            $('.delete-file-btn').on('click', function(event) {

                event.preventDefault();

                var fileId = $(this).data('file-id');

                if (confirm('Are you sure you want to delete this file?')) {
                    $.ajax({
                        url: '/project/delete-file/' + fileId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $(event.target).closest('tr').remove();
                                $('#file-table-body tr').each(function(index) {
                                    $(this).find('td:first').text(index + 1);
                                });
                            } else {
                                alert('Error: ' + (response.message ||
                                    'Unable to delete file'));
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Error occurred while deleting the file.');
                        }
                    });
                }
            });

            // add contractor details dynamically
            let contractorCount = {{ isset($projectContractors) ? count($projectContractors) : 0 }};

            // Function to update the status dropdown based on contractor count
            function updateStatusBasedOnContractors() {
                const contractorList = $("#contractor-table-body tr"); // Rows of contractor table
                const statusDropdown = $('#status'); // ID of your dropdown
                const inProgressOption = statusDropdown.find('option[value="in_progress"]');
                const pendingOption = statusDropdown.find('option[value="pending"]');

                if (contractorList.length === 0) {
                    // Disable "In Progress" option if no contractors
                    inProgressOption.prop('disabled', true);

                    // Set dropdown back to "Pending" if no contractors
                    statusDropdown.val("pending");
                } else {
                    // Enable "In Progress" option if at least 1 contractor
                    inProgressOption.prop('disabled', false);
                }
            }

            // Function to toggle the "In Progress" status based on contractor fields
            function toggleInProgressStatus() {
                let hasContractor = false;

                // Check all contractor input fields to see if any contractor is selected
                $('[name^="contractors"]').each(function() {
                    if ($(this).val().trim() !== '') {
                        hasContractor = true;
                        return false; // break out of loop early
                    }
                });

                // Enable or disable the "In Progress" option based on whether there are contractors
                $('option[value="In Progress"]').prop('disabled', !hasContractor);
            }

            // Add contractor to the table when button is clicked
            $("#addContractorBtn").click(function() {
                let rowIndex = $("#contractor-table-body tr").length + 1;
                contractorCount++; // Increment contractor count for uniqueness
                let selectedIds = [];
                $('.contractor-id').each(function() {
                    let val = $(this).val();
                    if (val) selectedIds.push(val);
                });

                let optionsHtml = '<option value="">Select Contractor</option>';
                @foreach ($contractors as $contractorOption)
                    if (!selectedIds.includes('{{ $contractorOption->id }}')) {
                        optionsHtml += `<option value="{{ $contractorOption->id }}">
            {{ $contractorOption->firstname }} {{ $contractorOption->lastname }}
        </option>`;
                    }
                @endforeach

                const newRow = `
<tr id="contractor-row-${contractorCount}" class="border-b">
    <td class="p-2 text-left">${rowIndex}</td>
    <td class="p-2">
       <select name="contractors[${contractorCount}][contractor_id]" class="contractor-id form-control w-56 px-2 py-1 border rounded-md bg-gray-100">
            ${optionsHtml}
       </select>
    </td>
    <td class="p-2 flex">
        <div
                                                class="bg-gray-300 text-sm px-1 py-0  border border-gray-400 rounded-l-md focus:outline-none">
                                                <p class="m-0 ">USD</p>

                                            </div>
        <input type="number" name="contractors[${contractorCount}][rate]" class="contractor-rate w-40 px-2 py-1 text-sm border rounded-r-md bg-gray-100" placeholder="Contractor Rate">
    </td>
    <td class="p-2 text-right">
        <button class="removeRow text-md bg-red-500 text-white px-3 py-0 rounded">X</button>
    </td>
</tr>`;


                $("#contractor-table-body").append(newRow);
                updateStatusBasedOnContractors(); // Update status dropdown after contractor is added
            });

            // Remove contractor row
            $(document).on("click", ".removeRow", function() {
                $(this).closest("tr").remove();

                // Re-index rows after removing
                $("#contractor-table-body tr").each(function(index) {
                    $(this).find("td:first").text(index + 1); // Reorder the contractor list
                });

                updateStatusBasedOnContractors(); // Update status dropdown after contractor is removed
            });

            // Add button only appears when accordion is open
            $("#collapseTwo").on('show.bs.collapse', function() {
                $("#addContractorBtn").removeClass("hidden");
            }).on('hide.bs.collapse', function() {
                $("#addContractorBtn").addClass("hidden");
            });

            // Remove contractor via Ajax
            $('.remove-contractor-btn').on('click', function(event) {
                event.preventDefault();

                var contractorId = $(this).data('contractor-id');
                var projectId = $(this).data(
                    'project-id'); // Assuming you have project ID as data attribute

                if (confirm('Are you sure you want to remove this contractor?')) {
                    $.ajax({
                        url: '/project/remove-contractor/' + contractorId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            project_id: projectId // Send the project ID with the request
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $(event.target).closest('tr').remove();
                                $('#contractor-table-body tr').each(function(index) {
                                    $(this).find('td:first').text(index +
                                        1); // Reorder the contractor list
                                });
                                updateStatusBasedOnContractors
                                    (); // Update status dropdown after contractor is removed
                            } else {
                                alert('Error: ' + (response.message ||
                                    'Unable to remove contractor'));
                            }
                        },
                        error: function(xhr, status, error) {
                            let message = 'Error occurred while removing the contractor.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            alert('Error: ' + message);
                        }
                    });
                }
            });

            // Initial call to set the status based on contractors when page loads
            updateStatusBasedOnContractors();

        });
    </script>
@endsection
