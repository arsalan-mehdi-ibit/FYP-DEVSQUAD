@extends('layouts.app')

@section('content')
    <div class="main-layout max-w-full mx-auto bg-white p-3 p-sm-2 shadow-lg rounded-lg">
        <h3 class="text-xl font-bold mb-4">Timesheets</h3>

        <!-- Parent Table -->
        <div class="table-responsive">
            <table class="table table-striped text-center border border-gray-300 text-sm">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th>SR</th>
                        <th>Date</th>
                        <th>Actual Hours</th>
                        <th>OT Hours</th>
                        <th>Type</th>
                        <th>Billable</th>
                        <th>Memo</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row 1 -->
                    <tr class="accordion-toggle cursor-pointer bg-white border-b hover:bg-gray-200" data-target="#taskTable1"style="background-color:white !important">
                        <th class="relative px-2 ">
                            <div class="flex justify-between items-center w-full">
                                <i class="fas fa-chevron-right toggle-icon cursor-pointer"></i>
                                <span class="flex-1 text-center">1</span>
                            </div>
                        </th>
                        <td>2025-03-12</td>
                        <td>8</td>
                        <td>2</td>
                        <td>Regular</td>
                        <td>Yes</td>
                        <td>Worked on project updates</td>
                    </tr>
                    <tr class="nested-table hidden" id="taskTable1">
                        <td colspan="7">
                            <div class="p-2 border rounded  bg-gray-50">
                                <h4 class="text-sm ml-1 font-semibold mb-1 text-left">Task List for 3rd March 2025</h4>
                                <table class="table border border-gray-300 w-full m-1"> 
                                    <thead class="bg-gray-700 text-white ">
                                        <tr class="nested-table opacity-100" id="taskTable1">
                                            <th>SR</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Actual Hours</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="task-body"></tbody>
                                </table>
                                <div class="flex justify-end">
                                    <button class="add-task bg-blue-900 text-white px-3 py-1 rounded">Create Task</button>
                                </div>
                            </div>
                        </td>
                    </tr>

<<<<<<< HEAD
            <!-- Back Button -->
            <a href="{{ route('timesheet.index') }}" class="text-dark d-flex align-items-center mb-2">
                <i class="fas fa-arrow-left"></i> &nbsp; <span>Back</span>
            </a>

            <!-- Notes Section -->
            <div class="mt-3">
                <label for="notes" class="form-label fw-bold small-text">Notes</label>
                <textarea id="notes" class="form-control bg-light border-1 w-full small-text" rows="3"></textarea>
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
                        <!-- <table class="table table-striped text-center align-middle text-sm "> -->
                        <table class="table text-center align-middle text-sm">

                            <thead class="table-grey text-sm">
                                <tr>
                                    <th>SR</th>
                                    <th>Date</th>
                                    <th>Actual Hours</th>
                                    <th>OT Hours</th>
                                    <th>Type</th>
                                    <th>Billable</th>
                                    <th>Memo</th>
                                    <!-- <th>Actions</th> -->
                                    <!-- <th>Approve</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr >
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
                                    <!-- <td>
                                        <input type="checkbox" checked>
                                    </td> -->
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
                                    <!-- <td>
                                        <input type="checkbox">
                                    </td> -->
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
                                    <!-- <td>
                                        <input type="checkbox">
                                    </td> -->
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

    <!-- Responsive Styling -->
    <style>
        /* General Fixes */
        /* body {
            overflow-x: hidden;
        } */

        /* Sidebar Adjustments */
        /* @media (min-width: 1024px) {

            /* Adjust for Large Screens */
            /* .container-fluid {
                margin-left: 18rem; */
                /* 72px sidebar width */
            /* }
         */

        /* @media (max-width: 1023px) {

            /* Hide Sidebar on Small Screens */
            /* .container-fluid {
                margin-left: 0;
            } */
        /* } */

        /* Table Styling */
        /* .custom-table {
            min-width: 800px;
            font-size: 14px;
        } */

        /* @media (max-width: 992px) {
            .custom-table {
                font-size: 13px;
            }
        } */

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                white-space: nowrap;
            }

            th,
            td {
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
            min-width: 70px;
            /* Ensures buttons don't shrink */
            white-space: nowrap;
            /* Prevents text wrapping */
        }
       
/* Table header styling */
.table thead {
    background-color: #f8f9fa !important; /* Light grey header */
    color: #333 !important; /* Dark text for readability */
}

/* Ensure all rows have white background and grey text */
.table tbody tr {
    background-color: #ffffff !important; /* White background */
    color: #6c757d !important; /* Grey text color */
}

/* Hover effect: Light grey background */
.table tbody tr:hover {
    background-color: #f1f1f1 !important; /* Light grey on hover */
    transition: background-color 0.3s ease-in-out; /* Smooth transition */
}


     
    </style>
=======
                    <!-- Row 2 -->
                    <tr class="accordion-toggle cursor-pointer bg-white border-b hover:bg-gray-200" data-target="#taskTable2">
                        <th class="relative px-2">
                            <div class="flex justify-between items-center w-full">
                                <i class="fas fa-chevron-right toggle-icon cursor-pointer"></i>
                                <span class="flex-1 text-center">2</span>
                            </div>
                        </th>
                        <td>2025-03-13</td>
                        <td>7</td>
                        <td>1</td>
                        <td>Overtime</td>
                        <td>No</td>
                        <td>Reviewed and tested new features</td>
                    </tr>
                    <tr class="nested-table hidden" id="taskTable2">
                        <td colspan="7">
                            <div class="p-3 border rounded bg-gray-50">
                                <table class="table table-bordered w-full bg-white m-1">
                                    <thead class="bg-gray-700 text-white">
                                        <tr>
                                            <th>SR</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Actual Hours</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="task-body"></tbody>
                                </table>
                                <div class="flex justify-end">
                                    <button class="add-task bg-blue-900 text-white px-3 py-1 rounded">Create Task</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

   
>>>>>>> 81266faf039edc0950cfb2f4c6a92fdbc12130bf
@endsection
