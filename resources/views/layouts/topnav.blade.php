<nav class="bg-white py-4 px-6 flex items-center justify-between shadow-lg">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes:wght@400&display=swap');

       .font-latin {
          font-family: 'Great Vibes', serif;
        }
      </style>

      <!-- Navbar Brand -->
      <a class="text-black text-4xl font-latin font-extrabold flex items-center no-underline hover:text-gray-600 transition duration-300 ease-in-out" href="{{ route('dashboard') }}">
        <span>RosantiBike</span>
      </a>

    <!-- Sidebar Toggle -->
    <div class="flex-1"></div>
    <button class="text-gray-600 text-2xl px-4 py-2 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-transform transform hover:scale-105" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>

    <div class="mx-2"></div>

    <!-- New Dropdown Toggle -->
    <div class="relative">
      <button id="newDropdownToggle" class="text-gray-600 text-lg px-4 py-2 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-transform transform hover:scale-105">
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
