@extends('layouts.app')

@section('content')
    <div id="invoice" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div
                class="bg-white shadow-md rounded-2xl p-3  flex items-center justify-between transition-all hover:shadow-lg w-full">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600">Revenue This Month</h3>
                    <p class="text-xl font-bold text-gray-800">2310</p>
                </div>
                <div class="p-3 rounded-xl bg-blue-100 flex items-center justify-center">
                    <i class="bi bi-filter text-blue-500 text-2xl"></i>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-3 flex items-center justify-between transition-all hover:shadow-lg w-full">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600">Total Invoices</h3>
                    <p class="text-xl font-bold text-gray-800">1000</p>
                </div>
                <div class="p-3 rounded-xl bg-yellow-100 flex items-center justify-center">
                    <i class="bi bi-receipt text-yellow-500 text-2xl"></i>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-3 flex items-center justify-between transition-all hover:shadow-lg w-full">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600">Active Invoices</h3>
                    <p class="text-xl font-bold text-gray-800">1310</p>
                </div>
                <div class="p-3 rounded-xl bg-green-100 flex items-center justify-center">
                    <i class="bi bi-check-circle text-green-500 text-2xl"></i>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-3 flex items-center justify-between transition-all hover:shadow-lg w-full">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600">Pending Invoices</h3>
                    <p class="text-xl font-bold text-gray-800">1243</p>
                </div>
                <div class="p-3 rounded-xl bg-yellow-100 flex items-center justify-center">
                    <i class="bi bi-receipt text-yellow-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Invoice Table (Responsive) -->
        <div class="bg-white p-2 sm:p-5 rounded-lg shadow-md mt-4 sm:mt-6">
            <h2 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4">All Invoices List</h2>

            <div class="max-h-[220px] overflow-y-auto overflow-x-auto relative border rounded-md" style="height: 320px">
                <table class="w-full min-w-full text-center">
                    <thead class="sticky top-0 bg-gray-100 z-10 text-center">
                        <tr class="border-b">
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                SR</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Invoice ID</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Billing Name</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Billing Amount</th>
                            <th class="p-2 sm:p-3 font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Payment Method</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Status</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">{{ $loop->iteration }}</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">#INV{{ $invoice->id }}</td>
                            <td class="p-2 sm:p-3 flex justify-center items-center">
                                <img src="{{ asset('assets/profile.jpeg') }}" class="h-8 sm:h-10 rounded-full mr-2" alt="User">
                                <span class="hidden sm:block text-xs sm:text-sm md:text-base">{{ $invoice->client->firstname ?? 'N/A' }}</span>
                            </td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">${{ number_format($invoice->amount, 2) }}</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">{{ $invoice->payment_method }}</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base 
                                {{ $invoice->status === 'Completed' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($invoice->status) }}
                            </td>
                            <td class="p-2 sm:p-3">
                                <button class="p-2 rounded-xl bg-yellow-100 hover:bg-orange-200 transition-all">
                                    <i class="bi bi-pencil text-orange-500"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        

                        {{-- <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">#INV2540</td>
                            <td class="p-2 sm:p-3 flex justify-center align-items-center">
                                <img src="{{ asset('assets/profile.jpeg') }}" class="h-8 sm:h-10 rounded-full mr-2"
                                    alt="User">
                                <span class="hidden sm:block text-xs sm:text-sm md:text-base">Arsalan Mehdi</span>
                            </td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$452</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Mastercard</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Completed</td>
                            <td class="p-2 sm:p-3">
                                <button class="p-2 rounded-xl bg-yellow-100 hover:bg-orange-200 transition-all">
                                    <i class="bi bi-pencil text-orange-500"></i>
                                </button>

                            </td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">3</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">#INV2540</td>
                            <td class="p-2 sm:p-3 flex justify-center align-items-center">
                                <img src="{{ asset('assets/profile.jpeg') }}" class="h-8 sm:h-10 rounded-full mr-2"
                                    alt="User">
                                <span class="hidden sm:block text-xs sm:text-sm md:text-base">Arsalan Mehdi</span>
                            </td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$452</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Mastercard</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Completed</td>
                            <td class="p-2 sm:p-3">
                                <button class="p-2 rounded-xl bg-yellow-100 hover:bg-orange-200 transition-all">
                                    <i class="bi bi-pencil text-orange-500"></i>
                                </button>

                            </td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">4</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">#INV2540</td>
                            <td class="p-2 sm:p-3 flex justify-center align-items-center">
                                <img src="{{ asset('assets/profile.jpeg') }}" class="h-8 sm:h-10 rounded-full mr-2"
                                    alt="User">
                                <span class="hidden sm:block text-xs sm:text-sm md:text-base">Arsalan Mehdi</span>
                            </td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$452</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Mastercard</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Completed</td>
                            <td class="p-2 sm:p-3">
                                <button class="p-2 rounded-xl bg-yellow-100 hover:bg-orange-200 transition-all">
                                    <i class="bi bi-pencil text-orange-500"></i>
                                </button>

                            </td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">5</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">#INV2540</td>
                            <td class="p-2 sm:p-3 flex justify-center align-items-center">
                                <img src="{{ asset('assets/profile.jpeg') }}" class="h-8 sm:h-10 rounded-full mr-2"
                                    alt="User">
                                <span class="hidden sm:block text-xs sm:text-sm md:text-base">Arsalan Mehdi</span>
                            </td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$452</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Mastercard</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Completed</td>
                            <td class="p-2 sm:p-3">
                                <button class="p-2 rounded-xl bg-yellow-100 hover:bg-orange-200 transition-all">
                                    <i class="bi bi-pencil text-orange-500"></i>
                                </button>

                            </td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">6</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">#INV2540</td>
                            <td class="p-2 sm:p-3 flex justify-center align-items-center">
                                <img src="{{ asset('assets/profile.jpeg') }}" class="h-8 sm:h-10 rounded-full mr-2"
                                    alt="User">
                                <span class="hidden sm:block text-xs sm:text-sm md:text-base">Arsalan Mehdi</span>
                            </td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">$452</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Mastercard</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Completed</td>
                            <td class="p-2 sm:p-3">
                                <button class="p-2 rounded-xl bg-yellow-100 hover:bg-orange-200 transition-all">
                                    <i class="bi bi-pencil text-orange-500"></i>
                                </button>

                            </td>
                        </tr> --}}

                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection
