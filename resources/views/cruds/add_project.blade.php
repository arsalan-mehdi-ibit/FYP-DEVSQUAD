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
                @csrf  <!-- CSRF token for security -->

                <!-- Project Form Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <!-- Project Name -->
                    <div>
                        <label class="block text-black text-sm text-center font-medium">Project Name*</label>
                        <input type="text" name="project_name" class="w-full px-2 py-1 text-sm border rounded-md" required>
                    </div>
                    <!-- Type -->
                    <div>
                        <label class="block text-black text-sm text-center font-medium">Type*</label>
                        <select name="type" class="w-full px-2 py-1 text-sm border rounded-md" required>
                            <option>Select Type</option>
                            <option>Fixed</option>
                            <option>Time and Material</option>
                        </select>
                    </div>
                    <!-- Client -->
                  
                   <div>
    <label class="block text-black text-sm text-center font-medium">Client*</label>
    <select name="client_id" class="w-full px-2 py-1 text-sm border rounded-md" required>
    @dump($clients);
        <option value="">Select Client</option>
        
        @foreach($clients as $client)
      
        <option value="{{ $client->id }}">{{ $client->firstname }} {{ $client->middlename }} {{ $client->lastname }}</option>

        @endforeach
        
    </select>
</div>

                    <!-- Consultant -->
                    <div>
                        <label class="block text-black text-sm text-center font-medium">Consultant*</label>
                        <select name="consultant" class="w-full px-2 py-1 text-sm border rounded-md" required>
                            <option>Select Consultant</option>
                            <option>Amery Craft</option>
                            <option>Bradley Mullen</option>
                            <!-- Add more consultants here -->
                        </select>
                    </div>

                    <!-- Client Rate -->
                    <div>
                        <label class="block text-black text-sm text-center font-medium">Client Rate</label>
                        <div class="flex relative">
                            <select name="client_rate" class="bg-gray-300 text-sm px-1 py-1 border border-gray-400 rounded-l-md">
                                <option>USD</option>
                                <option>CAD</option>
                            </select>
                            <input type="text" name="client_rate_value" class="w-full px-2 py-1 text-sm border border-gray-400 rounded-r-md">
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-black text-sm text-center font-medium">Status</label>
                        <select name="status" class="w-full px-2 py-1 text-sm border rounded-md">
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
                        <input type="date" name="start_date" class="w-full px-2 py-1 text-sm border rounded-md">
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="block text-black text-sm text-center font-medium">End Date</label>
                        <input type="date" name="end_date" class="w-full px-2 py-1 text-sm border rounded-md">
                    </div>

                    <!-- Referral Source -->
                    <div>
                        <label class="block text-black text-sm text-center font-medium">Referral Source</label>
                        <select name="referral_source" class="w-full px-2 py-1 text-sm border rounded-md">
                            <option>Select Source</option>
                            <option>Amery Craft</option>
                            <option>Bradley Mullen</option>
                            <!-- Add more referral sources here -->
                        </select>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-black text-sm text-center font-medium">Notes</label>
                        <textarea name="notes" class="w-full px-2 py-1 text-sm border rounded-md"></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end my-4 mx-1">
                    <button type="submit" class="bg-gradient-to-r from-yellow-400 to-red-400 hover:from-yellow-300 hover:to-red-300 text-white px-4 py-2 rounded-full text-sm font-medium shadow-md">
                        Create Project
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
