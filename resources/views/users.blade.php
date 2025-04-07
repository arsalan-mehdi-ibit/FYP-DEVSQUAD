@extends('layouts.app')

@section('content')
    <style>
        #updateSuccessPopup {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #38a169;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            boxShadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: opacity 0.3s ease-in-out;
        }
    </style>

    <div id="users" class="main-layout max-w-full mx-auto p-2 sm:p-4 md:p-6 lg:p-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
            <div
                class="bg-white shadow-md rounded-2xl p-2 sm:p-4 md:p-5 flex flex-col gap-2 sm:gap-3 transition-all hover:shadow-lg">
                <div class="flex items-center gap-2 sm:gap-2">
                    <div class="p-3 sm:p-3 rounded-xl bg-red-100 flex items-center justify-center">
                        <i class="bi bi-people text-orange-500 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-600">All Users </h3>
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
                    <p class="text-lg sm:text-xl font-bold text-gray-800 m-0">38,908.00</p>
                    <span class="text-xs sm:text-sm text-green-600 bg-green-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded-md">↑
                        45.9%</span>
                </div>
            </div>
        </div>


        <div class="bg-white p-2 sm:p-5 rounded-lg shadow-md mt-4 sm:mt-6">
            <div class="mx-2 flex justify-between items-center mb-1 sm:mb-4">
                <h2 class="text-lg sm:text-xl font-bold">All Users List</h2>
                <a href="{{ route('users.add') }}"
                    class="px-2 py-1 text-xs sm:text-sm font-medium text-white bg-gradient-to-r from-yellow-400 to-red-400 
          hover:from-red-400 hover:to-yellow-400 rounded-lg shadow-sm transform hover:scale-105 transition-all duration-300 flex items-center gap-1">
                    <i class="bi bi-person-plus text-sm"></i> Add
                </a>
            </div>
            <div class="max-h-[220px] overflow-y-auto overflow-x-auto relative border rounded-md" style="height: 320px">
                <table class="w-full min-w-full text-center">
                    <thead class="sticky top-0 bg-gray-100 z-10 text-center">
                        <tr class="border-b">
                            <th class="p-2 sm:p-3  font-semibold text-left text-gray-700 text-xs sm:text-sm md:text-base">
                                SR</th>
                            <th class="p-2 sm:p-3 font-semibold text-left text-gray-700 text-xs sm:text-sm md:text-base">
                                User Name</th>
                            <th class="p-2 sm:p-3 font-semibold text-left text-gray-700 text-xs sm:text-sm md:text-base">
                                Email</th>
                            <th class="p-2 sm:p-3 font-semibold text-left text-gray-700 text-xs sm:text-sm md:text-base">
                                Phone Number</th>
                            <th class="p-2 sm:p-3 font-semibold text-left text-gray-700 text-xs sm:text-sm md:text-base">
                                Role</th>
                            <th class="p-2 sm:p-3 font-semibold text-left text-gray-700 text-xs sm:text-sm md:text-base">
                                Source</th>
                            <th class="p-2 sm:p-3 font-semibold  text-gray-700 text-xs sm:text-sm md:text-base">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2 sm:p-3 text-left text-xs sm:text-sm md:text-base">{{ $loop->iteration }}</td>

                                <td class="p-2 sm:p-3 flex justify-left align-items-center">
                                    <img src="{{ asset('assets/profile.jpeg') }}"
                                        class="h-8 sm:h-10 rounded-full mr-2 hidden sm:block" alt="User">
                                    <span class="text-xs sm:text-sm md:text-base">
                                        {{ trim("{$user->firstname} {$user->middlename} {$user->lastname}") }}
                                    </span>
                                </td>

                                <td class="p-2 sm:p-3 text-xs text-left sm:text-sm md:text-base">{{ $user->email }}</td>
                                <td class="p-2 sm:p-3 text-xs text-left sm:text-sm md:text-base">{{ $user->phone ?? '-' }}
                                </td>
                                <td class="p-2 sm:p-3 text-xs text-left sm:text-sm md:text-base">{{ ucfirst($user->role) }}
                                </td>
                                <td class="p-2 sm:p-3 text-xs text-left sm:text-sm md:text-base">{{ $user->source ?? '-' }}
                                </td>
                                <td class="p-2 sm:p-3 flex justify-center space-x-2">
                                    <a href="{{ route('users.edit', $user->id) }}">
                                        <button class="p-2 rounded-xl bg-yellow-100 hover:bg-orange-200 transition-all">
                                            <i class="bi bi-pencil text-orange-500"></i>
                                        </button>
                                    </a>
                                    <button class="p-2 rounded-xl bg-red-100 hover:bg-red-200 transition-all">
                                        <i class="bi bi-trash text-red-500"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (session('user_invitation_sent'))
        <script>
            $(document).ready(function() {
                $('#userInvitationModal').modal('show');
            });
        </script>

        @include('components.new_user_model')
    @endif

    @if (session('user_updated'))
        <div id="updateSuccessPopup" class=" duration-300">
            User has been successfully updated.
        </div>

        <script>
            setTimeout(() => {
                const popup = document.getElementById('updateSuccessPopup');
                if (popup) {
                    popup.style.opacity = '0';
                    setTimeout(() => popup.remove(), 500); // Fade out before removing
                }
            }, 3000); // Hide after 3 seconds
        </script>
    @endif
@endsection
