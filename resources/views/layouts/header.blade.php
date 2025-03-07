<header class="bg-white shadow-md p-4 flex justify-between items-center">
    <h2 class="text-xl font-bold text-gray-700 uppercase tracking-wide">WELCOME Dua!</h2>

    <div class="flex items-center space-x-6">
        <div class="flex items-center space-x-4">
            <i class="bi bi-moon cursor-pointer hover:text-gray-700"></i>
            <div class="relative">
                <i class="bi bi-bell cursor-pointer hover:text-gray-700"></i>
                <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs px-1.5 rounded-full">3</span>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<i class="bi bi-box-arrow-right cursor-pointer hover:text-gray-700" id="logout-icon"></i>

            <div class="relative w-14 h-14 rounded-full overflow-hidden border border-gray-300">
                <img src="{{ asset('assets/profile.jpeg') }}" class="w-full h-full object-cover" alt="User">
            </div>
        </div>
        <div class="relative">
            <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 border rounded-xl bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400">
            <i class="bi bi-search absolute left-3 top-2.5 text-gray-500"></i>
        </div>
    </div>
</header>