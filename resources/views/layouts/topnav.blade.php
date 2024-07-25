<nav class="bg-gradient-to-r from-blue-800 to-blue-600 py-4 px-6 flex items-center justify-between shadow-lg">
    <!-- Navbar Brand -->
    <a class="text-white text-2xl font-extrabold flex items-center no-underline hover:text-gray-200 transition duration-300 ease-in-out" href="{{ route('dashboard') }}">
        <span>Admin Rosanti</span>
    </a>

    <!-- Sidebar Toggle -->
   <div class="flex-1"></div>
    <button class="text-white text-2xl px-4 py-2 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition-transform transform hover:scale-105" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="mx-2"></div>

    <!-- New Dropdown Toggle -->
    <div class="relative">
        <button id="newDropdownToggle" class="text-white text-lg px-4 py-2 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition-transform transform hover:scale-105">
            <i class="fas fa-user"></i>
        </button>
        <div id="newDropdownMenu" class="absolute right-0 mt-2 bg-white text-gray-900 border border-gray-300 rounded-lg shadow-xl hidden transform scale-95 transition-transform origin-top-right">
            <a href="#" class="block px-4 py-2 hover:bg-gray-100 transition duration-150 ease-in-out">Profile</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100 transition duration-150 ease-in-out">Settings</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100 transition duration-150 ease-in-out">Logout</a>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newDropdownToggle = document.getElementById('newDropdownToggle');
    const newDropdownMenu = document.getElementById('newDropdownMenu');

    newDropdownToggle.addEventListener('click', function() {
        newDropdownMenu.classList.toggle('hidden');
        newDropdownMenu.classList.toggle('scale-100');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!newDropdownToggle.contains(event.target) && !newDropdownMenu.contains(event.target)) {
            newDropdownMenu.classList.add('hidden');
            newDropdownMenu.classList.remove('scale-100');
        }
    });
});
</script>
