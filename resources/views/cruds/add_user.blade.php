@php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('content')
    <div id="add_user" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">

        <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-black flex items-center mb-3">
            <i class="bi bi-arrow-left"></i> <span class="ml-2">Back</span>
        </a>

        <h2 class="text-2xl font-bold text-gray-800">Add New User</h2>

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
            <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @if (isset($user))
                    @method('PUT') <!-- This ensures the request method is PUT for updating -->
                @endif

                <div class="accordion" id="userAccordion">
                    <!-- User Details -->
                    <div class="accordion-item border-none rounded-lg mb-3">
                        <h2 class="accordion-header" id="headingOne">
                            <button
                                class="basic_details accordion-button text-black collapsed text-md font-semibold py-2 px-2 w-full flex justify-between items-center"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                <i class="bi bi-chevron-right transition-transform duration-200 mr-2"></i>
                                User Details
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#userAccordion">
                            <div class="accordion-body p-5 sm:p-3 responsive-padding m-3 bg-white shadow-xl rounded-lg">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">First Name*</label>
                                        <input type="text" name="firstname"
                                            value="{{ old('firstname', $user->firstname ?? '') }}" required
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Middle Name</label>
                                        <input type="text" name="middlename"
                                            value="{{ old('middlename', $user->middlename ?? '') }}"
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Last Name*</label>
                                        <input type="text" name="lastname"
                                            value="{{ old('lastname', $user->lastname ?? '') }}" required
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>


                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Role*</label>
                                    
                                        @php
                                            $hasProject = isset($user) && $user->projects()->exists();
                                            $selectedRole = old('role', $user->role ?? '');
                                        @endphp
                                    
                                        <select name="role"
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white
                                                {{ $hasProject ? 'opacity-60 cursor-not-allowed' : '' }}"
                                            {{ $hasProject ? 'disabled' : '' }} required>
                                            <option value="">Select Role</option>
                                            @foreach (['admin', 'client', 'contractor', 'consultant'] as $role)
                                                <option value="{{ $role }}" {{ strtolower($selectedRole) === $role ? 'selected' : '' }}>
                                                    {{ ucfirst($role) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    
                                        @if ($hasProject)
                                            <!-- Hidden input to ensure the disabled role still gets submitted -->
                                            <input type="hidden" name="role" value="{{ $user->role }}">
                                            {{-- <p class="text-xs text-gray-500 mt-1 text-center">Role cannot be changed because this user is linked to a project.</p> --}}
                                        @endif
                                    </div>
                                    



                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Address</label>
                                        <input type="text" name="address"
                                            value="{{ old('address', $user->address ?? '') }}"
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Email*</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                                            required @if (isset($user)) readonly @endif
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Phone*</label>
                                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                                            required
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white"
                                            placeholder="+X (XXX) XXX-XXXX">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Source</label>
                                        <input type="text" name="source"
                                            value="{{ old('source', $user->source ?? '') }}"
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <!-- Hidden input to ensure unchecked value gets sent -->
                                    <div class="flex flex-col items-center space-y-1">
                                        <label class="text-black text-sm font-medium text-center">Active</label>
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" class="custom-checkbox" value="1"
                                            {{ old('is_active', $user->is_active ?? false) ? 'checked' : '' }}>
                                    </div>

                                    <div class="flex flex-col items-center">
                                        <label class="text-black font-medium text-center"
                                            style="font-size:11px !important;">
                                            Send Approval/Rejection Email
                                        </label>
                                        <input type="hidden" name="send_emails" value="0">
                                        <input type="checkbox" name="send_emails" class="custom-checkbox" value="1"
                                            {{ old('send_emails', $user->send_emails ?? false) ? 'checked' : '' }}>
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
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#userAccordion">
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
                                            @if (isset($user) && $user->fileAttachments)
                                                @foreach ($user->fileAttachments as $file)
                                                    <tr>
                                                        <td class="p-2">{{ $loop->iteration }}</td>
                                                        <td class="p-2">{{ Str::afterLast($file->file_path, '_') }}
                                                        </td>
                                                        <td class="p-2 text-right">
                                                            <!-- Delete button with data-id attribute -->
                                                            <button type="button"
                                                                class="delete-file-btn bg-red-500 text-white px-4 py-1 text-xs rounded"
                                                                data-file-id="{{ $file->id }}">
                                                                &times;
                                                            </button>
                                                            <!-- Download button -->
                                                            <a href="{{ route('users.downloadFile', $file->id) }}"
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

                                <!-- Hidden inputs for file storage -->
                                <input type="hidden" name="file_for" value="user">

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
                        {{ isset($user) ? 'Update User' : 'Create User' }}
                    </button>
                </div>
                @include('components.file-upload-modal')
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.basic_details').click();

            @if (isset($user))
                $('h2.text-2xl').text('Edit User');
            @endif

            function renumberTable() {
                $('#file-table-body tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
            }

            $('.delete-file-btn').on('click', function(event) {
                event.preventDefault(); // Prevent any default action

                var fileId = $(this).data('file-id'); // Get the file ID from the data attribute

                if (confirm('Are you sure you want to delete this file?')) {
                    $.ajax({
                        url: '/users/delete-file/' + fileId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Remove the file row
                                $('button[data-file-id="' + fileId + '"]').closest('tr')
                                    .remove();
                                // Re-number the table
                                renumberTable();
                            } else {
                                alert('Failed to delete file.');
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred while deleting the file.');
                        }
                    });
                }
            });



        });
    </script>
@endsection
