<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Favicon and Manifest -->

    <!-- Preload Critical CSS -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" as="script">


    <!-- Include Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Vite CSS -->
    @vite('resources/css/app.css')

    <!-- Stack for additional styles -->
    @stack('styles')
</head>
<body>
    <!-- Your content here -->

    <!-- Include FontAwesome (JS) -->
    <script src="https://use.fontawesome.com/releases/v6.4.0/js/all.js" crossorigin="anonymous" defer></script>

    <!-- Include DataTables JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>


    <!-- Stack for additional scripts -->
    @stack('scripts')
</body>
</html>
