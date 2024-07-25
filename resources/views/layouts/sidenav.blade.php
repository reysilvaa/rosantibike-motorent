<div id="layoutSidenav_nav" class="w-64 bg-gray-800 text-white">
    <nav class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex-1 px-4 py-6">
            <div class="text-xs font-semibold uppercase tracking-wider mb-6 text-gray-400">Core</div>
            <a class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
            <div class="text-xs font-semibold uppercase tracking-wider mt-6 mb-4 px-4 text-gray-400">Interface</div>
            <a class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <i class="fas fa-columns mr-3"></i>
                Layouts
                <i class="fas fa-angle-down ml-auto transition-transform duration-200" id="layoutIcon"></i>
            </a>
            <div class="collapse" id="collapseLayouts">
                <nav class="flex flex-col pl-6 mt-2 space-y-1">
                    {{-- <a class="py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md" href="{{ route('layout.static') }}">Static Navigation</a> --}}
                    {{-- <a class="py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md" href="{{ route('layout.light') }}">Light Sidenav</a> --}}
                </nav>
            </div>
            <a class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                <i class="fas fa-book-open mr-3"></i>
                Pages
                <i class="fas fa-angle-down ml-auto transition-transform duration-200" id="pagesIcon"></i>
            </a>
            <div class="collapse" id="collapsePages">
                <nav class="flex flex-col pl-6 mt-2 space-y-1">
                    <a class="flex items-center justify-between py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                        Authentication
                        <i class="fas fa-angle-down transition-transform duration-200" id="authIcon"></i>
                    </a>
                    <div class="collapse pl-4" id="pagesCollapseAuth">
                        <nav class="flex flex-col space-y-1">
                            <a class="py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200" href="{{ route('login') }}">Login</a>
                            {{-- <a class="py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200" href="{{ route('register') }}">Register</a> --}}
                            {{-- <a class="py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200" href="{{ route('password.request') }}">Forgot Password</a> --}}
                        </nav>
                    </div>
                    <a class="flex items-center justify-between py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                        Error
                        <i class="fas fa-angle-down transition-transform duration-200" id="errorIcon"></i>
                    </a>
                    <div class="collapse pl-4" id="pagesCollapseError">
                        <nav class="flex flex-col space-y-1">
                            {{-- <a class="py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200" href="{{ route('error.401') }}">401 Page</a> --}}
                            {{-- <a class="py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200" href="{{ route('error.404') }}">404 Page</a> --}}
                            {{-- <a class="py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200" href="{{ route('error.500') }}">500 Page</a> --}}
                        </nav>
                    </div>
                </nav>
            </div>
        </div>
    </nav>
</div>
