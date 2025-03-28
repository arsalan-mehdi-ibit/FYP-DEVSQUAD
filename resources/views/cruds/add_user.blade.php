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
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

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
                                        <input type="text" name="firstname" value="{{ old('firstname') }}" required
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Middle Name</label>
                                        <input type="text" name="middlename" value="{{ old('middlename') }}"
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Last Name*</label>
                                        <input type="text" name="lastname" value="{{ old('lastname') }}" required
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Role*</label>
                                        <select name="role" required
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                            <option value="">Select Role</option>
                                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="Client" {{ old('role') == 'Client' ? 'selected' : '' }}>Client
                                            </option>
                                            <option value="Consultant" {{ old('role') == 'Consultant' ? 'selected' : '' }}>
                                                Consultant</option>
                                            <option value="Contractor" {{ old('role') == 'Contractor' ? 'selected' : '' }}>
                                                Contractor</option>
                                            <option value="Timesheet Admin"
                                                {{ old('role') == 'Timesheet Admin' ? 'selected' : '' }}>Timesheet Admin
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Address</label>
                                        <input type="text" name="address" value="{{ old('address') }}"
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Email*</label>
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Phone*</label>
                                        <input type="text" name="phone" value="{{ old('phone') }}" required
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white"
                                            placeholder="+X (XXX) XXX-XXXX">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Source</label>
                                        <input type="text" name="source" value="{{ old('source') }}"
                                            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
                                    </div>

                                    <div class="flex flex-col items-center space-y-1">
                                        <label class="text-black text-sm font-medium text-center">Active</label>
                                        <input type="checkbox" name="is_active" class="custom-checkbox" value="1"
                                            checked>
                                    </div>

                                    <div class="flex flex-col items-center">
                                        <label class="text-black font-medium text-center"
                                            style="font-size:11px !important;">
                                            Send Approval/Rejection Email
                                        </label>
                                        <input type="checkbox" name="send_emails" class="custom-checkbox" value="1"
                                            checked>
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
                                            <!-- Uploaded files will be added here dynamically -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Hidden inputs for file storage -->
                                <input type="hidden" name="file_for" value="user">
                                <input type="hidden" name="file_paths" id="file_paths">

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
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('components.file-upload-modal')
    <script>
        $(document).ready(function() {
            $('.basic_details').click();
        });
    </script>
@endsection
