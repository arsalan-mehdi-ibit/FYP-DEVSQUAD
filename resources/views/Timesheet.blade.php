@extends('layouts.app')

@section('content')
    <div id="invoice" class="max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white shadow-md rounded-2xl p-4 flex flex-col gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-people text-orange-500 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-600">All Customers</h3>
                </div>
                <div class="flex justify-between text-center items-center ">
                    <p class="text-xl font-bold text-gray-800 m-0">+22.63k</p>
                    <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-md">↑ 34.4%</span>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-4 flex flex-col gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-box-seam text-red-500 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-600">Orders</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-xl font-bold text-gray-800 m-0">+4.5k</p>
                    <span class="text-xs text-red-600 bg-red-100 px-2 py-1 rounded-md">↓ 8.1%</span>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-4 flex flex-col gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-headset text-orange-500 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-600">Services Request</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-xl font-bold text-gray-800 m-0">+1.03k</p>
                    <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-md">↑ 12.6%</span>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-4 flex flex-col gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-receipt text-orange-500 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-600">Invoice & Payment</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-xl font-bold text-gray-800 m-0">$38,908.00</p>
                    <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-md">↑ 45.9%</span>
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
                                TIMESHEET NAME</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                STATUS</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                TOTAL HOURS</th>
                            <th class="p-2 sm:p-3 font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                TOTAL OT HOURS</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                APPROVER</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                PROJECT</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                CONTRACTOR</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                CLIENT</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                ACTION</th>
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
                            <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                <button class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="text-black">Reject</span>
                                </button>
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="text-red-500">Approve</span>
                                </button>
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
                            <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                <button class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="text-black">Reject</span>
                                </button>
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="text-red-500">Approve</span>
                                </button>
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
                            <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                <button class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="text-black">Reject</span>
                                </button>
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="text-red-500">Approve</span>
                                </button>
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
                            <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                <button class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="text-black">Reject</span>
                                </button>
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="text-red-500">Approve</span>
                                </button>
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
                            <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                <button class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="text-black">Reject</span>
                                </button>
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="text-red-500">Approve</span>
                                </button>
                            </td>
                            
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">6</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Sep 01,2024-Sep 01,2024</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Approved</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">8</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test client</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test project</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">customer comp</td>
                            <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                <button class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="text-black">Reject</span>
                                </button>
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="text-red-500">Approve</span>
                                </button>
                            </td>
                            
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
