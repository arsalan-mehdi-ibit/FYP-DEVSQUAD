<div id="content" class="transition-all duration-300">
    <header id="main-header" class="main-layout bg-none shadow-sm p-3 p-sm-3 flex items-center justify-between gap-4">

        <!-- Left Section: Sidebar Toggle & Title -->
        <div class="flex items-center text-center gap-1">
            <button id="menu-toggle" class="lg:hidden text-gray-700">
                <i class="bi bi-list text-2xl"></i>
            </button>
            <h2 class="text-lg md:text-xl mx-2 my-0 font-bold text-gray-700 uppercase">
                {{ $pageTitle }}
            </h2>
        </div>

        <!-- Right Section: Icons + Profile + Search -->
        <div class="flex items-center gap-2 sm:gap-3 md:gap-4 lg:gap-6 flex-wrap md:flex-nowrap">

            <!-- Icons Section -->
            <div class="flex items-center gap-2 sm:gap-3 md:gap-4">

                {{-- notification dropdown --}}
                <div class="relative z-50">
                    <!-- Bell Icon with Notification Badge -->
                    <div class="relative cursor-pointer" id="notificationBell">
                        <i class="bi bi-bell  text-gray-700 hover:text-gray-900"></i>
                        <span id="notificationCount"
                            class="absolute -top-1 -right-2 bg-red-500 text-white text-xs px-1.5 rounded-full {{ $unreadNotificationCount == 0 ? 'hidden' : '' }}">
                            {{ $unreadNotificationCount }}</span>

                    </div>

                    <!-- Notification Dropdown -->
                    <div id="notificationDropdown"
                        class="absolute mt-2 w-96 bg-white text-sm rounded-2xl shadow-2xl hidden">


                        <!-- Header -->
                        <div class="flex justify-between items-center px-3 py-2 border-b">
                            <h3 class="text-lg font-semibold m-0">Notifications</h3>
                            <i class="bi bi-search text-gray-500 cursor-pointer"></i>
                        </div>

                        <div class="p-4 p-sm-2 space-y-4 notification-scroll">
                            @foreach ($notifications as $notification)
                                <div class="flex items-start space-x-3 notification-item {{ $notification->is_read ? '' : 'new-notification' }}"
                                    data-id="{{ $notification->id }}"
                                    data-new="{{ $notification->is_read ? 'false' : 'true' }}">
                                    <div class="flex-1">
                                        <p class="m-1"><span class="font-bold text-gray-800">
                                                {{ $notification->title ?? 'Notification' }}</span></p>
                                        <p class="text-sm text-gray-500 m-1">{{ $notification->message }}</p>
                                        <p class="text-xs text-gray-400 m-1">
                                            {{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="border-b m-0 border-gray-200"></div>
                            @endforeach

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
                        <img src="{{ $headerProfilePic ? asset($headerProfilePic) : asset('assets/profile.jpeg') }}"
                            class="w-full h-full object-cover cursor-pointer" alt="User">
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
