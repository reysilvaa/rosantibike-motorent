<!-- Sidebar -->
<div id="sidebar" class="fixed top-0 left-0 w-64 h-full bg-white text-gray-800 shadow-md border-r border-gray-200 transform -translate-x-full transition-transform duration-300 ease-in-out z-40 pt-16">
    <nav class="flex flex-col h-full">
        <div class="flex-1 px-6 py-8 overflow-y-auto">
            <div class="text-xs font-semibold uppercase tracking-wider mb-6 text-gray-500">Menu</div>
            <a class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100 hover:text-gray-900 rounded-md transition duration-300 ease-in-out no-underline mb-4 group" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt mr-3"></i>
                <span class="group-hover:text-gray-900">Dashboard</span>
            </a>
            <a class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100 hover:text-gray-900 rounded-md transition duration-300 ease-in-out no-underline mb-4 group" href="{{ route('admin.users.index') }}">
                <i class="fas fa-cogs mr-3"></i>
                <span class="group-hover:text-gray-900">Manage Admin</span>
            </a>
            <a class="flex items-center px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-md transition duration-300 ease-in-out no-underline mb-4 group" href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt mr-3"></i>
                <span class="group-hover:text-white">Logout</span>
            </a>
        </div>
    </nav>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userDropdownToggle = document.getElementById('userDropdownToggle');
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        userDropdownToggle.addEventListener('click', function() {
            userDropdownMenu.classList.toggle('hidden');
            userDropdownMenu.classList.toggle('scale-100');
        });

        document.addEventListener('click', function(event) {
            if (!userDropdownToggle.contains(event.target) && !userDropdownMenu.contains(event.target)) {
                userDropdownMenu.classList.add('hidden');
                userDropdownMenu.classList.remove('scale-100');
            }
        });

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
            content.classList.toggle('ml-64');
        });
    });
</script>
