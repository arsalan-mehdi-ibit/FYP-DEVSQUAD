@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-black text-white shadow-md p-4">
        <h2 class="text-xl font-bold mb-4 text-yellow-400">TRACK POINT</h2>
        <nav>
            <ul class="space-y-2">
                <li><a href="#" class="block p-2 flex items-center"><i class="bi bi-house-door mr-2"></i> Dashboard</a></li>
                <li><a href="#" class="block p-2 flex items-center"><i class="bi bi-people mr-2"></i> Users</a></li>
                <li><a href="#" class="block p-2 flex items-center"><i class="bi bi-folder mr-2"></i> Projects</a></li>
                <li><a href="#" class="block p-2 flex items-center"><i class="bi bi-clock mr-2"></i> Timesheets</a></li>
                <li><a href="#" class="block p-2 flex items-center"><i class="bi bi-file-earmark-text mr-2"></i> Invoices</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-4">
        <h1 class="text-2xl font-bold mb-4">Projects</h1>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="p-4 bg-white shadow rounded-lg flex items-center w-full">
                <i class="bi bi-people text-orange-500 text-2xl mr-2"></i>
                <div>
                    <p class="text-gray-600">All Customers</p>
                    <p class="text-xl font-bold">+22.63k</p>
                    <span class="text-green-500 text-sm">↑ 34.4%</span>
                </div>
            </div>
            <div class="p-4 bg-white shadow rounded-lg flex items-center w-full">
                <i class="bi bi-box text-red-500 text-2xl mr-2"></i>
                <div>
                    <p class="text-gray-600">Orders</p>
                    <p class="text-xl font-bold">+4.5k</p>
                    <span class="text-red-500 text-sm">↓ 8.1%</span>
                </div>
            </div>
            <div class="p-4 bg-white shadow rounded-lg flex items-center w-full">
                <i class="bi bi-headset text-blue-500 text-2xl mr-2"></i>
                <div>
                    <p class="text-gray-600">Services Request</p>
                    <p class="text-xl font-bold">+1.03k</p>
                    <span class="text-green-500 text-sm">↑ 12.6%</span>
                </div>
            </div>
            <div class="p-4 bg-white shadow rounded-lg flex items-center w-full">
                <i class="bi bi-credit-card text-purple-500 text-2xl mr-2"></i>
                <div>
                    <p class="text-gray-600">Invoice & Payment</p>
                    <p class="text-xl font-bold">$38,908.00</p>
                    <span class="text-green-500 text-sm">↑ 45.9%</span>
                </div>
            </div>
        </div>

        <!-- Projects Table -->
        <div class="bg-white shadow rounded-lg p-4 w-full">
            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Projects</h2>
                <button class="bg-orange-500 text-white px-4 py-2 rounded flex items-center">
                    <i class="bi bi-plus-lg mr-2"></i> Add
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="bg-gray-200 text-sm">
                            <th class="p-3">SR</th>
                            <th class="p-3">Project Name</th>
                            <th class="p-3">Project Source</th>
                            <th class="p-3">Contractor</th>
                            <th class="p-3">Client</th>
                            <th class="p-3">Contractor Rate</th>
                            <th class="p-3">Client Rate</th>
                            <th class="p-3">Start Date</th>
                            <th class="p-3">Expected End Date</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t">
                            <td class="p-3">1</td>
                            <td class="p-3">Timesheet</td>
                            <td class="p-3">FYP</td>
                            <td class="p-3">Test contractor</td>
                            <td class="p-3">Customer Comp</td>
                            <td class="p-3">$50</td>
                            <td class="p-3">$75</td>
                            <td class="p-3">2024-03-01</td>
                            <td class="p-3">2024-06-01</td>
                            <td class="p-3 flex space-x-2">
                                <button class="text-blue-500"><i class="bi bi-eye"></i></button>
                                <button class="text-yellow-500"><i class="bi bi-pencil"></i></button>
                                <button class="text-red-500"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="p-3">2</td>
                            <td class="p-3">timesheet</td>
                            <td class="p-3">Startup</td>
                            <td class="p-3">ABC Ltd</td>
                            <td class="p-3">XYZ Client</td>
                            <td class="p-3">$60</td>
                            <td class="p-3">$90</td>
                            <td class="p-3">2024-04-01</td>
                            <td class="p-3">2024-08-01</td>
                            <td class="p-3 flex space-x-2">
                                <button class="text-blue-500"><i class="bi bi-eye"></i></button>
                                <button class="text-yellow-500"><i class="bi bi-pencil"></i></button>
                                <button class="text-red-500"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
    </main>
</div>
@endsection
