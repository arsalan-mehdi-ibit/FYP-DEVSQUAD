<div>
    <button id="menu-toggle" class="flex text-center justify-content-center absolute top-7 left-1 text-secondary p-1 rounded-md lg:hidden">
        <i class="bi bi-list text-2xl"></i>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 bg-gray-900 text-white min-h-screen p-3 px-4 fixed top-0 left-0 transform transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full z-50"> 
        <h2 class="text-3xl px-4 py-2 font-bold mb-6 text-yellow-200">TRACK POINT</h2>
        <ul class="pl-4">
            <li class="mb-4">
                <a href="#" class="flex items-center text-gray-300 hover:text-white">
                    <i class="bi bi-house-door mr-2"></i> Dashboard
                </a>
            </li>
            <li class="mb-4">
                <a href="{{route('users.index')}}" class="flex items-center text-gray-300 hover:text-white">
                    <i class="bi bi-people mr-2"></i> Users
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('project.index') }}" class="flex items-center text-gray-300 hover:text-white">
                    <i class="bi bi-folder2-open mr-2"></i> Projects
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('timesheet.index') }}" class="flex items-center text-gray-300 hover:text-white">
                    <i class="bi bi-clock-history mr-2"></i> Timesheets
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('invoice.index') }}" class="flex items-center text-gray-300 hover:text-white">
                    <i class="bi bi-receipt mr-2"></i> Invoices
                </a>
            </li>
        </ul>
        
    </aside>

    <!-- Overlay for Mobile Screens -->
    <div id="overlay" class="fixed inset-0 bg-gray-500 opacity-50 hidden lg:hidden"></div>
</div>
