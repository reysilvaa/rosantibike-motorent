<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title', 'Dashboard') - RosantiBike</title>
    @notifyCss

    <!-- Preload Fonts -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;500;600;700&display=swap" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" as="style">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
        .inset-0 {
            top: auto!important;
        }
        @media (max-width: 640px) {
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .dataTables_wrapper .dataTables_info {
                font-size: 0.75rem;
            }

            .status-badge {
                font-size: 0.75rem; /* Ukuran font lebih kecil pada layar kecil */
                padding: 0.25rem 0.5rem; /* Padding lebih kecil pada layar kecil */
            }
        }

    </style>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">
    @auth
    <x-notify::notify />

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Sidebar -->
    @include('layouts.sidebar')


    <!-- Main Content -->
    <div id="content" class="flex-1 pt-12 transition-margin duration-300 ease-in-out">
        <main>
            <div class="container mx-auto px-4 py-6">
                @yield('content')
                @notifyJs
            </div>
        </main>
    </div>
    @include('layouts.footer')
    @else
        <main class="flex-1">
            <div class="container mx-auto px-4 py-6">
                @yield('content')
            </div>
        </main>
    @endauth


</body>
</html>
