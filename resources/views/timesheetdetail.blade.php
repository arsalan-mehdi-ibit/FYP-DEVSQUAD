@extends('layouts.app')

@section('content')
<div class="container-fluid lg:ml-72 ml-0 transition-all duration-300">
    <div class="row">
        <div class="col-lg-10 col-md-12 px-3 px-md-4">

            <!-- Back Button -->
            <a href="{{ route('timesheet.index') }}" class="text-dark d-flex align-items-center mb-2">
                <i class="fas fa-arrow-left"></i> &nbsp; <span>Back</span>
            </a>

            <!-- Notes Section -->
            <div class="mt-3">
            <label for="notes" class="form-label fw-bold small-text">Notes</label>
            <textarea id="notes" class="form-control bg-light border-1 w-100 small-text" rows="3"></textarea>
            </div>

            <!-- Timesheets Title -->
            <h3 class="mt-4 fw-bold text-center text-md-start page-title">Timesheets</h3>

            <!-- Tabs -->
            <ul class="nav nav-tabs mt-3 flex-wrap">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#details">Timesheet Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#attachments">File Attachments</a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-3">
                <!-- Timesheet Details Tab -->
                <div class="tab-pane fade show active" id="details">
                    <div class="table-responsive"> 
                        <table class="table table-striped text-center align-middle custom-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>SR</th>
                                    <th>Date</th>
                                    <th>Actual Hours</th>
                                    <th>OT Hours</th>
                                    <th>Type</th>
                                    <th>Billable</th>
                                    <th>Memo</th>
                                    <!-- <th>Actions</th> -->
                                    <th>Approve</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>2025-03-12</td>
                                    <td>8</td>
                                    <td>2</td>
                                    <td>Regular</td>
                                    <td>Yes</td>
                                    <td>Worked on project updates</td>
                                    <!-- <td>
                                    <div class="d-flex gap-2 justify-content-center align-items-center">
        <button class="btn btn-sm btn-primary px-3">Edit</button>
        <button class="btn btn-sm btn-danger px-3">Delete</button>
    </div>
                                    </td> -->
                                    <td>
                                        <input type="checkbox" checked>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>2025-03-11</td>
                                    <td>7</td>
                                    <td>1</td>
                                    <td>Regular</td>
                                    <td>No</td>
                                    <td>Client meeting</td>
                                    <!-- <td>
                                    <div class="d-flex gap-2 justify-content-center align-items-center">
        <button class="btn btn-sm btn-primary px-3">Edit</button>
        <button class="btn btn-sm btn-danger px-3">Delete</button>
    </div>
                                    </td> -->
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>2025-03-10</td>
                                    <td>6</td>
                                    <td>0</td>
                                    <td>Overtime</td>
                                    <td>Yes</td>
                                    <td>Bug fixes and testing</td>
                                    <!-- <td>
                                    <div class="d-flex gap-2 justify-content-center align-items-center">
        <button class="btn btn-sm btn-primary px-3">Edit</button>
        <button class="btn btn-sm btn-danger px-3">Delete</button>
    </div>
                                    </td> -->
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- End Table Wrapper -->
                </div>

                <!-- File Attachments Tab -->
                <div class="tab-pane fade" id="attachments">
                    <h5 class="text-center mt-3 small-text">No Attachments Available</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Responsive Styling -->
<style>
    /* General Fixes */
    body {
        overflow-x: hidden;
    }

    /* Sidebar Adjustments */
    @media (min-width: 1024px) { /* Adjust for Large Screens */
        .container-fluid {
            margin-left: 18rem; /* 72px sidebar width */
        }
    }

    @media (max-width: 1023px) { /* Hide Sidebar on Small Screens */
        .container-fluid {
            margin-left: 0;
        }
    }

    /* Table Styling */
    .custom-table {
        min-width: 800px;
        font-size: 14px;
    }

    @media (max-width: 992px) {
        .custom-table {
            font-size: 13px;
        }
    }

    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
            white-space: nowrap;
        }
        th, td {
            padding: 8px;
            font-size: 12px;
        }
    }

    /* Tabs Adjustments */
    @media (max-width: 576px) {
        .nav-tabs .nav-item {
            flex-grow: 1;
            text-align: center;
        }
    }

    /* Font Sizes Adjusted */
    .page-title {
        font-size: 22px;
    }

    .small-text {
        font-size: 14px;
    }
    td .btn {
    min-width: 70px; /* Ensures buttons don't shrink */
    white-space: nowrap; /* Prevents text wrapping */
}
</style>

@endsection
