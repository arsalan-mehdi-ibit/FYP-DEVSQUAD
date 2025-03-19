@extends('layouts.app')

@section('content')
    <div id="timesheet" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
            <div class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-2">
                    <div class="p-3 sm:p-3 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="bi bi-filter text-blue-500"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">This Month's</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">+22.63k</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑ 34.4%</span>
                </div>
            </div>
        
            <div class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-3 sm:p-3 rounded-xl bg-green-100 flex items-center justify-center">
                        <i class="bi bi-check-circle text-green-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">APPROVED</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">+4.5k</p>
                    <span class="text-xs sm:text-sm text-red-600 bg-red-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↓ 8.1%</span>
                </div>
            </div>
        
            <div class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-3 sm:p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-x-circle text-red-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">REJECTED</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">+1.03k</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑ 12.6%</span>
                </div>
            </div>
        
            <div class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-3 sm:p-3 rounded-xl bg-yellow-100 flex items-center justify-center">
                        <i class="bi bi-receipt text-yellow-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">PENDING APPROVAL</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">$38,908.00</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑ 45.9%</span>
                </div>
            </div>
        </div>
        

        <div class="bg-white p-2 sm:p-5 rounded-lg shadow-md mt-4 sm:mt-6">
            <h2 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4">Timesheets</h2>

            <div class="max-h-[220px] overflow-y-auto overflow-x-auto relative border rounded-md" style="height: 320px">
                <table class="w-full min-w-full text-center">
                    <thead class="sticky top-0 bg-gray-100 z-10 text-center">
                        <tr class="border-b">
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                SR</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Timesheet Name</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Status</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Total Hours</th>
                            <th class="p-2 sm:p-3 font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Total OT Hours </th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Approver</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Project</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Contractor</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Client</th>
                                <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Detail</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">1</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Sep 01,2024-Sep 01,2024</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Approved</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">8</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test client</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test project</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">customer comp</td>
                            <td class="p-2 sm:p-3 text-center">
                                <button class="text-gray-600 hover:text-gray-900 transition-all">
                                    <!-- <i class="fas fa-eye"></i> -->
                                    <a href="{{ route('timesheet.details.index') }}" class="text-gray-600 hover:text-gray-900 transition-all">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </button>
                            </td>
                            <td class="p-2 sm:p-2 text-center">
                                <div class="inline-flex space-x-1">
                                    <button class="px-2 py-1 rounded-lg bg-green-200 hover:bg-green-100 transition-all text-xs">
                                        <span class="text-black">Approve</span>
                                    </button>
                                    <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                        <span class="text-black">Reject</span>
                                    </button>
                                </div>
                            </td>
                            
                            
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Sep 01,2024-Sep 01,2024</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Approved</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">8</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test client</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test project</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">customer comp</td>
                            <td class="p-2 sm:p-3 text-center">
                                <button class="text-gray-600 hover:text-gray-900 transition-all">
                                    <!-- <i class="fas fa-eye"></i> -->
                                    <a href="{{ route('timesheet.details.index') }}" class="text-gray-600 hover:text-gray-900 transition-all">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </button>
                            </td>
                            <td class="p-2 sm:p-2 text-center">
                                <div class="inline-flex space-x-1">
                                    <button class="px-2 py-1 rounded-lg bg-green-200 hover:bg-green-100 transition-all text-xs">
                                        <span class="text-black">Approve</span>
                                    </button>
                                    <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                        <span class="text-black">Reject</span>
                                    </button>
                                </div>
                            </td>
                            
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">3</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Sep 01,2024-Sep 01,2024</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Approved</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">8</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test client</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test project</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">customer comp</td>
                            <td class="p-2 sm:p-3 text-center">
                                <button class="text-gray-600 hover:text-gray-900 transition-all">
                                    <!-- <i class="fas fa-eye"></i> -->
                                    <a href="{{ route('timesheet.details.index') }}" class="text-gray-600 hover:text-gray-900 transition-all">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </button>
                            </td>
                            <td class="p-2 sm:p-2 text-center">
                                <div class="inline-flex space-x-1">
                                    <button class="px-2 py-1 rounded-lg bg-green-200 hover:bg-green-100 transition-all text-xs">
                                        <span class="text-black">Approve</span>
                                    </button>
                                    <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                        <span class="text-black">Reject</span>
                                    </button>
                                </div>
                            </td>
                            
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">4</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Sep 01,2024-Sep 01,2024</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Approved</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">8</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test client</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test project</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">customer comp</td>
                            <td class="p-2 sm:p-3 text-center">
                                <button class="text-gray-600 hover:text-gray-900 transition-all">
                                    <!-- <i class="fas fa-eye"></i> -->
                                    <a href="{{ route('timesheet.details.index') }}" class="text-gray-600 hover:text-gray-900 transition-all">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </button>
                            </td>
                            <td class="p-2 sm:p-2 text-center">
                                <div class="inline-flex space-x-1">
                                    <button class="px-2 py-1 rounded-lg bg-green-200 hover:bg-green-100 transition-all text-xs">
                                        <span class="text-black">Approve</span>
                                    </button>
                                    <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                        <span class="text-black">Reject</span>
                                    </button>
                                </div>
                            </td>
                            
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">5</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Sep 01,2024-Sep 01,2024</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Approved</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">8</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test client</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test project</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">customer comp</td>
                            <td class="p-2 sm:p-3 text-center">
                                <button class="text-gray-600 hover:text-gray-900 transition-all">
                                    <!-- <i class="fas fa-eye"></i> -->
                                    <a href="{{ route('timesheet.details.index') }}" class="text-gray-600 hover:text-gray-900 transition-all">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </button>
                            </td>
                            <td class="p-2 sm:p-2 text-center">
                                <div class="inline-flex space-x-1">
                                    <button class="px-2 py-1 rounded-lg bg-green-200 hover:bg-green-100 transition-all text-xs">
                                        <span class="text-black">Approve</span>
                                    </button>
                                    <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                        <span class="text-black">Reject</span>
                                    </button>
                                </div>
                            </td>
                            
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
