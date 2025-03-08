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
            <h2 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4">Projects</h2>

            <div class="max-h-[220px] overflow-y-auto overflow-x-auto relative border rounded-md" style="height: 320px">
                <table class="w-full min-w-full text-center">
                    <thead class="sticky top-0 bg-gray-100 z-10 text-center">
                        <tr class="border-b">
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                PROJECT NAME</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                PROJECT SOURCE</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                CONTRACTOR</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                CLIENT</th>
                            <th class="p-2 sm:p-3 font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                CONTRACTOR RATE</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                CLIENT RATE</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                START DATE</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                EXPECTED END DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Timesheet</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">FYP</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">costomer comp</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$50</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$75</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-03-01</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-06-01</td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Timesheet</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">FYP</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">costomer comp</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$50</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$75</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-03-01</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-06-01</td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Timesheet</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">FYP</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">costomer comp</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$50</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$75</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-03-01</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-06-01</td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Timesheet</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">FYP</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">costomer comp</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$50</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$75</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-03-01</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-06-01</td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Timesheet</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">FYP</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">costomer comp</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$50</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$75</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-03-01</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-06-01</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Timesheet</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">FYP</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">costomer comp</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$50</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$75</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-03-01</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-06-01</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
