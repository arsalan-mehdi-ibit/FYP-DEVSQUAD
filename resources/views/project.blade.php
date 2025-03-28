@extends('layouts.app')

@section('content')
    <div id="project" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-2">
                    <div class="p-3 sm:p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-people text-orange-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">Active Projects</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">+22.63k</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑
                        34.4%</span>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-3 sm:p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-box-seam text-red-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">Admins</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">+4.5k</p>
                    <span class="text-xs sm:text-sm text-red-600 bg-red-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↓
                        8.1%</span>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-3 sm:p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-headset text-orange-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">Clients</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">+1.03k</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑
                        12.6%</span>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="p-3 sm:p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-receipt text-orange-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">Contractors</h3>
                </div>
                <div class="flex justify-between text-center items-center">
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">$38,908.00</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑
                        45.9%</span>
                </div>
            </div>
        </div>


        <div class="bg-white p-2 sm:p-5 rounded-lg shadow-md mt-4 sm:mt-6">
            <div class="mx-2 flex justify-between items-center mb-1 sm:mb-4">
                <h2 class="text-lg sm:text-xl font-bold">Projects</h2>
                <a href="{{ route('project.add') }}"
                    class="px-2 py-1 text-xs sm:text-sm font-medium text-white bg-gradient-to-r from-yellow-400 to-red-400 
          hover:from-red-400 hover:to-yellow-400 rounded-lg shadow-sm transform hover:scale-105 transition-all duration-300 flex items-center gap-1">
                    <i class="bi bi-person-plus text-sm"></i> Add
                </a>
            </div>
            <div class="max-h-[220px] overflow-y-auto overflow-x-auto relative border rounded-md" style="height: 320px">


                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                SR</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Project Name</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Description</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Client ID</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Start Date</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                End Date</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Status</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Client Rate</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Created At</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Updated At</th>
                            <th
                                class="p-2 sm:p-3 text-center font-semibold text-gray-700 text-xs sm:text-sm md:text-base whitespace-nowrap">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $loop->iteration }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->name }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->description }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->client_id ?? 'N/A' }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->start_date }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->end_date }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ ucfirst($project->status) }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->client_rate }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->created_at }}</td>
                                <td class="p-2 sm:p-3 text-xs text-center sm:text-sm md:text-base whitespace-nowrap">
                                    {{ $project->updated_at }}</td>
                                <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                    <button
                                        class="px-2 py-1 rounded-lg bg-blue-100 hover:bg-blue-200 transition-all text-xs">
                                        <span class="bi bi-eye text-blue-500"></span>
                                    </button>
                                    <button
                                        class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                        <span class="bi bi-pencil text-black"></span>
                                    </button>
                                    <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                        <span class="bi bi-trash text-red-500"></span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>




                {{-- <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">1</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Timesheet</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Approved</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">FYP</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">costomer comp</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$50</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$75</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-03-01</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-06-01</td>
                            <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-eye text-red-500"></span>
                                </button>
                                <button
                                    class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="bi bi-pencil text-black"></span>
                                </button>
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-trash text-red-500"></span>
                                </button>
                            </td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Timesheet</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Approved</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">FYP</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">costomer comp</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$50</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$75</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-03-01</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-06-01</td>
                            <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-eye text-red-500"></span>
                                </button>
                                <button
                                    class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="bi bi-pencil text-black"></span>
                                </button>
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-trash text-red-500"></span>
                                </button>
                            </td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">3</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Timesheet</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Approved</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">FYP</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">costomer comp</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$50</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$75</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-03-01</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-06-01</td>
                            <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-eye text-red-500"></span>
                                </button>
                                <button
                                    class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="bi bi-pencil text-black"></span>
                                </button>
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-trash text-red-500"></span>
                                </button>
                            </td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">4</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Timesheet</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Approved</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">FYP</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">costomer comp</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$50</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$75</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-03-01</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-06-01</td>
                            <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-eye text-red-500"></span>
                                </button>
                                <button
                                    class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="bi bi-pencil text-black"></span>
                                </button>
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-trash text-red-500"></span>
                                </button>
                            </td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">5</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Timesheet</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Approved</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">FYP</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">costomer comp</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$50</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$75</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-03-01</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-06-01</td>
                            <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-eye text-red-500"></span>
                                </button>
                                <button
                                    class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="bi bi-pencil text-black"></span>
                                </button>
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-trash text-red-500"></span>
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">6</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Timesheet</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Approved</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">FYP</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Test contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">costomer comp</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$50</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$75</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-03-01</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2024-06-01</td>
                            <td class="p-2 sm:p-2 flex justify-center space-x-1">
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-eye text-red-500"></span>
                                </button>
                                <button
                                    class="px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                                    <span class="bi bi-pencil text-black"></span>
                                </button>
                                <button class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-trash text-red-500"></span>
                                </button>
                            </td>
                        </tr> --}}

                <!-- </tbody> -->
                </table>
            </div>
        </div>
    </div>
@endsection
