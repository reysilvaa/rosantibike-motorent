<nav class="bg-white py-4 px-6 flex items-center justify-between shadow-lg relative">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Great+Vibes:wght@400&display=swap');

      .font-latin {
        font-family: 'Great Vibes', serif;
      }
    </style>

    <!-- Sidebar Toggle (Visible on all devices) -->
    <button class="text-gray-600 text-2xl px-4 py-2 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-transform transform hover:scale-105 lg:static lg:translate-y-0 absolute left-4 top-1/2 transform -translate-y-1/2" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Brand (Visible on larger screens, left aligned) -->
    <a class="text-black font-latin font-extrabold flex items-center no-underline hover:text-gray-600 transition duration-300 ease-in-out lg:flex hidden" href="{{ route('dashboard') }}">
      <span class="text-2xl md:text-4xl">RosantiBike</span>
    </a>

    <!-- Centered Navbar Brand (Visible on mobile devices only) -->
    <div class="flex-1 lg:hidden flex justify-center">
      <text class="text-black font-latin font-extrabold flex items-center no-underline hover:text-gray-600 transition duration-300 ease-in-out" href="{{ route('dashboard') }}">
        <span class="text-2xl md:text-2xl">RosantiBike</span>
      </text>
    </div>

    <!-- Centered Navigation Buttons Container (Visible on mobile devices only) -->
    <div class="absolute right-0 inset-y-0 flex items-center pr-4 lg:hidden space-x-2">
      <button id="prevPage" class="text-gray-600 text-xl px-3 py-2 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-transform transform hover:scale-105">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button id="nextPage" class="text-gray-600 text-xl px-3 py-2 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-transform transform hover:scale-105">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>

    <!-- New Dropdown Toggle (Visible on larger screens only) -->
    <div class="relative lg:flex hidden">
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
      const prevPageButton = document.getElementById('prevPage');
      const nextPageButton = document.getElementById('nextPage');
      const sidebarToggle = document.getElementById('sidebarToggle');
      const sidebar = document.getElementById('sidebar'); // Ensure this is the ID of your sidebar element

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

      // Navigation button functionalities
      prevPageButton.addEventListener('click', function() {
        history.back(); // Goes back in browser history
      });

      nextPageButton.addEventListener('click', function() {
        history.forward(); // Goes forward in browser history
      });

      // Sidebar toggle button functionality
      sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('hidden');
      });
    });
  </script>
