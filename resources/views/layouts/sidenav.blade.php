<div id="layoutSidenav_nav" class="w-64 bg-gray-200 text-gray-600 shadow-lg">
    <nav class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex-1 px-4 py-6 mb-10">
            <!-- Core Section -->
            <div class="text-xs font-semibold uppercase tracking-wider mb-6 text-gray-500">Core</div>
            <a class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-300 hover:text-gray-800 rounded-md transition duration-300 ease-in-out no-underline mb-4" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
            <a class="flex items-center px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-md transition duration-300 ease-in-out no-underline mb-4" href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt mr-3"></i>
                Logout
            </a>
            <a class="flex items-center px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-md transition duration-300 ease-in-out no-underline" href="{{ route('admin.users.index') }}">
                <i class="fas fa-cogs mr-3"></i>
                Manage Admin
            </a>
        </div>
    </nav>
</div>
