<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Google tag Manager(gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-F5L46F7N9X"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-F5L46F7N9X');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'RosantiBike Motorent') }}</title>

    <!-- Tambahkan Vite untuk menggabungkan CSS dan JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
</html>
