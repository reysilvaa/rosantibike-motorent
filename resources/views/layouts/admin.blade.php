<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title', 'Dashboard') - SB Admin</title>
    @include('layouts.styles')
</head>
<body class="sb-nav-fixed">
    @include('layouts.topnav')

    <div id="layoutSidenav">
        @include('layouts.sidenav')

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>
            @include('layouts.footer')
        </div>
    </div>

    @include('layouts.scripts')
</body>
</html>
