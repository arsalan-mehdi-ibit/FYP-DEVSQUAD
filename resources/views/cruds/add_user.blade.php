@extends('layouts.app')

@section('content')
    <div id="add_user" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">

        <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-black flex items-center mb-3">
            <i class="bi bi-arrow-left"></i> <span class="ml-2">Back</span>
        </a>

        <h2 class="text-2xl font-bold text-gray-800">Add New User</h2>

        <!-- Form Card -->
        <div class="bg-white shadow-xl rounded-xl p-2 mt-4">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="accordion" id="userAccordion">
                    <!-- User Details -->
                    <div class="accordion-item border-none rounded-lg mb-3">
                        <h2 class="accordion-header" id="headingOne">
                            <button
                                class="accordion-button text-black collapsed text-md font-semibold py-2 px-2 w-full flex justify-between items-center"
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
                                        <input type="text" style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor:'#FFFFFF'"
                                            onblur="this.style.backgroundColor:'#F3F4F6'"
                                            class="w-full px-2 py-1 text-sm border rounded-md ">

                                    </div>

                                    <div>
                                        <label class="block text-black text-sm  text-center  font-medium">Middle
                                            Name</label>
                                        <input type="text" style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'"
                                            class="w-full px-2 py-1 text-sm border rounded-md ">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm  text-center  font-medium">Last Name*</label>
                                        <input type="text" style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'"
                                            class="w-full px-2 py-1 text-sm border rounded-md ">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Role*</label>
                                        <select class="w-full px-2 py-1 text-sm border rounded-md "
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'">
                                            <option>Select Role</option>
                                            <option>Admin</option>
                                            <option>Client</option>
                                            <option>Consultant</option>
                                            <option>Contractor</option>
                                            <option>Timesheet Admin</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Company*</label>
                                        <select class="w-full px-2 py-1 text-sm border rounded-md "
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'">
                                            <option>Select Company</option>
                                            <option>Gaines Levy Traders</option>
                                            <option>Partner Comp</option>
                                            <option>Pratt Hahn Trading</option>
                                            <option>sdfdaf</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm  text-center  font-medium">Country</label>
                                        <select class="w-full px-2 py-1 text-sm border rounded-md "
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'">
                                            <option>Select Country</option>
                                            <option>Canada</option>
                                            <option>US</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm  text-center  font-medium">City</label>
                                        <input type="text" style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'"
                                            class="w-full px-2 py-1 text-sm border rounded-md ">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm  text-center  font-medium">Address</label>
                                        <input type="text" style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'"
                                            class="w-full px-2 py-1 text-sm border rounded-md ">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm  text-center  font-medium">Email*</label>
                                        <input type="email" style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'"
                                            class="w-full px-2 py-1 text-sm border rounded-md ">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm  text-center  font-medium">Phone*</label>
                                        <input type="text" style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'"
                                            class="w-full px-2 py-1 text-sm border rounded-md "
                                            placeholder="+X (XXX) XXX-XXXX">
                                    </div>

                                    <div>
                                        <label class="block text-black text-sm  text-center  font-medium">Title</label>
                                        <input type="text" style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'"
                                            class="w-full px-2 py-1 text-sm border rounded-md ">
                                    </div>

                                    <div class="flex flex-col items-center space-y-1">
                                        <label class="text-indigo-900 text-sm font-medium text-center">Active</label>
                                        <input type="checkbox" class="custom-checkbox">
                                    </div>

                                    <!-- Send Approval/Rejection Email -->
                                    <div class="flex flex-col items-center ">
                                        <label
                                            class="text-indigo-900 font-medium text-center"style="font-size:11px !important;">Send
                                            Approval/Rejection Email</label>
                                        <input type="checkbox" class="custom-checkbox">
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
                                            <!-- Uploaded files will be added here -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex justify-end mt-4 mr-2">
                                    <button id="uploadBtn" type="button"
                                        class=" text-white px-4 py-2 text-sm rounded-full shadow-md hover:bg-indigo-700 bg-gradient-to-r from-yellow-400 to-red-400 
          hover:from-yellow-300 hover:to-red-300"
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
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- File Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-4">
                <h2 class="text-lg font-semibold mb-4">Upload File</h2>

                <label class="block text-gray-700 font-medium mb-2">File Name</label>
                <input type="text" id="fileNameInput"
                    class="w-full bg-gray-100 px-2 py-1 border rounded-md focus:ring focus:ring-blue-300 mb-2">
                <p id="file-name-error" class="text-red-500 text-sm hidden">Please enter File Name.</p>

                <!-- Uploaded Files Container -->
                <div id="uploaded-files" class="mb-2"></div>

                <!-- File Upload Box -->
                <input type="file" class="hidden" id="file-input" multiple>
                <div id="upload-box"
                    class="border-2 border-indigo-900 border-dashed rounded-lg p-5 flex flex-col items-center justify-center text-indigo-900 cursor-pointer hover:bg-gray-100">
                    <i class="bi bi-upload text-xl"></i>
                    <p class="mt-2 text-sm font-medium">Upload a file</p>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" class="bg-gray-400 text-white px-4 py-2 text-sm rounded-full shadow-md"
                        data-bs-dismiss="modal">Cancel</button>
                    <button id="submit-files"
                        class="bg-gradient-to-r from-yellow-400 to-red-400 
          hover:from-yellow-300 hover:to-red-300 text-white px-4 py-2 text-sm rounded-full shadow-md">Submit</button>
                </div>
            </div>
        </div>
    </div>

@endsection
