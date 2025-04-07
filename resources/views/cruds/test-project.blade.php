{{-- @php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('content')
    <div id="add_project" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">

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
            <form action="{{ isset($project) ? route('project.update', $project->id) : route('project.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @if (isset($project))
                    @method('PUT') <!-- This ensures the request method is PUT for updating -->
                @endif

                <div class="accordion" id="projectAccordion">
                    <!-- Project Details -->
                    <div class="accordion-item border-none rounded-lg mb-3">
                        <h2 class="accordion-header" id="headingOne">
                            <button
                                class="basic_details accordion-button text-black collapsed text-md font-semibold py-2 px-2 w-full flex justify-between items-center"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                <i class="bi bi-chevron-right transition-transform duration-200 mr-2"></i>
                                Project Details
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#projectAccordion">
                            <div class="accordion-body p-5 sm:p-3 responsive-padding m-3 bg-white shadow-xl rounded-lg">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Project Name*</label>
                                        <input type="text" name="project_name"
                                            value="{{ old('project_name', $project->project_name ?? '') }}" required
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Client*</label>
                                        <select name="client_id" required
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                            <option value="">Select Client</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}" 
                                                    @if (isset($project) && $project->client_id == $client->id) selected @endif>
                                                    {{ $client->firstname }} {{ $client->lastname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Consultant*</label>
                                        <select name="consultant_id" required
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                            <option value="">Select Consultant</option>
                                            @foreach ($consultants as $consultant)
                                                <option value="{{ $consultant->id }}" 
                                                    @if (isset($project) && $project->consultant_id == $consultant->id) selected @endif>
                                                    {{ $consultant->firstname }} {{ $consultant->lastname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Project Description</label>
                                        <textarea name="description" rows="4"
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">{{ old('description', $project->description ?? '') }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Start Date*</label>
                                        <input type="date" name="start_date" value="{{ old('start_date', $project->start_date ?? '') }}"
                                            required class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">End Date</label>
                                        <input type="date" name="end_date" value="{{ old('end_date', $project->end_date ?? '') }}"
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div class="flex flex-col items-center space-y-1">
                                        <label class="text-black text-sm font-medium text-center">Active</label>
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" class="custom-checkbox" value="1"
                                            {{ old('is_active', $project->is_active ?? false) ? 'checked' : '' }}>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File Attachments -->
                    <div class="accordion-item border-none rounded-lg mb-4">
                        <h2 class="accordion-header" id="headingTwo">
                            <button
                                class="accordion-button text-black collapsed text-md font-semibold py-2 px-2 w-full flex justify-between items-center"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                <i class="bi bi-chevron-right transition-transform font-semibold duration-200 mr-2"></i>
                                File Attachments
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#projectAccordion">
                            <div class="accordion-body p-0">
                                <div class="bg-white rounded-lg shadow-sm p-4 mt-4">
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
                                                            <button type="button"
                                                                class="delete-file-btn bg-red-500 text-white px-4 py-1 text-xs rounded"
                                                                data-file-id="{{ $file->id }}">
                                                                &times;
                                                            </button>
                                                            <a href="{{ route('projects.downloadFile', $file->id) }}"
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

                                <!-- Upload Button -->
                                <div class="flex justify-end mt-4 mr-2">
                                    <button id="uploadBtn" type="button"
                                        class="text-white px-4 py-2 text-sm rounded-full shadow-md bg-gradient-to-r from-yellow-400 to-red-400 hover:from-yellow-300 hover:to-red-300"
                                        data-bs-toggle="modal" data-bs-target="#uploadModal">
                                        File Upload
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="flex justify-end my-4 mx-1">
                    <button type="submit"
                        class="bg-gradient-to-r from-yellow-400 to-red-400 hover:from-yellow-300 hover:to-red-300 text-white px-4 py-2 rounded-full text-sm font-medium shadow-md">
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
                        url: '/projects/delete-file/' + fileId,
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
                                alert('Error: ' + (response.message || 'Unable to delete file'));
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
@endsection --}}
