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
                                            required value="{{ old('project_name', $project->project_name ?? '') }}"
                                            style="background-color: #F3F4F6;"
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
                                            @foreach ($projectTypes as $type)
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
                                            @foreach ($clients as $client)
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
                                            @foreach ($consultants as $consultant)
                                                <option value="{{ $consultant->id }}"
                                                    @if (isset($project) && $project->consultant_id == $consultant->id) selected @endif>
                                                    {{ $consultant->firstname }} {{ $consultant->lastname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Client Rate</label>
                                        <div class="flex relative">
                                            <select name="currency"
                                                class="bg-gray-300 text-sm px-1 py-1 border border-gray-400 rounded-l-md focus:outline-none">
                                                <option>USD</option>
                                                <option>CAD</option>
                                            </select>
                                            <input type="text" name="client_rate"
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
                                        <select name="status" class="w-full px-2 py-1 text-sm border rounded-md"
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'" required>
                                            <option>Select Status</option>
                                            @foreach ($statusOptions as $status)
                                                <option value="{{ $status }}"
                                                    @if (isset($project) && $project->status == $status) selected @endif>
                                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                    <!-- Capitalize status and replace underscores with spaces -->
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <!-- Start Date -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Start Date</label>
                                        <input type="date" name="start_date"
                                            value="{{ old('start_date', $project->start_date ?? '') }}"
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-white">
                                    </div>

                                    <!-- End Date -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">End Date</label>
                                        <input type="date" name="end_date"
                                            value="{{ old('end_date', $project->end_date ?? '') }}"
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
                                        </tbody>
                                    </table>
                                    {{-- <!-- Add Button -->
                                    <div class="absolute top-0 right-0 mt-[-20px] mr-[-20px]">
                                        <button id="addContractorBtn" type="button"
                                            class="bg-indigo-800 text-white px-4 py-2 rounded-full shadow-md hover:bg-indigo-700">
                                            +
                                        </button>
                                    </div> --}}
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
        });
    </script>
@endsection
