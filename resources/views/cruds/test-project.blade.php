{{-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
    <!-- Project Name -->
    <div>
        <label class="block text-black text-sm text-center font-medium">Project Name*</label>
        <input type="text" name="name" value="{{ old('name', $project->name ?? '') }}" required
            class="w-full px-2 py-1 text-sm border rounded-md bg-gray-200 focus:bg-white">
    </div>

    <!-- Type -->
    <div>
        <label class="block text-black text-sm text-center font-medium">Type*</label>
        <select name="type" class="w-full px-2 py-1 text-sm border rounded-md" required>
            <option value="" disabled selected>Select Type</option>
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
        <select name="client_id" required class="w-full px-2 py-1 text-sm border rounded-md">
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
        <select name="consultant_id" required class="w-full px-2 py-1 text-sm border rounded-md">
            <option>Select Consultant</option>
            @foreach ($users->where('role', 'consultant') as $consultant)
                <option value="{{ $consultant->id }}"
                    @if (isset($project) && $project->consultant_id == $consultant->id) selected @endif>
                    {{ $consultant->firstname }} {{ $consultant->lastname }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Client Rate -->
    <div>
        <label class="block text-black text-sm text-center font-medium">Client Rate</label>
        <div class="flex relative">
            <select name="currency" class="bg-gray-300 text-sm px-1 py-1 border border-gray-400 rounded-l-md focus:outline-none">
                <option>USD</option>
                <option>CAD</option>
            </select>
            <input type="number" name="client_rate" value="{{ old('client_rate', $project->client_rate ?? '') }}"
                class="w-full px-2 py-1 text-sm border border-gray-400 rounded-r-md">
        </div>
    </div>

    <!-- Status -->
    <div>
        <label class="block text-black text-sm text-center font-medium">Status</label>
        <select name="status" class="w-full px-2 py-1 text-sm border rounded-md" required>
            <option value="">Select Status</option>
            @foreach (['pending', 'in_progress', 'completed', 'cancelled'] as $status)
                <option value="{{ $status }}"
                    @if (isset($project) && $project->status == $status) selected @endif>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Start Date -->
    <div>
        <label class="block text-black text-sm text-center font-medium">Start Date</label>
        <input type="date" name="start_date" value="{{ old('start_date', $project->start_date ?? '') }}"
            class="w-full px-2 py-1 text-sm border rounded-md bg-white">
    </div>

    <!-- End Date -->
    <div>
        <label class="block text-black text-sm text-center font-medium">End Date</label>
        <input type="date" name="end_date" value="{{ old('end_date', $project->end_date ?? '') }}"
            class="w-full px-2 py-1 text-sm border rounded-md bg-white">
    </div>

    <!-- Referral Source -->
    <div>
        <label class="block text-black text-sm text-center font-medium">Referral Source</label>
        <input type="text" name="referral_source" value="{{ old('referral_source', $project->referral_source ?? '') }}"
            class="w-full px-2 py-1 text-sm border rounded-md" required>
    </div>

    <!-- Notes -->
    <div>
        <label class="block text-black text-sm text-center font-medium">Notes</label>
        <textarea name="notes" class="w-full px-2 py-1 text-sm border rounded-md bg-white">{{ old('notes', $project->notes ?? '') }}</textarea>
    </div>
</div> --}}
