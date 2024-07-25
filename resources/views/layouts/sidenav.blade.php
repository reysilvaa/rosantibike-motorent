<div id="layoutSidenav_nav" class="w-64 bg-gray-200 text-gray-600 shadow-lg">
    <nav class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex-1 px-4 py-6">
            <div class="text-xs font-semibold uppercase tracking-wider mb-6 text-gray-500">Core</div>
            <a class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-300 hover:text-gray-800 rounded-md transition duration-300 ease-in-out no-underline" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
            <div class="text-xs font-semibold uppercase tracking-wider mt-6 mb-4 px-4 text-gray-500">Interface</div>
            <a class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-300 hover:text-gray-800 rounded-md transition duration-300 ease-in-out no-underline" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <i class="fas fa-columns mr-3"></i>
                Layouts
                <i class="fas fa-angle-down ml-auto transition-transform duration-300" id="layoutIcon"></i>
            </a>
            <div class="collapse" id="collapseLayouts">
                <nav class="flex flex-col pl-6 mt-2 space-y-1">
                    <!-- Add your layout links here -->
                </nav>
            </div>
            <a class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-300 hover:text-gray-800 rounded-md transition duration-300 ease-in-out no-underline" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                <i class="fas fa-book-open mr-3"></i>
                Pages
                <i class="fas fa-angle-down ml-auto transition-transform duration-300" id="pagesIcon"></i>
            </a>
            <div class="collapse" id="collapsePages">
                <nav class="flex flex-col pl-6 mt-2 space-y-1">
                    <a class="flex items-center justify-between py-2 text-gray-600 hover:bg-gray-300 hover:text-gray-800 rounded-md transition duration-300 ease-in-out" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                        Authentication
                        <i class="fas fa-angle-down transition-transform duration-300" id="authIcon"></i>
                    </a>
                    <div class="collapse pl-4" id="pagesCollapseAuth">
                        <nav class="flex flex-col space-y-1">
                            <a class="py-2 text-gray-600 hover:bg-gray-300 hover:text-gray-800 rounded-md transition duration-300 ease-in-out" href="{{ route('login') }}">Login</a>
                            <!-- Add more authentication links here -->
                        </nav>
                    </div>
                    <a class="flex items-center justify-between py-2 text-gray-600 hover:bg-gray-300 hover:text-gray-800 rounded-md transition duration-300 ease-in-out" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                        Error
                        <i class="fas fa-angle-down transition-transform duration-300" id="errorIcon"></i>
                    </a>
                    <div class="collapse pl-4" id="pagesCollapseError">
                        <nav class="flex flex-col space-y-1">
                            <!-- Add your error links here -->
                        </nav>
                    </div>
                </nav>
            </div>
        </div>
    </nav>
</div>
