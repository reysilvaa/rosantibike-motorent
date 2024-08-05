<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title', 'Dashboard') - RosantiBike</title>


    <!-- Preload Fonts -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;500;600;700&display=swap" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" as="style">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">

    @vite('resources/css/app.css')
    {{-- DOnt delete the jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('layouts.styles')

    <style>
        body {
            font-family: 'Lato', sans-serif;
        }
        .custom-tbody-padding td {
            padding: 10px;
        }
        .custom-checkbox input[type="checkbox"] {
            transform: scale(1.5);
        }
        #jenisMotorKanban .selected {
            border-color: #4F46E5;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.1), 0 4px 6px -2px rgba(79, 70, 229, 0.05);
        }
        #jenisMotorKanban > div:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">
    @auth
        <!-- Navbar -->
        <nav class="bg-white py-2 px-6 flex items-center justify-between shadow-lg fixed top-0 left-0 right-0 z-50">
            <!-- Sidebar Toggle -->
            <button class="text-gray-600 text-2xl px-4 py-2 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-transform transform hover:scale-105" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navbar Brand -->
            <!-- Navbar Brand -->
            <a class="text-black font-latin font-extrabold flex items-center no-underline hover:text-gray-600 transition duration-300 ease-in-out" href="{{ route('dashboard') }}">
                <img src="https://i.ibb.co.com/k6sDTzz/Upscale-Image-1-20240729-removebg.png" alt="Upscale-Image-1-20240729" class="logo-image max-w-[200px] h-auto">
            </a>


            <!-- User Dropdown -->
            <div class="relative">
                <button id="userDropdownToggle" class="text-gray-600 text-lg px-4 py-2 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-transform transform hover:scale-105">
                    <i class="fas fa-user"></i>
                </button>
                <div id="userDropdownMenu" class="absolute right-0 mt-2 bg-white text-gray-900 border border-gray-300 rounded-lg shadow-xl hidden transform scale-95 transition-transform origin-top-right">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 transition duration-150 ease-in-out">Profile</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 transition duration-150 ease-in-out">Settings</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 transition duration-150 ease-in-out">Logout</a>
                </div>
            </div>
        </nav>

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

        <!-- Main Content -->
        <div id="content" class="flex-1 pt-12 transition-margin duration-300 ease-in-out">
            <main>
                <div class="container mx-auto px-4 py-6">
                    @yield('content')
                </div>
            </main>
            @include('layouts.footer')
        </div>
    @else
        <main class="flex-1">
            <div class="container mx-auto px-4 py-6">
                @yield('content')
            </div>
        </main>
    @endauth


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
</body>
</html>
