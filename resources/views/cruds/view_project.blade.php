@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
    <div id="add_user" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">

        <a href="{{ route('project.index') }}" class="text-gray-500 hover:text-black flex items-center mb-3">
            <i class="bi bi-arrow-left"></i> <span class="ml-2">Back</span>
        </a>

        <h2 class="text-2xl font-bold text-gray-800">VIEW PROJECT</h2>

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




                    @if(Auth::user()->role=='admin' || Auth::user()->role == 'consultant')
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
                                            Name</label>
                                            <p class = 'text-center' >{{$project->name}}</p>
                                    </div>

                                    <!-- Type -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Type*</label>
                                        <p class = 'text-center' >{{$project->type}}</p>
                                      
                                    </div>

                                    <!-- Client -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Client</label>
                                        <p  class = 'text-center' >{{$project->client->firstname}} {{ $project->client->lastname}}</p>
                                    </div>

                                    <!-- Consultant -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Consultant</label>
                                        @if(isset($project->consultant))
                                        <p class = 'text-center' >{{$project->consultant->firstname}} {{ $project->consultant->lastname}}</p>
                                        @endif
                                    </div>


                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Client Rate</label>
                                        <div class=" relative">
                                           
                                        <p class = 'text-center' >{{$project->client_rate}}</p>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Status</label>
                                        <p class = 'text-center' >{{$project->status}}</p>
                                    </div>



                                    <!-- Start Date -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Start Date</label>
                                        <p class = 'text-center' >{{$project->start_date}}</p>
                                    </div>

                                    <!-- End Date -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">End Date</label>
                                        <p class = 'text-center' >{{$project->end_date}}</p>
                                    </div>

                                    <!-- Referral Source -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Referral
                                        <p class = 'text-center' >{{$project->referral_source}}</p>
                                    </div>

                                    <!-- Notes -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Notes</label>
                                        <textarea readonly name="notes" class="w-full px-2 py-1 text-sm border rounded-md bg-white">{{ old('notes', $project->notes ?? '') }}</textarea>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-b border-black my-2"></div>
                    @else



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
                                            Name</label>
                                            <p class = 'text-center' >{{$project->name}}</p>
                                    </div>

                                    <!-- Type -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Type*</label>
                                        <p class = 'text-center' >{{$project->type}}</p>
                                      
                                    </div>

                                 

                                    <!-- Status -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Status</label>
                                        <p class = 'text-center' >{{$project->status}}</p>
                                    </div>



                                    <!-- Start Date -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Start Date</label>
                                        <p class = 'text-center' >{{$project->start_date}}</p>
                                    </div>

                                    <!-- End Date -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">End Date</label>
                                        <p class = 'text-center' >{{$project->end_date}}</p>
                                    </div>

                                    <!-- Referral Source -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Referral
                                        <p class = 'text-center' >{{$project->referral_source}}</p>
                                    </div>

                                    <!-- Notes -->
                                    <div>
                                        <label class="block text-black text-sm text-center font-medium">Notes</label>
                                        <textarea readonly name="notes" class="w-full px-2 py-1 text-sm border rounded-md bg-white">{{ old('notes', $project->notes ?? '') }}</textarea>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-b border-black my-2"></div>




                    @endif



                    @if(Auth::user()->role == 'admin')
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
                                            </tr>
                                        </thead>
                                        <tbody id="contractor-table-body">
                                            <!-- Contractor rows will be dynamically added here -->
                                            @if (isset($projectContractors))
                                                @foreach ($projectContractors as $index => $contractor)
                                                    <tr class="border-b" id="contractor-row-{{ $index }}">
                                                        <td class="p-2 text-left">{{ $index + 1 }}</td>
                                                        <td class="p-2">{{ $contractor['firstname'] }} {{ $contractor['lastname'] }}</td>
                                                        <td class="p-2 flex">
                                                                {{ $contractor['contractor_rate'] }}
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
                    @endif

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

                            </div>
                        </div>
                    </div>

                </div>
                <div class="border-b border-black my-2"></div>

                <!-- Submit Button -->
               
                @include('components.file-upload-modal')
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.basic_details').click();
        });
    </script>
@endsection
