@extends('layouts.app')

@section('content')
    <div id="invoice" class="max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <div
                class="bg-white shadow-md rounded-2xl p-3  flex items-center justify-between transition-all hover:shadow-lg w-full">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600">This Month's</h3>
                    <p class="text-xl font-bold text-gray-800">22.63k</p>
                </div>
                <div class="p-3 rounded-xl bg-yellow-100 flex items-center justify-center">
                    <i class="bi bi-receipt text-orange-500 text-2xl"></i>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-3 flex items-center justify-between transition-all hover:shadow-lg w-full">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600">Approved</h3>
                    <p class="text-xl font-bold text-gray-800">4.5k</p>
                </div>
                <div class="p-3 rounded-xl bg-red-100 flex items-center justify-center">
                    <i class="bi bi-x-circle text-red-500 text-2xl"></i>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-3 flex items-center justify-between transition-all hover:shadow-lg w-full">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600">Rejected</h3>
                    <p class="text-xl font-bold text-gray-800">1310</p>
                </div>
                <div class="p-3 rounded-xl bg-green-100 flex items-center justify-center">
                    <i class="bi bi-check-circle text-green-500 text-2xl"></i>
                </div>
            </div>

            <div
                class="bg-white shadow-md rounded-2xl p-3 flex items-center justify-between transition-all hover:shadow-lg w-full">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600">Pending Approval</h3>
                    <p class="text-xl font-bold text-gray-800">1243</p>
                </div>
                <div class="p-3 rounded-xl bg-blue-100 flex items-center justify-center">
                    <i class="bi bi-filter text-blue-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Timesheet table (Responsive) -->
        <div class="bg-white p-2 sm:p-5 rounded-lg shadow-md mt-4 sm:mt-6">
            <h2 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4">Timesheet list</h2>

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
                                Total OT hours</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Approver</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Project</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Contractor</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                Client</th>
                            <th class="p-2 sm:p-3  font-semibold text-gray-700 text-xs sm:text-sm md:text-base">
                                 Action</th>        
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                             <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">1</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Feb 26,2002-Feb 28,2002</td>
                            <td class="p-2 sm:p-3 flex justify-center align-items-center">                              
                                <span class="hidden sm:block text-xs sm:text-sm md:text-base">Approved</span>
                            </td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">6</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test client</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Project</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Customer comp</td>
                                    
                                                       <td class="p-2 sm:p-3">
                                                        <div class="flex space-x-2 text-xs" >
                                                            <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                                              Approve
                                                            </button>
                                                            <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                                              Reject
                                                            </button>
                                                          </div>

                            </td>
                        </tr>

                        <tr class="border-b hover:bg-gray-50">
                             <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">2</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">feb 24,2002-feb 27,2002</td>
                            <td class="p-2 sm:p-3 flex justify-center align-items-center">
                                
                                <span class="hidden sm:block text-xs sm:text-sm md:text-base">Approved</span>
                            </td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">4</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">6</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Client</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Project</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Customer comp</td>
                            <td class="p-2 sm:p-3">
                                <div class="flex space-x-2 text-xs" >
                                    <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                      Approve
                                    </button>
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                      Reject
                                    </button>
                                  </div>

    </td>
</tr>

                                                       

                        <tr class="border-b hover:bg-gray-50">
                             <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">3</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">March 06,2022-March 09,2022</td>
                            <td class="p-2 sm:p-3 flex justify-center align-items-center">
                                                            <span class="hidden sm:block text-xs sm:text-sm md:text-base">Approved</span>
                            </td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">9</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">7</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Client</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Project</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Customer comp</td>
                         
                            <td class="p-2 sm:p-3">
                                <div class="flex space-x-2 text-xs" >
                                    <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                      Approve
                                    </button>
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                      Reject
                                    </button>
                                  </div>

    </td>
</tr>


                        <tr class="border-b hover:bg-gray-50">
                             <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">4</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Jan 09,2025-jan 12,2025</td>
                            <td class="p-2 sm:p-3 flex justify-center align-items-center">
                                
                                <span class="hidden sm:block text-xs sm:text-sm md:text-base">Approved</span>
                            </td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">10</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">8</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Client</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Project</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Customer comp</td>
                       
                            <td class="p-2 sm:p-3">
                                <div class="flex space-x-2 text-xs" >
                                    <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                      Approve
                                    </button>
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                      Reject
                                    </button>
                                  </div>

    </td>
</tr>

                        <tr class="border-b hover:bg-gray-50">
                             <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">5</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Aug 10,2025-Aug 15,2025</td>
                            <td class="p-2 sm:p-3 flex justify-center align-items-center">
                                
                                <span class="hidden sm:block text-xs sm:text-sm md:text-base">Approved</span>
                            </td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">6</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">9</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test client</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Project</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Customer comp</td>
                            
                            <td class="p-2 sm:p-3">
                                <div class="flex space-x-2 text-xs" >
                                    <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                      Approve
                                    </button>
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                      Reject
                                    </button>
                                  </div>

    </td>
</tr>


                        <tr class="border-b hover:bg-gray-50">
                             <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">6</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">Dec 16,2024-Dec 20,2025</td>
                            <td class="p-2 sm:p-3 flex justify-center align-items-center">
                                                                <span class="hidden sm:block text-xs sm:text-sm md:text-base">Approved</span>
                            </td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">8</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base">10</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Client</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Project</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Test Contractor</td>
                            <td class="p-2 sm:p-3 text-xs sm:text-sm md:text-base text-green-600">Customer comp</td>
                                  
                            <td class="p-2 sm:p-3">
                                <div class="flex space-x-2 text-xs" >
                                    <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                      Approve
                                    </button>
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                      Reject
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
