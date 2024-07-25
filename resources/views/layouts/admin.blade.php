<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    @vite('resources/css/app.css')
    <meta name="author" content="" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>@yield('title', 'Dashboard') - SB Admin</title>
    @include('layouts.styles')
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    @auth
        @include('layouts.topnav')
        <div id="layoutSidenav" class="flex flex-1">
            @include('layouts.sidenav')
            <div id="layoutSidenav_content" class="flex-1">
                <main>
                    <div class="container mx-auto px-4 py-6">
                        @yield('content')
                    </div>
                </main>
                @include('layouts.footer')
            </div>
        </div>
    @else
        <main>
            <div class="container mx-auto px-4 py-6">
                @yield('content')
            </div>
        </main>
    @endauth

    @include('layouts.scripts')
    <style>
        .custom-tbody-padding td {
            padding: 10px;
        }
        /* Custom checkbox styles */
        .custom-checkbox input[type="checkbox"] {
            transform: scale(1.5); /* Scale up the checkbox */
        }
    </style>
</body>
</html>
