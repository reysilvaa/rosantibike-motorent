<!-- resources/views/layouts/navbar.blade.php -->
<nav class="bg-white py-2 px-6 flex items-center justify-between shadow-lg fixed top-0 left-0 right-0 z-50 transition-all duration-300 ease-in-out">
    <!-- Sidebar Toggle -->
    <button class="text-gray-600 text-2xl px-4 py-2 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-transform transform hover:scale-105" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Brand -->
    <a class="text-black font-latin font-extrabold flex items-center no-underline hover:text-gray-600 transition duration-300 ease-in-out" href="{{ route('dashboard') }}">
        <img src="{{ asset('logo2.png') }}" alt="RosantiBike Motorent" class="logo-image max-w-[150px] h-auto transition-transform transform hover:scale-110">
    </a>

    <!-- User Dropdown -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="text-gray-600 text-lg px-4 py-2 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-transform transform hover:scale-105" id="userDropdownToggle">
            <i class="fas fa-user"></i>
        </button>
        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            id="userDropdownMenu"
            class="absolute right-0 mt-2 w-48 bg-white text-gray-900 border border-gray-300 rounded-lg shadow-xl origin-top-right z-50 hidden">
            <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-100 transition duration-150 ease-in-out">Profile</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100 transition duration-150 ease-in-out">Settings</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100 transition duration-150 ease-in-out">Logout</a>
        </div>
    </div>
</nav>
