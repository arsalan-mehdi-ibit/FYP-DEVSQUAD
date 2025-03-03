@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4">

    <div class="bg-white shadow-md rounded-xl p-4 flex items-center transition-all hover:shadow-lg w-full">
        <div class="p-2 rounded-xl bg-orange-100 mr-3">
            <i class="bi bi-receipt text-orange-500 text-xl"></i>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-700">Total Invoice</h3>
            <p class="text-lg font-bold text-gray-900">2310</p>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-xl p-4 flex items-center transition-all hover:shadow-lg w-full">
        <div class="p-2 rounded-xl bg-red-100 mr-3">
            <i class="bi bi-x-circle text-red-500 text-xl"></i>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-700">Pending Invoice</h3>
            <p class="text-lg font-bold text-gray-900">1000</p>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-xl p-4 flex items-center transition-all hover:shadow-lg w-full">
        <div class="p-2 rounded-xl bg-green-100 mr-3">
            <i class="bi bi-check-circle text-green-500 text-xl"></i>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-700">Paid Invoice</h3>
            <p class="text-lg font-bold text-gray-900">1310</p>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-xl p-4 flex items-center transition-all hover:shadow-lg w-full">
        <div class="p-2 rounded-xl bg-blue-100 mr-3">
            <i class="bi bi-filter text-blue-500 text-xl"></i>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-700">Inactive Invoice</h3>
            <p class="text-lg font-bold text-gray-900">1243</p>
        </div>
    </div>

</div>

<div class="bg-white p-5 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">All Invoices List</h2>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="p-3 text-left font-semibold text-gray-700">Invoice ID</th>
                <th class="p-3 text-left font-semibold text-gray-700">Billing Name</th>
                <th class="p-3 text-left font-semibold text-gray-700">Order Date</th>
                <th class="p-3 text-left font-semibold text-gray-700">Total</th>
                <th class="p-3 text-left font-semibold text-gray-700">Payment Method</th>
                <th class="p-3 text-left font-semibold text-gray-700">Status</th>
                <th class="p-3 text-left font-semibold text-gray-700">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">#INV2540</td>
                <td class="p-3 flex items-center">
                    <img src="{{ asset('assets/profile.jpeg') }}" class=" h-10 rounded-full mr-2" alt="User"> Arsalan Mehdi
                </td>
                <td class="p-3">07 Jan, 2023</td>
                <td class="p-3">$452</td>
                <td class="p-3">Mastercard</td>
                <td class="p-3 text-green-600">Completed</td>
                <td class="p-3 flex space-x-2">
                    <button class="text-blue-500">🔍</button>
                    <button class="text-orange-500">✏️</button>
                    <button class="text-red-500">🗑️</button>
                </td>
            </tr>
            
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">#INV2541</td>
                <td class="p-3 flex items-center">
                    <img src="{{ asset('assets/user.png') }}" class=" h-10 rounded-full mr-2" alt="User"> Minahil Saif
                </td>
                <td class="p-3">08 Jan, 2023</td>
                <td class="p-3">$123</td>
                <td class="p-3">Visa</td>
                <td class="p-3 text-yellow-600">Pending</td>
                <td class="p-3 flex space-x-2">
                    <button class="text-blue-500">🔍</button>
                    <button class="text-orange-500">✏️</button>
                    <button class="text-red-500">🗑️</button>
                </td>
            </tr>

            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">#INV2542</td>
                <td class="p-3 flex items-center">
                    <img src="{{ asset('assets/user.png') }}" class=" h-10 rounded-full mr-2" alt="User"> Dua Shabir
                </td>
                <td class="p-3">09 Jan, 2023</td>
                <td class="p-3">$789</td>
                <td class="p-3">Paypal</td>
                <td class="p-3 text-red-600">Inactive</td>
                <td class="p-3 flex space-x-2">
                    <button class="text-blue-500">🔍</button>
                    <button class="text-orange-500">✏️</button>
                    <button class="text-red-500">🗑️</button>
                </td>
            </tr>

            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">#INV2543</td>
                <td class="p-3 flex items-center">
                    <img src="{{ asset('assets/user.png') }}" class=" h-10 rounded-full mr-2" alt="User"> Hafsa Farman
                </td>
                <td class="p-3">09 Jan, 2023</td>
                <td class="p-3">$789</td>
                <td class="p-3">Paypal</td>
                <td class="p-3 text-red-600"> gactive</td>
                <td class="p-3 flex space-x-2">
                    <button class="text-blue-500">🔍</button>
                    <button class="text-orange-500">✏️</button>
                    <button class="text-red-500">🗑️</button>
                </td>
            </tr>
        </tbody>
    </table>

</div>
@endsection