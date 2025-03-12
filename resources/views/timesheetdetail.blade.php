@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Back Button -->
    <a href="{{ route('timesheet.index') }}" class="text-dark d-flex align-items-center">
        <i class="fas fa-arrow-left"></i> &nbsp; Back
    </a>

    <!-- Notes Section -->
    <div class="mt-3">
        <label for="notes" class="form-label fw-bold">Notes</label>
        <textarea id="notes" class="form-control bg-light border-0" rows="3" readonly></textarea>
    </div>

    <!-- Timesheets Title -->
    <h2 class="mt-4 fw-bold">Timesheets</h2>

    <!-- Tabs -->
    <ul class="nav nav-tabs mt-3">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#details">TIMESHEET DETAILS</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#attachments">FILE ATTACHMENTS</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3">
        <!-- Timesheet Details Tab -->
        <div class="tab-pane fade show active" id="details">
            <div class="table-responsive"> <!-- Responsive Table Wrapper -->
                <table class="table table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>SR</th>
                            <th>DATE</th>
                            <th>ACTUAL HOURS</th>
                            <th>OT HOURS</th>
                            <th>TYPE</th>
                            <th>BILLABLE</th>
                            <th>MEMO</th>
                            <th>ACTIONS</th> <!-- Eye Icon Column -->
                            <th>APPROVE</th> <!-- Approve Button Column -->
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div> <!-- End Table Wrapper -->
        </div>

        <!-- File Attachments Tab -->
        <div class="tab-pane fade" id="attachments">
            <h4 class="text-center">No Attachments Available</h4>
        </div>
    </div>
</div>
@endsection
