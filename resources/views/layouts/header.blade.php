<div id="content" class="transition-all duration-300">
    <header id="main-header"
        class="bg-none shadow-sm p-4 md:p-4 flex flex-nowrap md:flex-nowrap justify-between items-center transition-all duration-300 ease-in-out gap-2 md:gap-6">

        <!-- Welcome Message (Responsive Font) -->
        <h2 class="text-lg sm:text-base md:text-lg lg:text-xl mx-2 md:mx-4 px-2 md:px-3 font-bold text-gray-700 uppercase tracking-wide">
            @php
                
                $titles = [
                    'invoice.index' => 'Invoice List',
                    'users.index' => 'Users List',
                ];
                $currentRoute = Route::currentRouteName();
                $pageTitle = $titles[$currentRoute] ?? 'Dashboard';
            @endphp
            {{ $pageTitle }}
        </h2>
        

        <!-- Right Section: Icons + Profile + Search -->
        <div class="flex items-center gap-2 sm:gap-3 md:gap-4 lg:gap-6 flex-wrap md:flex-nowrap">

            <!-- Icons Section -->
            <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                <i class="bi bi-moon cursor-pointer hover:text-gray-700 text-lg sm:text-base md:text-lg"></i>
                <div class="relative">
                    <i class="bi bi-bell cursor-pointer hover:text-gray-700 text-lg sm:text-base md:text-lg"></i>
                    <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs sm:text-sm px-1.5 rounded-full">3</span>
                </div>
                <i class="bi bi-box-arrow-right cursor-pointer hover:text-gray-700 text-lg sm:text-base md:text-lg" id="logout-icon"></i>

                <!-- Profile Image -->
                <div class="relative w-full md:w-12 h-10 md:h-12 rounded-full overflow-hidden border border-gray-300">
                    <img src="{{ asset('assets/profile.jpeg') }}" class="w-full h-full object-cover" alt="User">
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
