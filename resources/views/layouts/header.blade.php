<div id="content" class="transition-all duration-300">
    <header id="main-header"
        class=" main-layout bg-none shadow-sm p-4 md:p-4 flex flex-nowrap md:flex-nowrap justify-between items-center transition-all duration-300 ease-in-out gap-2 md:gap-6">

        <!-- Welcome Message (Responsive Font) -->
        <h2
            class="text-lg sm:text-base md:text-lg lg:text-xl mx-2 md:mx-4 px-2 md:px-3 font-bold text-gray-700 uppercase tracking-wide">
            {{ $pageTitle }}
        </h2>


        <!-- Right Section: Icons + Profile + Search -->
        <div class="flex items-center gap-2 sm:gap-3 md:gap-4 lg:gap-6 flex-wrap md:flex-nowrap">

            <!-- Icons Section -->
            <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                {{-- <i class="bi bi-moon cursor-pointer hover:text-gray-700 text-lg sm:text-base md:text-lg"></i> --}}
                {{-- notification dropdown --}}
                <div class="relative z-50">
                    <!-- Bell Icon with Notification Badge -->
                    <div class="relative cursor-pointer" id="notificationBell">
                        <i class="bi bi-bell  text-gray-700 hover:text-gray-900"></i>
                        <span id="notificationCount"
                            class="absolute -top-1 -right-2 bg-red-500 text-white text-xs px-1.5 rounded-full">0</span>

                    </div>

                    <!-- Notification Dropdown -->
                    <div id="notificationDropdown"
                        class="absolute mt-2 w-96 bg-white text-sm rounded-2xl shadow-2xl hidden">
                        <!-- Top Tab -->
                        {{-- <div class="absolute top-0 left-1/2 -translate-x-1/2 w-10 h-5 bg-white rounded-b-lg"></div> --}}

                        <!-- Header -->
                        <div class="flex justify-between items-center px-3 py-2 border-b">
                            <h3 class="text-lg font-semibold m-0">Notifications</h3>
                            <i class="bi bi-search text-gray-500 cursor-pointer"></i>
                        </div>

                        <div class="p-4 p-sm-2 space-y-4 notification-scroll">

                            <div class="flex items-start space-x-3 notification-item new-notification" data-new="true">
                                <div class="flex-1">
                                    <p class="m-1"><span class="font-bold text-gray-800">New User</span></p>
                                    <p class="text-sm text-gray-500 m-1">You have a new follower!</p>
                                    <p class="text-xs text-gray-400 m-1">Just now</p>
                                </div>
                            </div>
                            <div class="border-b m-0 border-gray-200"></div>
                            <div class="flex items-start space-x-3 notification-item">

                                <div class="flex-1">
                                    <p class="m-1"><span class="font-bold text-gray-800">Brandon Newman</span></p>
                                    <p class="text-sm text-gray-500 m-1">UI/UX Inspo</p>
                                    <p class="text-xs text-gray-400 m-1">21 min ago</p>
                                </div>
                            </div>
                            <div class="border-b m-0 border-gray-200"></div>

                            <div class="flex items-start space-x-3 notification-item">

                                <div class="flex-1">
                                    <p class="m-1"><span class="font-bold text-gray-800">Dave Wood</span></p>
                                    <p class="text-sm text-gray-500 m-1">Daily UI Challenge 049</p>
                                    <p class="text-xs text-gray-400 m-1">2 hours ago</p>
                                </div>
                            </div>
                            <div class="border-b m-0 border-gray-200"></div>

                            <div class="flex items-start space-x-3 notification-item">

                                <div class="flex-1">
                                    <p class="m-1"><span class="font-bold text-gray-800">Anna Lee</span></p>
                                    <p class="text-sm text-gray-500 m-1">Woah! Loving these colours! Keep it up</p>
                                    <p class="text-xs text-gray-400 m-1">1 day ago</p>
                                </div>
                            </div>
                            <div class="border-b m-0 border-gray-200"></div>

                            <div class="flex items-start space-x-3 notification-item">

                                <div class="flex-1">
                                    <p class="m-1"><span class="font-bold text-gray-800">Michael Scott</span></p>
                                    <p class="text-sm text-gray-500 m-1">Woah! Loving these colours! Keep it up</p>
                                    <p class="text-xs text-gray-400 m-1">1 day ago</p>
                                </div>
                            </div>
                            <div class="border-b m-0 border-gray-200"></div>

                            <div class="flex items-start space-x-3 notification-item">

                                <div class="flex-1">
                                    <p class="m-1"><span class="font-bold text-gray-800">Jessica Pearson</span></p>
                                    <p class="text-sm text-gray-500 m-1">This design looks amazing! 🔥</p>
                                    <p class="text-xs text-gray-400 m-1">4 days ago</p>
                                </div>
                            </div>
                        </div>

                        <!-- Footer: Mark All as Read Button -->
                        <div class="p-2 text-center border-t">
                            <button id="markAllRead"
                                class="text-gray-600 font-semibold hover:underline cursor-pointer">Mark All as
                                Read</button>
                        </div>
                    </div>
                </div>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <i class="bi bi-box-arrow-right cursor-pointer hover:text-gray-700 text-lg sm:text-base md:text-lg"
                    id="logout-icon"></i>

                <!-- Profile Image -->
                <div class="relative w-full md:w-12 h-10 md:h-12 rounded-full overflow-hidden border border-gray-300">
                    <a href="{{ route('profile') }}">
                        <img src="{{ asset('assets/profile.jpeg') }}" class="w-full h-full object-cover cursor-pointer"
                            alt="User">
                    </a>
                </div>
            </div>

            <!-- Search Bar (Responsive Width) -->
            <div class="relative hidden sm:block w-50 md:w-64">
                <input type="text" placeholder="Search..."
                    class="pl-10 pr-4 py-2 border rounded-xl bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 w-full text-xs sm:text-sm md:text-base">
                <i class="bi bi-search absolute left-4 top-1.5 text-gray-500"></i>
            </div>

        </div>
    </header>
</div>
