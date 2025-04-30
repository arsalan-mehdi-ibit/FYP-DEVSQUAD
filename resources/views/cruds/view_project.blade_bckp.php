@extends('layouts.app')

@section('content')
<style>
    .form-label {
        font-size: 0.875rem;
    }

    .form-control,
    .form-control[readonly],
    textarea.form-control {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
        height: auto;
    }

    h2.page-title {
        font-size: 1.25rem;
        margin-bottom: 0;
    }

    .accordion-button {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Responsive column to prevent sidebar overlap -->
        <div class="col-12 col-md-11 col-lg-10 col-xl-9 ms-auto px-4">

            <!-- Back Button and Heading -->
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center pt-4 mb-3 border-bottom">
                <a href="{{ route('project.index') }}" class="btn btn-secondary">
                    ← Back
                </a>
                <h2 class="page-title">View Project</h2>
            </div>

            <!-- Project Accordion -->
            <div class="accordion" id="ProjectAccordion">
                <!-- Basic Details Accordion -->
                <div class="accordion-item border-none rounded-lg mb-4">
                    <h2 class="accordion-header" id="headingOne">
                        <button
                            class="accordion-button text-black text-md font-semibold py-2 px-2 w-full flex justify-between items-center"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                            aria-controls="collapseOne">
                            <i class="bi bi-chevron-right transition-transform font-semibold duration-200 mr-2"></i>
                            Basic Details
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#ProjectAccordion">
                        <div class="accordion-body p-0">
                            <div class="bg-white rounded-lg shadow-sm p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Project Name</label>
                                        <input type="text" readonly class="form-control" value="{{ $project->name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Type</label>
                                        <input type="text" readonly class="form-control" value="{{ $project->type }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Client</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $project->client->firstname  }}  {{$project->client->lastname}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Consultant</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $project->consultant }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Client Rate</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $project->client_rate }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status</label>
                                        <input type="text" readonly class="form-control" value="{{ $project->status }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Start Date</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $project->start_date }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">End Date</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $project->end_date }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Referral Source</label>
                                        <input type="text" readonly class="form-control"
                                            value="{{ $project->referral_source }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Notes</label>
                                        <textarea readonly class="form-control"
                                            rows="2">{{ $project->notes }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Contractor List (Read-Only) -->
                <div class="accordion-item border-none rounded-lg mb-3">
                    <h2 class="accordion-header" id="headingTwo">
                        <button
                            class="accordion-button text-black collapsed text-sm font-semibold py-2 px-3 w-full flex justify-between items-center"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                            aria-controls="collapseTwo">
                            <i class="bi bi-chevron-right transition-transform font-semibold duration-200 mr-2"></i>
                            Contractor List
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#ProjectAccordion">
                        <div class="accordion-body p-0">
                            <div class="bg-white rounded-lg shadow-sm p-3">
                                <table class="table table-sm table-bordered text-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="p-2 text-black">Sr</th>
                                            <th class="p-2 text-black">Contractor Name</th>
                                            <th class="p-2 text-black">Contractor's Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($projectContractors as $index => $contractor)
                                        <tr class="text-black">
                                            <td class="p-2">{{ $index + 1 }}</td>
                                            <td class="p-2">{{ $contractor['firstname'] }} {{ $contractor['lastname'] }}
                                            </td>
                                            <td class="p-2">${{ number_format($contractor['contractor_rate'], 2) }}</td>
                                        </tr>
                                        @endforeach
                                        @if(count($projectContractors) === 0)
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No contractors assigned.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

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
                                            <td class="p-2">{{ Str::afterLast($file->file_path, '_') }}</td>
                                            <td class="p-2 text-right">
                                                <a href="{{ route('project.downloadFile', $file->id) }}"
                                                    class="bg-blue-500 text-white px-2 py-1 text-xs rounded"
                                                    title="Download File" target="_blank">
                                                    Download
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3" class="text-center p-2 text-gray-500">No files attached</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div> <!-- end col -->
    </div> <!-- end row -->
</div> <!-- end container -->
@endsection
<script>
    document.querySelectorAll('.accordion-button').forEach(button => {
        button.addEventListener('click', function () {
            const icon = this.querySelector('i.bi');
            const isCollapsed = this.classList.contains('collapsed');
            icon.classList.toggle('rotate-90', !isCollapsed);
        });
    });
</script>

<style>
    .rotate-90 {
        transform: rotate(90deg);
    }
</style>




public function approve(Request $request, $id)
{
    $timesheet = Timesheet::with(['details', 'contractor', 'project.client'])->findOrFail($id);

    if (!in_array(Auth::user()->role, ['admin', 'client'])) {
        abort(403, 'Unauthorized');
    }

    $timesheet->status = 'approved';
    $timesheet->save();

    // Dispatch the invoice creation job with all required relationships preloaded
    InvoiceJob::dispatch($timesheet);

    // Send email to contractor
    $contractor = $timesheet->contractor;
    $project = $timesheet->project;
    $client = $project->client;
    $approver = Auth::user();

    $emailData = [
        'contractor_name' => "{$contractor->firstname} {$contractor->lastname}",
        'approver_name' => "{$approver->firstname} {$approver->lastname}",
        'project_name' => $project->name,
        'status' => 'approved',
    ];

    Mail::to($contractor->email)->send(new EmailSender(
        "Timesheet Approved",
        $emailData,
        'emails.timesheet_status_email'
    ));

    // Define all users to notify (contractor, client, all admins)
    $usersToNotify = collect([$contractor, $client])
        ->merge(User::where('role', 'admin')->get())
        ->filter(); // removes null users like missing client

    foreach ($usersToNotify as $user) {
        $description = $user->id === $contractor->id
            ? 'Your timesheet for the project "' . $project->name . '" has been approved.'
            : 'A contractor\'s timesheet for the project "' . $project->name . '" has been approved.';

        RecentActivity::create([
            'title' => 'Timesheet Approved',
            'description' => $description,
            'parent_id' => $timesheet->id,
            'created_for' => 'timesheet',
            'user_id' => $user->id,
            'created_by' => $approver->id,
        ]);
    }

    return back()->with('success', 'Timesheet approved successfully.');
}
