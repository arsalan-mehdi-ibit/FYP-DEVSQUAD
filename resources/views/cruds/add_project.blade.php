@extends('layouts.app')

@section('content')
    <div id="add_user" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">

        <a href="{{ route('project.index') }}" class="text-gray-500 hover:text-black flex items-center mb-3">
            <i class="bi bi-arrow-left"></i> <span class="ml-2">Back</span>
        </a>

        <h2 class="text-2xl font-bold text-gray-800">Add New Project</h2>

        <!-- Form Card -->
        <div class="bg-white shadow-xl rounded-xl p-2 mt-4">
            <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="accordion" id="ProjectAccordion">

                    <!-- Basic Details -->
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
                                        <input type="text" style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'"
                                            class="w-full px-2 py-1 text-sm border rounded-md " required>
                                    </div>
                                    <!-- Type -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Type*</label>
                                        <select class="w-full px-2 py-1 text-sm border rounded-md "
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'" required>
                                            <option>Select Type</option>
                                            <option>Fixed</option>
                                            <option>Time and Material</option>
                                        </select>
                                    </div>

                                    <!-- Client -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Client*</label>
                                        <select class="w-full px-2 py-1 text-sm border rounded-md "
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'" required>
                                            <option>Select Client</option>
                                            <option>Bass and Butler LLC</option>
                                            <option>Bugs</option>
                                            <option>c20</option>
                                            <option>c551</option>
                                        </select>
                                    </div>

                                    <!-- Consultant -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Consultant*</label>
                                        <select class="w-full px-2 py-1 text-sm border rounded-md overflow-auto max-h-40"
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'" required>
                                            <option>Select Consultant</option>
                                            <option>Amery Craft</option>
                                            <option>Amery Craft</option>
                                            <option>Amery Bird</option>
                                            <option>Bradley Mullen</option>
                                            <option>Brenda Marshall</option>
                                            <option>c35 contractor</option>
                                            <option>Caleb Mcconnell</option>
                                            <option>Caleb Webster</option>
                                            <option>Dahlia Justice</option>
                                            <option>Eden Dickson</option>
                                            <option>fname lname</option>
                                            <option>Gray Carter</option>
                                            <option>Hadley Watkins</option>
                                            <option>Harriet Terrell</option>
                                            <option>Jocelyn Sykes</option>
                                            <option>Jocelyn Peterson</option>
                                            <option>k k</option>
                                            <option>Kasimir Newton</option>
                                            <option>Latifah Guy</option>
                                        </select>
                                    </div>


                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Client Rate</label>
                                        <div class="flex relative">
                                            <select
                                                class="bg-gray-300 text-sm px-1 py-1 border border-gray-400 rounded-l-md focus:outline-none">
                                                <option>USD</option>
                                                <option>CAD</option>
                                            </select>
                                            <input type="text" style="background-color: #F3F4F6;"
                                                onfocus="this.style.backgroundColor='#FFFFFF'"
                                                onblur="this.style.backgroundColor='#F3F4F6'"
                                                class="w-full px-2 py-1 text-sm border border-gray-400 rounded-r-md">
                                        </div>
                                    </div>



                                    <!-- Status -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Status</label>
                                        <select class="w-full px-2 py-1 text-sm border rounded-md "
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'">
                                            <option>Select Status</option>
                                            <option>Not Started</option>
                                            <option>Active</option>
                                            <option>On hold</option>
                                            <option>Completed</option>
                                        </select>
                                    </div>

                                    <!-- Start Date -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Start Date</label>
                                        <input type="date" class="w-full px-2 py-1 text-sm border rounded-md bg-white">
                                    </div>

                                    <!-- End Date -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">End Date</label>
                                        <input type="date" class="w-full px-2 py-1 text-sm border rounded-md bg-white">
                                    </div>

                                    <!-- Referral Source -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Referral Source
                                        </label>
                                        <select class="w-full px-2 py-1 text-sm border rounded-md overflow-auto max-h-40"
                                            style="background-color: #F3F4F6;"
                                            onfocus="this.style.backgroundColor='#FFFFFF'"
                                            onblur="this.style.backgroundColor='#F3F4F6'" required>
                                            <option>Select Source</option>
                                            <option>Amery Craft</option>
                                            <option>Amery Craft</option>
                                            <option>Amery Bird</option>
                                            <option>Bradley Mullen</option>
                                            <option>Brenda Marshall</option>
                                            <option>c35 contractor</option>
                                            <option>Caleb Mcconnell</option>
                                            <option>Caleb Webster</option>
                                            <option>Dahlia Justice</option>
                                            <option>Eden Dickson</option>
                                            <option>fname lname</option>
                                            <option>Gray Carter</option>
                                            <option>Hadley Watkins</option>
                                            <option>Harriet Terrell</option>
                                            <option>Jocelyn Sykes</option>
                                            <option>Jocelyn Peterson</option>
                                            <option>k k</option>
                                            <option>Kasimir Newton</option>
                                            <option>Latifah Guy</option>
                                        </select>
                                    </div>

                                    <!-- Notes -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Notes</label>
                                        <textarea class="w-full px-2 py-1 text-sm border rounded-md bg-white"></textarea>
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
                                            <!-- Uploaded files will be added here -->
                                        </tbody>
                                    </table>
                                </div>
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
                        Create Project
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
