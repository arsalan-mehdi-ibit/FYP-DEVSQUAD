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
                            <div class="p-3 border rounded  bg-gray-50">
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

   
@endsection
